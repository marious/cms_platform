<?php
namespace EG\Base\Supports;

use Botble\Assets\Assets as BaseAssets;
use Botble\Assets\HtmlBuilder;
use Illuminate\Config\Repository;
use Throwable;
use File;
use Illuminate\Support\Str;

class Assets extends BaseAssets
{
    public function __construct(Repository $config, HtmlBuilder $htmlBuilder)
    {
        parent::__construct($config, $htmlBuilder);

        $this->config = $config->get('core.base.assets');

        $this->scripts = $this->config['scripts'];

        $this->styles = $this->config['styles'];
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }


    /**
     * Get all admin themes
     *
     * @return array
     */
    public function getThemes(): array
    {
        $themes = [];

        if (!File::isDirectory(public_path('vendor/core/base/css/themes'))) {
            return $themes;
        }

        foreach (File::files(public_path('vendor/core/base/css/themes')) as $file) {
            $name = '/vendor/core/base/css/themes/' . basename($file);
            if (!Str::contains($file, '.css.map')) {
                $themes[basename($file, '.css')] = $name;
            }
        }

        return $themes;
    }

    /**
     * @return array
     */
    public function getAdminLocales(): array
    {
        return Language::getAvailableLocales();
    }

    /**
     * @param array $lastStyles
     * @return string
     * @throws Throwable
     */
    public function renderHeader($lastStyles = [])
    {
        do_action(BASE_ACTION_ENQUEUE_SCRIPTS);

        return parent::renderHeader($lastStyles);
    }

    /**
     * @return string
     * @throws Throwable
     */
    public function renderFooter()
    {
        $bodyScripts = $this->getScripts(self::ASSETS_SCRIPT_POSITION_FOOTER);
        return view('assets::footer', compact('bodyScripts'))->render();
    }

}
