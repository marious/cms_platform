<?php
namespace EG\Blog\Repositories\Interfaces;

use EG\Support\Repositories\Interfaces\RepositoryInterface;

interface CategoryInterface extends RepositoryInterface
{
     /**
     * @return array
     */
    public function getDataSiteMap();

    /**
     * @param int $limit
     * @param array $with
     */
    public function getFeaturedCategories($limit, array $with = []);

    /**
     * @param array $condition
     * @param array $with
     * @return array
     */
    public function getAllCategories(array $condition = [], array $with = []);

     /**
     * @param int $id
     * @return mixed
     */
    public function getCategoryById($id);

     /**
     * @param array $select
     * @param array $orderBy
     * @return Collection
     */
    public function getCategories(array $select, array $orderBy);

     /**
     * @param int $id
     * @return array|null
     */
    public function getAllRelatedChildrenIds($id);

    /**
     * @param array $condition
     * @param array $with
     * @param array $select
     * @return mixed
     */
    public function getAllCategoriesWithChildren(array $condition = [], array $with = [], array $select = ['*']);

     /**
     * @param array $filters
     * @return mixed
     */
    public function getFilters($filters);

    /**
     * @param int $limit
     * @return mixed
     */
    public function getPopularCategories(int $limit);
}
