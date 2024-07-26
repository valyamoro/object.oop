<?php
declare(strict_types=1);

use App\lesson_23_07_2024\V1\Collections\ArticleCollection;
use App\lesson_23_07_2024\V1\Collections\CategoryCollection;
use App\lesson_23_07_2024\V1\Collections\RoleCollection;
use App\lesson_23_07_2024\V1\Collections\UserCollection;
use App\lesson_23_07_2024\V1\Collections\UserRolesCollection;
use App\lesson_23_07_2024\V1\Dto\ArticleDto;
use App\lesson_23_07_2024\V1\Dto\CategoryDto;
use App\lesson_23_07_2024\V1\Dto\RoleDto;
use App\lesson_23_07_2024\V1\Dto\UserDto;
use App\lesson_23_07_2024\V1\Dto\UserRolesDto;
use App\lesson_23_07_2024\V1\Enums\Roles;
use App\lesson_23_07_2024\V1\Repositories\ArticleRepository;
use App\lesson_23_07_2024\V1\Repositories\CategoryRepository;
use App\lesson_23_07_2024\V1\Repositories\RoleRepository;
use App\lesson_23_07_2024\V1\Repositories\UserRepository;
use App\lesson_23_07_2024\V1\Repositories\UserRolesRepository;
use App\lesson_23_07_2024\V1\Services\ArticleService;
use App\lesson_23_07_2024\V1\Services\CategoryService;
use App\lesson_23_07_2024\V1\Services\RoleService;
use App\lesson_23_07_2024\V1\Services\UserRolesService;
use App\lesson_23_07_2024\V1\Services\UserService;

require __DIR__ . '/../../../vendor/autoload.php';

$config = require __DIR__ . '/config/database.php';

$database = $config['database'];
$host = $config['host'];
$databaseName = $config['database_name'];
$charset = $config['charset'];
$username = $config['username'];
$password = $config['password'];
$options = $config['options'];

$pdo = new \PDO(
    $database . ':host=' . $host . ';dbname=' . $databaseName . ';charset=' . $charset,
    $username,
    $password,
    $options,
);

$userRolesRepository = new UserRolesRepository($pdo);
$userRolesCollection = new UserRolesCollection();
$userRolesService = new UserRolesService($userRolesRepository, $userRolesCollection);

for ($i = 1; $i <= 5; $i++) {
    $userRolesData = [
        'id' => $i,
        'user_id' => $i,
        'role_id' => $i,
    ];
    $userRolesDto = new UserRolesDto(
        $userRolesData['id'],
        $userRolesData['user_id'],
        $userRolesData['role_id'],
    );

    if ($userRolesService->getOne($userRolesDto->id) === null) {
        $userRolesService->create($userRolesDto);
    }
}

$userRolesData = [
    'id' => 2,
    'user_id' => 1,
    'role_id' => 2,
];
$userRolesDto = new UserRolesDto(
    $userRolesData['id'],
    $userRolesData['user_id'],
    $userRolesData['role_id'],
);
$updatedUserRoles = $userRolesService->update(
    $userRolesData['id'],
    $userRolesDto,
);

$userRolesData = [
    'id' => 1,
    'user_id' => 4,
    'role_id' => 4,
];
$userRolesDto = new UserRolesDto(
    $userRolesData['id'],
    $userRolesData['user_id'],
    $userRolesData['role_id'],
);
$deletedUserRoles = $userRolesService->delete($userRolesDto);
$allUserRoles = $userRolesService->getAll();

echo 'Get user role by id: ' . $userRolesService->getOne(3)->getId() . PHP_EOL;
echo 'Updated user role id: ' . $updatedUserRoles->getUserId() . PHP_EOL;
echo 'Deleted user role id: ' . $deletedUserRoles->getUserId() . PHP_EOL;
echo 'All user roles ids: ';
foreach ($allUserRoles->get() as $value) {
    echo $value->getId() . ' ';
}
echo PHP_EOL;
echo PHP_EOL;

$roleRepository = new RoleRepository($pdo);
$roleCollection = new RoleCollection();
$roleService = new RoleService($roleRepository, $roleCollection);

$roles = Roles::cases();

$i = 0;
foreach ($roles as $item) {
    $roleData = [
        'id' => ++$i,
        'name' => $item->value,
    ];
    $roleDto = new RoleDto(
        $roleData['id'],
        $roleData['name'],
    );

    if ($roleService->getOne($roleDto->id) === null) {
        $createdUserRoles = $roleService->create($roleDto);
    }
}

$roleData = [
    'id' => 2,
    'name' => 'MODER',
];
$roleDto = new RoleDto(
    $roleData['id'],
    $roleData['name'],
);
$updatedRole = $roleService->update(
    $roleDto->id,
    $roleDto,
);

$roleData = [
    'id' => 1,
    'name' => Roles::ADMIN->value,
];

$roleDto = new RoleDto(
    $roleData['id'],
    $roleData['name'],
);
$deletedRole = $roleService->delete($roleDto);
$allRoles = $roleService->getAll();

echo 'Get role by id: ' . $roleService->getOne(3)->getId() . PHP_EOL;
echo 'Updated role id: ' . $updatedRole->getId() . PHP_EOL;
echo 'Deleted role id: ' . $deletedRole->getId() . PHP_EOL;
echo 'All roles ids: ';
foreach ($allRoles->get() as $value) {
    echo $value->getId() . ' ';
}
echo PHP_EOL;
echo PHP_EOL;

$categoryRepository = new CategoryRepository($pdo);
$categoryCollection = new CategoryCollection();
$categoryService = new CategoryService($categoryRepository, $categoryCollection);

