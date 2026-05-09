<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Album;
use App\Entity\Media;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaTest extends TestCase
{
    public function testSetAndGetTitle(): void
    {
        $media = new Media();
        $media->setTitle('Sunset');

        self::assertSame('Sunset', $media->getTitle());
    }

    public function testSetAndGetPath(): void
    {
        $media = new Media();
        $media->setPath('uploads/photo.jpg');

        self::assertSame('uploads/photo.jpg', $media->getPath());
    }

    public function testSetAndGetUser(): void
    {
        $media = new Media();
        $user = new User();
        $user->setName('Alice');
        $media->setUser($user);

        self::assertSame($user, $media->getUser());
    }

    public function testSetUserToNull(): void
    {
        $media = new Media();
        $media->setUser(null);

        self::assertNull($media->getUser());
    }

    public function testSetAndGetAlbum(): void
    {
        $media = new Media();
        $album = new Album();
        $album->setName('Portraits');
        $media->setAlbum($album);

        self::assertSame($album, $media->getAlbum());
    }

    public function testSetAlbumToNull(): void
    {
        $media = new Media();
        $media->setAlbum(null);

        self::assertNull($media->getAlbum());
    }

    public function testGetFileReturnsNullByDefault(): void
    {
        $media = new Media();

        self::assertNull($media->getFile());
    }

    public function testSetAndGetFile(): void
    {
        $tmpPath = tempnam(sys_get_temp_dir(), 'test_') . '.jpg';
        file_put_contents($tmpPath, 'fake image content');

        $uploadedFile = new UploadedFile($tmpPath, 'photo.jpg', 'image/jpeg', null, true);

        $media = new Media();
        $media->setFile($uploadedFile);

        self::assertSame($uploadedFile, $media->getFile());

        unlink($tmpPath);
    }
}
