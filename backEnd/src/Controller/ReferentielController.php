<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\Referentiel;
use App\Entity\GroupeCompetence;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReferentielRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\GroupeCompetenceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReferentielController extends AbstractController
{
  /**
  * @Route(path="/api/admin/referentiels", name="api_add_referentiels", methods={"POST"})
  */
  public function addReferentiel(Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManager,ValidatorInterface $validator,GroupeCompetenceRepository $grpCompRepo)
  {
    $referentiel = new Referentiel();

    if($this->isGranted("EDIT",$referentiel)){
      // Get Body content of the Request
      $referentielJson = $request->getContent();

      // On transforme le json en tableau
      $referentielTab = $serializer->decode($referentielJson, 'json');
                        
      // $programme = $request->files->get("$programme");
      // $programme = fopen($programme->getRealPath(),"rb");
      // $referentielTab["programme"] = $programme;
      //$uploadedFile = $request->files->get('programme');
      //return $this->json($uploadedFile);
      // if($uploadedFile){
      //   $file = $uploadedFile->getRealPath();
      //   $programme = fopen($file, 'r+');
      //   $referentielTab["programme"] = $programme;
      // }

      $referentiel->setLibelle($referentielTab["libelle"]);
      $referentiel->setPresentation($referentielTab["presentation"]);
      $referentiel->setCritereEvaluation($referentielTab["critereEvaluation"]);
      $referentiel->setCritereAdmission($referentielTab["critereAdmission"]);
      $referentiel->setProgramme($referentielTab["programme"]);

      $grpCompetencesTab = $referentielTab["groupeCompetences"];

      foreach ($grpCompetencesTab as $value){
        $groupeCompetence = new GroupeCompetence();
        $groupeCompetence = $grpCompRepo-> find($value);
        $referentiel->addGroupeCompetence($groupeCompetence);
      }
      //$entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($referentiel);
      $entityManager->flush();
      return new JsonResponse("success",Response::HTTP_CREATED,[],true);
    }
    else{
      return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
    }
  }

  /**
  * @Route(path="/api/admin/referentiels/{id}", name="put_Referentiel", methods={"PUT"})
  */
  public function putGrpCompetences(Request $request,SerializerInterface $serializer, $id, EntityManagerInterface $entityManager,ValidatorInterface $validator, ReferentielRepository $refRepo, GroupeCompetenceRepository $grpCompRepo)
  {
    $referentiel = new Referentiel();
    if($this->isGranted("EDIT",$referentiel)){
      // Get Body content of the Request
      $referentielJson = $request->getContent();
      //On détermine si le referentiel existe dans la base de données
      $referentiel = $refRepo-> find($id);
      if (isset($referentiel)){
        // On transforme les données json en tableau
        $referentielTab = $serializer->decode($referentielJson, 'json');
        //On détermine si dans le tableau nous avons les champs libellé et descriptif sont rempli
        //puis on les set.
        if (!empty($referentielTab["libelle"])){
          $referentiel->setLibelle($referentielTab["libelle"]);
        }
        if (!empty($referentielTab["presentation"])){
          $referentiel->setPresentation($referentielTab["presentation"]);
        }
        if (!empty($referentielTab["programme"])){
          $referentiel->setProgramme($referentielTab["programme"]);
        }
        if (!empty($referentielTab["critereEvaluation"])){
          $referentiel->setCritereEvaluation($referentielTab["critereEvaluation"]);
        }
        if (!empty($referentielTab["critereAdmission"])){
          $referentiel->setCritereAdmission($referentielTab["critereAdmission"]);
        }
        //On récupére les groupes de compétences à ajouter qu'on met dans un tableau
        $grpCompetencesToAddOrDeleteTab = $referentielTab["grpCompetenceToAddOrDelete"];
        
        // on recupére les groupes de compétence déja éxistante qu'on met dans un tableau
        $grpCompetenceOfRefTab = $referentiel->getGroupeCompetences();

        // On supprime l'ancien tab de grp Compétence pour ajouter de nouveaux
        // Car on utilise le Drag and Drop de angular matérial coté front 
        foreach ($grpCompetenceOfRefTab as $grpCompetenceOfRef) {
          $referentiel->removeGroupeCompetence($grpCompetenceOfRef);
        }

        //On parcour le tableau de groupe competence donner coté front
        foreach ($grpCompetencesToAddOrDeleteTab as $grpCompetencesToAddOrDelete){
          $grpCompetence = new GroupeCompetence();
          $grpCompetence = $grpCompRepo-> find($grpCompetencesToAddOrDelete["id"]);
          if (isset($grpCompetence)){
            $referentiel->addGroupeCompetence($grpCompetence);
          }
        }

        $entityManager->persist($referentiel);
        $entityManager->flush();
        return new JsonResponse("success");
      }else{
        return $this->json(["message" => "Il n'existe pas de referentiel avec cet id."], Response::HTTP_FORBIDDEN);
      }
    }else{
      return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
    }
  }

  /**
  * @Route(path="/api/admin/referentiels/{id}/grpecompetences/{id2}",
  *        name="get_CompOfGrpCompByIdOfRefById",
  *        methods={"GET"}
  *)
  */
  public function getCompOfGrpCompByIdOfRefById(Request $request,SerializerInterface $serializer, $id, $id2, EntityManagerInterface $entityManager,ValidatorInterface $validator, ReferentielRepository $RefRepo, GroupeCompetenceRepository $grpCompRepo)
  {
    $referentiel = new Referentiel();
    $competence = new Competence();
    if($this->isGranted("VIEW",$referentiel)){
      //On détermine si le referentiel existe dans la base de données
      $referentiel = $RefRepo-> find($id);
      if (isset($referentiel)){
        foreach ($referentiel->getGroupeCompetences() as $grpCompetence){
          if($grpCompetence == $grpCompRepo->find($id2)) {
            $competence = $grpCompetence->getCompetences();
          }
        }
        return $this->json($competence, 200, [], ["groups" => ["get_CompOfGrpCompByIdOfRefById:read"]]);
        }else{
          return $this->json(["message" => "Ce référentiel n'existe pas."], Response::HTTP_FORBIDDEN);
        }
    }else{
      return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
    }
  }
}
