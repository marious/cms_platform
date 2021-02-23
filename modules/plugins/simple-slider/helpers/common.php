<?php
use EG\SimpleSlider\Repositories\Interfaces\SimpleSliderInterface;

if (!function_exists('get_all_simple_sliders')) {
    function get_all_simple_sliders(array $conditions = []) {
        return app(SimpleSliderInterface::class)->allBy($conditions);
    }
}
