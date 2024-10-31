<?php

namespace Retrilhar\Shortcode;

class ProdutoEvento extends AbstractShortcode
{
    static $key = 'produto-evento-datas';

    static function shortcode($atts, $content = null)
    {
        global $post;
        global $wpdb;
        $wpdb->suppress_errors(false);

        $post_slug = $post->post_name;
        $atts = array_change_key_case((array) $atts, CASE_LOWER);

        if (isset($atts['produto_id'])) {
            $idProduto = (int) $atts['produto_id'];
        } else {
            $idProduto = (int) get_post_meta(get_the_ID(), 'retrilhar_id_produto', true);
        }

        $urlSistema = (new \Retrilhar\Config())->getUrl();

        $html = '<div id="retrilhar_div_produto_eventos">';

        $shortcode = new \Retrilhar\Shortcode();
        $aEventos   = (new \Retrilhar\Model\Evento())->getPorProdutoSlug($post_slug, $idProduto);
        foreach ($aEventos as $rEvento) {
            $aDicionario['data'] = (new \DateTime($rEvento->dt_inicio))->format('d/m/Y');
            $aDicionario['data_extenso'] = $shortcode->formatarEventoDatas($rEvento);
            $aDicionario['reserva_url']  = $urlSistema . '/pre-reserva?evento=' . $rEvento->st_codigo;
            $aDicionario['produto_url']  = $rEvento->st_link;
            $html .= static::render($aDicionario);
        }
        return $html . '</div>';
    }

    static function getDicionarioShow()
    {
        return [
            'data' => 'Data do evento (d/m/a)',
            'data_extenso' => 'Período do evento',
            'reserva_url' => 'URL do evento',
            'produto_url' => 'URL do produto',
        ];
    }

    static function getTemplateDefault()
    {
        return '<a class="minha-classe" href="{reserva_url}">{data_extenso}</a><br>';
    }
}
