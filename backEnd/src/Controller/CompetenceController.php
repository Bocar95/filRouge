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
    $competence = new Competence;
    if($this->isGranted("EDIT",$competence)){
      // Get Body content of the Request
      $competenceJson = $request->getContent();
      // On transforme le json en tableau
      $competenceTab = $serializer->decode($competenceJson, 'json');
      $competence->setLibelle($competenceTab["libelle"]);
      $competence->setDescriptif($competenceTab["descriptif"]);
      
      if($competenceTab["niveauCritereEvaluation1"] || $competenceTab["niveauGroupeAction1"]){
        $newNiveau1 = new NiveauCompetence();
        $newNiveau1->setLibelle("Niveau 1");
        $newNiveau1->setCritereEvaluation($competenceTab["niveauCritereEvaluation1"]);
        $newNiveau1->setGroupeAction($competenceTab["niveauGroupeAction1"]);
        $competence->addNiveauCompetence($newNiveau1);
      }
      if($competenceTab["niveauCritereEvaluation2"] || $competenceTab["niveauGroupeAction2"]){
        $newNiveau2 = new NiveauCompetence();
        $newNiveau2->setLibelle("Niveau 2");
        $newNiveau2->setCritereEvaluation($competenceTab["niveauCritereEvaluation2"]);
        $newNiveau2->setGroupeAction($competenceTab["niveauGroupeAction2"]);
        $competence->addNiveauCompetence($newNiveau2);
      }
      if($competenceTab["niveauCritereEvaluation3"] || $competenceTab["niveauGroupeAction3"]){
        $newNiveau3 = new NiveauCompetence();
        $newNiveau3->setLibelle("Niveau 3");
        $newNiveau3->setCritereEvaluation($competenceTab["niveauCritereEvaluation3"]);
        $newNiveau3->setGroupeAction($competenceTab["niveauGroupeAction3"]);
        $competence->addNiveauCompetence($newNiveau3);
      }
      //return $this->json($competence);
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($competence);
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
        
        if(isset($competenceTab["niveauCritereEvaluation1"]) || isset($competenceTab["niveauGroupeAction1"])){
          $newNiveau1 = new NiveauCompetence();
          $newNiveau1->setLibelle("Niveau 1");
          $newNiveau1->setCritereEvaluation($competenceTab["niveauCritereEvaluation1"]);
          $newNiveau1->setGroupeAction($competenceTab["niveauGroupeAction1"]);
          $competence->addNiveauCompetence($newNiveau1);
        }

        if(isset($competenceTab["niveauCritereEvaluation2"])){
          $newNiveau2 = new NiveauCompetence();
          $newNiveau2->setLibelle("Niveau 2");
          $newNiveau2->setCritereEvaluation($competenceTab["niveauCritereEvaluation2"]);
          $newNiveau2->setGroupeAction($competenceTab["niveauGroupeAction2"]);
          $competence->addNiveauCompetence($newNiveau2);
        }
        if(isset($competenceTab["niveauCritereEvaluation3"])){
          $newNiveau3 = new NiveauCompetence();
          $newNiveau3->setLibelle("Niveau 3");
          $newNiveau3->setCritereEvaluation($competenceTab["niveauCritereEvaluation3"]);
          $newNiveau3->setGroupeAction($competenceTab["niveauGroupeAction3"]);
          $competence->addNiveauCompetence($newNiveau3);
        }
        
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
