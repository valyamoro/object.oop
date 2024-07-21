<?php
declare(strict_types=1);

namespace lesson20_07_2024\V3;

use App\lesson20_07_2024\V3\Role;
use App\lesson20_07_2024\V3\RoleDto;
use App\lesson20_07_2024\V3\User;
use App\lesson20_07_2024\V3\UserDto;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testCanCreate(): void
    {
        $id = 1;
        $login = 'user';
        $password = '123456j';
        $email = 'user@gmail.com';
        $roleUser = Role::create(new RoleDto(
            1,
            Role::USER,
        ));
        $userDto = new UserDto(
            $id,
            $login,
            $password,
            $email,
            [
                $roleUser,
            ],
        );

        $user = User::create($userDto);

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame(1, $user->getId());
        $this->assertSame('user', $user->getLogin());
        $this->assertSame('123456j', $user->getPassword());
        $this->assertSame('user@gmail.com', $user->getEmail());
        $this->assertInstanceOf(Role::class, $user->getRoles()[0]);
        $this->assertSame(1, $user->getRoles()[0]->getId());
        $this->assertSame(Role::USER, $user->getRoles()[0]->getName());
    }

}
