<?php

namespace EG\Slug\Listeners;

use EG\Base\Events\DeletedContentEvent;
use EG\Slug\Repositories\Interfaces\SlugInterface;
use Exception;
use SlugHelper;

class DeletedContentListener
{
    /**
     * @var SlugInterface
     */
    protected $slugRepository;

    public function __construct(SlugInterface $slugRepository)
    {
        $this->slugRepository = $slugRepository;
    }

    public function handle(DeletedContentEvent $event)
    {
        if (SlugHelper::isSupportedModel(get_class($event->data))) {
            try {
                $this->slugRepository->deleteBy([
                    'reference_id'   => $event->data->id,
                    'reference_type' => get_class($event->data),
                ]);
            } catch (Exception $exception) {
                info($exception->getMessage());
            }
        }
    }
}
