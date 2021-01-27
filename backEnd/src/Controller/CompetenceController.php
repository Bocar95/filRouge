<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\NiveauCompetence;
use App\Repository\CompetenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\NiveauCompetenceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Core\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompetenceController extends AbstractController
{
  /**
  * @Route(path="/api/admin/competences", name="api_add_competences", methods={"POST"})
  */
  public function addCompetences(Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManager,ValidatorInterface $validator,NiveauCompetenceRepository $niveauRepo)
  {
    $competences = new Competence;
    if($this->isGranted("EDIT",$competences)){
      // Get Body content of the Request
      $competencesJson = $request->getContent();
      // On transforme le json en tableau
      $competencesTab = $serializer->decode($competencesJson, 'json');
      //dd($competencesTab["libelle"]);
      $competences->setLibelle($competencesTab["libelle"]);
      $competences->setDescriptif($competencesTab["descriptif"]);
      $niveauTab = $competencesTab["niveauCompetences"];
      
      foreach ($niveauTab as $value){
        $niveau = new NiveauCompetence();
        $niveau = $niveauRepo-> find($value);
        $competences->addNiveauCompetence($niveau);
      }
      //return $this->json($competences);
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($competences);
      $entityManager->flush();
    return new JsonResponse("success",Response::HTTP_CREATED,[],true);
    }
    else{
      return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
    }
  }

  /**
  * @Route(path="/api/admin/competences/{id}", name="put_competences", methods={"PUT"})
  */
  public function putCompetences(Request $request,SerializerInterface $serializer, $id, EntityManagerInterface $entityManager,ValidatorInterface $validator, CompetenceRepository $compRepo, NiveauCompetenceRepository $niveauRepo)
  {
    $competence = new Competence();
    if($this->isGranted("EDIT",$competence)){
      // Get Body content of the Request
      $competenceJson = $request->getContent();
      //On détermine si le compétence existe dans la base de données
      $competence = $compRepo-> find($id);
      if (isset($competence)){
        // On transforme les données json en tableau
        $competenceTab = $serializer->decode($competenceJson, 'json');
        //On détermine si dans le tableau nous avons les champs libellé et descriptif sont rempli
        //puis on les set.
        if (!empty($competenceTab["libelle"])){
          $competence->setLibelle($competenceTab["libelle"]);
        }
        if (!empty($competenceTab["descriptif"])){
          $competence->setDescriptif($competenceTab["descriptif"]);
        }
        //On récupére les niveaux qu'on met dans un tableau
        $niveauTab = $competenceTab["niveauCompetences"];
        
        if (!empty($niveauTab)){
          //On parcour le tableau de niveau
          foreach ($niveauTab as $id){
            if(is_int($id)){
              //On crée un objet
              $niveau = new NiveauCompetence();
              $niveau = $niveauRepo-> find($id);
              if (isset($niveau)){
                $competence->addNiveauCompetence($niveau);
              }
            }
          }
        }
        //return $this->json($competence);

        $entityManager->persist($competence);
        $entityManager->flush();
        return new JsonResponse("success");
      }else{
        return $this->json(["message" => "Il n'existe pas de competence avec cet id."], Response::HTTP_FORBIDDEN);
      }
    }else{
      return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
    }
  }

}
