<?php

namespace App\Tests\Functional\Admin;

use App\Entity\User;
use App\Tests\Support\DatabaseWebTestCase;

class GuestControllerTest extends DatabaseWebTestCase
{
    public function testIndexRedirectsWhenNotAuthenticated(): void
    {
        $this->client->request('GET', '/admin/guests');

        self::assertResponseRedirects('/login');
    }

    public function testIndexAsAdmin(): void
    {
        $admin = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => 'admin@example.com',
        ]);

        $this->client->loginUser($admin);
        $this->client->request('GET', '/admin/guests');

        self::assertResponseIsSuccessful();
    }

    public function testAddFormAsAdmin(): void
    {
        $admin = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => 'admin@example.com',
        ]);

        $this->client->loginUser($admin);
        $this->client->request('GET', '/admin/guests/add');

        self::assertResponseIsSuccessful();
        self::assertSelectorExists('form');
    }

    public function testAddGuestPost(): void
    {
        $admin = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => 'admin@example.com',
        ]);

        $this->client->loginUser($admin);
        $crawler = $this->client->request('GET', '/admin/guests/add');

        $form = $crawler->filter('form')->form([
            'guest[name]' => 'Nouvel Invité',
            'guest[email]' => 'nouveau@example.com',
        ]);
        $this->client->submit($form);

        self::assertResponseRedirects('/admin/guests');
    }

    public function testToggleBlockGuest(): void
    {
        $admin = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => 'admin@example.com',
        ]);

        $this->client->loginUser($admin);

        // GET the index to render the forms (which contain the CSRF tokens)
        $crawler = $this->client->request('GET', '/admin/guests');

        // Submit the first "Bloquer" form directly via the crawler
        $form = $crawler->selectButton('Bloquer')->form();
        $this->client->submit($form);

        self::assertResponseRedirects('/admin/guests');
    }

    public function testDeleteGuest(): void
    {
        $admin = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => 'admin@example.com',
        ]);

        $this->client->loginUser($admin);

        // GET the index to render the forms (which contain the CSRF tokens)
        $crawler = $this->client->request('GET', '/admin/guests');

        // Submit the first "Supprimer" form directly via the crawler
        $form = $crawler->selectButton('Supprimer')->form();
        $this->client->submit($form);

        self::assertResponseRedirects('/admin/guests');
    }
}
