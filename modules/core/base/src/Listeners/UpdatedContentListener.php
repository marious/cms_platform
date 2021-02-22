<?php
namespace EG\Base\Listeners;

use Exception;
use EG\Base\Events\UpdatedContentEvent;

class UpdatedContentListener
{
    public function handle(UpdatedContentEvent $event)
    {
      try {
        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, $event->screen, $event->request, $event->data);
      } catch (Exception $exception) {
        info($exception->getMessage());
      }
    }
}
