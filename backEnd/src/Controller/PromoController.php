<?php

namespace App\Controller;

use DateTime;
use App\Entity\Promo;
use App\Entity\Apprenant;
use App\Entity\Formateur;
use App\Entity\Referentiel;
use App\Entity\GroupeApprenants;
use App\Repository\ApprenantRepository;
use App\Repository\FormateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReferentielRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PromoController extends AbstractController
{
  /**
  * @Route(path="/api/admin/promo", name="api_add_promo", methods={"POST"})
  */
  public function addPromo(Request $request,SerializerInterface $serializer, \Swift_Mailer $mailer, EntityManagerInterface $entityManager,ValidatorInterface $validator,ReferentielRepository $refRepo, FormateurRepository $formateurRepo, ApprenantRepository $apprenantRepo)
  {
    $promo = new Promo();

    if($this->isGranted("EDIT",$promo)){
      $promoJson = $request->getContent();
        // On transforme le json en tableau
      $promoTab = $serializer->decode($promoJson, 'json');

      $promo->setTitre($promoTab["titre"]);
      $promo->setDescription($promoTab["description"]);
      $promo->setAnnee(new DateTime("08/02/2020"));
      $promo->setDateDebut(new DateTime("08/02/2020"));
      $promo->setDateFinProvisoire(new DateTime("08/12/2020"));

      $referentielTab = $promoTab["referentiels"];
      $formateursTab = $promoTab["formateurs"];
      $apprenantsTab = $promoTab["apprenants"];

      foreach ($referentielTab as $ref => $refId){
        $referentiel = new Referentiel();
        $referentiel = $refRepo -> find($refId);
        if (isset($referentiel)){
          $promo->setReferentiel($referentiel);
        }
      }

      foreach ($formateursTab as $key => $formateurId){
        $formateur = new Formateur();
        $formateur = $formateurRepo -> find($formateurId);
        if (isset($formateur)){
          $promo->addFormateur($formateur);
        }
      }

      $groupeApprenant = new GroupeApprenants();

      $date = new DateTime();
      $date->format('Y-m-d H:i:s');

      $groupeApprenant->setNom($promoTab["nomGroupePrincipal"]);
      $groupeApprenant->setType("Principal");
      $groupeApprenant->setDateCreation($date);

      foreach ($apprenantsTab as $key => $apprenantId) {
        $apprenant = new Apprenant();
        $apprenant = $apprenantRepo -> find($apprenantId);
          if ($apprenant){
            $apprenantEmail = $apprenant->getEmail();
            $groupeApprenant->addApprenant($apprenant);
            $message = (new \Swift_Message('Selections Sonatel Académie'))
              ->setFrom('bocar.diallo95@gmail.com')
              ->setTo($apprenantEmail)
              ->setBody('NB: ceci est un TEST de groupe de travail.
                Bonsoir Cher(e) candidat(e) de la Promotion 3 de Sonatel Academy,
                Après les différentes étapes de sélection que tu as passé avec brio,
                nous t’informons que ta candidature a été retenue pour intégrer la troisième promotion
                de la première école de codage gratuite du Sénégal.
                Rendez-vous Lundi à 8h dans les locaux de Orange Digital Center.'
              );
            $mailer->send($message);
          }
            
      }
      $promo->addGroupeApprenant($groupeApprenant);

      // $token = substr($request->server->get("HTTP_AUTHORIZATION"), 7);
      // $token = explode(".",$token);

      // if (isset($token[1])){
      //   $payload = $token[1];
      //   $payload = json_decode(base64_decode($payload));
      //   $admin = $AdminRepo->findOneBy([
      //     "username" => $payload->username
      //   ]);
      //   $promo->setAdmin($admin);
      // }
      $entityManager->persist($promo);
      $entityManager->flush();
      return new JsonResponse("success",Response::HTTP_CREATED,[],true);
    }
    else{
      return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
    }
  }

}
