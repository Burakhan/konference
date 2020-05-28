<?php

namespace App\Tests;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{


    public function testRegister()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/register');
        $form = $crawler->selectButton('Register')->form();
        $formValue = [
            'registration_form' => [
                'fullName' => 'Fabien Scot',
                'email' => 'info@thekonferences.com',
                'password' => [
                    'first' => '123456',
                    'second' => '123456',

                ],
                'agreeTerms' => true
            ]

        ];
        $form->setValues($formValue);

        $client->submit($form);

        $this->assertResponseRedirects();
        $this->clear();
    }


    private function clear()
    {

        $em = $this->getEntityManager();
        $userRepo = $em->getRepository(User::class);
        $user = $userRepo->findOneBy(['email' => 'info@thekonferences.com']);
        $em->remove($user);
        $em->flush();
    }

    /**
     * @return EntityManager
     */
    private function getEntityManager()
    {
        return self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }


}
