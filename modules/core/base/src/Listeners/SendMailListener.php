<?php
namespace EG\Base\Listeners;

use Log;
use Exception;
use EG\Base\Events\SendMailEvent;
use EG\Base\Supports\EmailAbstract;
use Illuminate\Contracts\Mail\Mailer;

class SendMailListener
{
    /**
     * @var Mailer
     */
    protected $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function handle(SendMailEvent $event)
    {
      try {
        $this->mailer->to($event->to)->send(new EmailAbstract($event->content, $event->title, $event->args));
      } catch (Exception $exception) {
        if ($event->debug) {
            throw $exception;
        }
        Log::error($exception->getMessage());
      }
    }
}
