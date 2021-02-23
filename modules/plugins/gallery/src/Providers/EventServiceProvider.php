<?php

namespace EG\Gallery\Providers;

use EG\Base\Events\CreatedContentEvent;
use EG\Base\Events\DeletedContentEvent;
use EG\Theme\Events\RenderingSiteMapEvent;
use EG\Base\Events\UpdatedContentEvent;
use EG\Gallery\Listeners\CreatedContentListener;
use EG\Gallery\Listeners\DeletedContentListener;
use EG\Gallery\Listeners\RenderingSiteMapListener;
use EG\Gallery\Listeners\UpdatedContentListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RenderingSiteMapEvent::class => [
            RenderingSiteMapListener::class,
        ],
        UpdatedContentEvent::class   => [
            UpdatedContentListener::class,
        ],
        CreatedContentEvent::class   => [
            CreatedContentListener::class,
        ],
        DeletedContentEvent::class   => [
            DeletedContentListener::class,
        ],
    ];
}
