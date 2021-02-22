<?php

namespace EG\Language\Repositories\Eloquent;

use EG\Support\Repositories\Eloquent\RepositoriesAbstract;
use EG\Language\Repositories\Interfaces\LanguageInterface;

class LanguageRepository extends RepositoriesAbstract implements LanguageInterface
{
    /**
     * {@inheritDoc}
     */
    public function getActiveLanguage($select = ['*'])
    {
        $data = $this->model->orderBy('lang_order', 'asc')->select($select)->get();
        $this->resetModel();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultLanguage($select = ['*'])
    {
        $data = $this->model->where('lang_is_default', 1)->select($select)->first();
        $this->resetModel();

        return $data;
    }
}
