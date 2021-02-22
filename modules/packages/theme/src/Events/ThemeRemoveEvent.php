<?php

namespace EG\Theme\Events;

use EG\Base\Events\Event;
use Illuminate\Queue\SerializesModels;

class ThemeRemoveEvent extends Event
{
    use SerializesModels;

    /**
     * @var string
     */
    public $theme;

    /**
     * ThemeRemoveEvent constructor.
     * @param string
     */
    public function __construct($theme)
    {
        $this->theme = $theme;
    }
}
