<?php

namespace Retrilhar\Shortcode;

class VitrineProduto extends AbstractShortcode
{
    static $key = 'vitrine-produto';

    static function shortcode($atts, $content = null)
    {
        global $wpdb;
        $wpdb->suppress_errors(false);
        $atts = array_change_key_case((array) $atts, CASE_LOWER);

        $aFiltro = ['bo_exibir_home' => true];
        if (isset($atts['atividade'])) {
            $aFiltro['atividade'] = (int) $atts['atividade'];
        }

        if (isset($atts['pais'])) {
            $aFiltro['pais'] = $atts['pais'];
        }

        if (isset($atts['regiao'])) {
            $aFiltro['regiao'] = $atts['regiao'];
        }

        if (isset($atts['estado'])) {
            $aFiltro['estado'] = $atts['estado'];
        }

        $bPosts = isset($atts['posts']) ? filter_var($atts['posts'], FILTER_VALIDATE_BOOLEAN) : false;

        $urlSistema = (new \Retrilhar\Config())->getUrl();
        $rsProdutos = (new \Retrilhar\Model\Produto())->all($aFiltro, $bPosts);

        $html = '';
        foreach ($rsProdutos as $idx => $rProduto) {
            $aDicionario['idx']  = $idx;
            $aDicionario['nome'] = $rProduto->st_nome;
            $aDicionario['st_texto'] = $rProduto->st_texto;
            $aDicionario['url']  = $rProduto->st_link;
            $aDicionario['url_imagem_card']  = $rProduto->url_imagem_card;
            $aDicionario['valor'] = \Retrilhar\Utils::formatMoney($rProduto->re_valor);
            $aDicionario['url_post'] = empty($rProduto->ID) ? '' : get_post_permalink($rProduto->ID);
            $html .= static::render($aDicionario);
        }

        if (empty($atts['ajax'])) {
            $html = '<div id="retrilhar_div_vitrine_produtos">' . $html . '</div>';
        }
        return $html;
    }

    static function getDicionarioShow()
    {
        return [
            'nome' => 'Nome do produto',
            'url' => 'URL do produto no ecommerce',
            'valor' => 'Valor do produto',
            'st_texto' => 'Texto de resumo',
            'url_post' => 'URL do post/page do site'
        ];
    }

    static function getTemplateDefault()
    {
        return '<article class="elementor-post elementor-grid-item post-180 post type-post status-publish format-standard has-post-thumbnail hentry">
                    <div class="elementor-post__card">
                        <a class="elementor-post__thumbnail__link" href="{url}">
                            <div class="elementor-post__thumbnail retrilhar-img">
                                <img src="{url_imagem_card}" class="attachment-full size-full img-fluid" alt="{nome}">
                            </div>
                        </a>
                        <div class="elementor-post__text">
                            <h3 class="elementor-post__title">
                                <a href="{url}">{nome}</a>
                            </h3>
                            <a class="elementor-post__read-more" href="{url}">+ informações</a>
                        </div>
                    </div>
                </article>';
    }
}
