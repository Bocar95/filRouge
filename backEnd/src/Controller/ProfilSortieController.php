<?php

namespace App\Controller;

use App\Entity\Promo;
use App\Entity\ProfilSortie;
use App\Repository\PromoRepository;
use App\Repository\ApprenantRepository;
use App\Repository\ProfilSortieRepository;
use App\Repository\GroupeApprenantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilSortieController extends AbstractController
{
    /**
     * @Route("/api/admin/promo/{id1}/profilsortie/{id2}",
     *         name="getApprenantByProfilSortie",
     *         methods="GET",
     * defaults={
     *         "_controller"="\app\ControllerProfilSortieController::getApprenantByProfilSortie",
     *         "_api_resource_class"=ProfilSortie::class,
     *         "_api_collection_operation_name"="getApprenantByProfilSortie"
     *         }
     * )
     */
    public function getApprenantByProfilSortie(Request $request,$id1,$id2,ApprenantRepository $apprenantRepo, GroupeApprenantRepository $gARepo,SerializerInterface $serializer, PromoRepository $promoRepo, ProfilSortieRepository $profilSortieRepo)
    {
        $promo = new Promo();
        $profilSortie = new ProfilSortie();

        if($this->isGranted("VIEW",$profilSortie)){

            //On détermine si la promo existe dans la base de données
            $promo = $promoRepo-> find($id1);
                        
            if (isset($promo)){
                                                    
                // On transforme l'objet promo en tableau.
                $promoTab = $serializer->normalize($promo, 'json');
            
                //On récupére les groupes apprenants de la promo qu'on met dans un tableau
                $groupeApprenantsTab = $promoTab["groupeApprenants"];

                $profilDeSortie = $profilSortieRepo->find($id2);
                $profilDeSortie = $serializer->normalize($profilDeSortie, 'json');

                foreach ($groupeApprenantsTab as $key => $value) {
                    $apprenants = $value["apprenants"];
                }

                foreach ($apprenants as $key1 => $value1) {
                    $PS = $value1["profilSortie"];
                    if ($PS["libelle"] == $profilDeSortie["libelle"]){
                        $apprenant [] = $value1;
                    }
                }

                if(isset($apprenant)){
                    return $this->json($apprenant,Response::HTTP_OK,);
                }

            }else{
                return $this->json(["message" => "Cette promo n'existe pas."], Response::HTTP_FORBIDDEN);
            }
                
        }else{
        return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
        }
    }
}
