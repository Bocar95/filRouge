<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Admins extends Fixture implements DependentFixtureInterface
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
        $password = 'admin';
        $role = [$tabRoles[0]];

        $admin=new Admin();
        $profil=$this->getReference("ADMIN");

        $admin->setNom('Niass');
        $admin->setPrenom('Baye');
        $admin->setEmail('niass@gmail.com');
        $admin->setAdresse('Inconnu');
        $admin->setProfil($profil);
        $admin->setRoles($role);

        $password = $this->encoder->encodePassword($admin, $password);
        $admin->setPassword($password);
            
        $manager->persist($admin);
        $manager->flush();
    }

    public function getDependencies () {
        return array(Profils::class,);
    }

}
