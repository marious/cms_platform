<?php

namespace EG\Media\Providers;

use EG\Base\Supports\Helper;
use EG\Base\Traits\LoadAndPublishTrait;
use EG\Media\Chunks\Storage\ChunkStorage;
use EG\Media\Commands\ClearChunksCommand;
use EG\Media\Commands\DeleteThumbnailCommand;
use EG\Media\Commands\GenerateThumbnailCommand;
use EG\Media\Facades\RvMediaFacade;
use EG\Media\Models\MediaFile;
use EG\Media\Models\MediaFolder;
use EG\Media\Models\MediaSetting;
use EG\Media\Repositories\Caches\MediaFileCacheDecorator;
use EG\Media\Repositories\Caches\MediaFolderCacheDecorator;
use EG\Media\Repositories\Caches\MediaSettingCacheDecorator;
use EG\Media\Repositories\Eloquent\MediaFileRepository;
use EG\Media\Repositories\Eloquent\MediaFolderRepository;
use EG\Media\Repositories\Eloquent\MediaSettingRepository;
use EG\Media\Repositories\Interfaces\MediaFileInterface;
use EG\Media\Repositories\Interfaces\MediaFolderInterface;
use EG\Media\Repositories\Interfaces\MediaSettingInterface;
use EG\Setting\Supports\SettingStore;
use Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;


class MediaServiceProvider extends ServiceProvider
{
    use LoadAndPublishTrait;

    public function register()
    {
        Helper::autoload(__DIR__ . '/../../helpers');

        $this->app->bind(MediaFileInterface::class, function () {
            return new MediaFileCacheDecorator(
                new MediaFileRepository(new MediaFile),
                MEDIA_GROUP_CACHE_KEY
            );
        });

        $this->app->bind(MediaFolderInterface::class, function () {
            return new MediaFolderCacheDecorator(
                new MediaFolderRepository(new MediaFolder),
                MEDIA_GROUP_CACHE_KEY
            );
        });

        $this->app->bind(MediaSettingInterface::class, function () {
            return new MediaSettingCacheDecorator(
                new MediaSettingRepository(new MediaSetting)
            );
        });

        AliasLoader::getInstance()->alias('RvMedia', RvMediaFacade::class);
    }

    public function boot()
    {
        $this->setNamespace('core/media')
            ->loadAndPublishConfigurations(['permissions', 'media'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes()
            ->publishAssets();

        $config = $this->app->make('config');
        $setting = $this->app->make(SettingStore::class);
        // dd($setting);

        $config->set([
            'core.media.media.chunk.enabled'       => (bool)$setting->get('media_chunk_enabled',
                $config->get('core.media.media.chunk.enabled')),
            'core.media.media.chunk.chunk_size'    => (int)$setting->get('media_chunk_size',
                $config->get('core.media.media.chunk.chunk_size')),
            'core.media.media.chunk.max_file_size' => (int)$setting->get('media_max_file_size',
                $config->get('core.media.media.chunk.max_file_size')),
        ]);

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-core-media',
                'priority'    => 995,
                'parent_id'   => null,
                'name'        => 'core/media::media.menu_name',
                'icon'        => 'far fa-images',
                'url'         => route('media.index'),
                'permissions' => ['media.index'],
            ]);
        });

        $this->commands([
            GenerateThumbnailCommand::class,
            DeleteThumbnailCommand::class,
            ClearChunksCommand::class,
        ]);

        $this->app->booted(function () {
            if (config('core.media.media.chunk.clear.schedule.enabled')) {
                $schedule = $this->app->make(Schedule::class);

                $schedule->command('cms:media:chunks:clear')
                    ->cron(config('core.media.media.chunk.clear.schedule.cron'));
            }
        });

        $this->app->singleton(ChunkStorage::class, function () {
            return new ChunkStorage;
        });
    }
}
