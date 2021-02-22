<?php
namespace EG\Slug\Providers;

use EG\Base\Events\CreatedContentEvent;
use EG\Base\Events\DeletedContentEvent;
use EG\Base\Events\UpdatedContentEvent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use EG\Slug\Listeners\CreatedContentListener;
use EG\Slug\Listeners\DeletedContentListener;
use EG\Slug\Listeners\UpdatedContentListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UpdatedContentEvent::class => [
            UpdatedContentListener::class,
        ],
        CreatedContentEvent::class => [
            CreatedContentListener::class,
        ],
        DeletedContentEvent::class => [
            DeletedContentListener::class,
        ],
    ];
}
