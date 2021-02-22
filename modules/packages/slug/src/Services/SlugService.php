<?php

namespace EG\Slug\Services;

use EG\Slug\Repositories\Interfaces\SlugInterface;
use SlugHelper;
use Str;

class SlugService
{
    /**
     * @var SlugInterface
     */
    protected $slugRepository;

    public function __construct(SlugInterface $slugRepository)
    {
        $this->slugRepository = $slugRepository;
    }

    public function create($name, $slugId = 0, $model = null, $lang = null)
    {
        $slug = $this->slug($name);
        $index = 1;
        $prefix = null;
        $baseSlug = $slug;
        if (!empty($model)) {
            $prefix = SlugHelper::getPrefix($model);
        }

        while ($this->checkIfExistedSlug($slug, $slugId, $prefix, $lang)) {
            $slug = apply_filters(FILTER_SLUG_EXISTED_STRING, $baseSlug . '-' . $index++, $baseSlug, $index, $model);
        }

        if (empty($slug)) {
            $slug = time();
        }

        return apply_filters(FILTER_SLUG_STRING, $slug, $model);
    }

    public function createFromArray($slugData, $slugId = 0, $model = null)
    {
        $slugs = [];
        foreach ($slugData['key'] as $lang => $slug) {
            $slugs[$lang] = $this->create($slug, $slugId, $model, $lang);
        }
        return $slugs;
    }

    /**
     * @param $slug
     * @param $slugId
     * @param $prefix
     * @return bool
     */
    protected function checkIfExistedSlug($slug, $slugId, $prefix, $lang): bool
    {
        $key = $lang ? 'key->' . $lang : 'key';
        return $this->slugRepository
                ->getModel()
                ->where([
                    $key    => $slug,
                    'prefix' => $prefix,
                ])
                ->where('id', '!=', $slugId)
                ->count() > 0;
    }



    function slug($str, $limit = null) {
        if ($limit) {
            $str = mb_substr($str, 0, $limit, "utf-8");
        }
        $text = html_entity_decode($str, ENT_QUOTES, 'UTF-8');
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        // trim
        $text = trim($text, '-');
        return mb_strtolower($text);
    }


    public function makeSlug($string = null, $separator = "-") {
        if (is_null($string)) {
            return "";
        }

        // Remove spaces from the beginning and from the end of the string
        $string = trim($string);

        // Lower case everything
        // using mb_strtolower() function is important for non-Latin UTF-8 string | more info: http://goo.gl/QL2tzK
        $string = mb_strtolower($string, "UTF-8");

        // Make alphanumeric (removes all other characters)
        // this makes the string safe especially when used as a part of a URL
        // this keeps latin characters and arabic charactrs as well
        $string = preg_replace("/[^a-z0-9_\sءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/", "", $string);

        // Remove multiple dashes or whitespaces
        $string = preg_replace("/[\s\-,،]+/", " ", $string);

        // Convert whitespaces and underscore to the given separator
        $string = preg_replace("/[\s_]/", $separator, $string);

        return $string;
    }
}
