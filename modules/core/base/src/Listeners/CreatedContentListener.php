<?php
namespace EG\Base\Listeners;

use Exception;
use EG\Base\Events\CreatedContentEvent;

class CreatedContentListener
{
    public function handle(CreatedContentEvent $event)
    {
      try {
        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, $event->screen, $event->request, $event->data);
      } catch (Exception $exception) {
        info($exception->getMessage());
      }
    }
}
