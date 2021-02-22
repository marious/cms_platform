<?php
namespace EG\ACL\Providers;

use File;
use Event;
use EG\Base\Events\SendMailEvent;
use EG\Base\Events\CreatedContentEvent;
use EG\Base\Events\DeletedContentEvent;
use EG\Base\Events\UpdatedContentEvent;
use EG\Base\Listeners\SendMailListener;
use EG\Base\Events\BeforeEditContentEvent;
use EG\Base\Listeners\CreatedContentListener;
use EG\Base\Listeners\DeletedContentListener;
use EG\Base\Listeners\UpdatedContentListener;
use EG\Base\Listeners\BeforeEditContentListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
      SendMailEvent::class => [
        SendMailListener::class,
      ],
      CreatedContentEvent::class => [
        CreatedContentListener::class,
      ],
      UpdatedContentEvent::class => [
        UpdatedContentListener::class,
      ],
      DeletedContentEvent::class  => [
        DeletedContentListener::class,
      ],
      BeforeEditContentEvent::class => [
        BeforeEditContentListener::class,
      ],
    ];

    public function boot()
    {
        parent::boot();

        Event::listen(['cache:cleared'], function () {
          File::delete([storage_path('cache_keys.json'), storage_path('settings.json')]);
        });

    }
}
