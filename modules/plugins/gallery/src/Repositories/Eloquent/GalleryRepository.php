<?php

namespace EG\Gallery\Repositories\Eloquent;

use EG\Base\Enums\BaseStatusEnum;
use EG\Support\Repositories\Eloquent\RepositoriesAbstract;
use EG\Gallery\Repositories\Interfaces\GalleryInterface;

class GalleryRepository extends RepositoriesAbstract implements GalleryInterface
{

    /**
     * {@inheritDoc}
     */
    public function getAll()
    {
        $data = $this->model
            ->with('slugable')
            ->where('galleries.status', BaseStatusEnum::PUBLISHED)
            ->orderBy('galleries.order', 'asc')
            ->orderBy('galleries.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getDataSiteMap()
    {
        $data = $this->model
            ->with('slugable')
            ->where('galleries.status', BaseStatusEnum::PUBLISHED)
            ->select('galleries.*')
            ->orderBy('galleries.order', 'asc')
            ->orderBy('galleries.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getFeaturedGalleries($limit)
    {
        $data = $this->model
            ->with(['user', 'slugable'])
            ->where([
                'galleries.status'   => BaseStatusEnum::PUBLISHED,
                'galleries.is_featured' => 1,
            ])
            ->select([
                'galleries.id',
                'galleries.name',
                'galleries.user_id',
                'galleries.image',
                'galleries.created_at',
            ])
            ->orderBy('galleries.order', 'asc')
            ->orderBy('galleries.created_at', 'desc')
            ->limit($limit);

        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
