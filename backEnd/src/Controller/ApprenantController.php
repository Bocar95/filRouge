<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Apprenant;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ApprenantController extends AbstractController
{
        /**
        * @Route(path="/api/apprenants", name="ajout_apprenants", methods={"POST"})
        */
        public function addApprenant(Request $request,SerializerInterface $serializer,UserPasswordEncoderInterface $encoder,EntityManagerInterface $manager,ValidatorInterface $validator)
        {
            if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_FORMATEUR')){

                // Get Body content of the Request
                $userJson = $request->getContent();
                
                // Deserialize and insert into dataBase
                $user = $serializer->deserialize($userJson, Apprenant::class,'json');

                // Data Validation
                $errors = $validator->validate($user);
                if (count($errors)>0) {
                    $errorsString =$serializer->serialize($errors,"json");
                    return new JsonResponse( $errorsString ,Response::HTTP_BAD_REQUEST,[],true);
                }

                $entityManager = $this->getDoctrine()->getManager();
                $password = $user->getPassword();
                $user->setPassword($encoder->encodePassword($user, $password));
                $entityManager->persist($user);
                $entityManager->flush();
                return new JsonResponse("success",Response::HTTP_CREATED,[],true);

            }
            else{
                return $this->json("Access denied!!!");
            }
        }

        //Seuls Les ADMIN/CM/Formateurs Peuvent Lister les Apprenants!!!

        /**
        * @Route(path="/api/apprenants",
        * name="api_get_apprenants",
        * methods={"GET"},
        * defaults={
        *   "_controller"="\app\ApprenantController::getApprenants",
        *   "_api_resource_class"=User::class,
        *   "_api_collection_operation_name"="get_apprenants"
        *})
        */
        public function getApprenants(ApprenantRepository $repo)
        {
            if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_FORMATEUR') || $this->isGranted('ROLE_CM') ) {
                $apprenants= $repo->findByProfil("APPRENANT");
                //dd($apprenants);
                return $this->json($apprenants,Response::HTTP_OK,);
            }
            else{
                return $this->json("Access denied!!!");
            }
        }
}
