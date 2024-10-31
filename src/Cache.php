<?php

namespace Retrilhar;

class Cache
{
    static function clear()
    {
        if (!function_exists('is_plugin_active')) {
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }

        // utiliza o plugin LiteSpeed Cache
        if (defined('WPINC') && \is_plugin_active('litespeed-cache/litespeed-cache.php')) {
            \LiteSpeed\Purge::purge_all('integração Retrilhar');
        } 
    }
}
