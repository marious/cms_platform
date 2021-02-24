<?php
namespace EG\Blog\Providers;

use EG\Blog\Models\Tag;
use EG\Blog\Models\Post;
use EG\Base\Supports\Helper;
use EG\Blog\Models\Category;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use EG\Base\Traits\LoadAndPublishTrait;
use Illuminate\Routing\Events\RouteMatched;
use EG\Blog\Repositories\Eloquent\TagRepository;
use EG\Blog\Repositories\Eloquent\PostRepository;
use EG\Blog\Repositories\Interfaces\TagInterface;
use EG\Blog\Repositories\Caches\TagCacheDecorator;
use EG\Blog\Repositories\Interfaces\PostInterface;
use EG\Blog\Repositories\Caches\PostCacheDecorator;
use EG\Blog\Repositories\Eloquent\CategoryRepository;
use EG\Blog\Repositories\Interfaces\CategoryInterface;
use EG\Blog\Repositories\Caches\CategoryCacheDecorator;
use SeoHelper;
use SlugHelper;
use Language;

class BlogServiceProvider extends ServiceProvider
{
    use LoadAndPublishTrait;


    public function register()
    {
        $this->app->bind(PostInterface::class, function () {
            return new PostCacheDecorator(new PostRepository(new Post));
        });

        $this->app->bind(CategoryInterface::class, function () {
            return new CategoryCacheDecorator(new CategoryRepository(new Category));
        });

        $this->app->bind(TagInterface::class, function () {
            return new TagCacheDecorator(new TagRepository(new Tag));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }



    public function boot()
    {
        SlugHelper::registerModule(Post::class, 'Blog Posts');
        SlugHelper::registerModule(Category::class, 'Blog Categories');
        SlugHelper::registerModule(Tag::class, 'Blog Tags');
        SlugHelper::setPrefix(Tag::class, 'tag');


        $this->setNamespace('plugins/blog')
          ->loadAndPublishConfigurations(['permissions'])
          ->loadAndPublishViews()
          ->loadAndPublishTranslations()
          ->loadRoutes(['web', 'api'])
          ->loadMigrations()
          ->publishAssets();


          Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-plugins-blog',
                    'priority'    => 3,
                    'parent_id'   => null,
                    'name'        => 'plugins/blog::base.menu_name',
                    'icon'        => 'fa fa-edit',
                    'url'         => null,
                    'permissions' => ['posts.index'],
                ])
                 ->registerItem([
                     'id'          => 'cms-plugins-blog-post',
                     'priority'    => 1,
                     'parent_id'   => 'cms-plugins-blog',
                     'name'        => 'plugins/blog::posts.menu_name',
                     'icon'        => null,
                     'url'         => route('posts.index'),
                     'permissions' => ['posts.index'],
                 ])
                 ->registerItem([
                     'id'          => 'cms-plugins-blog-categories',
                     'priority'    => 2,
                     'parent_id'   => 'cms-plugins-blog',
                     'name'        => 'plugins/blog::categories.menu_name',
                     'icon'        => null,
                     'url'         => route('categories.index'),
                     'permissions' => ['categories.index'],
                 ])
                ->registerItem([
                    'id'          => 'cms-plugins-blog-tags',
                    'priority'    => 3,
                    'parent_id'   => 'cms-plugins-blog',
                    'name'        => 'plugins/blog::tags.menu_name',
                    'icon'        => null,
                    'url'         => route('tags.index'),
                    'permissions' => ['tags.index'],
                ]);
        });

        $this->app->booted(function () {
            $models = [Post::class, Category::class, Tag::class];

            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                Language::registerModule($models);
            }


            SeoHelper::registerModule($models);
        });
    }
}
