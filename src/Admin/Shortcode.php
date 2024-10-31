<?php

namespace Retrilhar\Admin;

class Shortcode
{
    static function index()
    {
        $shortCode = null;
        if (!empty($_GET['slug'])) {
            $shortCode = sanitize_text_field($_GET['slug']);
        }
        if (!$shortCode) {
            return wp_safe_redirect('admin.php?page=retrilhar');
        }

        $class = \Retrilhar\Shortcode::getClasse($shortCode);
        if (!$class) {
            return wp_safe_redirect('admin.php?page=retrilhar');
        }

        $aDicionario = $class::getDicionarioShow();
        $template = $class::getTemplate();
        include plugin_dir_path(RETRILHAR_PATH) . 'views/admin/shortcode-form.php';
    }

    static function save()
    {
        if (!current_user_can('manage_options')) {
            wp_die('You do not have sufficient permissions to access this page.');
        }

        $shortCode = sanitize_text_field($_POST['shortcode']);

        $class = \Retrilhar\Shortcode::getClasse($shortCode);
        if (!$class) {
            return wp_safe_redirect('admin.php?page=retrilhar');
        }

        if (!empty($_POST['conteudo'])) {
            $class::setTemplate($_POST['conteudo']);
        }
        wp_safe_redirect('admin.php?page=retrilhar');
    }
}
