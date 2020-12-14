<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TagController extends AbstractController
{
        /**
        * @Route(path="/api/admin/tags", name="api_get_tags", methods={"GET"})
        */
        public function getTag(TagRepository $repo)
        {
                $tag = new Tag;

                if($this->isGranted("VIEW",$tag)){
                        $tag= $repo->findAll();
                        return $this->json($tag,Response::HTTP_OK,);
                }else{
                        return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
                }
        }
    
        /**
        * @Route(path="/api/admin/tags", name="api_add_tags", methods={"POST"})
        */
        public function addTag(Request $request,SerializerInterface $serializer,EntityManagerInterface $manager,ValidatorInterface $validator)
        {
                $tag = new Tag;

                if($this->isGranted("EDIT",$tag)){

                        // Get Body content of the Request
                        $tagJson = $request->getContent();

                        // Deserialize and insert into dataBase
                        $tag = $serializer->deserialize($tagJson, Tag::class,'json');

                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($tag);
                        $entityManager->flush();

                        return new JsonResponse("success",Response::HTTP_CREATED,[],true);
                }
                else{
                        return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
                }


        }
}
