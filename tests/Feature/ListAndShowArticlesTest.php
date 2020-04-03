<?php

namespace Tests\Feature;

use App\Drug;
use App\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListAndShowArticlesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->articles = factory(Article::class, 2)
            ->create()
            ->each(function ($article) {
                $article->drugs()->saveMany(factory(Drug::class, 2)->make());
            });
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testListArticles()
    {
        $response = $this->get('/articles');

        $response->assertStatus(200);
        $response->assertSeeText($this->articles[0]->title);
        $response->assertSeeText($this->articles[1]->title);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetArticleByIdGetPermanentlyRedirected()
    {
        $response = $this->get('/articles/' . $this->articles[0]->id);

        $this->followingRedirects();

        $response->assertStatus(301);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetArticleBySlugReturns200()
    {
        $response = $this->get('/articles/' . $this->articles[0]->slug);

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNotExitingArticleReturns404()
    {
        $response = $this->get('/articles/100');
        $response->assertStatus(404);

        $response = $this->get('/articles/not-an-article');
        $response->assertStatus(404);
    }
}
