<?php

namespace App\Tests\Functional;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\Support\DatabaseTestCase;

class UserRepositoryTest extends DatabaseTestCase
{
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->entityManager->getRepository(User::class);
    }

    public function testFindGuestsExcludesAdminAndBlocked(): void
    {
        $guests = $this->userRepository->findGuests();

        self::assertNotEmpty($guests);

        foreach ($guests as $guest) {
            self::assertFalse($guest->isAdmin());
            self::assertFalse($guest->isBlocked());
        }

        $names = array_map(fn(User $u) => $u->getName(), $guests);
        self::assertContains('Invite Actif', $names);
        self::assertNotContains('Ina Admin', $names);
        self::assertNotContains('Invite Bloque', $names);
    }

    public function testFindGuestAccountsIncludesBlockedButNotAdmin(): void
    {
        $accounts = $this->userRepository->findGuestAccounts();

        $names = array_map(fn(User $u) => $u->getName(), $accounts);

        self::assertContains('Invite Actif', $names);
        self::assertContains('Invite Bloque', $names);
        self::assertNotContains('Ina Admin', $names);
    }

    public function testFindOneAdminReturnsAdmin(): void
    {
        $admin = $this->userRepository->findOneAdmin();

        self::assertNotNull($admin);
        self::assertTrue($admin->isAdmin());
        self::assertSame('Ina Admin', $admin->getName());
    }

    public function testFindGuestsWithMediaCountReturnsCorrectCount(): void
    {
        $rows = $this->userRepository->findGuestsWithMediaCount();

        self::assertNotEmpty($rows);

        $byName = [];
        foreach ($rows as $row) {
            $byName[$row['name']] = $row;
        }

        self::assertArrayHasKey('Invite Actif', $byName);
        self::assertSame(1, $byName['Invite Actif']['mediaCount']);
        self::assertNotContains('Invite Bloque', array_keys($byName));
    }

    public function testUpgradePasswordUpdatesHash(): void
    {
        $guest = $this->userRepository->findOneBy(['email' => 'guest.active@example.com']);

        self::assertNotNull($guest);

        $this->userRepository->upgradePassword($guest, 'new_hashed_password');

        $this->entityManager->clear();

        $refreshed = $this->userRepository->findOneBy(['email' => 'guest.active@example.com']);

        self::assertSame('new_hashed_password', $refreshed->getPassword());
    }
}
