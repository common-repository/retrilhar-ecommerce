<?php

namespace Retrilhar;

class Plugin
{
    const VERSION = '0.2.11';

    public function init()
    {
        (new \Retrilhar\Autoload())->init();
        (new \Retrilhar\Shortcode())->init();
        $this->preparePublic();
        $this->prepareAdmin();
    }

    static public function prepareAdmin()
    {
        \register_activation_hook(RETRILHAR_PATH, ['Retrilhar\Install', 'run']);
        \register_deactivation_hook(RETRILHAR_PATH, ['Retrilhar\Install', 'uninstall']);

        \add_action('admin_menu', ['Retrilhar\Plugin', 'menu']);
        \add_action('admin_enqueue_scripts', ['Retrilhar\Plugin', 'adminEnqueue']);
        \add_action('admin_post_retrlhar_config', ['Retrilhar\Admin\Painel', 'save']);
        \add_action('admin_post_retrlhar_config_shortcode', ['Retrilhar\Admin\Shortcode', 'save']);
        \add_action('wp_ajax_retrilhar_vitrine_eventos', ['Retrilhar\Vitrine', 'renderEventos']);
        \add_action('wp_ajax_retrilhar_vitrine_eventos_posts', ['Retrilhar\Vitrine', 'renderEventosPosts']);
        \add_action('wp_ajax_retrilhar_vitrine_produtos', ['Retrilhar\Vitrine', 'renderProdutos']);
        \add_action('wp_ajax_retrilhar_quick_produtos', ['Retrilhar\Plugin', 'getQuickJson']);

        \add_action('rest_api_init', function () {
            // [GET] host/index.php/wp-json/retrilhar/produto
            // [GET] host/index.php?rest_route=/retrilhar/produto
            \register_rest_route('retrilhar', 'produto', ['methods' => 'GET', 'callback' => ['Retrilhar\Import', 'run']]);
        });

        // posts / pages - https://wp-kama.ru/hook/quick_edit_custom_box
        \add_action('quick_edit_custom_box', ['Retrilhar\Admin\Post', 'quickEditProduto'], 10, 2);
        \add_action('save_post', ['Retrilhar\Admin\Post', 'quickEditSave'], 10, 2); //manage_book_posts_custom_column
        \add_filter('manage_post_posts_columns', ['Retrilhar\Admin\Post', 'wpListPostProduto']);
        \add_action('manage_post_posts_custom_column', ['Retrilhar\Admin\Post', 'wpListPostProdutoColumn']);
        \add_filter('manage_page_posts_columns', ['Retrilhar\Admin\Post', 'wpListPostProduto']);
        \add_action('manage_page_posts_custom_column', ['Retrilhar\Admin\Post', 'wpListPostProdutoColumn']);
        if (!empty($_GET['post_type'])) {
            \add_filter("manage_{$_GET['post_type']}_posts_columns", ['Retrilhar\Admin\Post', 'wpListPostProduto']);
            \do_action("manage_{$_GET['post_type']}_posts_custom_column", ['Retrilhar\Admin\Post', 'wpListPostProdutoColumn']);
        }
/*
        \add_action('wp_ajax_retrilhar_vitrine_eventos', ['Retrilhar\Vitrine', 'renderEventos']);
        \add_action('wp_ajax_retrilhar_vitrine_eventos_posts', ['Retrilhar\Vitrine', 'renderEventosPosts']);
        \add_action('wp_ajax_retrilhar_vitrine_produtos', ['Retrilhar\Vitrine', 'renderProdutos']);
*/
    }

    private function preparePublic()
    {
        \add_action('wp_enqueue_scripts', ['Retrilhar\Plugin', 'enqueue']);
/*
        \add_action('wp_ajax_nopriv_retrilhar_vitrine_eventos', ['Retrilhar\Vitrine', 'renderEventos']);
        \add_action('wp_ajax_nopriv_retrilhar_vitrine_eventos_posts', ['Retrilhar\Vitrine', 'renderEventosPosts']);
        \add_action('wp_ajax_nopriv_retrilhar_vitrine_produtos', ['Retrilhar\Vitrine', 'renderProdutos']);
*/
    }

    static public function menu()
    {
        \add_menu_page('Retrilhar', 'Retrilhar', 'administrator', 'retrilhar', ['\Retrilhar\Admin\Painel', 'index'], 'dashicons-admin-generic');
        //\add_submenu_page('retrilhar', 'Configuração', 'Configuração', 'administrator', 'retrilhar_configuracao', [&$retrilharConfiguracao, 'render']);
        \add_submenu_page('retrilhar', 'Produtos', 'Produtos', 'administrator', 'retrilhar_produtos', ['\Retrilhar\Admin\Painel', 'produtos']);
        
        \add_plugins_page(
                'Retrilhar shorcode',
                'Retrilhar',
                'read',
                'retrilhar-page-shortcode',
                ['\Retrilhar\Admin\Shortcode', 'index']
        );
    }

    static function adminEnqueue($hook)
    {
        \wp_enqueue_script('retrilhar_admin_script', \plugins_url('assets/js/admin.js', RETRILHAR_PATH), ['jquery'], Plugin::VERSION, true);
        \wp_localize_script('retrilhar_admin_script', 'Retrilhar', ['ajaxUrl' => admin_url('admin-ajax.php'), 'we_value' => Plugin::VERSION]);
    }

    static function enqueue()
    {
        \wp_enqueue_script('retrilhar-script', \plugins_url('assets/js/retrilhar.js', RETRILHAR_PATH), ['jquery'], Plugin::VERSION, true);
        \wp_localize_script('retrilhar-script', 'Retrilhar', ['ajaxUrl' => admin_url('admin-ajax.php'), 'we_value' => Plugin::VERSION]);
    }

    /**
     * Carrega o produto do post/page do quickeditor
     *
     * @return void
     */
    public function getQuickJson()
    {
        $idPost = (int) sanitize_text_field($_POST['post_id']);
        $idProduto = (int) get_post_meta($idPost, 'retrilhar_id_produto', true);
        $aReturn = [
            'idProduto' => $idProduto,
        ];
        \wp_send_json_success($aReturn);
        \wp_die();
    }
}
