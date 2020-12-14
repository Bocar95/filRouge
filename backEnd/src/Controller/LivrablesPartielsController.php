<?php

namespace App\Controller;

use DateTime;
use App\Entity\Promo;
use App\Entity\PromoBrief;
use App\Entity\Commentaires;
use App\Entity\LivrablesPartiels;
use App\Repository\PromoRepository;
use App\Repository\ApprenantRepository;
use App\Repository\FormateurRepository;
use App\Entity\ApprenantLivrablePartiel;
use App\Repository\PromoBriefRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CompetencesRepository;
use App\Repository\ReferentielRepository;
use App\Repository\LivrableRenduRepository;
use App\Repository\GroupeApprenantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\LivrablesPartielsRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PromoBriefApprenantRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\StatistiquesCompetencesRepository;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\ApprenantLivrablePartielRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LivrablesPartielsController extends AbstractController
{

    /**
    * @Route(path="/api/formateurs/promo/{id1}/referentiel/{id2}/competences")
    */

    public function getFormateurPromoIdReferentielIdCompetences($id1,$id2,SerializerInterface $serializer,StatistiquesCompetencesRepository $statRepo){
        $promo=new Promo();
        if ($this->isGranted("VIEW",$promo)) {
            $stat_promo=$statRepo->findBy(["promo"=>$id1,"referentiel"=>$id2]);
            $stat_promo=$serializer->normalize($stat_promo,"json",["groups"=>"Stat_apprenant"]);
            return $this->json($stat_promo,Response::HTTP_OK);
        }
        else {
            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
        }
    }

    /**
    * @Route(path="/api/formateurs/promo/{id1}/referentiel/{id2}/statistiques/competences"
    *)
    */

    public function getFormateurPromoIdReferentielIdStatistiquesCompetences(SerializerInterface $serializer,StatistiquesCompetencesRepository $statRepo,CompetencesRepository $compRepo,$id1,$id2){

        $promo=new Promo();
        if ($this->isGranted("VIEW",$promo)) {
            $stat_competences=$statRepo->findBy(["promo"=>$id1,"referentiel"=>$id2]);
            $stat_competences=$serializer->normalize($stat_competences,"json",["groups"=>"Stat_competences"]);
            return $this->json($stat_competences,Response::HTTP_OK);
        }
        else {

            return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
        }
    }

    /**
    * @Route(path="/api/apprenant/{id1}/promo/{id2}/referentiel/{id3}/competences",
    *        name="apigetApprenantIdPromoIdReferentielIdCompetences",
    *        methods={"GET"}
    *)
    */

    public function getApprenantIdPromoIdReferentielIdCompetences($id1,$id2,$id3,SerializerInterface $serializer,StatistiquesCompetencesRepository $statRepo){
        $stat_apprenant=$statRepo->findBy([ "apprenant"=>$id1, "promo"=>$id2, "referentiel"=>$id3 ]);
        if ($stat_apprenant) {
            $stat_apprenant=$serializer->normalize($stat_apprenant,"json",["groups"=>"Apprenant_stat"]);
            return $this->json($stat_apprenant,Response::HTTP_OK);
        }

        return $this->json(["message" => "Parametres url incorrects."], Response::HTTP_FORBIDDEN);        
    }

    /**
    * @Route(path="/api/apprenants/{id1}/promo/{id2}/referentiel/{id3}/statistisques/briefs",
    *        name="apigetApprenantIdPromoIdReferentielIdStatistiquesBriefs",
    *        methods={"GET"}
    *)
    */

    public function getApprenantIdPromoIdReferentielIdStatistiquesBriefs($id1,$id2,$id3,SerializerInterface $serializer,PromoRepository $promoRepo,PromoBriefApprenantRepository $promoBriefAppRepo,GroupeApprenantRepository $groupeAppRepo){
        $promo=$promoRepo->findBy(["id"=>$id2,"referentiel"=>$id3]);
        if ($promo) {
            
            $groupeApp=$groupeAppRepo->findBy(["promo"=>$id2,"type"=>"principal"]);
            $apprenants=$serializer->normalize($groupeApp,"json",["groups"=>"App_check_stat_brief"]);
            $apprenants=$apprenants[0]["apprenants"];
            $found=false;
            $a=0;
            while (($a < count($apprenants)) && ($found==false)) {
                if ($apprenants[$a]["id"]==$id1) {
                    $found=true;
                }
                $a++;
            }
            if ($found==false) {
                return $this->json(["message" => "Cet apprenant n'est pas dans cette promo."], Response::HTTP_FORBIDDEN); 
            }
            
            $promo_brief_app=$promoBriefAppRepo->findBy(["apprenant"=>$id1]);
            if ($promo_brief_app) {
                $promo_brief_app=$serializer->normalize($promo_brief_app,"json",["groups"=>"Brief:app_read"]);
                return $this->json($promo_brief_app,Response::HTTP_OK);
            }
            return $this->json(["message" => "Aucun brief assigne a cet apprenant"], Response::HTTP_FORBIDDEN);  
        }
        return $this->json(["message" => "Aucun referentiel dans ce promo ou promo inexistante."], Response::HTTP_FORBIDDEN);       
    }

    /**
    * @Route(path="/api/formateurs/livrablepartiels/{id}/commentaires",
    *        name="apipostFormateursLivrablepartielsIdcommentaires",
    *        methods={"POST"}
    *)
    */
    public function postFormateursLivrablepartielsIdcommentaires($id,SerializerInterface $serializer,FormateurRepository $formaRepo,LivrableRenduRepository $livRenduRepo,Request $request,EntityManagerInterface $em,TokenStorageInterface $token){
        //$piecejointe= $request->files->get("pieces_jointes");
        //dd($piecejointe);
        //$piecejointe=fopen($piecejointe->getRealPath(),"rb");
        $comment=$request->getContent();       
        $comment = $serializer->decode($comment, 'json');
        $id_liv_rendu=$comment["id_liv_rendu"];
        $libelle=$comment["libelle"];
        $livrable_rendu=$livRenduRepo->findBy(["livrablesPartiels"=>$id,"id"=>$id_liv_rendu]);
        if ($livrable_rendu) {
            $userFormateur=$token->getToken()->getUser();
            $userFormateur=$serializer->normalize($userFormateur,'json');
            $id_formateur=$userFormateur["id"];
            $formateur=$formaRepo->find($id_formateur);
            //dd($formateur);
            $date = new DateTime();
            $date->format('Y-m-d H:i:s');
            $liv_rendu=$livRenduRepo->find($id_liv_rendu);
            
            //dd($liv_rendu);
            $commentaire=new Commentaires();
            $commentaire->setLivrableRendu($liv_rendu);
            $commentaire->setFormateur($formateur);
            $commentaire->setLibelle($libelle); 
            $commentaire->setPiecesJointes(null);
            $commentaire->setDate($date);

            $em->persist($commentaire);
            $em->flush();
            return $this->json("Commentaire ajouté",Response::HTTP_OK);
        }
        return $this->json(["message" => "Aucun livrable rendu pour ce livrale partiel."], Response::HTTP_FORBIDDEN);
    }

    /**
    * @Route(path="/api/apprenants/livrablepartiels/{id}/commentaires",
    *        name="apipostApprenantsLivrablepartielsIdcommentaires",
    *        methods={"POST"}
    *)
    */
    public function postApprenantsLivrablepartielsIdcommentaires($id,SerializerInterface $serializer,Request $request,EntityManagerInterface $entityManager,TokenStorageInterface $token){
        // $apprenant=$token->getToken()->getUser();
        // $apprenant=$serializer->normalize($apprenant,'json');
        // $id_apprenant=$apprenant["id"];
        // dd($id_apprenant);
        // $commentaire=new Commentaires();
        // dd($commentaire);
        // return $this->json($data,Response::HTTP_OK);
    }

    /**
    * @Route(path="/api/formateurs/promo/{id1}/brief/{id2}/livrablepartiels",
    *        name="apiputFormateursPromoIdBriefIdLivrablepartiels",
    *        methods={"PUT"}
    *)
    */
    public function putFormateursPromoIdBriefIdLivrablepartiels(Request $request,EntityManagerInterface $em,$id1,$id2,SerializerInterface $serializer,PromoBriefRepository $promoBriefRepo){

        // $promo_briefs=$promoBriefRepo->findBy(["promo"=>$id1,"brief"=>$id2]);
        // //$promo_briefs=$serializer->normalize($promo_briefs,"json");
        // if ($promo_briefs) {
        //     foreach ($promo_briefs as $key_promo_briefs => $promo_brief) {
        //        // dd($promo_brief);
        //         $livrables_partiels=$promo_brief->getLivrablesPartiels();
        //         if ($livrables_partiels) {
        //             foreach ($livrables_partiels as $key_livrables_partiels => $livrable_partiel) {
        //                 $PromoBrief=new PromoBrief();
        //                 $PromoBrief->removeLivrablesPartiel($livrable_partiel);
                        
        //             } 
        //             $em->flush();
        //             return $this->json("Livrables Partiels supprimes",Response::HTTP_OK);
        //         }
        //         return $this->json(["message" => "Aucun livrable partiel pour ce brief dans cette promo."], Response::HTTP_FORBIDDEN); 
        //     }
        // }
    }

    /**
    * @Route(path="/api/apprenants/{id1}/livrablepartiels/{id2}",
    *        name="apiputApprenantIdLivrablepartielsId",
    *        methods={"PUT"}
    *)
    */

    public function putApprenantIdLivrablepartielsId(Request $request,$id1,$id2,EntityManagerInterface $em,SerializerInterface $serializer,ApprenantLivrablePartielRepository $appLivPartielRepo){
        // $apprLivPartiel=$appLivPartielRepo->findBy(["apprenant"=>$id1,"livrablePartiel"=>$id2]);
        // //dd(gettype($apprLivPartiel));
        // if ($apprLivPartiel) {
        //     $statut=$request->getContent();
        //     $statut = $serializer->decode($statut, 'json');
        //     $statut=$statut["statut"];
        //     //dd($statut);
        //     //$apprLivPartiel=$serializer->normalize($apprLivPartiel,"json");
        //     //$id_app_liv_partiel=$apprLivPartiel[0]["id"];
        //     //dd($id_app_liv_partiel);
        //     $appLiv=new ApprenantLivrablePartiel();
        //     $appLiv->setStatut($statut);
        //     $em->persist($appLiv);
        //     $em->flush();
        //     return $this->json("Statut modifié",Response::HTTP_OK);
            
        // }
        // return $this->json("Aucune relation entre cet apprenant et ce livrable",Response::HTTP_FORBIDDEN);
    }


}
