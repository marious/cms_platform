<?php
namespace EG\Base\Events;

use Illuminate\Queue\SerializesModels;

class BeforeEditContentEvent extends Event
{
  use SerializesModels;


    /**
     * @var Request
     */
    public $request;

    /**
     * @var Eloquent|false
     */
    public $data;

     /**
     * BeforeEditContentEvent constructor.
     * @param Request $request
     * @param Eloquent|false|stdClass $data
     */
    public function __construct($request, $data)
    {
        $this->request = $request;
        $this->data = $data;
    }
}
