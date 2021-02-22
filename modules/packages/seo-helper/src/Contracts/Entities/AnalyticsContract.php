<?php
namespace EG\SeoHelper\Contracts\Entities;

use EG\SeoHelper\Contracts\RenderableContract;


interface AnalyticsContract extends RenderableContract
{
    /**
     * Set Google Analytics code.
     *
     * @param string $code
     * @return $this
     */
    public function setGoogle($code);
}
