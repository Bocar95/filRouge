<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Profil;
use App\Repository\UserRepository;
use App\Repository\ProfilRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    /**
        * @Route(
        *        path="/api/admin/profils/{id}/users",
        *        name="getUsersProfil",
        *        methods={"GET"},
        * defaults={
        *         "_controller"="\app\ProfilController::getUsersProfil",
        *         "_api_resource_class"=Profil::class,
        *         "_api_collection_operation_name"="getUsersProfil"
        *         }
        *)
        */
        public function getUsersProfil(ProfilRepository $profilRepository, UserRepository $userRepository ,int $id)
        {
            $profil = $profilRepository->find($id);

            if(!empty($profil)) {
                foreach ($profil->getUsers() as $profilUsers) {
                    $users[] = [
                        "Users"=>$userRepository->findOneBy([ 'id' => $profilUsers->getProfil()->getId() ])
                    ];
                }
            return $this->json($users, 200, [], ["groups" => ["users_profil:read"]]);
            }
            return new Response("Ce profil n'existe pas.");
        }
}
