<?php
declare(strict_types=1);

namespace lesson20_07_2024\V4;

use App\lesson_20_07_2024\V4\Role;
use App\lesson_20_07_2024\V4\RoleDto;
use App\lesson_20_07_2024\V4\Roles;
use PHPUnit\Framework\TestCase;

class RoleTest extends TestCase
{
    public function testCanCreateAdmin(): void
    {
        $id = 1;
        $roleName = Roles::ADMIN->value;

        $roleDto = new RoleDto(
            $id,
            $roleName,
        );

        $role = Role::create($roleDto);

        $this->assertInstanceOf(Role::class, $role);
        $this->assertSame(1, $role->getId());
        $this->assertSame(Roles::ADMIN->value, $role->getName());
    }

    public function testCanCreateModerator(): void
    {
        $id = 2;
        $roleName = Roles::MODERATOR->value;

        $roleDto = new RoleDto(
            $id,
            $roleName,
        );

        $role = Role::create($roleDto);

        $this->assertInstanceOf(Role::class, $role);
        $this->assertSame(2, $role->getId());
        $this->assertSame(Roles::MODERATOR->value, $role->getName());
    }

    public function testCanCreateUser(): void
    {
        $id = 3;
        $roleName = Roles::USER->value;
        $roleDto = new RoleDto(
            $id,
            $roleName,
        );

        $role = Role::create($roleDto);

        $this->assertInstanceOf(Role::class, $role);
        $this->assertSame(3, $role->getId());
        $this->assertSame(Roles::USER->value, $role->getName());
    }

}
