<?php

return [
    App\lesson_23_07_2024\V2\Database\PDODriver::class => [],

    App\lesson_23_07_2024\V2\Collections\CategoryCollection::class => [
        'dependencies' => [],
    ],
    App\lesson_23_07_2024\V2\Repositories\CategoryRepository::class  => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Database\PDODriver::class,
        ],
    ],
    App\lesson_23_07_2024\V2\Services\CategoryService::class  => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Repositories\CategoryRepository::class,
            App\lesson_23_07_2024\V2\Collections\CategoryCollection::class,
        ],
    ],
    App\lesson_23_07_2024\V2\Controllers\CategoryController::class  => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Services\CategoryService::class,
        ],
    ],

    App\lesson_23_07_2024\V2\Collections\RoleCollection::class  => [
        'dependencies' => [],
    ],
    App\lesson_23_07_2024\V2\Repositories\RoleRepository::class  => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Database\PDODriver::class,
        ],
    ],
    App\lesson_23_07_2024\V2\Services\RoleService::class => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Repositories\RoleRepository::class,
            App\lesson_23_07_2024\V2\Collections\RoleCollection::class,
        ],
    ],
    App\lesson_23_07_2024\V2\Controllers\RoleController::class  => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Services\RoleService::class,
        ],
    ],

    App\lesson_23_07_2024\V2\Collections\UserRolesCollection::class  => [
        'dependencies' => [],
    ],
    App\lesson_23_07_2024\V2\Repositories\UserRolesRepository::class  => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Database\PDODriver::class,
        ],
    ],
    App\lesson_23_07_2024\V2\Services\UserRolesService::class => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Repositories\UserRolesRepository::class,
            App\lesson_23_07_2024\V2\Collections\UserRolesCollection::class,
        ],
    ],

    App\lesson_23_07_2024\V2\Collections\UserCollection::class  => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Services\UserRolesService::class,
            App\lesson_23_07_2024\V2\Services\RoleService::class,
            App\lesson_23_07_2024\V2\Collections\RoleCollection::class,
        ],
    ],
    App\lesson_23_07_2024\V2\Repositories\UserRepository::class  => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Database\PDODriver::class,
        ],
    ],
    App\lesson_23_07_2024\V2\Services\UserService::class  => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Repositories\UserRepository::class,
            App\lesson_23_07_2024\V2\Services\UserRolesService::class,
            App\lesson_23_07_2024\V2\Collections\UserCollection::class,
        ],
    ],
    App\lesson_23_07_2024\V2\Controllers\UserController::class  => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Services\UserService::class,
            App\lesson_23_07_2024\V2\Collections\UserRolesCollection::class,
        ],
    ],

    App\lesson_23_07_2024\V2\Collections\ArticleCollection::class  => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Services\CategoryService::class,
            App\lesson_23_07_2024\V2\Services\UserService::class,
        ],
    ],
    App\lesson_23_07_2024\V2\Repositories\ArticleRepository::class  => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Database\PDODriver::class,
        ],
    ],
    App\lesson_23_07_2024\V2\Services\ArticleService::class  => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Repositories\ArticleRepository::class,
            App\lesson_23_07_2024\V2\Collections\ArticleCollection::class,
            App\lesson_23_07_2024\V2\Services\CategoryService::class,
            App\lesson_23_07_2024\V2\Services\UserService::class,
        ],
    ],
    App\lesson_23_07_2024\V2\Controllers\ArticleController::class => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Services\ArticleService::class,
            App\lesson_23_07_2024\V2\Services\CategoryService::class,
            App\lesson_23_07_2024\V2\Services\UserService::class,
        ],
    ],

];
