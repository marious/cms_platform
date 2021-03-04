<?php
namespace EG\Hospital;

use Schema;
use EG\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('hs_departments');
        Schema::dropIfExists('hs_doctors');
        Schema::dropIfExists('hs_appointments');
    }
}
