<?php

namespace EG\Block\Repositories\Eloquent;

use EG\Support\Repositories\Eloquent\RepositoriesAbstract;
use EG\Block\Repositories\Interfaces\BlockInterface;
use Illuminate\Support\Str;

class BlockRepository extends RepositoriesAbstract implements BlockInterface
{
    /**
     * {@inheritDoc}
     */
    public function createSlug($name, $id)
    {
        $slug = Str::slug($name);
        $index = 1;
        $baseSlug = $slug;
        while ($this->model->where('alias', $slug)->where('id', '!=', $id)->count() > 0) {
            $slug = $baseSlug . '-' . $index++;
        }

        if (empty($slug)) {
            $slug = time();
        }

        $this->resetModel();

        return $slug;
    }
}
