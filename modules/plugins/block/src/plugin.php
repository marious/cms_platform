<?php

namespace EG\Block;

use Schema;
use EG\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('blocks');
    }
}
