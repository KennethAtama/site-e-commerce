<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->request('GET', '/inscription');

        $client->submitForm('Valider', [
            'register_user[email]' => 'example@gmail.com',
            'register_user[plainPassword][first]' => '1234567',
            'register_user[plainPassword][second]' => '1234567',
            'register_user[firstname]' => 'john',
            'register_user[lastname]' => 'Doe'
        ]);

        $this->assertResponseRedirects('/connexion');
        $client->followRedirect();

        $this->assertSelectorExists('div:contains("Félicitation !! Votre compte a été crée")');
    }
}
