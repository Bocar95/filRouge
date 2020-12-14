<?php

namespace App\Controller;

use App\Entity\GroupeTag;
use App\Repository\AdminRepository;
use App\Repository\GroupeTagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GroupetagController extends AbstractController
{
        /**
        * @Route(path="/api/admin/grptags", name="api_get_grptags", methods={"GET"})
        */
        public function getGrpTag(GroupeTagRepository $repo)
        {
                $tag = new GroupeTag;

                if($this->isGranted("VIEW",$tag)){
                        $tag= $repo->findAll();
                        return $this->json($tag,Response::HTTP_OK,);
                }else{
                        return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
                }
        }
    
        /**
        * @Route(path="/api/admin/grptags", name="api_add_grptags", methods={"POST"})
        */
        public function addGrpTag(Request $request,SerializerInterface $serializer,EntityManagerInterface $manager,ValidatorInterface $validator, AdminRepository $AdminRepo)
        {
                $grpTag = new GroupeTag;

                if($this->isGranted("EDIT",$grpTag)){

                        // Get Body content of the Request
                        $grpTagJson = $request->getContent();

                        // Deserialize and insert into dataBase
                        $grpTag = $serializer->deserialize($grpTagJson, GroupeTag::class,'json');

                        $token = substr($request->server->get("HTTP_AUTHORIZATION"), 7);
                        $token = explode(".",$token);

                        $payload = $token[1];
                        $payload = json_decode(base64_decode($payload));

                        $admin = $AdminRepo->findOneBy([
                                "username" => $payload->username
                        ]);

                        $grpTag->addAdmin($admin);

                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($grpTag);
                        $entityManager->flush();

                        return new JsonResponse("success",Response::HTTP_CREATED,[],true);
                }
                else{
                        return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
                }


        }
}
