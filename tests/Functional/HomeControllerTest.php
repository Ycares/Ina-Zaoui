<?php

namespace App\Tests\Functional;

use App\Entity\Album;
use App\Entity\User;
use App\Tests\Support\DatabaseWebTestCase;

class HomeControllerTest extends DatabaseWebTestCase
{
    public function testHomePage(): void
    {
        $this->client->request('GET', '/');

        self::assertResponseIsSuccessful();
    }

    public function testAboutPage(): void
    {
        $this->client->request('GET', '/about');

        self::assertResponseIsSuccessful();
    }

    public function testGuestPage(): void
    {
        $guest = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => 'guest.active@example.com',
        ]);

        self::assertNotNull($guest);

        $this->client->request('GET', '/guest/' . $guest->getId());

        self::assertResponseIsSuccessful();
    }

    public function testPortfolioWithAlbum(): void
    {
        $album = $this->entityManager->getRepository(Album::class)->findOneBy([
            'name' => 'Album Invites',
        ]);

        self::assertNotNull($album);

        $this->client->request('GET', '/portfolio/' . $album->getId());

        self::assertResponseIsSuccessful();
    }

    public function testPortfolioWithoutAlbum(): void
    {
        $this->client->request('GET', '/portfolio');

        self::assertResponseIsSuccessful();
    }
}
