<?php

namespace EG\Slug\Listeners;

use EG\Base\Events\CreatedContentEvent;
use Exception;
use EG\Slug\Repositories\Interfaces\SlugInterface;
use EG\Slug\Services\SlugService;
use SlugHelper;
use Str;
use Language;

class CreatedContentListener
{
    /**
     * @var SlugInterface
     */
    protected $slugRepository;

    public function __construct(SlugInterface $slugRepository)
    {
        $this->slugRepository = $slugRepository;
    }

    public function handle(CreatedContentEvent $event)
    {
        if (SlugHelper::isSupportedModel(get_class($event->data))) {
            try {
                $slug = $event->request->input('slug');
                $data = Language::handleMultiLangFields($event->request->input());


                $slugService = new SlugService($this->slugRepository);
                $slugData = [];

                foreach ($data as $key => $item) {
                    if (!$data[$key]['slug']) {
                        $data[$key]['slug'] = $data[$key]['name'];
                    }
                    $slugData['key'][$key] = $data[$key]['slug'];
                }
//                dd($data);

//                if (!$slug) {
//                    $slug = $event->request->input('name');
//                }
//                if (!$slug && $event->data->name) {
//                    $slug = Str::slug($event->data->name);
//                }
//                if (!$slug) {
//                    $slug = time();
//                }

                $slug = $slugService->createFromArray($slugData, $event->data->slug_id, get_class($event->data));


                $this->slugRepository->createOrUpdate([
                    'key'            => $slug,
                    'reference_type' => get_class($event->data),
                    'reference_id'   => $event->data->id,
                    'prefix'         => SlugHelper::getPrefix(get_class($event->data)),
                ]);
            } catch (Exception $e) {
                info($e->getMessage());
            }
        }
    }
}
