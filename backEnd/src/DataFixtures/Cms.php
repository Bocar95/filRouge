<?php

namespace App\DataFixtures;

use App\Entity\Cm;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Cms extends Fixture implements DependentFixtureInterface
{
    
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $tabRoles = ['ROLE_ADMIN', 'ROLE_FORMATEUR', 'ROLE_CM', 'ROLE_APPRENANT'];
        $password = 'cm';
        $role = [$tabRoles[2]];

        $cm=new Cm();
        $profil=$this->getReference("CM");

        $cm->setNom('Mane');
        $cm->setPrenom('Yankoba');
        $cm->setEmail('jacob@gmail.com');
        $cm->setAdresse('Inconnu');
        $cm->setProfil($profil);
        $cm->setRoles($role);

        $password = $this->encoder->encodePassword($cm, $password);
        $cm->setPassword($password);
            
        $manager->persist($cm);
        $manager->flush();
    }

    public function getDependencies () {
        return array(Profils::class,);
    }
}
