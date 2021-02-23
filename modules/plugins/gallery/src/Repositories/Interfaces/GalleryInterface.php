<?php

namespace EG\Gallery\Repositories\Interfaces;

use EG\Support\Repositories\Interfaces\RepositoryInterface;

interface GalleryInterface extends RepositoryInterface
{

    /**
     * Get all galleries.
     *
     * @return mixed
     */
    public function getAll();

    /**
     * @return mixed
     */
    public function getDataSiteMap();

    /**
     * @param $limit
     */
    public function getFeaturedGalleries($limit);
}
