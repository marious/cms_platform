<?php

namespace EG\SeoHelper\Listeners;

use SeoHelper;
use Exception;
use EG\Base\Events\CreatedContentEvent;

class CreatedContentListener
{
    /**
     * Handle the event.
     *
     * @param CreatedContentEvent $event
     * @return void
     */
    public function handle(CreatedContentEvent $event)
    {
        try {
            SeoHelper::saveMetaData($event->screen, $event->request, $event->data);
        } catch (Exception $e) {
            info($e->getMessage());
        }
    }
}
