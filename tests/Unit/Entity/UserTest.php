<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetRolesAlwaysContainsRoleUser(): void
    {
        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);

        self::assertContains('ROLE_USER', $user->getRoles());
        self::assertContains('ROLE_ADMIN', $user->getRoles());
    }

    public function testIsAdminReturnsTrueWhenRoleAdminPresent(): void
    {
        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);

        self::assertTrue($user->isAdmin());
    }

    public function testBlockedDefaultsToFalseAndCanBeChanged(): void
    {
        $user = new User();
        self::assertFalse($user->isBlocked());

        $user->setBlocked(true);
        self::assertTrue($user->isBlocked());
    }

    public function testGetUserIdentifierReturnsEmail(): void
    {
        $user = new User();
        $user->setEmail('test@example.com');

        self::assertSame('test@example.com', $user->getUserIdentifier());
    }

    public function testEraseCredentialsDoesNothing(): void
    {
        $user = new User();
        $user->setPassword('secret');
        $user->eraseCredentials();

        self::assertSame('secret', $user->getPassword());
    }

    public function testSetAndGetEmail(): void
    {
        $user = new User();
        $user->setEmail('hello@example.com');

        self::assertSame('hello@example.com', $user->getEmail());
    }

    public function testSetAndGetPassword(): void
    {
        $user = new User();
        $user->setPassword('hashed_pw');

        self::assertSame('hashed_pw', $user->getPassword());
    }

    public function testSetAndGetName(): void
    {
        $user = new User();
        $user->setName('Alice');

        self::assertSame('Alice', $user->getName());
    }

    public function testSetAndGetDescription(): void
    {
        $user = new User();
        $user->setDescription('Portfolio photographer');

        self::assertSame('Portfolio photographer', $user->getDescription());
    }

    public function testIsAdminReturnsFalseByDefault(): void
    {
        $user = new User();

        self::assertFalse($user->isAdmin());
    }

    public function testGetMediasReturnsEmptyCollectionByDefault(): void
    {
        $user = new User();

        self::assertCount(0, $user->getMedias());
    }
}
