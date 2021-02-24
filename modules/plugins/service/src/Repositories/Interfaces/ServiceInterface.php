<?php

namespace EG\Service\Repositories\Interfaces;

use EG\Support\Repositories\Interfaces\RepositoryInterface;

interface ServiceInterface extends RepositoryInterface
{
	public function getAllServices($active = true);
	public function getListServiceNonInList(array $selected = [], $limit = 7);
}
