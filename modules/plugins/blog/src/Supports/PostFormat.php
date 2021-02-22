<?php
namespace EG\Blog\Supports;

class PostFormat
{
    protected static $formats = [
      '' => [
        'key'   => '',
        'icon'  => null,
        'name'  => 'Default',
        ],
      'gallery' => [
        'key'  => 'gallery',
        'icon' => 'fa fa-image',
        'name' => 'Gallery',
      ],
    'video'   => [
        'key'  => 'video',
        'icon' => 'fa fa-camera',
        'name' => 'Video',
      ],
    ];

    public static function registerPostFormat(array $formats = [])
    {
        foreach ($formats as $key => $format) {
            self::$formats[$key] = $format;
        }
    }

    public static function getPostFormats($isConvertToList = false)
    {
        if ($isConvertToList) {
            $results = [];
            foreach (self::$formats as $key => $item) {
                $results[$key] = [
                    $key,
                    $item['name'],
                ];
            }
            return $results;
        }


        return self::$formats;
    }
}
