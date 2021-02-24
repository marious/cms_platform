<?php

namespace EG\Service\Repositories\Eloquent;

use EG\Base\Enums\BaseStatusEnum;
use EG\Support\Repositories\Eloquent\RepositoriesAbstract;
use EG\Service\Repositories\Interfaces\ServiceInterface;

class ServiceRepository extends RepositoriesAbstract implements ServiceInterface
{
	public function getAllServices($active = true)
    {
        $data = $this->model->select('services.*');
        if ($active) {
            $data = $data->where('services.status', BaseStatusEnum::PUBLISHED);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }
    public function getListServiceNonInList(array $selected = [], $limit = 7)
    {
        $data = $this->model
            ->where('services.status', BaseStatusEnum::PUBLISHED)
            ->whereNotIn('services.id', $selected)
            ->limit($limit)
            ->orderBy('services.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
