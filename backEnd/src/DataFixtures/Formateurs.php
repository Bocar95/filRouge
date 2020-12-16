<?php

namespace App\DataFixtures;

use App\Entity\Formateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Formateurs extends Fixture implements DependentFixtureInterface
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
        $password = 'formateur';
        $role = [$tabRoles[1]];

        $formateur=new Formateur();
        $profil=$this->getReference("FORMATEUR");

        $formateur->setNom('Wane');
        $formateur->setPrenom('Birane');
        $formateur->setEmail('douvewane85@gmail.com');
        $formateur->setPassword('formateur');
        $formateur->setAdresse('Inconnu');
        $formateur->setProfil($profil);
        $formateur->setRoles($role);

        $password = $this->encoder->encodePassword($formateur, $password);
        $formateur->setPassword($password);
            
        $manager->persist($formateur);
        $manager->flush();
    }

    public function getDependencies () {
        return array(Profils::class,);
    }
}
