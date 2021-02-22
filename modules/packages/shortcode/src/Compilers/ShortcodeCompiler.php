<?php

namespace EG\Shortcode\Compilers;

class ShortcodeCompiler
{
    /**
     * Enabled state
     *
     * @var bool
     */
    protected $enabled = false;

    /**
     * Enable strip state
     *
     * @var bool
     */
    protected $strip = false;

    /**
     * @var mixed
     */
    protected $matches;

    /**
     * Registered shortcode
     *
     * @var array
     */
    protected $registered = [];

    /**
     * Enable
     *
     * @return void
     */
    public function enable()
    {
        $this->enabled = true;
    }

    /**
     * Disable
     *
     * @return void
     */
    public function disable()
    {
        $this->enabled = false;
    }

    /**
     * Compile the contents
     *
     * @param string $value
     * @return string
     */
    public function compile($value)
    {
        // Only continue is shortcode have been registered
        if (!$this->enabled || !$this->hasShortcodes()) {
            return $value;
        }
        // Set empty result
        $result = '';
        // Here we will loop through all of the tokens returned by the Zend lexer and
        // parse each one into the corresponding valid PHP. We will then have this
        // template as the correctly rendered PHP that can be rendered natively.
        foreach (token_get_all($value) as $token) {
            $result .= is_array($token) ? $this->parseToken($token) : $token;
        }

        return $result;
    }

    /**
     * @param $key
     * @param $name
     * @param null $description
     * @param callable|string|null $callback
     */
    public function add($key, $name, $description = null, $callback = null)
    {
        $this->registered[$key] = compact('key', 'name', 'description', 'callback');
    }



    /**
     * Check if shortcode have been registered
     *
     * @return bool
     */
    public function hasShortcodes()
    {
        return !empty($this->registered);
    }

    /**
     * Parse the tokens from the template.
     *
     * @param array $token
     * @return string
     */
    protected function parseToken($token)
    {
        [$id, $content] = $token;
        if ($id == T_INLINE_HTML) {
            $content = $this->renderShortcodes($content);
        }

        return $content;
    }

    /**
     * Render shortcode
     *
     * @param string $value
     * @return string
     */
    protected function renderShortcodes($value)
    {
        $pattern = $this->getRegex();

        return preg_replace_callback('/' . $pattern . '/s', [$this, 'render'], $value);
    }

    /**
     * Render the current called shortcode.
     *
     * @param array $matches
     * @return string
     */
    public function render($matches)
    {
        // Compile the shortcode
        $compiled = $this->compileShortcode($matches);
        $name = $compiled->getName();

        // Render the shortcode through the callback
        return call_user_func_array($this->getCallback($name), [
            $compiled,
            $compiled->getContent(),
            $this,
            $name,
        ]);
    }

    /**
     * Get Compiled Attributes.
     *
     * @param $matches
     * @return mixed

     */
    protected function compileShortcode($matches)
    {
        // Set matches
        $this->setMatches($matches);
        // pars the attributes
        $attributes = $this->parseAttributes($this->matches[3]);

        // return shortcode instance
        return new Shortcode(
            $this->getName(),
            $attributes,
            $this->getContent()
        );
    }

    /**
     * Set the matches
     *
     * @param array $matches

     */
    protected function setMatches($matches = [])
    {
        $this->matches = $matches;
    }

    /**
     * Return the shortcode name
     *
     * @return string

     */
    public function getName()
    {
        return $this->matches[2];
    }

    /**
     * Return the shortcode content
     *
     * @return string

     */
    public function getContent()
    {
        // Compile the content, to support nested shortcode
        return $this->compile($this->matches[5]);
    }

    /**
     * Get the callback for the current shortcode (class or callback)
     *
     * @param string $key
     * @return callable|array

     */
    public function getCallback($key)
    {
        // Get the callback from the shortcode array
        $callback = $this->registered[$key]['callback'];
        // if is a string
        if (is_string($callback)) {
            // Parse the callback
            [$class, $method] = Str::parseCallback($callback, 'register');
            // If the class exist
            if (class_exists($class)) {
                // return class and method
                return [
                    app($class),
                    $method,
                ];
            }
        }

        return $callback;
    }

    /**
     * Parse the shortcode attributes
     * @param $text
     * @return array

     */
    protected function parseAttributes($text)
    {
        // decode attribute values
        $text = htmlspecialchars_decode($text, ENT_QUOTES);

        $attributes = [];
        // attributes pattern
        $pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
        // Match
        if (preg_match_all($pattern, preg_replace('/[\x{00a0}\x{200b}]+/u', ' ', $text), $match, PREG_SET_ORDER)) {
            foreach ($match as $item) {
                if (!empty($item[1])) {
                    $attributes[strtolower($item[1])] = stripcslashes($item[2]);
                } elseif (!empty($item[3])) {
                    $attributes[strtolower($item[3])] = stripcslashes($item[4]);
                } elseif (!empty($item[5])) {
                    $attributes[strtolower($item[5])] = stripcslashes($item[6]);
                } elseif (isset($item[7]) && strlen($item[7])) {
                    $attributes[] = stripcslashes($item[7]);
                } elseif (isset($item[8])) {
                    $attributes[] = stripcslashes($item[8]);
                }
            }
        } else {
            $attributes = ltrim($text);
        }

        // return attributes
        return is_array($attributes) ? $attributes : [$attributes];
    }

    /**
     * Get shortcode names
     *
     * @return string

     */
    public function getShortcodeNames()
    {
        return join('|', array_map('preg_quote', array_keys($this->registered)));
    }

    /**
     * Get shortcode regex.
     *
     * @return string

     */
    protected function getRegex()
    {
        $name = $this->getShortcodeNames();

        return '\\[(\\[?)(' . $name . ')(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
    }

    /**
     * Remove all shortcode tags from the given content.
     *
     * @param string $content Content to remove shortcode tags.
     * @return string Content without shortcode tags.

     */
    public function strip($content)
    {
        if (empty($this->registered)) {
            return $content;
        }
        $pattern = $this->getRegex();

        return preg_replace_callback('/' . $pattern . '/s', [$this, 'stripTag'], $content);
    }

    /**
     * @return mixed

     */
    public function getStrip()
    {
        return $this->strip;
    }

    /**
     * @param boolean $strip

     */
    public function setStrip($strip)
    {
        $this->strip = $strip;
    }

    /**
     * Remove shortcode tag
     *
     * @param string $match
     * @return string Content without shortcode tag.

     */
    protected function stripTag($match)
    {
        if ($match[1] == '[' && $match[6] == ']') {
            return substr($match[0], 1, -1);
        }

        return $match[1] . $match[6];
    }

    /**
     * @return array
     */
    public function getRegistered()
    {
        return $this->registered;
    }

    /**
     * @param string $key
     * @param string $html
     */
    public function setAdminConfig(string $key, $html)
    {
        $this->registered[$key]['admin_config'] = $html;
    }

}
