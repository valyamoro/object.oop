<?php
declare(strict_types=1);

namespace lesson20_07_2024\V1;

use App\lesson_20_07_2024\V1\Role;
use PHPUnit\Framework\TestCase;

class RoleTest extends TestCase
{
    public function testCanCreateAdmin(): void
    {
        $id = 1;
        $roleName = Role::ADMIN;

        $role = new Role(
            $id,
            $roleName,
        );

        $this->assertInstanceOf(Role::class, $role);
        $this->assertSame(1, $role->getId());
        $this->assertSame(Role::ADMIN, $role->getName());
    }

    public function testCanCreateModerator(): void
    {
        $id = 2;
        $roleName = Role::MODERATOR;

        $role = new Role(
            $id,
            $roleName,
        );

        $this->assertInstanceOf(Role::class, $role);
        $this->assertSame(2, $role->getId());
        $this->assertSame(Role::MODERATOR, $role->getName());
    }

    public function testCanCreateUser(): void
    {
        $id = 3;
        $roleName = Role::USER;

        $role = new Role(
            $id,
            $roleName,
        );

        $this->assertInstanceOf(Role::class, $role);
        $this->assertSame(3, $role->getId());
        $this->assertSame(Role::USER, $role->getName());
    }

}