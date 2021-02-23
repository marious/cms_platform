<?php

namespace EG\Contact\Providers;

use EG\Base\Traits\LoadAndPublishTrait;
use EmailHandler;
use Illuminate\Routing\Events\RouteMatched;
use EG\Base\Supports\Helper;
use EG\Contact\Models\ContactReply;
use EG\Contact\Repositories\Caches\ContactReplyCacheDecorator;
use EG\Contact\Repositories\Eloquent\ContactReplyRepository;
use EG\Contact\Repositories\Interfaces\ContactInterface;
use EG\Contact\Models\Contact;
use EG\Contact\Repositories\Caches\ContactCacheDecorator;
use EG\Contact\Repositories\Eloquent\ContactRepository;
use EG\Contact\Repositories\Interfaces\ContactReplyInterface;
use Event;
use Illuminate\Support\ServiceProvider;

class ContactServiceProvider extends ServiceProvider
{
    use LoadAndPublishTrait;

    public function register()
    {
        $this->app->bind(ContactInterface::class, function () {
            return new ContactCacheDecorator(new ContactRepository(new Contact));
        });

        $this->app->bind(ContactReplyInterface::class, function () {
            return new ContactReplyCacheDecorator(new ContactReplyRepository(new ContactReply));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/contact')
            ->loadAndPublishConfigurations(['permissions', 'email'])
            ->loadRoutes(['web'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-contact',
                'priority'    => 120,
                'parent_id'   => null,
                'name'        => 'plugins/contact::contact.menu',
                'icon'        => 'far fa-envelope',
                'url'         => route('contacts.index'),
                'permissions' => ['contacts.index'],
            ]);

            EmailHandler::addTemplateSettings(CONTACT_MODULE_SCREEN_NAME, config('plugins.contact.email', []));
        });

        $this->app->booted(function () {
            $this->app->register(HookServiceProvider::class);
        });
    }
}
