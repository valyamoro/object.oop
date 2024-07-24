<?php
declare(strict_types=1);

namespace lesson20_07_2024\V4;

use App\lesson_20_07_2024\V4\Role;
use App\lesson_20_07_2024\V4\RoleDto;
use App\lesson_20_07_2024\V4\User;
use App\lesson_20_07_2024\V4\UserDto;
use App\lesson_20_07_2024\V4\Roles;
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
            Roles::USER->value,
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
        $this->assertSame(Roles::USER->value, $user->getRoles()[0]->getName());
    }

}
