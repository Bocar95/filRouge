<?php

namespace App\DataFixtures;

use App\Entity\Apprenant;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Apprenants extends Fixture implements DependentFixtureInterface
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
        $password = 'apprenant';
        $role = [$tabRoles[3]];

        $apprenant=new Apprenant();
        $profil=$this->getReference("APPRENANT");

        $apprenant->setNom('Zerty');
        $apprenant->setPrenom('Die');
        $apprenant->setEmail('stop@gmail.com');
        $apprenant->setAdresse('Inconnu');
        $apprenant->setProfil($profil);
        $apprenant->setRoles($role);

        $password = $this->encoder->encodePassword($apprenant, $password);
        $apprenant->setPassword($password);
            
        $manager->persist($apprenant);
        $manager->flush();
    }

    public function getDependencies () {
        return array(Profils::class,);
    }
}
