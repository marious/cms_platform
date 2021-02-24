<?php

namespace EG\Service;

use Schema;
use EG\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('services');
        Schema::dropIfExists('business_solutions');
    }
}
