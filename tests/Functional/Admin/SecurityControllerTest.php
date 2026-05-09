<?php

namespace App\Tests\Functional\Admin;

use App\Tests\Support\DatabaseWebTestCase;

class SecurityControllerTest extends DatabaseWebTestCase
{
    public function testLoginPageIsAccessible(): void
    {
        $this->client->request('GET', '/login');

        self::assertResponseIsSuccessful();
        self::assertSelectorExists('form');
    }

    public function testAdminRedirectsToLoginWhenNotAuthenticated(): void
    {
        $this->client->request('GET', '/admin/guests');

        self::assertResponseRedirects('/login');
    }
}
