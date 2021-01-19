<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\NiveauCompetence;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
  public function addCompetences(Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManager,ValidatorInterface $validator)
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
      foreach ($niveauTab as $key => $value){
        $niveau = new NiveauCompetence();
        $niveau->setLibelle($value["libelle"]);
        $niveau->setCritereEvaluation($value["critereEvaluation"]);
        $niveau->setGroupeAction($value["groupeAction"]);
        $competences->addNiveauCompetence($niveau);
      }
      //dd($competences);
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($competences);
      $entityManager->flush();
    return new JsonResponse("success",Response::HTTP_CREATED,[],true);
    }
      else{
        return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
      }
  }

}
