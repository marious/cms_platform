<?php

namespace EG\SeoHelper\Listeners;

use SeoHelper;
use Exception;
use EG\Base\Events\DeletedContentEvent;

class DeletedContentListener
{
    /**
     * Handle the event.
     *
     * @param DeletedContentEvent $event
     * @return void
     */
    public function handle(DeletedContentEvent $event)
    {
        try {
            SeoHelper::deleteMetaData($event->screen, $event->data);
        } catch (Exception $e) {
            info($e->getMessage());
        }
    }
}
