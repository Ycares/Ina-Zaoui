<?php

namespace App\Tests\Functional\Admin;

use App\Entity\Album;
use App\Entity\User;
use App\Tests\Support\DatabaseWebTestCase;

class AlbumControllerTest extends DatabaseWebTestCase
{
    public function testIndexAsAdmin(): void
    {
        $admin = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => 'admin@example.com',
        ]);

        $this->client->loginUser($admin);
        $this->client->request('GET', '/admin/album');

        self::assertResponseIsSuccessful();
    }

    public function testAddAlbumGet(): void
    {
        $admin = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => 'admin@example.com',
        ]);

        $this->client->loginUser($admin);
        $this->client->request('GET', '/admin/album/add');

        self::assertResponseIsSuccessful();
        self::assertSelectorExists('form');
    }

    public function testAddAlbumPost(): void
    {
        $admin = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => 'admin@example.com',
        ]);

        $this->client->loginUser($admin);
        $this->client->request('GET', '/admin/album/add');

        $this->client->submitForm('Ajouter', [
            'album[name]' => 'Paysages',
        ]);

        self::assertResponseRedirects('/admin/album');
    }

    public function testUpdateAlbumGet(): void
    {
        $admin = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => 'admin@example.com',
        ]);
        $album = $this->entityManager->getRepository(Album::class)->findOneBy([
            'name' => 'Album Admin',
        ]);

        $this->client->loginUser($admin);
        $this->client->request('GET', '/admin/album/update/' . $album->getId());

        self::assertResponseIsSuccessful();
    }

    public function testDeleteAlbum(): void
    {
        $admin = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => 'admin@example.com',
        ]);
        $album = $this->entityManager->getRepository(Album::class)->findOneBy([
            'name' => 'Album Admin',
        ]);

        $this->client->loginUser($admin);
        $this->client->request('GET', '/admin/album/delete/' . $album->getId());

        self::assertResponseRedirects('/admin/album');
    }
}
