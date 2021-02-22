<?php
namespace EG\Page\Supports;

use Theme;

class Template
{

    public static function registerPageTemplate($templates = [])
    {
        $validTemplates = [];
        foreach ($templates as $key => $template) {
            if (in_array($key, self::getExistsTemplate())) {
                $validTemplates[$key] = $template;
            }
        }

        config([
            'packages.page.general.templates' => array_merge(config('packages.page.general.templates'),
                $validTemplates),
        ]);
    }

    protected static function getExistsTemplate()
    {
        $files = scan_folder(theme_path(Theme::getThemeName() .
                DIRECTORY_SEPARATOR . config('packages.theme.general.containerDir.layout')));

        foreach ($files as $key => $file) {
            $files[$key] = str_replace('.blade.php','', $file);
        }
        return $files;
    }

    public static function getPageTemplates()
    {
        return config('packages.page.general.templates', []);
    }
}
