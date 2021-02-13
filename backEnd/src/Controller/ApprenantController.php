<?php

namespace App\Controller;

use App\Service\Service;
use App\Repository\UserRepository;
use App\Repository\ProfilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ApprenantController extends AbstractController
{
    /**
     * @Route("/api/apprenant", name="add_apprenant", methods={"POST"})
     */
    public function addApprenant(Request $request,SerializerInterface $serializer ,UserPasswordEncoderInterface $encoder, ProfilRepository $profilRepo, EntityManagerInterface $manager)
    {
      if ($this->isGranted('ROLE_ADMIN','ROLE_FORMATEUR')) {
        $service = new Service($serializer,$encoder,$profilRepo);
        $apprenant = $service->addUser('APPRENANT', $request,$manager);

        return new JsonResponse("success",Response::HTTP_CREATED,[],true);
      }
      else{
        return $this->json("Access denied!!!");
      }
    }

    /**
     * @Route("/api/apprenant/{id}", name="put_apprenant", methods={"PUT"})
     */
    public function putApprenant($id, Request $request,SerializerInterface $serializer ,UserPasswordEncoderInterface $encoder, ProfilRepository $profilRepo, UserRepository $userRepo, EntityManagerInterface $manager)
    {
      if ($this->isGranted('ROLE_ADMIN')) {
        $service = new Service($serializer, $encoder, $profilRepo, $userRepo);
        $apprenant = $service->putUser($id, $userRepo, $profilRepo, $request, $manager);
        return new JsonResponse("success",Response::HTTP_CREATED,[],true);
      }
      else{
        return $this->json("Access denied!!!");
      }
    }
}
