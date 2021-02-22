<?php
namespace EG\Base\Supports;

class PageTitle
{
    protected $title;

    public function setTitle(string $tilte)
    {
        $this->title = $tilte;
    }

    public function getTitle(bool $full = true)
    {
        if (empty($this->title)) {
            return setting('admin_title', config('core.base.general.base_name'));
        }

        if (!$full) {
            return $this->title;
        }

        return $this->title . ' | ' . setting('admin_title', config('core.base.general.base_name'));
    }
}
