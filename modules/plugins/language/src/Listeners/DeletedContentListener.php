<?php

namespace EG\Language\Listeners;

use EG\Base\Events\DeletedContentEvent;
use Exception;
use Language;

class DeletedContentListener
{

    /**
     * Handle the event.
     *
     * @param DeletedContentEvent $event
     * @return void
     * @author Sang Nguyen
     */
    public function handle(DeletedContentEvent $event)
    {
        try {
            Language::deleteLanguage($event->screen, $event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
