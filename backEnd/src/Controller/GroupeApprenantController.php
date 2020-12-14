<?php

namespace App\Controller;

use DateTime;
use App\Entity\Promo;
use App\Entity\Apprenant;
use App\Entity\Formateur;
use App\Entity\GroupeApprenant;
use App\Repository\PromoRepository;
use App\Repository\ApprenantRepository;
use App\Repository\FormateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\GroupeApprenantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GroupeApprenantController extends AbstractController
{
        /**
        * @Route(path="/api/admin/groupes", name="api_get_groupes", methods={"GET"})
        */
        public function getGroupes(GroupeApprenantRepository $repo)
        {
                $grpApprenant = new GroupeApprenant;

                if($this->isGranted("VIEW",$grpApprenant)){
                        $grpApprenant = $repo->findAll();

                        return $this->json($grpApprenant,Response::HTTP_OK,);
                }else{
                        return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
                }
        }

        /**
        * @Route(path="/api/admin/groupes", name="apiAddGroupes", methods={"POST"})
        */
        public function AddGroupes(Request $request,SerializerInterface $serializer, EntityManagerInterface $entityManager,ValidatorInterface $validator, GroupeApprenantRepository $GaRepo, ApprenantRepository $apprenantRepo, PromoRepository $promoRepo, FormateurRepository $formateurRepo)
        {
          $grpApprenant = new GroupeApprenant();
          $apprenant = new Apprenant();
          $promo = new Promo();
          $formateur = new Formateur();
          $date = new DateTime();
          $date->format('Y-m-d');

          if($this->isGranted("EDIT",$grpApprenant)){

            // Get Body content of the Request
            $grpApprenantJson = $request->getContent();

            // On transforme les données json en tableau
            $grpApprenantTab = $serializer->decode($grpApprenantJson, 'json');

            foreach ($grpApprenantTab as $key => $value) {
              foreach ($value as $k => $v) {
                if ((isset($v["type"])) && ($v["type"] != "Principal")){

                  //On détermine si dans le tableau nous avons les champs libellé et descriptif sont rempli
                  //puis on les set.
                    if (!empty($v["nom"])){
                      $grpApprenant->setNom($v["nom"]);
                    }
                    $grpApprenant->setType($v["type"]);
                    $grpApprenant->setStatut("actif");
                    $grpApprenant->setDateCreation($date);
                  }else{
                    return $this->json(["message" => "Le groupe principal existe déja."], Response::HTTP_FORBIDDEN);
                  }

                  $apprenantTab = $v["apprenants"];
                  $promo = $v["promo"];
                  $formateurTab = $v["formateurs"];
              }
            }


            foreach ($apprenantTab as $key => $value) {
              foreach ($value as $k => $v) {
                $apprenant = $apprenantRepo->findByEmail($v);
                if($apprenant){
                  $grpApprenant->addApprenant($apprenant[0]);
                }
              }
            }

            foreach ($promo as $key => $value) {
              $idPromo = $value;
            }

            foreach ($formateurTab as $key => $value) {
              foreach ($value as $k => $v) {
                $formateur = $formateurRepo->findByEmail($v);
                if($formateur){
                  $grpApprenant->addFormateur($formateur[0]);
                }
              }
            }

            //On détermine si la promo existe dans la base de données
            $promo = $promoRepo-> find($idPromo);
            //dd($promo);

            if (isset($promo)){
              $grpApprenant->setPromo($promo);
            }else{
              return $this->json(["message" => "Cet Promo n'existe."], Response::HTTP_FORBIDDEN);
            }

              $entityManager->persist($grpApprenant);
              $entityManager->flush();
              return new JsonResponse("success",Response::HTTP_CREATED,[],true);
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }

        /**
        * @Route(path="/api/admin/groupes/apprenants",
        *        name="apigetGroupesApprenants",
        *        methods={"GET"},
        *       defaults={
        *          "_controller"="\app\ControllerGroupeApprenantController::getGroupesApprenants",
        *         "_api_resource_class"=GroupeApprenant::class,
        *         "_api_collection_operation_name"="getGroupesApprenants"
        *         }
        *)
        */
        public function getGroupesApprenants(Request $request,SerializerInterface $serializer, EntityManagerInterface $entityManager,ValidatorInterface $validator, GroupeApprenantRepository $GaRepo)
        {
          $groupeApprenant = new GroupeApprenant();

          if($this->isGranted("VIEW",$groupeApprenant)){

            $groupeApprenant = $GaRepo -> findAll();

            if (!empty($groupeApprenant)){
                                        
              $groupeApprenantTab = $serializer->normalize($groupeApprenant, 'json');

              foreach ($groupeApprenantTab as $key => $value) {
                $types []= $value["type"];
                foreach ($types as $k => $v) {
                  if ($v == "Principal" ){
                    $apprenants [] = $value["apprenants"];
                  }
                }
              }

              return $this->json($apprenants,Response::HTTP_OK,);
            }
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }

        /**
        * @Route(path="/api/admin/groupes/{id}/apprenant",
        *        name="apideleteGroupesIdApprenant",
        *        methods={"DELETE"},
        *       defaults={
        *          "_controller"="\app\ControllerGroupeApprenantController::deleteGroupesIdApprenant",
        *         "_api_resource_class"=GroupeApprenant::class,
        *         "_api_collection_operation_name"="deleteGroupesIdApprenant"
        *         }
        *)
        */
        public function deleteGroupesIdApprenant(Request $request, $id, SerializerInterface $serializer, EntityManagerInterface $entityManager,ValidatorInterface $validator, GroupeApprenantRepository $GaRepo, ApprenantRepository $apprenantRepo)
        {
          $groupeApprenant = new GroupeApprenant();
          $apprenant = new Apprenant();

          if($this->isGranted("VIEW",$groupeApprenant)){

            $groupeApprenant = $GaRepo -> find($id);

            if (isset($groupeApprenant)){
              // Get Body content of the Request
              $grpApprenantJson = $request->getContent();

              // On transforme les données json en tableau
              $grpApprenantTab = $serializer->decode($grpApprenantJson, 'json');

              foreach ($grpApprenantTab as $key => $value) {
                foreach ($value as $k => $v) {
                  foreach ($v as $x => $y) {
                    $apprenant = $apprenantRepo->findByEmail($y);
                  }
                }
              }

              if ($apprenant){
                  //$apprenantTab = $serializer->normalize($val, 'json');
                  $groupeApprenant->removeApprenant($apprenant[0]);
                }else{
                  return $this->json(["message" => "Aucun apprenant n'a cet email."], Response::HTTP_FORBIDDEN);
                }
              }

              $entityManager->persist($groupeApprenant);
              $entityManager->flush();
              return $this->json(["message" => "Suppression réussi."]);
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }

        /**
        * @Route(path="/api/admin/groupes/{id}",
        *        name="apiPutGroupesId",
        *        methods={"put"}
        *)
        */
        public function PutGroupesId(Request $request, $id, SerializerInterface $serializer, EntityManagerInterface $entityManager,ValidatorInterface $validator, GroupeApprenantRepository $GaRepo, ApprenantRepository $apprenantRepo)
        {
          $groupeApprenant = new GroupeApprenant();
          $apprenant = new Apprenant();

          if($this->isGranted("VIEW",$groupeApprenant)){

            $groupeApprenant = $GaRepo -> find($id);

            if (isset($groupeApprenant)){
              // Get Body content of the Request
              $grpApprenantJson = $request->getContent();

              // On transforme les données json en tableau
              $grpApprenantTab = $serializer->decode($grpApprenantJson, 'json');

              foreach ($grpApprenantTab as $key => $value) {
                foreach ($value as $k => $v) {
                  foreach ($v as $x => $y) {
                    $apprenant = $apprenantRepo->findByEmail($y);
                  }
                }
              }

              if ($apprenant){
                  //$apprenantTab = $serializer->normalize($val, 'json');
                  $groupeApprenant->addApprenant($apprenant[0]);
                }else{
                  return $this->json(["message" => "Aucun apprenant n'a cet email."], Response::HTTP_FORBIDDEN);
                }
              }

              $entityManager->persist($groupeApprenant);
              $entityManager->flush();
              return $this->json(["message" => "Ajout réussi."]);
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }
        }
}
