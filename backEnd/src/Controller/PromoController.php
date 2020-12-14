<?php

namespace App\Controller;

use DateTime;
use App\Entity\Promo;
use App\Entity\Apprenant;
use App\Entity\Formateur;
use App\Entity\Competences;
use App\Entity\Referentiel;
use App\Entity\GroupeApprenant;
use App\Repository\AdminRepository;
use App\Repository\PromoRepository;
use App\Entity\StatistiquesCompetences;
use App\Repository\ApprenantRepository;
use App\Repository\FormateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CompetencesRepository;
use App\Repository\ReferentielRepository;
use App\Repository\GroupeApprenantRepository;
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
        * @Route(path="/api/admin/promo", name="api_get_promo", methods={"GET"})
        */
        public function getPromo(PromoRepository $repo)
        {
                $promo = new Promo;

                if($this->isGranted("VIEW",$promo)){
                        $promo = $repo->findAll();

                        return $this->json($promo,Response::HTTP_OK,);
                }else{
                        return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
                }
        }

        /**
        * @Route(path="/api/admin/promo/principal",
        *        name="apigetGpPrincipal",
        *        methods={"GET"},
        *       defaults={
        *          "_controller"="\app\ControllerPromoController::getGpPrincipal",
        *         "_api_resource_class"=Promo::class,
        *         "_api_collection_operation_name"="getGpPrincipal"
        *         }
        *)
        */
        public function getGpPrincipal(Request $request,SerializerInterface $serializer, EntityManagerInterface $entityManager,ValidatorInterface $validator, GroupeApprenantRepository $GaRepo, PromoRepository $PromoRepo)
        {
          $promo = new Promo();

          if($this->isGranted("VIEW",$promo)){

            $promo = $PromoRepo-> findAll();
                        
            if (!empty($promo)){
                                        
              $promoTab = $serializer->normalize($promo, 'json');

              $groupeApprenant = new GroupeApprenant();
              $groupeApprenant = $GaRepo -> findAll();

              $total= count($promoTab);

              $total2= count($groupeApprenant);

              for ($i=0; $i < $total; $i++) {
                for ($j=0; $j < $total2; $j++) {
                  if (isset($promoTab[$i]["groupeApprenants"][$j])){
                    $GroupeApprenant = $promoTab[$i]["groupeApprenants"][$j];
                      $type = $GroupeApprenant["type"];
                      if($type=="Principal"){
                        $principal = $GaRepo -> findByType($type);
                      }
                  }
                }
              }

              return $this->json($principal,Response::HTTP_OK,);

            }else{
              return $this->json(["message" => "Les groupes de compétences n'existe pas dans la base de données."], Response::HTTP_FORBIDDEN);
            }
              
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }

        /**
        * @Route(path="/api/admin/promo/apprenants/attente",
        *        name="apiGetApprenantsAttente",
        *        methods={"GET"}
        *)
        */
        public function GetApprenantsAttente(Request $request,SerializerInterface $serializer, EntityManagerInterface $entityManager,ValidatorInterface $validator, GroupeApprenantRepository $GaRepo, PromoRepository $PromoRepo)
        {
          $newPromo = new Promo();

          if($this->isGranted("VIEW",$newPromo)){

            $promoTab = $PromoRepo-> findAll();
                        
            if (isset($promoTab)){
              foreach ($promoTab as $promoKey => $promoValue) {
                $promoValue = $serializer->normalize($promoValue, 'json');
                  $groupeApprenantTab [] = $promoValue["groupeApprenants"];
              }

              foreach ($groupeApprenantTab as $gAkey => $gAValue) {
                foreach ($gAValue as $k => $element) {
                  $apprenantTab [] = $element["apprenants"];
                }
              }

              foreach ($apprenantTab as $apprenantTabKey => $apprenantTabValue) {
                foreach ($apprenantTabValue as $appTabElementKey => $appTabElementValue) {
                  if (!$appTabElementValue["isConnected"]){
                    $apprenantAttente [] = $appTabElementValue;
                  }
                }
              }
              return $this->json($apprenantAttente,Response::HTTP_OK,);
            }

          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }

        }


        /**
        * @Route(path="/api/admin/promo", name="api_add_promo", methods={"POST"})
        */
        public function addPromo(Request $request,SerializerInterface $serializer,CompetencesRepository $compRepo, \Swift_Mailer $mailer, EntityManagerInterface $entityManager,ValidatorInterface $validator,ReferentielRepository $refRepo, FormateurRepository $formateurRepo, ApprenantRepository $apprenantRepo, AdminRepository $AdminRepo)
        {
          
                $promo = new Promo();

                if($this->isGranted("EDIT",$promo)){
                        // Get Body content of the Request
                        
                        $promoJson = $request->getContent();
                       
                        // On transforme le json en tableau
                        $promoTab = $serializer->decode($promoJson, 'json');

                        $promo->setLangue($promoTab["langue"]);
                        $promo->setTitre($promoTab["titre"]);
                        $promo->setDescription($promoTab["description"]);
                        $promo->setLieu($promoTab["lieu"]);
                        $promo->setDateDebut(new DateTime("08/02/2020"));
                        $promo->setDateFinProvisoire(new DateTime("08/12/2020"));
                        $promo->setFabrique($promoTab["fabrique"]);
                        $promo->setEtat($promoTab["etat"]);

                        $referentielTab = $promoTab["referentiel"];
                        $formateursTab = $promoTab["formateurs"];

                        foreach ($referentielTab as $key => $value){
                          $referentiel = new Referentiel();
                          $referentiel = $refRepo -> find($value);
                            if (isset($referentiel)){
                              $promo->setReferentiel($referentiel);
                            }
                        }

                        $groupesComp=$referentiel->getGroupeCompetences();
                        $groupesComp=$serializer->normalize($groupesComp,"json",["groups"=>"Ref:comp"]);
                        foreach ($groupesComp as $key_groupe_com => $grpComp) {
                          $competences=$grpComp["competences"];
                          foreach ($competences as $key_competences => $competence) {
                            $tab_competences_id[]=$competence["id"];
                          }
                        }
                        //dd($tab_competences_id);

                        foreach ($formateursTab as $key => $value){
                          $formateur = new Formateur();
                          foreach ($value as $k => $v) {
                            $formateur = $formateurRepo -> find($v);
                            if (isset($formateur)){
                              $promo->addFormateur($formateur);
                            }
                          }
                        }

                        $groupeApprenantsTab = $promoTab["groupes"];

                        $date = new DateTime();
                        $date->format('Y-m-d H:i:s');

                        foreach ($groupeApprenantsTab as $key => $value) {
                          $groupeApprenants = new GroupeApprenant();

                          $groupeApprenants->setNom($value["nom"]);
                          $groupeApprenants->setType($value["type"]);
                          $groupeApprenants->setStatut($value["statut"]);
                          $groupeApprenants->setDateCreation($date);

                          $apprenantsTab = $value["apprenants"]; 
                          
                          foreach ($apprenantsTab as $k => $v) {
                            $apprenants = new Apprenant();

                            if ($apprenants = $apprenantRepo -> findOneByEmail($v["email"])){
                              //Ajout stat apprenant dans stattComp
                              foreach ($tab_competences_id as $key_competences_id => $id_competence) {
                                $competence= new Competences();
                                $competence= $compRepo->find($id_competence);
                                $statComp= new StatistiquesCompetences();

                                $statComp->setApprenant($apprenants);
                                $statComp->setPromo($promo);
                                $statComp->setReferentiel($referentiel);
                                $statComp->setCompetence($competence);
                                $statComp->setNiveau1(0);
                                $statComp->setNiveau2(0);
                                $statComp->setNiveau3(0);
                                $entityManager->persist($statComp);
                              }
                              //dd($apprenants);
                              $apprenantEmail = $apprenants->getEmail();

                              $groupeApprenants->addApprenant($apprenants);
                              $message = (new \Swift_Message('Selections Sonatel Académie'))
                                    ->setFrom('bocar.diallo95@gmail.com')
                                    ->setTo($apprenantEmail)
                                    ->setBody('NB: ceci est un TEST de groupe de travail.
                                                Bonsoir Cher(e) candidat(e) de la Promotion 3 de sonatel Academy,
                                                Après les différentes étapes de sélection que tu as passé avec brio,
                                                nous t’informons que ta candidature a été retenue pour intégrer la troisième promotion de la première école de codage gratuite du Sénégal.
                                                Veuillez cliqué sur ce lien "http://bocar.alwaysdata.net/Projet_MVC/Gestionnaire/AddEtudiant" pour compléter vos informations.')
                                                ;
                                    $mailer->send($message);
                            }
                            
                          }

                          $promo->addGroupeApprenant($groupeApprenants);
                        }

                        $token = substr($request->server->get("HTTP_AUTHORIZATION"), 7);
                        $token = explode(".",$token);

                        if (isset($token[1])){

                          $payload = $token[1];
                          $payload = json_decode(base64_decode($payload));

                          $admin = $AdminRepo->findOneBy([
                                  "username" => $payload->username
                          ]);

                          $promo->setAdmin($admin);

                        }
//dd($promo);
                        $entityManager->persist($promo);
                        $entityManager->flush();
                        return new JsonResponse("success",Response::HTTP_CREATED,[],true);
                }
                else{
                        return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
                }
        }

        /**
        * @Route(path="/api/admin/promo/{id}/principal",
        *        name="apigetPromoIdGpPrincipal",
        *        methods={"GET"},
        * defaults={
        *          "_controller"="\app\ControllerPromoController::getPromoIdGpPrincipal",
        *         "_api_resource_class"=Promo::class,
        *         "_api_collection_operation_name"="getPromoIdGpPrincipal"
        *         }
        *)
        */
        public function getPromoIdGpPrincipal(Request $request,SerializerInterface $serializer, $id, EntityManagerInterface $entityManager,ValidatorInterface $validator, PromoRepository $PromoRepo, GroupeApprenantRepository $GaRepo)
        {
          $promo = new Promo();

          if($this->isGranted("VIEW",$promo)){

            //On détermine si la promo existe dans la base de données
            $promo = $PromoRepo-> find($id);
                        
            if (isset($promo)){
                                        
              // On transforme l'objet promo en tableau.
              $promoTab = $serializer->normalize($promo, 'json');

              //On récupére les groupes apprenants de la promo qu'on met dans un tableau
              $groupeApprenantsTab = $promoTab["groupeApprenants"];

              foreach ($groupeApprenantsTab as $key => $value) {
                $type = $value["type"];
                if($type=="Principal"){
                  return $this->json($value,Response::HTTP_OK,);
                }
              }

            }else{
              return $this->json(["message" => "Cette promo n'existe pas."], Response::HTTP_FORBIDDEN);
            }
              
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }

        }

        /**
        * @Route(path="/api/admin/promo/{id}/referentiels",
        *        name="apigetPromoIdReferentiel",
        *        methods={"GET"},
        * defaults={
        *          "_controller"="\app\ControllerPromoController::getPromoIdReferentiel",
        *         "_api_resource_class"=Promo::class,
        *         "_api_collection_operation_name"="getPromoIdReferentiel"
        *         }
        *)
        */
        public function getPromoIdReferentiel(Request $request,SerializerInterface $serializer, $id, EntityManagerInterface $entityManager,ValidatorInterface $validator, PromoRepository $PromoRepo, ReferentielRepository $RefRepo)
        {
          $promo = new Promo();

          if($this->isGranted("VIEW",$promo)){

            //On détermine si la promo existe dans la base de données
            $promo = $PromoRepo-> find($id);
                        
            if (isset($promo)){
                                        
              // On transforme l'objet promo en tableau.
              $promoTab = $serializer->normalize($promo, 'json');

              //On récupére les groupes apprenants de la promo qu'on met dans un tableau
              $referentielTab = $promoTab["referentiel"];

              return $this->json($referentielTab,Response::HTTP_OK,);

            }else{
              return $this->json(["message" => "Cette promo n'existe pas."], Response::HTTP_FORBIDDEN);
            }
              
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }

        }

        /**
        * @Route(path="/api/admin/promo/{id}/apprenants/attente",
        *        name="apiGetPromoIdApprenantsAttente",
        *        methods={"GET"}
        *)
        */
        public function GetPromoIdApprenantsAttente(Request $request, $id,SerializerInterface $serializer, EntityManagerInterface $entityManager,ValidatorInterface $validator, GroupeApprenantRepository $GaRepo, PromoRepository $PromoRepo)
        {
          $newPromo = new Promo();

          if($this->isGranted("VIEW",$newPromo)){

            $newPromo = $PromoRepo-> find($id);
                        
            if (isset($newPromo)){
              $newPromo = $serializer->normalize($newPromo, 'json');
              $groupeApprenant = $newPromo["groupeApprenants"];

              foreach ($groupeApprenant as $gAkey => $gAValue) {
                $apprenantTab [] = $gAValue["apprenants"];
              }
              

              foreach ($apprenantTab as $apprenantTabKey => $apprenantTabValue) {
                foreach ($apprenantTabValue as $appTabElementKey => $appTabElementValue) {
                  if (!$appTabElementValue["isConnected"]){
                    $apprenantAttente [] = $appTabElementValue;
                  }
                }
              }
              return $this->json($apprenantAttente,Response::HTTP_OK,);
            }

          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }

        }

        /**
        * @Route(path="/api/admin/promo/{id}/groupe/{id2}/apprenants",
        *        name="apigetPromoIdGroupeIdApprenants",
        *        methods={"GET"},
        * defaults={
        *          "_controller"="\app\ControllerPromoController::getPromoIdGroupeIdApprenants",
        *         "_api_resource_class"=Promo::class,
        *         "_api_collection_operation_name"="getPromoIdGroupeIdApprenants"
        *         }
        *)
        */
        public function getPromoIdGroupeIdApprenants(Request $request,SerializerInterface $serializer, EntityManagerInterface $entityManager,ValidatorInterface $validator, PromoRepository $PromoRepo, GroupeApprenantRepository $GaRepo)
        {
          $promo = new Promo();

          $uri = $request->getUri();
          $uriTab = explode("/", $uri);
          $id1 = $uriTab[6];
          $id2 = $uriTab[8];

          if($this->isGranted("VIEW",$promo)){

            //On détermine si la promo existe dans la base de données
            $promo = $PromoRepo-> find($id1);
                        
            if (isset($promo)){
                                        
              // On transforme l'objet promo en tableau.
              $promoTab = $serializer->normalize($promo, 'json');

              $groupeApprenant = new GroupeApprenant();

              $groupeApprenant = $GaRepo-> find($id2);

              if (isset($groupeApprenant)){
                // On transforme l'objet  en tableau.
                $groupeApprenantTab = $serializer->normalize($groupeApprenant, 'json');
                //On récupére les groupes apprenants de la promo qu'on met dans un tableau
                $apprenants = $groupeApprenantTab["apprenants"];

                return $this->json($apprenants,Response::HTTP_OK,);
              }
              
            }else{
              return $this->json(["message" => "Cette promo n'existe pas."], Response::HTTP_FORBIDDEN);
            }
              
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }

        /**
        * @Route(path="/api/admin/promo/{id}/formateurs",
        *        name="apigetPromoIdFormateurs",
        *        methods={"GET"},
        * defaults={
        *          "_controller"="\app\ControllerPromoController::getPromoIdFormateurs",
        *         "_api_resource_class"=Promo::class,
        *         "_api_collection_operation_name"="getPromoIdFormateurs"
        *         }
        *)
        */
        public function getPromoIdFormateurs(Request $request,SerializerInterface $serializer, $id, EntityManagerInterface $entityManager,ValidatorInterface $validator, PromoRepository $PromoRepo, FormateurRepository $FormateurRepo)
        {
          $promo = new Promo();

          if($this->isGranted("VIEW",$promo)){

            //On détermine si la promo existe dans la base de données
            $promo = $PromoRepo-> find($id);
                        
            if (isset($promo)){
                                        
              // On transforme l'objet promo en tableau.
              $promoTab = $serializer->normalize($promo, 'json');

              //On récupére les groupes apprenants de la promo qu'on met dans un tableau
              $referentielTab = $promoTab["formateurs"];

              return $this->json($referentielTab,Response::HTTP_OK,);

            }else{
              return $this->json(["message" => "Cette promo n'existe pas."], Response::HTTP_FORBIDDEN);
            }
              
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }

        /**
        * @Route(path="/api/admin/promo/{id}", name="apiputPromoId", methods={"PUT"})
        */
        public function PutPromoId(Request $request,SerializerInterface $serializer, $id, EntityManagerInterface $entityManager,ValidatorInterface $validator, PromoRepository $promoRepo, ReferentielRepository $refRepo)
        {
          $promo = new Promo();

          if($this->isGranted("EDIT",$promo)){

            // Get Body content of the Request
            $promoJson = $request->getContent();

            //On détermine si le groupe compétence existe dans la base de données
            $promo = $promoRepo-> find($id);

            if (isset($promo)){
                                        
              // On transforme les données json en tableau
              $promoTab = $serializer->decode($promoJson, 'json');
               
              //On détermine si dans le tableau nous avons les champs libellé et descriptif sont rempli
              //puis on les set.
              if (!empty($promoTab["langue"])){
                $promo->setLangue($promoTab["langue"]);
              }
              if (!empty($promoTab["titre"])){
                $promo->setTitre($promoTab["titre"]);
              }
              if (!empty($promoTab["descriptif"])){
                $promo->setDescriptif($promoTab["descriptif"]);
              }
              if (!empty($promoTab["lieu"])){
                $promo->setLieu($promoTab["lieu"]);
              }
              if (!empty($promoTab["fabrique"])){
                $promo->setFabrique($promoTab["fabrique"]);
              }
              if (!empty($promoTab["etat"])){
                $promo->setEtat($promoTab["etat"]);
              }

              //On récupére les compétences qu'on met dans un tableau
              $referentielTab = $promoTab["referentiel"];

              if (!empty($referentielTab)){
                    //On crée un objet
                    $referentiel = new Referentiel();

                    $referentiel = $refRepo-> find($referentielTab["id"]);
                    
                    $promo->setReferentiel($referentiel);
              }

              //$entityManager = $this->getDoctrine()->getManager();
              $entityManager->persist($promo);
              $entityManager->flush();
              return new JsonResponse("success",Response::HTTP_CREATED,[],true);
            }else{
              return $this->json(["message" => "Cet Id n'existe pas."], Response::HTTP_FORBIDDEN);
            }
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }

        /**
        * @Route(path="/api/admin/promo/{id}/formateurs", name="apiputPromoIdFormateur", methods={"PUT"})
        */
        public function PutPromoIdFormateur(Request $request,SerializerInterface $serializer, $id, EntityManagerInterface $entityManager,ValidatorInterface $validator, PromoRepository $promoRepo, FormateurRepository $formateurRepo)
        {
          $promo = new Promo();
          $formateur = new Formateur();

          if($this->isGranted("EDIT",$promo)){

            // Get Body content of the Request
            $promoJson = $request->getContent();

            //On détermine si la promo existe dans la base de données
            $promo = $promoRepo-> find($id);

            if (isset($promo)){
            // On transforme les données json en tableau
            $promoTabBD = $serializer->normalize($promo, 'json');
            //dd($promoTabBD);
            $formateurPromo = $promoTabBD["formateurs"];
            //dd($formateurTabBD);

            foreach ($formateurPromo as $key => $value) {
              $formateurEmailsPromo []= $value["email"];
            }
            //dd($formateurEmailsP);

              // On transforme les données json en tableau
              $promoTabPostman = $serializer->decode($promoJson, 'json');
               
              //On détermine si dans le tableau nous avons les champs libellé et descriptif sont rempli
              //puis on les set.
              if (!empty($promoTabPostman["langue"])){
                $promo->setLangue($promoTabPostman["langue"]);
              }
              if (!empty($promoTabPostman["titre"])){
                $promo->setTitre($promoTabPostman["titre"]);
              }
              if (!empty($promoTabPostman["descriptif"])){
                $promo->setDescriptif($promoTabPostman["descriptif"]);
              }
              if (!empty($promoTabPostman["lieu"])){
                $promo->setLieu($promoTabPostman["lieu"]);
              }
              if (!empty($promoTabPostman["fabrique"])){
                $promo->setFabrique($promoTabPostman["fabrique"]);
              }
              if (!empty($promoTabPostman["etat"])){
                $promo->setEtat($promoTabPostman["etat"]);
              }

              //On récupére les compétences qu'on met dans un tableau
              $formateurTabPostman = $promoTabPostman["formateurs"];

              foreach ($formateurTabPostman as $key => $value) {
                $idPostman = $value["id"];
                $formateur = $formateurRepo -> find($idPostman);
                $formateurTabBD  = $serializer->normalize($formateur, 'json');
                
                $formateurEmailsPostman []= $formateurTabBD["email"];
              }

              foreach ($formateurEmailsPostman as $key => $value) {
                foreach ($formateurEmailsPromo as $k => $v) {
                  if($value==$v){
                    $promo->removeFormateur($formateur);
                  }else{
                    $promo->addFormateur($formateur);
                  }
                }
              }
              

              //$entityManager = $this->getDoctrine()->getManager();
              $entityManager->persist($promo);
              $entityManager->flush();
              return new JsonResponse("success",Response::HTTP_CREATED,[],true);
            }else{
              return $this->json(["message" => "Cet Id n'existe pas."], Response::HTTP_FORBIDDEN);
            }
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }

        }

        /**
        * @Route(path="/api/admin/promo/{id}/groupes/{id2}", name="apiputPromoIdGroupesId", methods={"PUT"})
        */
        public function putPromoIdGroupesId(Request $request,SerializerInterface $serializer, EntityManagerInterface $entityManager,ValidatorInterface $validator, PromoRepository $PromoRepo, GroupeApprenantRepository $GaRepo)
        {
          $promo = new Promo();

          $uri = $request->getUri();
          $uriTab = explode("/", $uri);
          $id1 = $uriTab[6];
          $id2 = $uriTab[8];

          if($this->isGranted("VIEW",$promo)){

            //On détermine si la promo existe dans la base de données
            $promo = $PromoRepo-> find($id1);
                        
            if (isset($promo)){
                                        
              // On transforme l'objet promo en tableau.
              $promoTab = $serializer->normalize($promo, 'json');

              $groupeApprenant = new GroupeApprenant();

              $groupeApprenant = $GaRepo-> find($id2);

              if (isset($groupeApprenant)){
                // On transforme l'objet  en tableau.
                $groupeApprenantTab = $serializer->normalize($groupeApprenant, 'json');

                $type = $groupeApprenantTab["type"];

                if($type=="Principal"){
                  return $this->json(["message" => "Vous ne pouvez pas modifier le statut du groupe principal."], Response::HTTP_FORBIDDEN);
                }else{
                  $statut = $groupeApprenantTab["statut"];
                  if ($statut == "actif"){
                    $statutModifier = "inactif";
                    $groupeApprenant->setStatut($statutModifier);
                  }else{
                    $statutModifier = "actif";
                    $groupeApprenant->setStatut($statutModifier);
                  }
                  $entityManager->persist($promo);
                  $entityManager->flush();
                  return new JsonResponse("Statut modifié à $statutModifier",Response::HTTP_CREATED,[],true);
                }

              }
              
            }else{
              return $this->json(["message" => "Cette promo n'existe pas."], Response::HTTP_FORBIDDEN);
            }
              
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }

        /**
        * @Route(path="/api/admin/promo/{id}/apprenants",
        * name="apiputPromoIdApprenants",
        * methods={"PUT"},
        *       defaults={
        *          "_controller"="\app\ControllerPromoController::putPromoIdApprenants",
        *         "_api_resource_class"=Promo::class,
        *         "_api_collection_operation_name"="putPromoIdApprenants"
        *         }
        *)
        */
        public function putPromoIdApprenants(Request $request,SerializerInterface $serializer, $id, EntityManagerInterface $entityManager,ValidatorInterface $validator, PromoRepository $promoRepo, ApprenantRepository $apprenantRepo, GroupeApprenantRepository $GaRepo)
        {
          $promo = new Promo();
          $apprenant = new Apprenant();
          $groupeApprenant = new GroupeApprenant();

          if($this->isGranted("EDIT",$promo)){

            // Get Body content of the Request
            $promoJson = $request->getContent();

            // On transforme les données json en tableau
            $promoTabPostman = $serializer->decode($promoJson, 'json');

            $groupeApprenantPostman = $promoTabPostman["groupeApprenants"];

            foreach ($groupeApprenantPostman as $key => $value) {
              $apprenantPostmanTab = $value["apprenants"];
              foreach ($apprenantPostmanTab as $k => $v) {
                $apprenant = $apprenantRepo->findByEmail($v["email"]);
                if ($apprenant){
                  $emailPostman []= $v["email"];
                }else{
                  return $this->json(["message" => "Cet apprenant n'existe pas."], Response::HTTP_FORBIDDEN);
                }
              }
            }

            //On détermine si la promo existe dans la base de données
            $promo = $promoRepo-> find($id);

            if (isset($promo)){
            // On transforme les données json en tableau
            $promoTabBD = $serializer->normalize($promo, 'json');
            //dd($promoTabBD);
            $groupeApprenantPromo = $promoTabBD["groupeApprenants"];

            //dd($groupeApprenantPromo);

            foreach ($groupeApprenantPromo as $key => $value) {
              $groupeApprenant = $GaRepo->findByName($value["nom"]);

                $groupes [] = $value["type"];
                foreach ($groupes as $k => $v) {
                  if($v == "Principal"){
                    $apprenantTab = $value["apprenants"];
     
                  }
                }
            }
            
            foreach ($apprenantTab as $key => $value) {
              $emailTabBD []= $value["email"];
            }

//Le dénormalize ne fonctionne pas bien à revoir --- Le dénormalize ne fonctionne pas bien à revoir --- Le dénormalize ne fonctionne pas bien à revoir --- Le dénormalize ne fonctionne pas bien à revoir --- Le dénormalize ne fonctionne pas bien à revoir --- Le dénormalize ne fonctionne pas bien à revoir --- Le dénormalize ne fonctionne pas bien à revoir 
              foreach ($emailPostman as $c => $d) {
                $apprenant = new Apprenant();
                $apprenant = $apprenantRepo->findByEmail($d);

                foreach ($apprenant as $e => $f) {
                  foreach ($emailTabBD as $a => $b) {
                    if($d==$b){
                      $groupeApprenant[0]->removeApprenant($apprenant[0]);
                      $message = "Supprimer";
                    }else{
                      $groupeApprenant[0]->addApprenant($apprenant[0]);
                      $message = "Ajouter";
                    }
                  }
                }
              }

              $promo->addGroupeApprenant($groupeApprenant[0]);
              //dd($promo);

              //$entityManager = $this->getDoctrine()->getManager();
              $entityManager->persist($promo);
              $entityManager->flush();
              return new JsonResponse("$message",Response::HTTP_CREATED,[],true);
            }else{
              return $this->json(["message" => "Cet Id n'existe pas."], Response::HTTP_FORBIDDEN);
            }
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }

        }
}
