<?php

namespace App\Controller;

use App\Entity\Referentiel;
use App\Entity\GroupeCompetence;
use Doctrine\ORM\EntityManagerInterface;
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
                        
      //$programme = $request->files->get("$programme");
      //$programme = fopen($programme->getRealPath(),"rb");
      //$referentielTab["programme"] = $programme;

      $referentiel->setLibelle($referentielTab["libelle"]);
      $referentiel->setPresentation($referentielTab["presentation"]);
      $referentiel->setCritereEvaluation($referentielTab["critereEvaluation"]);
      $referentiel->setCritereAdmission($referentielTab["critereAdmission"]);
      //$referentiel->setProgramme($referentielTab["programme"]);

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
}
