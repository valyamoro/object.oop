<?php
declare(strict_types=1);

namespace lesson20_07_2024\V2;

use App\lesson_20_07_2024\V2\Article;
use App\lesson_20_07_2024\V2\Category;
use App\lesson_20_07_2024\V2\Role;
use App\lesson_20_07_2024\V2\User;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    public function testCanCreate(): void
    {
        $id = 1;
        $title = 'article_one';
        $body = 'article content';
        $category = Category::create(1, 'category_one');
        $user = User::create(1,
            'user',
            '123456j',
            'user@gmail.com',
            [
                Role::create(
                    1,
                    Role::USER,
                ),
            ],
        );

        $article = Article::create(
            $id,
            $title,
            $body,
            $category,
            $user,
        );

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