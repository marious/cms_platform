<?php
namespace EG\Base\Helpers;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;

class BaseHelper
{

    /**
     * @param Carbon $timestamp
     * @param string $format
     * @return mixed
     */
    public function formatTime(Carbon $timestamp, string $format = 'j M Y H:i')
    {
        return format_time($timestamp, $format);
    }

    /**
     * @param string $date
     * @param string $format
     * @return string
     */
    public function formatDate(?string $date, string $format = null)
    {
        if (empty($format)) {
            $format = config('core.base.general.date_format.date');
        }

        return date_from_database($date, $format);
    }

    /**
     * Autoload files in directory
     * @param string $directory
     */
    public function autoload(string $directory)
    {
        $helpers = File::glob($directory . '/*.php');
        foreach ($helpers as $helper) {
            File::requireOnce($helper);
        }
    }

    /**
     * Check if the the table is exists on the database
     * @param string $tableName
     * @return bool
     */
    public function isConnectedDatabase($tableName = 'settings'): bool
    {
        try {
            return Schema::hasTable($tableName);
        } catch (Exception $e) {
            return false;
        }
    }


    /**
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public function getAdminPrefix()
    {
        return config('core.base.general.admin_dir');
    }

    /**
     * @return bool
     */
    public static function clearCache(): bool
    {
        Event::dispatch('cache:clearing');

        try {
            Cache::flush();
            if (!File::exists($storagePath = storage_path('framework/cache'))) {
                return true;
            }

            foreach (File::files($storagePath) as $file) {
                if (preg_match('/facade-.*\.php$/', $file)) {
                    File::delete($file);
                }
            }
        } catch (Exception $exception) {
            info($exception->getMessage());
        }

        Event::dispatch('cache:cleared');

        return true;
    }
}
