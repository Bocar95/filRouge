<?php

namespace App\Service;

use App\Entity\Cm;
use App\Entity\Admin;
use App\Entity\Profil;
use App\Entity\Apprenant;
use App\Entity\Formateur;
use App\Repository\UserRepository;
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
   private $userRepo;

     public function __construct(SerializerInterface $serializer ,UserPasswordEncoderInterface $encoder, ProfilRepository $profilRepo, UserRepository $userRepo){
      $this->serializer = $serializer;
      $this->encoder = $encoder;
      $this->profilRepo = $profilRepo;
      $this->userRepo = $userRepo;
     }

    public function addUser($profil,$request,$manager){
      
      $data = $request->getContent();

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

      $user = $this->serializer->decode($data, 'json');
      $user = $this->serializer->denormalize($user, $userType, 'json');
      
      $user->setProfil($this->profilRepo->findOneBy(['libelle'=>$profil]));
      
      $password = $user->getPassword();
      $user->setPassword($this->encoder->encodePassword($user,$password));

      $manager->persist($user);
      $manager->flush();

      return $user;

    }

    public function putUser($id,$userRepo,$profilRepo,$request,$manager) {
        // Get Body content of the Request
        $data = $request->getContent();
        $user = $userRepo-> find($id);

        if($user){
          // On transforme les données json en tableau
          $userTab = $this->serializer->decode($data, 'json');

          if (!empty($userTab["prenom"])){
            $user->setPrenom($userTab["prenom"]);
          }
          if (!empty($userTab["nom"])){
            $user->setNom($userTab["nom"]);
          }
          if (!empty($userTab["email"])){
            $user->setEmail($userTab["email"]);
          }
          if (!empty($userTab["adresse"])){
            $user->setAdresse($userTab["adresse"]);
          }

          $profil = new Profil();
          $profil = $profilRepo-> findOneBy(['libelle'=>$userTab["profil"]]);
          $user->setProfil($profil);
        
          //$entityManager = $this->getDoctrine()->getManager();
          $manager->persist($user);
          $manager->flush();
          return $user;
        }else{
          return $this->json(["message" => "Cet Id n'existe pas."], Response::HTTP_FORBIDDEN);
        }
    }

}