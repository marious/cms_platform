<?php
namespace EG\Base\Http\Controllers;

use Assets2;
use EG\Table\TableBuilder;
use Illuminate\Http\Request;
use EG\Base\Tables\InfoTable;
use Illuminate\Routing\Controller;
use EG\Base\Supports\SystemManagement;

class SystemController extends Controller
{
    public function getInfo(Request $request, TableBuilder $tableBuilder)
    {
        page_title()->setTitle(trans('core/base::system.info.title'));

        Assets2::addStylesDirectly(['vendor/core/base/css/system-info.css']);

        $composerArray = SystemManagement::getComposerArray();
        $packages = SystemManagement::getPackagesAndDependencies($composerArray['require']);

        $infoTable = $tableBuilder->create(InfoTable::class);

        if ($request->expectsJson()) {
            return $infoTable->renderTable();
        }
        $systemEnv = SystemManagement::getSystemEnv();
        $serverEnv = SystemManagement::getServerEnv();

        return view('core/base::system.info', compact(
                'packages',
                'infoTable',
                'systemEnv',
                'serverEnv'
        ));
    }

    public function getCacheManagement()
    {
        page_title()->setTitle(trans('cache.cache_management'));
        return view('core/base::layouts.master');
    }
}
