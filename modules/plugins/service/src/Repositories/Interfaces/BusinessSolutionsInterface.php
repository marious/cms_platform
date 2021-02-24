<?php

namespace EG\Service\Repositories\Interfaces;

use EG\Support\Repositories\Interfaces\RepositoryInterface;

interface BusinessSolutionsInterface extends RepositoryInterface
{
    public function getListBusinessSolutionsNonInList(array $selected = [], $limit = 7);
    public function getFirstById($id);
}
