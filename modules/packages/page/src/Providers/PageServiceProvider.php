<?php
namespace EG\Page\Providers;

use EG\Base\Supports\Helper;
use EG\Base\Traits\LoadAndPublishTrait;
use EG\Page\Models\Page;
use EG\Page\Repositories\Caches\PageCacheDecorator;
use EG\Page\Repositories\Eloquent\PageRepository;
use EG\Page\Repositories\Interfaces\PageInterface;
use EG\Shortcode\View\View;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;
use Event;
use SlugHelper;
use Language;
use SeoHelper;

class PageServiceProvider extends ServiceProvider
{
    use LoadAndPublishTrait;

    public function register()
    {
        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        SlugHelper::registerModule(Page::class, 'Pages');

        $this->app->bind(PageInterface::class, function () {
            return new PageCacheDecorator(new PageRepository(new Page()));
        });

        $this->setNamespace('packages/page')
            ->loadAndPublishConfigurations(['permissions', 'general'])
            ->loadRoutes(['web'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-core-page',
                'priority'    => 2,
                'parent_id'   => null,
                'name'        => 'packages/page::pages.menu_name',
                'icon'        => 'fa fa-book',
                'url'         => route('pages.index'),
                'permissions' => ['pages.index'],
            ]);
        });

//        if (function_exists('admin_bar')) {
//            admin_bar()->registerLink(trans('packages/page::pages.menu_name'), route('pages.index'), 'add-new');
//        }

        if (function_exists('shortcode')) {
            view()->composer(['packages/page::theme.page'], function (View $view) {
                $view->withShortcodes();
            });
        }

        $this->app->booted(function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                Language::registerModule([Page::class]);
            }
            SeoHelper::registerModule([Page::class]);
        });

        $this->app->booted(function () {
            $this->app->register(HookServiceProvider::class);
        });


        $this->app->register(EventServiceProvider::class);
    }
}
