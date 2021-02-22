<?php

namespace EG\Widget\Repositories\Eloquent;

use EG\Support\Repositories\Eloquent\RepositoriesAbstract;
use EG\Widget\Repositories\Interfaces\WidgetInterface;

class WidgetRepository extends RepositoriesAbstract implements WidgetInterface
{
    /**
     * {@inheritDoc}
     */
    public function getByTheme($theme)
    {
        $data = $this->model->where('theme', $theme)->get();
        $this->resetModel();

        return $data;
    }
}
