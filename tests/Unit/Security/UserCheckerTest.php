<?php

namespace App\Tests\Unit\Security;

use App\Entity\User;
use App\Security\UserChecker;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\InMemoryUser;

class UserCheckerTest extends TestCase
{
    private UserChecker $checker;

    protected function setUp(): void
    {
        $this->checker = new UserChecker();
    }

    public function testCheckPreAuthDoesNothingForNonAppUser(): void
    {
        $this->expectNotToPerformAssertions();

        $nonAppUser = new InMemoryUser('user', 'pass');
        $this->checker->checkPreAuth($nonAppUser);
    }

    public function testCheckPreAuthThrowsForBlockedUser(): void
    {
        $this->expectException(CustomUserMessageAccountStatusException::class);

        $user = new User();
        $user->setBlocked(true);

        $this->checker->checkPreAuth($user);
    }

    public function testCheckPreAuthDoesNothingForActiveUser(): void
    {
        $this->expectNotToPerformAssertions();

        $user = new User();
        $user->setBlocked(false);

        $this->checker->checkPreAuth($user);
    }

    public function testCheckPostAuthDoesNothing(): void
    {
        $this->expectNotToPerformAssertions();

        $user = new User();
        $this->checker->checkPostAuth($user);
    }
}
