<?php

namespace EG\Shortcode\Compilers;

class Shortcode
{
    /**
     * Shortcode name
     *
     * @var string
     */
    protected $name;

    /**
     * Shortcode attributes
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Shortcode content
     *
     * @var string
     */
    protected $content;

    public function __construct($name, $attributes = [], $content = null)
    {
        $this->name = $name;
        $this->attributes = $attributes;
        $this->content = $content;
    }

    /**
     * Get html attribute
     *
     * @param string $attribute
     * @param $fallback
     * @return string|null
     */
    public function get($attribute, $fallback = null)
    {
        $value = $this->{$attribute};
        if (!empty($value)) {
            return $attribute . '="' . $value . '"';
        } elseif (!empty($fall)) {
            return $attribute . '="' . $fallback . '"';
        }
        return '';
    }

    /**
     * Get shortcode name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get shortcode content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get shortcode attributes
     *
     * @return array
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * Dynamically get attributes
     *
     * @param $param
     * @return mixed|null
     */
    public function __get($param)
    {
        return isset($this->attributes[$param]) ? $this->attributes[$param] : null;
    }
}
