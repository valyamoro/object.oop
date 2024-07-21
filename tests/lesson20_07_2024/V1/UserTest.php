<?php
declare(strict_types=1);

namespace lesson20_07_2024\V1;

use App\lesson20_07_2024\V1\Role;
use App\lesson20_07_2024\V1\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testCanCreate(): void
    {
        $id = 1;
        $login = 'user';
        $password = '123456j';
        $email = 'user@gmail.com';
        $roleAdmin = new Role(
            1,
            Role::ADMIN,
        );
        $roleModerator = new Role(
            2,
            Role::MODERATOR,
        );
        $roleUser = new Role(
            3,
            Role::USER,
        );
        $roles = [
            $roleAdmin,
            $roleModerator,
            $roleUser,
        ];

        $user = new User(
            $id,
            $login,
            $password,
            $email,
            $roles,
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame(1, $user->getId());
        $this->assertSame('user', $user->getLogin());
        $this->assertSame('123456j', $user->getPassword());
        $this->assertSame('user@gmail.com', $user->getEmail());
        $this->assertInstanceOf(Role::class, $user->getRoles()[0]);
        $this->assertSame(1, $user->getRoles()[0]->getId());
        $this->assertSame(Role::ADMIN, $user->getRoles()[0]->getName());
        $this->assertInstanceOf(Role::class, $user->getRoles()[1]);
        $this->assertSame(2, $user->getRoles()[1]->getId());
        $this->assertSame(Role::MODERATOR, $user->getRoles()[1]->getName());
        $this->assertInstanceOf(Role::class, $user->getRoles()[2]);
        $this->assertSame(3, $user->getRoles()[2]->getId());
        $this->assertSame(Role::USER, $user->getRoles()[2]->getName());
    }

}