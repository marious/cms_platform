<?php
use EG\Service\Repositories\Interfaces\ServiceInterface;
use EG\Service\Repositories\Interfaces\BusinessSolutionsInterface;

if (!function_exists('get_latest_services')) {
    /**
     * @param int $limit
     * @param array $excepts
     * @return array
     */
    function get_latest_services($limit, $excepts = [])
    {
        // return 'ok';
        return app(ServiceInterface::class)->getListServiceNonInList($excepts, $limit);
    }
}

if (!function_exists('get_latest_business_solutions')) {
    /**
     * @param int $limit
     * @param array $excepts
     * @return array
     */
    function get_latest_business_solutions($limit, $excepts = [])
    {
        // return 'ok';
        return app(BusinessSolutionsInterface::class)->getListBusinessSolutionsNonInList($excepts, $limit);
    }
}

?>
