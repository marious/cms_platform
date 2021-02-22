<?php

namespace EG\Page\Listeners;

use EG\Page\Repositories\Interfaces\PageInterface;
use SiteMapManager;

class RenderingSiteMapListener
{
    protected $pageRepository;

    public function __construct(PageInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function handle()
    {
        $pages = $this->pageRepository->getDataSiteMap();
        foreach ($pages as $page) {
            SiteMapManager::add($page->url, $page->updated_at, '0.8', 'daily');
        }
    }
}
