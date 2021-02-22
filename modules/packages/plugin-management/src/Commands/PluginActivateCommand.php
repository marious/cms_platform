<?php
namespace EG\PluginManagement\Commands;

use Illuminate\Console\Command;
use EG\PluginManagement\Services\PluginService;

class PluginActivateCommand extends Command
{
    protected $signature = 'cms:plugin:activate {name: The plugin that you want to activate}';

    protected $description = 'Activate a plugin in /plugins directory';

    protected $pluginService;

     /**
     * PluginActivateCommand constructor.
     * @param PluginService $pluginService
     */
    public function __construct(PluginService $pluginService)
    {
        parent::__construct();

        $this->pluginService = $pluginService;
    }


    /**
     * @return boolean
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        if (!preg_match('/^[a-z0-9\-]+$/i', $this->argument('name'))) {
            $this->error('Only alphabetic characters are allowed.');
            return 1;
        }

        $plugin = strtolower($this->argument('name'));

        $result = $this->pluginService->activate($plugin);

        if ($result['error']) {
            $this->error($result['message']);
            return 1;
        }

        $this->info($result['message']);

        return 0;
    }
}
