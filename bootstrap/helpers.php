<?php

use Illuminate\Support\HtmlString;

if (!function_exists('ift_generate_html_class')) {
    function ift_generate_html_class($expression) {
        $classes = [];

        if (is_array($expression)) {
            foreach ($expression as $key => $value) {
                if ($value === FALSE) {
                    continue;
                }
                $classes[] = $key;
            }
        } else {
            $classes[] = (string)$expression;
        }
        return new HtmlString(implode(' ', $classes));
    }
}