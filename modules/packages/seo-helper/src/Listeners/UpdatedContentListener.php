<?php

namespace EG\SeoHelper\Listeners;

use SeoHelper;
use Exception;
use EG\Base\Events\UpdatedContentEvent;

class UpdatedContentListener
{
    /**
     * Handle the event.
     *
     * @param UpdatedContentEvent $event
     * @return void
     */
    public function handle(UpdatedContentEvent $event)
    {
        try {
            SeoHelper::saveMetaData($event->screen, $event->request, $event->data);
        } catch (Exception $e) {
            info($e->getMessage());
        }
    }
}
