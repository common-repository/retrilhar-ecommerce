<?php

namespace Retrilhar\Shortcode;

class ProdutoValor extends AbstractShortcode
{
    static $key = 'produto-valor';

    static function shortcode($atts, $content = null)
    {
        global $post;

        $post_slug = $post->post_name;
        $atts = array_change_key_case((array) $atts, CASE_LOWER);

        if (isset($atts['produto_id'])) {
            $idProduto = (int) $atts['produto_id'];
        } else {
            $idProduto = (int) get_post_meta(get_the_ID(), 'retrilhar_id_produto', true);
        }

        $reValor = '-';
        $rProduto = (new \Retrilhar\Model\Produto())->find($idProduto);
        if ($rProduto) {
            $reValor = number_format($rProduto->re_valor, 2, ',', '.');
        }
        $aDicionario['valor'] = $reValor;
        return static::render($aDicionario);
    }

    static function getDicionarioShow()
    {
        return [];
    }

    static function getTemplateDefault()
    {
        return '{valor}';
    }
}
