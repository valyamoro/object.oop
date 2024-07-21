<?php
declare(strict_types=1);

use App\lesson20_07_2024\V1\Article;
use App\lesson20_07_2024\V1\Category;
use App\lesson20_07_2024\V1\Role;
use App\lesson20_07_2024\V1\User;

require __DIR__ . '/../../../vendor/autoload.php';

$roleAdminId = 1;
$roleAdminName = Role::ADMIN;

$roleAdmin = new Role(
    $roleAdminId,
    $roleAdminName,
);

$roleModeratorId = 2;
$roleModeratorName = Role::MODERATOR;

$roleModerator = new Role(
    $roleModeratorId,
    $roleModeratorName,
);

$roleUserId = 3;
$roleUserName = Role::USER;

$roleUser = new Role(
    $roleUserId,
    $roleUserName,
);

$categoryId = 1;
$categoryName = 'category_one';

$category = new Category(
    $categoryId,
    $categoryName,
);

$userId = 1;
$userLogin = 'user';
$userPassword = '123456j';
$userEmail = 'user@gmail.com';
$userRoles = [
    $roleAdminId => $roleAdmin,
    $roleModeratorId => $roleModerator,
    $roleUserId => $roleUser,
];

$user = new User(
    $userId,
    $userLogin,
    $userPassword,
    $userEmail,
    $userRoles,
);

$articleId = 1;
$articleTitle = 'article_one';
$articleBody = 'article content';

$article = new Article(
    $articleId,
    $articleTitle,
    $articleBody,
    $category,
    $user,
);

echo $article->getId() . PHP_EOL;
echo $article->getTitle() . PHP_EOL;
echo $article->getBody() . PHP_EOL;
echo PHP_EOL;
echo $article->getCategory()->getId() . PHP_EOL;
echo $article->getCategory()->getName() . PHP_EOL;
echo PHP_EOL;
echo $article->getUser()->getId() . PHP_EOL;
echo $article->getUser()->getLogin() . PHP_EOL;
echo $article->getUser()->getPassword() . PHP_EOL;
echo $article->getUser()->getEmail() . PHP_EOL;
echo PHP_EOL;
echo $article->getUser()->getRoles()[$roleAdminId]->getId() . PHP_EOL;
echo $article->getUser()->getRoles()[$roleAdminId]->getName() . PHP_EOL;
echo $article->getUser()->getRoles()[$roleModeratorId]->getId() . PHP_EOL;
echo $article->getUser()->getRoles()[$roleModeratorId]->getName() . PHP_EOL;
echo $article->getUser()->getRoles()[$roleUserId]->getId() . PHP_EOL;
echo $article->getUser()->getRoles()[$roleUserId]->getName() . PHP_EOL;
