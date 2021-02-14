<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\GroupeCompetence;
use App\Repository\AdminRepository;
use App\Repository\CompetenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\GroupeCompetenceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GrpCompetenceController extends AbstractController
{
  /**
  * @Route(path="/api/admin/grpCompetences", name="api_add_grpCompetences", methods={"POST"})
  */
  public function addGrpCompetences(Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManager,ValidatorInterface $validator, CompetenceRepository $competenceRepo, AdminRepository $AdminRepo)
  {
    $grpCompetences = new GroupeCompetence();
    if($this->isGranted("EDIT",$grpCompetences)){
      // Get Body content of the Request
      $grpCompetencesJson = $request->getContent();
      // On transforme le json en tableau
      $grpCompetencesTab = $serializer->decode($grpCompetencesJson, 'json');
      $grpCompetences->setLibelle($grpCompetencesTab["libelle"]);
      $grpCompetences->setDescriptif($grpCompetencesTab["descriptif"]);
      $competencesTab = $grpCompetencesTab["competences"];
      foreach ($competencesTab as $key => $value){
        $competence = new Competence();
        $competenceId = $value;
        if ($competenceRepo->find($competenceId)){
          $competence = $competenceRepo->find($competenceId);
        }
        $grpCompetences->addCompetence($competence);
      }
      if($grpCompetencesTab["competenceLibelle"] && $grpCompetencesTab["competenceDescriptif"]){
        $newCompetence = new Competence();
        $newCompetence->setLibelle($grpCompetencesTab["competenceLibelle"]);
        $newCompetence->setDescriptif($grpCompetencesTab["competenceDescriptif"]);
        $grpCompetences->addCompetence($newCompetence);
      }

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($grpCompetences);
      $entityManager->flush();
      return new JsonResponse("success",Response::HTTP_CREATED,[],true);
    }
    else{
      return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
    }
  }

  /**
  * @Route(path="/api/admin/grpCompetences/{id}", name="put_grpCompetences", methods={"PUT"})
  */
  public function putGrpCompetences(Request $request,SerializerInterface $serializer, $id, EntityManagerInterface $entityManager,ValidatorInterface $validator, CompetenceRepository $CompRepo, GroupeCompetenceRepository $grpCompRepo)
  {
    $grpCompetences = new GroupeCompetence();
    if($this->isGranted("EDIT",$grpCompetences)){
      // Get Body content of the Request
      $grpCompetencesJson = $request->getContent();
      //On détermine si le groupe compétence existe dans la base de données
      $grpCompetences = $grpCompRepo-> find($id);
      if (isset($grpCompetences)){
        // On transforme les données json en tableau
        $grpCompetencesTab = $serializer->decode($grpCompetencesJson, 'json');
        //On détermine si dans le tableau nous avons les champs libellé et descriptif sont rempli
        //puis on les set.
        if (!empty($grpCompetencesTab["libelle"])){
          $grpCompetences->setLibelle($grpCompetencesTab["libelle"]);
        }
        if (!empty($grpCompetencesTab["descriptif"])){
          $grpCompetences->setDescriptif($grpCompetencesTab["descriptif"]);
        }
        //On récupére les compétences qu'on met dans un tableau
        $competencesTab = $grpCompetencesTab["competences"];
        //return $this->json($competencesTab);
        
        if (!empty($competencesTab)){
          //On parcour le tableau de competence
          foreach ($competencesTab as $id){
            $competence = new Competence();
            if (is_int($id)) {
              //On crée un objet
              $competence = $CompRepo-> find($id);
              if (isset($competence)){
                $grpCompetences->addCompetence($competence);
              }
            }
          }
        }
        $entityManager->persist($grpCompetences);
        $entityManager->flush();
        return new JsonResponse("success");
      }else{
        return $this->json(["message" => "Il n'existe pas de groupe de competence avec cet id."], Response::HTTP_FORBIDDEN);
      }
    }else{
      return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
    }
  }

}