for ($i = 1; $i <= 10; $i++) {
    $categoryData = [
        'id' => $i,
        'name' => 'category_' . $i,
    ];
    $categoryDto = new CategoryDto(
        $categoryData['id'],
        $categoryData['name'],
    );

    if ($categoryService->getOne($categoryDto->id) === null) {
        $createdCategory = $categoryService->create($categoryDto);
    }
}
$categoryData = [
    'id' => 2,
    'name' => 'updated category',
];
$categoryDto = new CategoryDto(
    $categoryData['id'],
    $categoryData['name'],
);
$updatedCategory = $categoryService->update(
    $categoryDto->id,
    $categoryDto,
);

$categoryData = [
    'id' => 10,
    'name' => 'category_10',
];

$categoryDto = new CategoryDto(
    $categoryData['id'],
    $categoryData['name'],
);
$deletedCategory = $categoryService->delete($categoryDto);
$allCategories = $categoryService->getAll();

echo 'Get category by id: ' . $categoryService->getOne(3)->getId() . PHP_EOL;
echo 'Updated category id: ' . $updatedCategory->getId() . PHP_EOL;
echo 'Deleted category id: ' . $deletedCategory->getId() . PHP_EOL;
echo 'All categories ids: ';
foreach ($allCategories->get() as $value) {
    echo $value->getId() . ' ';
}
echo PHP_EOL;
echo PHP_EOL;

$userRepository = new UserRepository($pdo);
$userCollection = new UserCollection($userRolesService, $roleService, $roleCollection);
$userService = new UserService($userRepository, $userRolesService, $roleService, $userCollection);

$rolesData = [
    [
        'id' => 3,
        'name' => Roles::USER->value,
    ],
];

$roles = $roleCollection->make($rolesData);

for ($i = 1; $i <= 10; $i++) {
    $userData = [
        'id' => $i,
        'login' => 'user_' . $i,
        'password' => '123456j',
        'email' => 'user_' . $i . '@gmail.com',
        'roles' => $roles,
    ];
    $userDto = new UserDto(
        $userData['id'],
        $userData['login'],
        $userData['password'],
        $userData['email'],
        $userData['roles'],
    );

    if ($userService->getOne($userDto->id) === null) {
        $createdUser = $userService->create($userDto);
    }
}

$userData = [
    'id' => 2,
    'login' => 'updated_user_2',
    'password' => '123456j',
    'email' => 'user_2@gmail.com',
    'roles' => $roles,
];
$userDto = new UserDto(
    $userData['id'],
    $userData['login'],
    $userData['password'],
    $userData['email'],
    $userData['roles'],
);
$updatedUser = $userService->update(
    $userDto->id,
    $userDto,
);

$userData = [
    'id' => 10,
    'login' => 'user_10',
    'password' => '123456j',
    'email' => 'user_10@gmail.com',
    'roles' => $roles,
];

$userDto = new UserDto(
    $userData['id'],
    $userData['login'],
    $userData['password'],
    $userData['email'],
    $userData['roles'],
);
$deletedUser = $userService->delete($userDto);
$allUsers = $userService->getAll();

echo 'Get user by id: ' . $userService->getOne(3)->getId() . PHP_EOL;
echo 'Updated user id: ' . $updatedUser->getId() . PHP_EOL;
echo 'Deleted user id: ' . $deletedUser->getId() . PHP_EOL;
echo 'All users ids: ';
foreach ($allUsers->get() as $value) {
    echo $value->getId() . ' ';
}

echo PHP_EOL;
echo PHP_EOL;

$articleRepository = new ArticleRepository($pdo);
$articleCollection = new ArticleCollection(
    $categoryService,
    $userService,
);
$articleService = new ArticleService(
    $articleRepository,
    $userService,
    $categoryService,
    $articleCollection,
);

for ($i = 1; $i <= 5; $i++) {
    $articleData = [
        'id' => $i,
        'title' => 'article_' . $i,
        'body' => 'article content ' . $i,
        'category' => $categoryService->getOne($i),
        'user' => $userService->getOne($i),
    ];

    $articleDto = new ArticleDto(
        $articleData['id'],
        $articleData['title'],
        $articleData['body'],
        $articleData['category'],
        $articleData['user'],
    );

    if ($articleService->getOne($articleDto->id) === null) {
        $createdArticle = $articleService->create($articleDto);
    }
}

$articleData = [
    'id' => 2,
    'title' => 'article_2',
    'body' => 'article content 2',
    'user' => $userService->getOne(2),
    'category' => $categoryService->getOne(2),
];
$articleDto = new ArticleDto(
    $articleData['id'],
    $articleData['title'],
    $articleData['body'],
    $articleData['category'],
    $articleData['user'],
);
$updatedArticle = $articleService->update(
    $articleDto->id,
    $articleDto,
);
$articleData = [
    'id' => 1,
    'title' => 'article 1',
    'body' => 'article content 1',
    'user' => $userService->getOne(1),
    'category' => $categoryService->getOne(1),
];

$articleDto = new ArticleDto(
    $articleData['id'],
    $articleData['title'],
    $articleData['body'],
    $articleData['category'],
    $articleData['user'],
);
$deletedArticle = $articleService->delete($articleDto);
$allArticles = $articleService->getAll();

echo 'Get article by id: ' . $articleService->getOne(3)->getId() . PHP_EOL;
echo 'Updated article id: ' . $updatedArticle->getId() . PHP_EOL;
echo 'Deleted article id: ' . $deletedArticle->getId() . PHP_EOL;
echo 'All articles ids: ';
foreach ($allArticles->get() as $value) {
    echo $value->getId() . ' ';
}
echo PHP_EOL;
echo PHP_EOL;
