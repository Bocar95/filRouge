<?php

namespace App\Controller;

use App\Entity\Competences;
use App\Entity\GroupeCompetences;
use App\Repository\UserRepository;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CompetencesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\GroupeCompetencesRepository;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Core\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GrpCompetencesController extends AbstractController
{
        /**
        * @Route(path="/api/admin/grpCompetences", name="api_get_grpCompetences", methods={"GET"})
        */
        public function getGrpCompetences(GroupeCompetencesRepository $repo)
        {
                $grpCompetences = new GroupeCompetences;

                if($this->isGranted("VIEW",$grpCompetences)){
                        $grpCompetences = $repo->findAll();

                        return $this->json($grpCompetences,Response::HTTP_OK,);
                }else{
                        return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
                }
        }

        /**
        * @Route(path="/api/admin/grpCompetences/competences",
        *        name="apiGetGrpCompCompetences",
        *        methods={"GET"},
        *       defaults={
        *          "_controller"="\app\ControllerGrpCompetencesController::getGrpCompCompetences",
        *         "_api_resource_class"=GroupeCompetences::class,
        *         "_api_collection_operation_name"="getGrpCompCompetences"
        *         }
        *)
        */
        public function getGrpCompCompetences(Request $request,SerializerInterface $serializer, EntityManagerInterface $entityManager,ValidatorInterface $validator, AdminRepository $AdminRepo, CompetencesRepository $CompRepo, GroupeCompetencesRepository $grpCompRepo)
        {
          //On cré un objet de groupe de competences
          $grpCompetences = new GroupeCompetences();

          //Ici On vérifie l'autorisation d'accés.
          if($this->isGranted("VIEW",$grpCompetences)){

            //On récupére tous les groupes de compétences existant qu'on place dans une variable
            $grpCompetences = $grpCompRepo-> findAll();
                        
            if (!empty($grpCompetences)){
                                        
              // On transforme les groupes de competences "objets" en tableau.
              $grpCompetencesTab = $serializer->normalize($grpCompetences, 'json');

              //On cré un objet de compétence puis on récupére tous les compétences existant
              $competence = new Competences();
              $competence = $CompRepo-> findAll();

              //on détermine le nombre total de groupes de compétences
              $total= count($grpCompetencesTab);

              //on détermine le nombre total de compétences
              $total2= count($competence);

              //Ici on récupére les compétences qui sont dans les groupes de compétence...
              //puis on les place dans un tableau
              for ($i=0; $i < $total; $i++) {
                for ($j=0; $j < $total2; $j++) {
                  if (isset($grpCompetencesTab[$i]["competences"][$j])){
                    $competences []= $grpCompetencesTab[$i]["competences"][$j];
                  }
                }
              }

              //enfin on retourne le resultat
              return $this->json($competences,Response::HTTP_OK,);

            }else{
              return $this->json(["message" => "Les groupes de compétences n'existe pas dans la base de données."], Response::HTTP_FORBIDDEN);
            }
              
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }

        }
    
        /**
        * @Route(path="/api/admin/grpCompetences", name="api_add_grpCompetences", methods={"POST"})
        */
        public function addGrpCompetences(Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManager,ValidatorInterface $validator, AdminRepository $AdminRepo)
        {
                $grpCompetences = new GroupeCompetences();

                if($this->isGranted("EDIT",$grpCompetences)){
                        // Get Body content of the Request
                        $grpCompetencesJson = $request->getContent();

                        // On transforme le json en tableau
                        $grpCompetencesTab = $serializer->decode($grpCompetencesJson, 'json');
                        
                        $grpCompetences->setLibelle($grpCompetencesTab["libelle"]);
                        $grpCompetences->setDescriptif($grpCompetencesTab["descriptif"]);

                        $competencesTab = $grpCompetencesTab["competences"];
                        //dd($competencesTab[0]["id"]);

                        foreach ($competencesTab as $key => $value){
                                $competence = new Competences();
                                $competence->setLibelle($value["libelle"]);
                                $competence->setDescriptif($value["descriptif"]);
                                $grpCompetences->addCompetence($competence);
                        }

                        $token = substr($request->server->get("HTTP_AUTHORIZATION"), 7);
                        $token = explode(".",$token);

                        $payload = $token[1];
                        $payload = json_decode(base64_decode($payload));

                        $admin = $AdminRepo->findOneBy([
                                "username" => $payload->username
                        ]);

                        $grpCompetences->setAdmin($admin);
                        //dd($grpCompetences);

                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($grpCompetences);
                        $entityManager->flush();
                        return new JsonResponse("success",Response::HTTP_CREATED,[],true);
                }
                else{
                        return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
                }

        }


        /**
        * @Route(path="/api/admin/grpCompetences/{id}", name="api_upd_grpCompetences", methods={"PUT"})
        */
        public function UpdateGrpCompetences(Request $request,SerializerInterface $serializer, $id, EntityManagerInterface $entityManager,ValidatorInterface $validator, AdminRepository $AdminRepo, CompetencesRepository $CompRepo, GroupeCompetencesRepository $grpCompRepo)
        {
          $grpCompetences = new GroupeCompetences();

          if($this->isGranted("EDIT",$grpCompetences)){

            // Get Body content of the Request
            $grpCompetencesJson = $request->getContent();

            //On détermine si le groupe compétence existe dans la base de données
            $grpCompetences = $grpCompRepo-> find($id);
                        
            if (isset($grpCompetences)){
                                        
              // On transforme les données json en tableau
              $grpCompetencesTab = $serializer->decode($grpCompetencesJson, 'json');
               
              //On détermine si dans le tableau nous avons les champs libellé et descriptif sont rempli
              //puis on les set.
              if (!empty($grpCompetencesTab["libelle"])){
                $grpCompetences->setLibelle($grpCompetencesTab["libelle"]);
              }
              if (!empty($grpCompetencesTab["descriptif"])){
                $grpCompetences->setDescriptif($grpCompetencesTab["descriptif"]);
              }

              //On récupére les compétences qu'on met dans un tableau
              $competencesTab = $grpCompetencesTab["competences"];

              if (!empty($competencesTab)){

                //On parcour le tableau de competence
                foreach ($competencesTab as $key => $value){

                    //On crée un objet
                  $competence = new Competences();

                  $nbrElement = count($value);
                                          
                  if (isset($value["id"])){

                    $competence = $CompRepo-> find($value["id"]);
                    
                    if (isset($competence)){
                        if($nbrElement==3){
                            $competence->setLibelle($value["libelle"]);
                            $competence->setDescriptif($value["descriptif"]);
                        }elseif($nbrElement==1){
                            //dd($nbrElement);
                            $grpCompetences->removeCompetence($competence);
                        }
                    }

                  }else{
                    $competence->setLibelle($value["libelle"]);
                    $competence->setDescriptif($value["descriptif"]);
                    $grpCompetences->addCompetence($competence);
                  }
                }
              }

              $token = substr($request->server->get("HTTP_AUTHORIZATION"), 7);
              $token = explode(".",$token);

              $payload = $token[1];
              $payload = json_decode(base64_decode($payload));

              $admin = $AdminRepo->findOneBy([
                "username" => $payload->username
              ]);

              $grpCompetences->setAdmin($admin);
              //dd($grpCompetences);

              //$entityManager = $this->getDoctrine()->getManager();
              $entityManager->persist($grpCompetences);
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
        * @Route(path="/api/admin/grpCompetences/{id}/competences",
        *        name="apiGetGrpIdCompetences",
        *        methods={"GET"},
        * defaults={
        *          "_controller"="\app\ControllerGrpCompetencesController::getGrpIdCompetences",
        *         "_api_resource_class"=GroupeCompetences::class,
        *         "_api_collection_operation_name"="getGrpIdCompetences"
        *         }
        *)
        */
        public function getGrpIdCompetences(Request $request,SerializerInterface $serializer, $id, EntityManagerInterface $entityManager,ValidatorInterface $validator, AdminRepository $AdminRepo, CompetencesRepository $CompRepo, GroupeCompetencesRepository $grpCompRepo)
        {
          $grpCompetences = new GroupeCompetences();

          if($this->isGranted("VIEW",$grpCompetences)){

            //On détermine si le groupe compétence existe dans la base de données
            $grpCompetences = $grpCompRepo-> find($id);
                        
            if (isset($grpCompetences)){
                                        
              // On transforme les groupes de competences "objets" en tableau.
              $grpCompetencesTab = $serializer->normalize($grpCompetences, 'json');

              //On récupére les compétences qu'on met dans un tableau
              $competencesTab = $grpCompetencesTab["competences"];
              //dd($competencesTab);

              if (!empty($competencesTab)){
                return $this->json($competencesTab,Response::HTTP_OK,);
              }
            }else{
              return $this->json(["message" => "Ce groupe de competences n'existe pas."], Response::HTTP_FORBIDDEN);
            }
              
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }

        }
}

        
