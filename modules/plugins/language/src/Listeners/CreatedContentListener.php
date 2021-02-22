<?php

namespace EG\Language\Listeners;

use EG\Base\Events\CreatedContentEvent;
use Exception;
use Language;

class CreatedContentListener
{
    public function handle(CreatedContentEvent $event)
    {
        try {
            Language::saveLanguage($event->screen, $event->request, $event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
