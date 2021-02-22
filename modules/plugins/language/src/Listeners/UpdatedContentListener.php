<?php

namespace EG\Language\Listeners;

use EG\Base\Events\UpdatedContentEvent;
use Exception;
use Language;

class UpdatedContentListener
{

    /**
     * Handle the event.
     *
     * @param UpdatedContentEvent $event
     * @return void
     * @author Sang Nguyen
     */
    public function handle(UpdatedContentEvent $event)
    {
        try {
            Language::saveLanguage($event->screen, $event->request, $event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
