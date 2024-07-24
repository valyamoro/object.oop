<?php
declare(strict_types=1);

use App\lesson_20_07_2024\V4\Article;
use App\lesson_20_07_2024\V4\ArticleDto;
use App\lesson_20_07_2024\V4\Category;
use App\lesson_20_07_2024\V4\CategoryDto;
use App\lesson_20_07_2024\V4\Role;
use App\lesson_20_07_2024\V4\RoleDto;
use App\lesson_20_07_2024\V4\User;
use App\lesson_20_07_2024\V4\UserDto;
use App\lesson_20_07_2024\V4\Roles;

require __DIR__ . '/../../../vendor/autoload.php';

$roleAdminId = 1;
$roleAdminName = Roles::ADMIN->value;
$roleAdminDto = new RoleDto($roleAdminId, $roleAdminName);

$roleAdmin = Role::create($roleAdminDto);

$roleModeratorId = 2;
$roleModeratorName = Roles::MODERATOR->value;
$roleModeratorDto = new RoleDto($roleModeratorId, $roleModeratorName);

$roleModerator = Role::create($roleModeratorDto);

$roleUserId = 3;
$roleUserName = Roles::USER->value;
$roleUserDto = new RoleDto($roleUserId, $roleUserName);

$roleUser = Role::create($roleUserDto);

$userId = 1;
$userName = 'user';
$userPassword = '123456j';
$userEmail = 'user@gmail.com';
$roles = [
    $roleAdminId => $roleAdmin,
    $roleModeratorId => $roleModerator,
    $roleUserId => $roleUser,
];
$userDto = new UserDto(
    $userId,
    $userName,
    $userPassword,
    $userEmail,
    $roles,
);

$user = User::create($userDto);

$categoryId = 1;
$categoryName = 'category_one';
$categoryDto = new CategoryDto(
    $categoryId,
    $categoryName,
);

$category = Category::create($categoryDto);

$articleId = 1;
$articleTitle = 'article_one';
$articleBody = 'article_content';
$articleDto = new ArticleDto(
    $articleId,
    $articleTitle,
    $articleBody,
    $category,
    $user,
);

$article = Article::create($articleDto);

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
