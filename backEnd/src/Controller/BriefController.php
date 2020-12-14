<?php

namespace App\Controller;

use App\Entity\Brief;
use App\Entity\Promo;
use App\Entity\Formateur;
use App\Entity\GroupeApprenant;
use App\Repository\BriefRepository;
use App\Repository\PromoRepository;
use App\Repository\FormateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\GroupeApprenantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BriefController extends AbstractController
{
        /**
        * @Route(path="/api/formateurs/briefs", name="api_get_briefs", methods={"GET"})
        */
        public function getBriefs(BriefRepository $repo)
        {
          $brief = new Brief();
          $briefs = [];

          if($this->isGranted("VIEW",$brief)){
            $briefs = $repo->findAll();

            return $this->json($briefs,200, [], ["groups" => ["all_briefs"]]);
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }

        /**
        * @Route(path="/api/formateurs/promo/{id}/groupe/{id2}/briefs",
        *        name="apigetPromoIdGroupeIdBriefs",
        *        methods={"GET"},
        * defaults={
        *          "_controller"="\app\ControllerPromoController::getPromoIdGroupeIdBriefs",
        *         "_api_resource_class"=Brief::class,
        *         "_api_collection_operation_name"="getPromoIdGroupeIdBriefs"
        *         }
        *)
        */
        public function getPromoIdGroupeIdBriefs(Request $request,$id,$id2, PromoRepository $PromoRepo, GroupeApprenantRepository $GaRepo, BriefRepository $briefRepository)
        {
          $brief = new Brief();
          $briefs = [];

          if($this->isGranted("VIEW",$brief)){
            $promo = $PromoRepo-> find($id);
            if (isset($promo)){
              foreach ($promo->getGroupeApprenants() as $groupes) {
                if ($groupes == $GaRepo-> find($id2)){
                  if ($groupes->getStatut() == "actif") {
                    foreach ($groupes->getBriefs() as $groupeBrief) {
                      $briefs[] = [
                        "Briefs"=>$briefRepository->findOneBy([ 'id' => $groupeBrief->getId() ]) // ici apres avoir récupéré le group on récupère l'id du brief correspondant puis on affiche ses données
                      ];
                    }
                  }
                }
              }
              if(isset($briefs)){
                return $this->json($briefs, 200, [], ["groups" => ["brief_of_groupe_of_promo"]]);
              }else{
                return $this->json(["message" => "Les groupes de cette promo n'ont pas de briefs."], Response::HTTP_FORBIDDEN);
              }
            }else{
              return $this->json(["message" => "Cette promo n'existe pas."], Response::HTTP_FORBIDDEN);
            }
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }

        /**
        * @Route(
        *        path="/api/formateurs/promo/{id}/briefs",
        *        name="get_brief_of_one_formateur",
        *        methods={"GET"},
        * defaults={
        *         "_controller"="\app\BriefController::getBriefOfOneFormateur",
        *         "_api_resource_class"=Brief::class,
        *         "_api_collection_operation_name"="get_brief_of_one_formateur"
        *         }
        *)
        */
        public function getBriefOfOneFormateur(PromoRepository $promoRepository, BriefRepository $briefRepository ,int $id)
        {

          $brief = new Brief();
          $briefs = []; 

          if ( $this->isGranted("VIEW",$brief) ) { // ici on verifie si l'utilisateur est un formateur

            $briefs = []; // la variable qui va contenir les données a afficher
            $promo = $promoRepository->find($id); // ici on récupère l'id de la promo

            if(!empty($promo)) { // on verifie si l'id existe
              foreach ($promo->getPromoBriefs() as $promobrief) { // on parcours l'entité promo puis on récupère PormoBrief
                $briefs[] = [
                  "Briefs"=>$briefRepository->findOneBy([ 'id' => $promobrief->getBrief()->getId() ]) // ici apres avoir récupéré promobiref on récupère l'id du brief correspondant puis on affiche ses données
                ];
              }
              return $this->json($briefs, 200, [], ["groups" => ["brief_of_promo"]]); // ici on retourne le resultat
            }
            return new Response("Cette promo n'existe pas."); // ça c si on entre l'id d'une promo qui n'existe pas
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }


        /**
        * @Route(path="/api/formateurs/{id}/briefs/broullons",
        *        name="apigetFormateursIdBriefsBroullons",
        *        methods={"GET"},
        * defaults={
        *          "_controller"="\app\ControllerPromoController::getFormateursIdBriefsBroullons",
        *         "_api_resource_class"=Brief::class,
        *         "_api_collection_operation_name"="getFormateursIdBriefsBroullons"
        *         }
        *)
        */
        public function getFormateursIdBriefsBroullons($id, BriefRepository $briefRepository, FormateurRepository $formateurRepo)
        {
          $brief = new Brief();
          $formateur = new Formateur();
          $briefs = []; 

          if($this->isGranted("VIEW",$brief)){
            $formateur = $formateurRepo->find($id);

            if (isset($formateur)){

              foreach ($formateur->getBriefs() as $formateurBriefs) {
                if ($formateurBriefs->getStatutBrief() == "broullon"){
                  $briefs[] = [
                    "Briefs"=>$briefRepository->findOneBy([ 'id' => $formateurBriefs->getId() ])
                  ];
                }
              }

              if(!empty($briefs)){
                return $this->json($briefs, 200, [], ["groups" => ["brief_broullon_of_formateur"]] );
              }else{
                return $this->json(["message" => "Ce formateur n'a pas de brief en broullon."], Response::HTTP_FORBIDDEN);
              }

            }else{
              return $this->json(["message" => "Ce formateur n'existe pas."], Response::HTTP_FORBIDDEN);
            }

          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }

        /**
        * @Route(path="/api/formateurs/{id}/briefs/valide",
        *        name="apigetFormateursIdBriefsValide",
        *        methods={"GET"},
        * defaults={
        *          "_controller"="\app\ControllerPromoController::getFormateursIdBriefsValide",
        *         "_api_resource_class"=Brief::class,
        *         "_api_collection_operation_name"="getFormateursIdBriefsValide"
        *         }
        *)
        */
        public function getFormateursIdBriefsValide($id, BriefRepository $briefRepository, FormateurRepository $formateurRepo)
        {
          $brief = new Brief();
          $formateur = new Formateur();
          $briefs = []; 

          if($this->isGranted("VIEW",$brief)){
            $formateur = $formateurRepo->find($id);

            if (isset($formateur)){

              foreach ($formateur->getBriefs() as $formateurBriefs) {
                if ($formateurBriefs->getStatutBrief() == "valide"){
                  $briefs[] = [
                    "Briefs"=>$briefRepository->findOneBy([ 'id' => $formateurBriefs->getId() ])
                  ];
                }
              }

              if(!empty($briefs)){
                return $this->json($briefs, 200, [], ["groups" => ["brief_valide_of_formateur"]] );
              }else{
                return $this->json(["message" => "Ce formateur n'a pas de brief en broullon."], Response::HTTP_FORBIDDEN);
              }

            }else{
              return $this->json(["message" => "Ce formateur n'existe pas."], Response::HTTP_FORBIDDEN);
            }

          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }

        /**
        * @Route(path="/api/formateurs/promos/{id1}/briefs/{id2}",
        *        name="apigetPromosIdBriefsId",
        *        methods={"GET"},
        * defaults={
        *          "_controller"="\app\ControllerPromoController::getPromosIdBriefsId",
        *         "_api_resource_class"=Brief::class,
        *         "_api_collection_operation_name"="getPromosIdBriefsId"
        *         }
        *)
        */
        public function getPromosIdBriefsId($id1,$id2, BriefRepository $briefRepository, PromoRepository $PromoRepository)
        {
          $promo = new Promo();
          $brief = new Brief();
          $briefs = []; 

          if($this->isGranted("VIEW",$brief)){
            $briefs = []; // la variable qui va contenir les données a afficher
            $promo = $PromoRepository->find($id1); // ici on récupère l'id de la promo

            if(!empty($promo)) { // on verifie si l'id existe
              foreach ($promo->getPromoBriefs() as $promobrief) { // on parcours l'entité promo puis on récupère PormoBrief
                
                if ($promobrief->getBrief() == $briefRepository->find($id2)) {
                  $briefs[] = [
                    "Briefs"=>$briefRepository->findOneBy([ 'id' => $promobrief->getBrief()->getId() ]) // ici apres avoir récupéré promobiref on récupère l'id du brief correspondant puis on affiche ses données
                  ];
                }
              }
              return $this->json($briefs, 200, [], ["groups" => ["one_brief_of_promo"]]); // ici on retourne le resultat
            }
            return new Response("Cette promo n'existe pas."); // ça c si on entre l'id d'une promo qui n'existe pas
          
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }

        /**
        * @Route(path="/api/apprenants/promos/{id}/briefs",
        *        name="apigetApprenantsPromosIdBriefs",
        *        methods={"GET"},
        * defaults={
        *          "_controller"="\app\ControllerPromoController::getApprenantsPromosIdBriefs",
        *         "_api_resource_class"=Brief::class,
        *         "_api_collection_operation_name"="getApprenantsPromosIdBriefs"
        *         }
        *)
        */
        public function getApprenantsPromosIdBriefs($id, PromoRepository $PromoRepository, BriefRepository $briefRepository)
        {
          $promo = new Promo();
          $brief = new Brief();
          $briefs = [];

          if($this->isGranted("VIEW",$brief)){

            $promo = $PromoRepository->find($id);

            if ( !empty($promo) ) {
                $briefmapromo = $promo->getPromoBriefs();
                foreach($briefmapromo as $value ) {
                    if( $value->getBrief()->getStatutBrief() == "assigne" ) {
                      $briefs[] = [
                        "Briefs" => $briefRepository->findOneBy([ 'id' => $value->getId() ])
                      ];
                    }
                    return $this->json($briefs, 200, [], ["groups" => ["brief_assigned"]]);
                }
            }else{
              return $this->json(["message" => "Cette promo n'existe pas."], Response::HTTP_FORBIDDEN);
            }
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }

}
