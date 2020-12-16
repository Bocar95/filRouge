<?php

namespace App\Service;

use App\Entity\Cm;
use App\Entity\Admin;
use App\Entity\Apprenant;
use App\Entity\Formateur;
use App\Repository\ProfilRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Service{

   private $serializer;
   private $encoder;
   private $profilRepo;

     public function __construct(SerializerInterface $serializer ,UserPasswordEncoderInterface $encoder, ProfilRepository $profilRepo){
      $this->serializer = $serializer;
      $this->encoder = $encoder;
      $this->repo = $profilRepo;
     }

    public function addUser($profil, Request $request,$manager){
      
      $data = $request->request->all();

      $uploadedFile = $request->files->get('avatar');

      if($uploadedFile){
        $file = $uploadedFile->getRealPath();
        $avatar = fopen($file, 'r+');
        $data['avatar'] = $avatar;
      }

      if($profil=='ADMIN'){
        $userType = Admin::class;
      }elseif ($profil=='FORMATEUR') {
        $userType = Formateur::class;
      }elseif ($profil=='CM') {
        $userType = Cm::class;
      }elseif ($profil=='APPRENANT') {
        $userType = Apprenant::class;
      }

      $user = $this->serializer->denormalize($data, $userType, 'json');

      $user->setProfil($this->repo->findOneBy(['libelle'=>$profil]));

      $password = $user->getPassword();
      $user->setPassword($this->encoder->encodePassword($user,$password));

      $manager->persist($user);
      $manager->flush();

      return $user;

    }

}