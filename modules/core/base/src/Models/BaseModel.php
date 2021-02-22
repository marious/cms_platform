<?php
namespace EG\Base\Models;

use Language;
use Eloquent;
use Illuminate\Support\Str;
use MacroableModels;

class BaseModel extends Eloquent
{
    /**
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        if (class_exists('MacroableModels')) {
            $method = 'get' . Str::studly($key) . 'Attribute';
            if (MacroableModels::modelHasMacro(get_class($this), $method)) {
                return call_user_func([$this, $method]);
            }
        }

        return parent::__get($key);
    }

    public function fillMultiLang($data)
    {
        $this->fill($data);
        $multiLangField = Language::handleMultiLangFields($data);
        if ($multiLangField && count($multiLangField)) {
            if (method_exists($this, 'setTranslation')) {
                foreach ($multiLangField as $lang => $fields) {
                    // check if item has method
                    foreach ($fields as $key => $field) {
                        if(in_array($key, $this->translatable)) {
                            $this->setTranslation($key, $lang, $field);
                        }
                    }

                }
            }
        }

        return $this;
    }
}
