<?php
namespace App\Controller\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddTest extends WebTestCase{
    
    //Test Fonctionnel

    protected function createAuthenticatedClient(string $username, string $password): KernelBrowser
    {
        $client = static::createClient();

        $infos = [
            "username" => $username,
            "password" => $password
        ];
    
        $client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($infos)
        );
        
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);//test si l'authentification s'est bien passée
        $data = \json_decode($client->getResponse()->getContent(), true);
        $client->setServerParameter('HTTP_Authorization', \sprintf('Bearer %s', $data['token']));
        $client->setServerParameter('CONTENT_TYPE', 'application/json');

        return $client;
    }


    public function testShowProfil()
    {
        $client = $this->createAuthenticatedClient("mami","admin");
        $client->request('GET', '/api/admin/profils');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testCreateProfil()
    {
        $profil = [
                "libelle" => "ADMIN1388"
        ];

        $client = $this->createAuthenticatedClient("mami","admin");
        $client->request(
            'POST',
            '/api/admin/profils',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($profil)
        );
        $responseContent = $client->getResponse();
        //$responseDecode = json_decode($responseContent);
        $this->assertEquals(Response::HTTP_OK,$responseContent->getStatusCode());
        //$this->assertJson($responseContent);
        //$this->assertNotEmpty($responseDecode);    
    }

    public function testCreatePromo()
    {
        $client = $this->createAuthenticatedClient("mami","admin");
        $client->request(
            'POST',
            '/api/admin/promo',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                "langue":"fr",
                    "titre":"Cohorte 3 Dev",
                    "description":"Formation dev Web et Mobile",
                    "lieu":"ODC/Sonatel Acaddémie",
                    "fabrique":"Sonatel Académie",
                    "etat":1,
                    "referentiel":{
                        "id":4
                    },
                    "formateurs":[
                        {
                            "id":28
                        },
                        {
                            "id":29
                        }
                    ],
                    "groupes":[
                        {
                            "nom":"SAC3 Family",
                            "type":"Groupe 10",
                            "statut":"actif",
                            "apprenants":[
                                {
                                    "email":"takkinoyaya@gmail.com"
                                },
                                {
                                    "email":"ndiayengone261@gmail.com"
                                },
                                {
                                    "email":"seckdieng@gmail.com"
                                },
                                {
                                    "email":"bocar.diallo95@gmail.com"
                                }
                            ]
                        }
                    ]
            }'
        );
        $responseContent = $client->getResponse();
        //$responseDecode = json_decode($responseContent);
        $this->assertEquals(Response::HTTP_CREATED,$responseContent->getStatusCode());
        //$this->assertJson($responseContent);
        //$this->assertNotEmpty($responseDecode);    
    }

}