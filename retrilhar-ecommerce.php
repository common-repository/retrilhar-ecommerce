<?php

/**
 * Plugin Name: Retrilhar Ecommerce
 * Plugin URI: https://wordpress.org/plugins/retrilhar-ecommerce
 * Description: Integração com o Retrilhar Ecommerce
 * Version: 0.2.14
 * Author: Retrilhar
 * Author URI: https://retrilhar.com.br
 * License: GPL2
 */
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
if (!function_exists('add_action')) {
    echo 'Essa funcionalidade não pode ser executada fora do plugin do WP.';
    exit;
}
if (!function_exists('dd')) {
    function dd($var)
    {
        echo '<pre>';
        var_dump($var);
        die;
    }
}
define('RETRILHAR_PATH', __FILE__);

require_once(plugin_dir_path(__FILE__) . 'src/Autoload.php');
require_once(plugin_dir_path(__FILE__) . 'src/Plugin.php');
(new \Retrilhar\Plugin())->init();
