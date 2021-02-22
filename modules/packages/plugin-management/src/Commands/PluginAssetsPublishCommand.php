<?php
namespace EG\PluginManagement\Commands;

use Illuminate\Console\Command;
use EG\PluginManagement\Services\PluginService;

class PluginAssetsPublishCommand extends Command
{
    protected $signature = 'cms:plugin:assets:publish {name : The plugin that you want to publish assets}';

    protected $description = 'Publish assets for a plugin';

    protected $pluginService;

    public function __construct(PluginService $pluginService)
    {
        parent::__construct();

        $this->pluginService = $pluginService;
    }

    public function handle()
    {
        if (!preg_match('/^[a-z0-9\-]+$/i', $this->argument('name'))) {
            $this->error('Only alphabetic characters are allowed.');
            return 1;
        }

        $plugin = strtolower($this->argument('name'));
        $result = $this->pluginService->publishAssets($plugin);

        if ($result['error']) {
            $this->error($result['message']);
            return 1;
        }

        $this->info($result['message']);

        return 0;
    }

}
