<?php

namespace App\Controller;

use App\Entity\Niveau;
use App\Entity\Competences;
use App\Repository\NiveauRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CompetencesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Core\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompetencesController extends AbstractController
{
        /**
        * @Route(path="/api/admin/competences", name="api_get_competences", methods={"GET"})
        */
        public function getCompetences(CompetencesRepository $repo)
        {
                $Competences = new Competences;

                if($this->isGranted("VIEW",$Competences)){
                        $Competences= $repo->findAll();
                        return $this->json($Competences,Response::HTTP_OK,);
                }else{
                        return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
                }
        }
    
        /**
        * @Route(path="/api/admin/competences", name="api_add_competences", methods={"POST"})
        */
        public function addCompetences(Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManager,ValidatorInterface $validator)
        {
                $competences = new Competences;

                if($this->isGranted("EDIT",$competences)){

                        // Get Body content of the Request
                        $competencesJson = $request->getContent();

                        // On transforme le json en tableau
                        $competencesTab = $serializer->decode($competencesJson, 'json');
                        //dd($competencesTab["libelle"]);

                        $competences->setLibelle($competencesTab["libelle"]);
                        $competences->setDescriptif($competencesTab["descriptif"]);

                        $niveauTab = $competencesTab["niveau"];

                        foreach ($niveauTab as $key => $value){
                                $niveau = new Niveau();
                                $niveau->setLibelle($value["libelle"]);
                                $niveau->setCritereEvaluation($value["critereEvaluation"]);
                                $niveau->setGroupeAction($value["groupeAction"]);
                                $competences->addNiveau($niveau);
                        }
                        //dd($competences);

                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($competences);
                        $entityManager->flush();
                        return new JsonResponse("success",Response::HTTP_CREATED,[],true);
                }
                else{
                        return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
                }
        }


        /**
        * @Route(path="/api/admin/competences/{id}", name="api_upd_competence", methods={"PUT"})
        */
        public function UpdateCompetences(Request $request,SerializerInterface $serializer, $id, EntityManagerInterface $entityManager,ValidatorInterface $validator, CompetencesRepository $CompRepo,NiveauRepository $niveauRepo)
        {
          $competence = new Competences();

          if($this->isGranted("EDIT",$competence)){

            // Get Body content of the Request
            $competenceJson = $request->getContent();

            //On détermine si le groupe compétence existe dans la base de données
            $competence = $CompRepo-> find($id);
                        
            if (isset($competence)){
                                        
              // On transforme les données json en tableau
              $competenceTab = $serializer->decode($competenceJson, 'json');
               
              //On détermine si dans le tableau nous avons les champs libellé et descriptif sont rempli
              //puis on les set.
              if (!empty($competenceTab["libelle"])){
                $competence->setLibelle($competenceTab["libelle"]);
              }
              if (!empty($competenceTab["descriptif"])){
                $competence->setDescriptif($competenceTab["descriptif"]);
              }

              //On récupére les compétences qu'on met dans un tableau
              $niveauTab = $competenceTab["niveau"];

              if (!empty($niveauTab)){

                //On parcour le tableau de competence
                foreach ($niveauTab as $key => $value){

                    //On crée un objet
                  $niveau = new Niveau();

                  $nbrElement = count($value);
                                          
                  if (isset($value["id"])){

                    $niveau = $niveauRepo-> find($value["id"]);
                    
                    if (isset($niveau)){
                        if($nbrElement==4){
                            $niveau->setLibelle($value["libelle"]);
                            $niveau->setCritereEvaluation($value["critereEvaluation"]);
                            $niveau->setGroupeAction($value["groupeAction"]);
                        }elseif($nbrElement==1){
                            //dd($nbrElement);
                            $competence->removeNiveau($niveau);
                        }
                    }

                  }else{
                    $niveau->setLibelle($value["libelle"]);
                    $niveau->setCritereEvaluation($value["critereEvaluation"]);
                    $niveau->setGroupeAction($value["groupeAction"]);
                    $competence->addNiveau($niveau);
                  }
                }
              }

              //dd($competence);

              //$entityManager = $this->getDoctrine()->getManager();
              $entityManager->persist($competence);
              $entityManager->flush();
              return new JsonResponse("success",Response::HTTP_CREATED,[],true);
            }else{
              return $this->json(["message" => "Cet Id n'existe pas."], Response::HTTP_FORBIDDEN);
            }
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }

        }

}
