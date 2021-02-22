<?php

namespace EG\Theme\Events;

use EG\Base\Events\Event;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Queue\SerializesModels;

class ThemeRoutingBeforeEvent extends Event
{
    use SerializesModels;

    /**
     * @var Application|mixed
     */
    public $router;

    /**
     * ThemeRoutingBeforeEvent constructor.
     */
    public function __construct()
    {
        $this->router = app('router');
    }
}
