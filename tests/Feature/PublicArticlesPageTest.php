<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicArticlesPageTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected ArticleCategory $category1;
    protected ArticleCategory $category2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->category1 = ArticleCategory::create([
            'name' => 'Site Progress',
            'slug' => 'site-progress',
            'description' => 'Real-time structural progress updates.',
            'created_by' => $this->admin->id,
        ]);

        $this->category2 = ArticleCategory::create([
            'name' => 'Engineering & Tech',
            'slug' => 'engineering-and-tech',
            'description' => 'BIM 5D and structural mechanics.',
            'created_by' => $this->admin->id,
        ]);
    }

    public function test_articles_index_page_is_accessible_and_renders_published_articles(): void
    {
        $article1 = Article::create([
            'category_id' => $this->category1->id,
            'title' => 'Vertex Tower Superstructure Enclosure',
            'slug' => 'vertex-tower-superstructure-enclosure',
            'author_name' => 'Engr. Mahbubur Rahman',
            'summary' => 'Core shear wall concrete pours reach level 28 topping out.',
            'content' => '<p>Detailed structural enclosure content.</p>',
            'published_at' => now()->subDay(),
            'read_time' => 4,
            'featured' => true,
            'is_published' => true,
            'created_by' => $this->admin->id,
        ]);

        $article2 = Article::create([
            'category_id' => $this->category2->id,
            'title' => 'Deploying 5D BIM On Industrial Warehouses',
            'slug' => 'deploying-5d-bim-on-industrial-warehouses',
            'author_name' => 'Tariq Hasan',
            'summary' => 'How real-time RTK drone clouds eliminate clash detections.',
            'content' => '<p>BIM 5D workflows and laser-screed floor leveling.</p>',
            'published_at' => now()->subDays(2),
            'read_time' => 5,
            'featured' => false,
            'is_published' => true,
            'created_by' => $this->admin->id,
        ]);

        $draftArticle = Article::create([
            'category_id' => $this->category1->id,
            'title' => 'Unpublished Draft Article',
            'slug' => 'unpublished-draft-article',
            'author_name' => 'Draft Author',
            'summary' => 'This is a draft article.',
            'content' => '<p>Draft content not ready for public.</p>',
            'published_at' => null,
            'read_time' => 2,
            'featured' => false,
            'is_published' => false,
            'created_by' => $this->admin->id,
        ]);

        $response = $this->get(route('public.articles.index'));

        $response->assertStatus(200);
        $response->assertSee('Vertex Tower Superstructure Enclosure');
        $response->assertSee('Deploying 5D BIM On Industrial Warehouses');
        $response->assertDontSee('Unpublished Draft Article');
        $response->assertSee('Site Progress');
        $response->assertSee('Engineering & Tech');
    }

    public function test_articles_index_page_filters_by_category(): void
    {
        $article1 = Article::create([
            'category_id' => $this->category1->id,
            'title' => 'Vertex Tower Superstructure Enclosure',
            'slug' => 'vertex-tower-superstructure-enclosure',
            'summary' => 'Core shear wall concrete pours reach level 28.',
            'content' => '<p>Content</p>',
            'is_published' => true,
            'created_by' => $this->admin->id,
        ]);

        $article2 = Article::create([
            'category_id' => $this->category2->id,
            'title' => 'Deploying 5D BIM On Industrial Warehouses',
            'slug' => 'deploying-5d-bim-on-industrial-warehouses',
            'summary' => 'Drone photogrammetry.',
            'content' => '<p>Content</p>',
            'is_published' => true,
            'created_by' => $this->admin->id,
        ]);

        $response = $this->get(route('public.articles.index', ['category' => 'site-progress']));

        $response->assertStatus(200);
        $articles = $response->viewData('articles');
        $this->assertTrue($articles->contains('id', $article1->id));
        $this->assertFalse($articles->contains('id', $article2->id));
    }

    public function test_article_detail_page_loads_and_increments_views(): void
    {
        $article = Article::create([
            'category_id' => $this->category1->id,
            'title' => 'Vertex Tower Superstructure Enclosure',
            'slug' => 'vertex-tower-superstructure-enclosure',
            'author_name' => 'Engr. Mahbubur Rahman',
            'summary' => 'Core shear wall concrete pours reach level 28 topping out.',
            'content' => '<p>Deep technical breakdown with 65 MPa high-performance concrete.</p>',
            'published_at' => now()->subDay(),
            'read_time' => 4,
            'featured' => true,
            'is_published' => true,
            'views_count' => 10,
            'created_by' => $this->admin->id,
        ]);

        $response = $this->get(route('public.articles.show', $article->slug));

        $response->assertStatus(200);
        $response->assertSee('Vertex Tower Superstructure Enclosure');
        $response->assertSee('Engr. Mahbubur Rahman');
        $response->assertSee('Deep technical breakdown with 65 MPa high-performance concrete.');
        $response->assertSee('Site Progress');

        $this->assertEquals(11, $article->fresh()->views_count);
    }

    public function test_unpublished_article_returns_404_on_detail_page(): void
    {
        $draftArticle = Article::create([
            'category_id' => $this->category1->id,
            'title' => 'Confidential Internal Memo',
            'slug' => 'confidential-internal-memo',
            'summary' => 'Draft only.',
            'content' => '<p>Draft</p>',
            'is_published' => false,
            'created_by' => $this->admin->id,
        ]);

        $response = $this->get(route('public.articles.show', $draftArticle->slug));

        $response->assertStatus(404);
    }

    public function test_article_detail_page_displays_related_articles(): void
    {
        $mainArticle = Article::create([
            'category_id' => $this->category1->id,
            'title' => 'Vertex Tower Superstructure Enclosure',
            'slug' => 'vertex-tower-superstructure-enclosure',
            'summary' => 'Main summary.',
            'content' => '<p>Main content</p>',
            'is_published' => true,
            'created_by' => $this->admin->id,
        ]);

        $relatedArticle = Article::create([
            'category_id' => $this->category1->id,
            'title' => 'Diaphragm Wall Ground Stabilization',
            'slug' => 'diaphragm-wall-ground-stabilization',
            'summary' => 'Related summary in same category.',
            'content' => '<p>Related content</p>',
            'is_published' => true,
            'created_by' => $this->admin->id,
        ]);

        $response = $this->get(route('public.articles.show', $mainArticle->slug));

        $response->assertStatus(200);
        $response->assertSee('Diaphragm Wall Ground Stabilization');
        $response->assertSee('Related Research');
    }
}
