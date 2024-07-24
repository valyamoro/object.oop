<?php
declare(strict_types=1);

use App\lesson_20_07_2024\V2\Article;
use App\lesson_20_07_2024\V2\Category;
use App\lesson_20_07_2024\V2\Role;
use App\lesson_20_07_2024\V2\User;

require __DIR__ . '/../../../vendor/autoload.php';

$roleAdminId = 1;
$roleAdminName = Role::ADMIN;

$roleAdmin = Role::create(
    $roleAdminId,
    $roleAdminName,
);

$roleModeratorId = 2;
$roleModeratorName = Role::MODERATOR;

$roleModerator = Role::create(
    $roleModeratorId,
    $roleModeratorName,
);

$roleUserId = 3;
$roleUserName = Role::USER;

$roleUser = Role::create(
    $roleUserId,
    $roleUserName,
);

$categoryId = 1;
$categoryName = 'category_one';

$category = Category::create(
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

$user = User::create(
    $userId,
    $userLogin,
    $userPassword,
    $userEmail,
    $userRoles,
);

$articleId = 1;
$articleTitle = 'article_one';
$articleBody = 'article content';

$article = Article::create(
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
