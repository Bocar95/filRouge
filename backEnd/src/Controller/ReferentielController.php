<?php

namespace App\Controller;

use App\Entity\Referentiel;
use App\Entity\GroupeCompetences;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReferentielRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\GroupeCompetencesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReferentielController extends AbstractController
{
        /**
        * @Route(path="/api/admin/referentiels", name="api_get_referentiels", methods={"GET"})
        */
        public function getReferentiels(ReferentielRepository $repo)
        {
                $referentiel = new Referentiel();

                if($this->isGranted("VIEW",$referentiel)){
                  $referentiel = $repo->findAll();

                  return $this->json($referentiel,Response::HTTP_OK,);
                }else{
                        return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
                }
        }

        /**
        * @Route(path="/api/admin/referentiels/grpecompetences",
        *        name="apiGetRefGrpComp",
        *        methods={"GET"},
        *        defaults={
        *               "_controller"="\app\ControllerReferentielController::getRefGrpCompetences",
        *               "_api_resource_class"=Referentiel::class,
        *               "_api_collection_operation_name"="getRefGrpCompetences"
        *         }
        *)
        */
        public function getRefGrpCompetences(Request $request,SerializerInterface $serializer, EntityManagerInterface $entityManager,ValidatorInterface $validator, ReferentielRepository $RefRepo, GroupeCompetencesRepository $grpCompRepo)
        {
          $referentiel = new Referentiel();

          if($this->isGranted("VIEW",$referentiel)){

            //On récupére tous les referentiel existant qu'on place dans une variable
            $referentiel = $RefRepo-> findAll();
                        
            if (isset($referentiel)){
                                        
              // On transforme les referentiel "objets" en tableau.
              $referentielTab = $serializer->normalize($referentiel, 'json');

              //On cré un objet de groupe compétence puis on récupére ceux existant
              $grpCompetence = new GroupeCompetences();
              $grpCompetence = $grpCompRepo-> findAll();

              //on détermine le nombre total de referentiel
              $total= count($referentielTab);

              //on détermine le nombre total de groupe compétences
              $total2= count($grpCompetence);

              //Ici on récupére les groupes compétences qui sont dans les referentiels...
              //puis on les place dans un tableau
              for ($i=0; $i < $total; $i++) {
                for ($j=0; $j < $total2; $j++) {
                  if (isset($referentielTab[$i]["groupeCompetences"][$j])){
                    $grpCompetences []= $referentielTab[$i]["groupeCompetences"][$j];
                  }
                }
              }

              //enfin on retourne le resultat
              return $this->json($grpCompetences,Response::HTTP_OK,);
            }
              
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }

        }


        /**
        * @Route(path="/api/admin/referentiels", name="api_add_referentiels", methods={"POST"})
        */
        public function addReferentiel(Request $request,SerializerInterface $serializer,EntityManagerInterface $entityManager,ValidatorInterface $validator,GroupeCompetencesRepository $GrpCompRepo)
        {
                $referentiel = new Referentiel();

                if($this->isGranted("EDIT",$referentiel)){
                        // Get Body content of the Request
                        $referentielJson = $request->getContent();

                        // On transforme le json en tableau
                        $referentielTab = $serializer->decode($referentielJson, 'json');
                        
                        //$programme = $request->files->get("$programme");
                        //$programme = fopen($programme->getRealPath(),"rb");
                        //$referentielTab["programme"] = $programme;
                        

                        $referentiel->setLibelle($referentielTab["libelle"]);
                        $referentiel->setPresentation($referentielTab["presentation"]);
                        $referentiel->setCritereEvaluation($referentielTab["critere_evaluation"]);
                        $referentiel->setCritereAdmission($referentielTab["critere_admission"]);
                        //$referentiel->setProgramme($referentielTab["programme"]);

                        $grpCompetencesTab = $referentielTab["groupeCompetences"];

                        foreach ($grpCompetencesTab as $key => $value){
                          $grpCompetences = new GroupeCompetences();
                          $grpCompetences = $GrpCompRepo -> find($value);
                            if (isset($grpCompetences)){
                              $referentiel->addGroupeCompetence($grpCompetences);
                            }
                        }

                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($referentiel);
                        $entityManager->flush();
                        return new JsonResponse("success",Response::HTTP_CREATED,[],true);
                }
                else{
                        return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
                }
        }

        /**
        * @Route(path="/api/admin/referentiels/{id}/grpecompetences",
        *        name="apiGetRefIdgrpComp",
        *        methods={"GET"},
        * defaults={
        *          "_controller"="\app\ControllerReferentielController::getRefIdGrpCompetences",
        *         "_api_resource_class"=Referentiel::class,
        *         "_api_collection_operation_name"="getRefIdGrpCompetences"
        *         }
        *)
        */
        public function getRefIdGrpCompetences(Request $request,SerializerInterface $serializer, $id, EntityManagerInterface $entityManager,ValidatorInterface $validator, ReferentielRepository $RefRepo, GroupeCompetencesRepository $grpCompRepo)
        {
          $referentiel = new Referentiel();

          if($this->isGranted("VIEW",$referentiel)){

            //On détermine si le referentiel existe dans la base de données
            $referentiel = $RefRepo-> find($id);
                        
            if (isset($referentiel)){
                                        
              // On transforme le referentiel "objets" en tableau.
              $referentielTab = $serializer->normalize($referentiel, 'json');

              //On récupére les groupe compétences qu'on met dans un tableau
              $grpCompetencesTab = $referentielTab["groupeCompetences"];
              //dd($competencesTab);

              if (!empty($grpCompetencesTab)){
                return $this->json($grpCompetencesTab,Response::HTTP_OK,);
              }
            }else{
              return $this->json(["message" => "Ce groupe de competences n'existe pas."], Response::HTTP_FORBIDDEN);
            }
              
          }else{
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
          }

        }
}
