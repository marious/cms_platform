<?php

namespace EG\Language\Repositories\Interfaces;

use EG\Support\Repositories\Interfaces\RepositoryInterface;

interface LanguageInterface extends RepositoryInterface
{
    /**
     * @param array $select
     * @return mixed
     */
    public function getActiveLanguage($select = ['*']);

    /**
     * @param array $select
     * @return mixed
     */
    public function getDefaultLanguage($select = ['*']);
}
