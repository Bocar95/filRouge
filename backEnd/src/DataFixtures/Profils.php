<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Profils extends Fixture
{

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $tab = ['ADMIN', 'FORMATEUR', 'CM', 'APPRENANT'];

        for ($i=0; $i<count($tab); $i++){

            $profils = new Profil();
            $profils->setLibelle($tab[$i]);

            $manager->persist($profils);
            $manager->flush();
            
            if ($tab[$i]=="ADMIN") {
                $this->setReference("ADMIN",$profils);
            }
            elseif ($tab[$i]=="APPRENANT") {
                $this->setReference("APPRENANT",$profils);
            }  
            elseif ($tab[$i]=="FORMATEUR") {
                $this->setReference("FORMATEUR",$profils);
            }
            elseif ($tab[$i]=="CM") {
                $this->setReference("CM",$profils);
            }
        }
    }
}
