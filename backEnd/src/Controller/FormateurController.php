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

class FormateurController extends AbstractController
{
    /**
     * @Route("/api/formateur", name="add_formateur", methods={"POST"})
     */
    public function addFormateur(Request $request,SerializerInterface $serializer ,UserPasswordEncoderInterface $encoder, ProfilRepository $profilRepo, EntityManagerInterface $manager)
    {
      if ($this->isGranted('ROLE_ADMIN')) {
        $service = new Service($serializer,$encoder,$profilRepo);
        $formateur = $service->addUser('FORMATEUR', $request,$manager);

        return new JsonResponse("success",Response::HTTP_CREATED,[],true);
      }
      else{
        return $this->json("Access denied!!!");
      }
    }

    /**
     * @Route("/api/formateur/{id}", name="put_formateur", methods={"PUT"})
     */
    public function putFormateur($id, Request $request,SerializerInterface $serializer ,UserPasswordEncoderInterface $encoder, ProfilRepository $profilRepo, UserRepository $userRepo, EntityManagerInterface $manager)
    {
      if ($this->isGranted('ROLE_ADMIN')) {
        $service = new Service($serializer, $encoder, $profilRepo, $userRepo);
        $formateur = $service->putUser($id, $userRepo, $profilRepo, $request, $manager);
        return new JsonResponse("success",Response::HTTP_CREATED,[],true);
      }
      else{
        return $this->json("Access denied!!!");
      }
    }
}
