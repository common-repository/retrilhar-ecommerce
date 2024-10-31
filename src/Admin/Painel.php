<?php

namespace Retrilhar\Admin;

class Painel
{
    static function index()
    {
        $aProdutos  = (new \Retrilhar\Model\Produto())->all();
        $aEventos   = (new \Retrilhar\Model\Evento())->pesquisar();
        $urlSistema = (new \Retrilhar\Config())->getUrl();

        include plugin_dir_path(RETRILHAR_PATH) . 'views/admin/index.php';
    }

    static function save()
    {
        if (!current_user_can('manage_options')) {
            wp_die('You do not have sufficient permissions to access this page.');
        }

        if (!empty($_POST['url'])) {
            $url = sanitize_text_field($_POST['url']);
            (new \Retrilhar\Config())->setUrl($url);
            \Retrilhar\Import::run();
        }

        wp_safe_redirect('admin.php?page=retrilhar');
    }

    static function produtos()
    {
        $aProdutos  = (new \Retrilhar\Model\Produto())->all();
        $aEventos   = (new \Retrilhar\Model\Evento())->pesquisar();
        $urlSistema = (new \Retrilhar\Config())->getUrl();

        include plugin_dir_path(RETRILHAR_PATH) . 'views/admin/produtos.php';
    }
}
