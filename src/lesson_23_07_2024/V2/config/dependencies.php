<?php

return [
    App\lesson_23_07_2024\V2\Database\PDODriver::class => [],

    'App\lesson_23_07_2024\V2\Collections\CategoryCollection' => [
        'dependencies' => [],
    ],
    'App\lesson_23_07_2024\V2\Repositories\CategoryRepository' => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Database\PDODriver::class,
        ],
    ],
    'App\lesson_23_07_2024\V2\Services\CategoryService' => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Repositories\CategoryRepository::class,
            App\lesson_23_07_2024\V2\Collections\CategoryCollection::class,
        ],
    ],
    'App\lesson_23_07_2024\V2\Controllers\CategoryController' => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Services\CategoryService::class,
        ],
    ],

    'App\lesson_23_07_2024\V2\Collections\RoleCollection' => [
        'dependencies' => [],
    ],
    'App\lesson_23_07_2024\V2\Repositories\RoleRepository' => [
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
    'App\lesson_23_07_2024\V2\Controllers\RoleController' => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Services\RoleService::class,
        ],
    ],

    'App\lesson_23_07_2024\V2\Collections\UserRolesCollection' => [
        'dependencies' => [],
    ],
    'App\lesson_23_07_2024\V2\Repositories\UserRolesRepository' => [
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

    'App\lesson_23_07_2024\V2\Collections\UserCollection' => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Services\UserRolesService::class,
            App\lesson_23_07_2024\V2\Services\RoleService::class,
            App\lesson_23_07_2024\V2\Collections\RoleCollection::class,
        ],
    ],
    'App\lesson_23_07_2024\V2\Repositories\UserRepository' => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Database\PDODriver::class,
        ],
    ],
    'App\lesson_23_07_2024\V2\Services\UserService' => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Repositories\UserRepository::class,
            App\lesson_23_07_2024\V2\Services\UserRolesService::class,
            App\lesson_23_07_2024\V2\Collections\UserCollection::class,
        ],
    ],
    'App\lesson_23_07_2024\V2\Controllers\UserController' => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Services\UserService::class,
            App\lesson_23_07_2024\V2\Collections\UserRolesCollection::class,
        ],
    ],

    'App\lesson_23_07_2024\V2\Collections\ArticleCollection' => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Services\CategoryService::class,
            App\lesson_23_07_2024\V2\Services\UserService::class,
        ],
    ],
    'App\lesson_23_07_2024\V2\Repositories\ArticleRepository' => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Database\PDODriver::class,
        ],
    ],
    'App\lesson_23_07_2024\V2\Services\ArticleService' => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Repositories\ArticleRepository::class,
            App\lesson_23_07_2024\V2\Collections\ArticleCollection::class,
            App\lesson_23_07_2024\V2\Services\CategoryService::class,
            App\lesson_23_07_2024\V2\Services\UserService::class,
        ],
    ],
    'App\lesson_23_07_2024\V2\Controllers\ArticleController' => [
        'dependencies' => [
            App\lesson_23_07_2024\V2\Services\ArticleService::class,
            App\lesson_23_07_2024\V2\Services\CategoryService::class,
            App\lesson_23_07_2024\V2\Services\UserService::class,
        ],
    ],

];
