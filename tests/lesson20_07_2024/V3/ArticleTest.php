<?php
declare(strict_types=1);

namespace lesson20_07_2024\V3;

use App\lesson20_07_2024\V3\Article;
use App\lesson20_07_2024\V3\ArticleDto;
use App\lesson20_07_2024\V3\Category;
use App\lesson20_07_2024\V3\CategoryDto;
use App\lesson20_07_2024\V3\Role;
use App\lesson20_07_2024\V3\RoleDto;
use App\lesson20_07_2024\V3\User;
use App\lesson20_07_2024\V3\UserDto;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    public function testCanCreate(): void
    {
        $id = 1;
        $title = 'article_one';
        $body = 'article content';
        $category = Category::create(new CategoryDto(
            1,
            'category_one',
        ));
        $user = User::create(new UserDto(
            1,
            'user',
            '123456j',
            'user@gmail.com',
            [
                Role::create(new RoleDto(1, Role::USER)),
            ],
        ));
        $articleDto = new ArticleDto(
            $id,
            $title,
            $body,
            $category,
            $user,
        );

        $article = Article::create($articleDto);

        $this->assertInstanceOf(Article::class, $article);
        $this->assertSame(1, $article->getId());
        $this->assertSame('article_one', $article->getTitle());
        $this->assertSame('article content', $article->getBody());
        $this->assertInstanceOf(Category::class, $article->getCategory());
        $this->assertSame(1, $article->getCategory()->getId());
        $this->assertSame('category_one', $article->getCategory()->getName());
        $this->assertInstanceOf(User::class, $article->getUser());
        $this->assertSame(1, $article->getUser()->getId());
        $this->assertSame('user', $article->getUser()->getLogin());
        $this->assertSame('123456j', $article->getUser()->getPassword());
        $this->assertSame('user@gmail.com', $article->getUser()->getEmail());
        $this->assertInstanceOf(Role::class, $article->getUser()->getRoles()[0]);
        $this->assertSame(1, $article->getUser()->getRoles()[0]->getId());
        $this->assertSame(Role::USER, $article->getUser()->getRoles()[0]->getName());
    }

}
