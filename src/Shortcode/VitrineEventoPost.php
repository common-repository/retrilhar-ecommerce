<?php

namespace Retrilhar\Shortcode;

class VitrineEventoPost extends AbstractShortcode
{
    static $key = 'vitrine-evento-post';

    static function shortcode($atts, $content = null)
    {
        global $wpdb;
        $wpdb->suppress_errors(false);
        $atts = array_change_key_case((array) $atts, CASE_LOWER);

        $idTipoAtividade = null;
        if (isset($atts['atividade'])) {
            $idTipoAtividade = $atts['atividade'];
        }
        $dtInicio= null;
        if (isset($atts['inicio'])) {
            $dtInicio = $atts['inicio'];
        }
        $dtFim = null;
        if (isset($atts['fim'])) {
            $dtFim = $atts['fim'];
        }

        $iQuantidade = null;
        if (isset($atts['quantidade'])) {
            $iQuantidade = $atts['quantidade'];
        }

        $urlSistema = (new \Retrilhar\Config())->getUrl();
        $rsEventos = (new \Retrilhar\Model\Evento())->getPosts($idTipoAtividade, $dtInicio, $dtFim, $iQuantidade);
        $shortcode = new \Retrilhar\Shortcode();

        $html = '';
        foreach ($rsEventos as $idx => $rEvento) {
            $dtInicio = new \DateTime($rEvento->dt_inicio);
            $aDicionario['idx']  = $idx;
            $aDicionario['nome'] = $rEvento->st_nome;
            $aDicionario['qt_dias'] = $rEvento->qt_dias;
            $aDicionario['re_valor'] = number_format($rEvento->evento_re_valor, 2, ',', '.');
            $aDicionario['re_valor_online'] = number_format($rEvento->evento_re_valor_online, 2, ',', '.');
            $aDicionario['url_imagem_card']  = $rEvento->url_imagem_card;
            $aDicionario['inicio']       = $dtInicio->format('d/m/Y');
            $aDicionario['data_extenso'] = $shortcode->formatarEventoDatas($rEvento);
            $aDicionario['inicio_semana'] = $shortcode->formatarDiaSemana($dtInicio);
            $aDicionario['inicio_semana_curto'] = $shortcode->formatarDiaSemana($dtInicio, true);
            $aDicionario['url_evento']   = $rEvento->st_link;
            $aDicionario['st_texto']     = $shortcode->formataTextoProduto($rEvento->st_texto);
            $aDicionario['url_reserva']  = $urlSistema . '/pre-reserva?evento=' . $rEvento->st_codigo;
            $aDicionario['url_post']   = get_post_permalink($rEvento->ID);
            $aDicionario['st_nivel_dificuldade'] = $rEvento->st_nivel_dificuldade;
            $html .= static::render($aDicionario);
        }

        if (empty($atts['ajax'])) {
            $html = '<div id="retrilhar_div_vitrine_eventos_posts">' . $html . '</div>';
        }
        return $html;
    }

    static function getDicionarioShow()
    {
        return [
            'nome' => 'Nome do produto',
            'url_post' => 'URL do post(WP)',
            'url_evento' => 'URL do produto',
            'url_reserva' => 'URL do produto',
            'url_imagem_card' => 'URL da imagem do card',
            'inicio' => 'Data de início (d/m/a)',
            'inicio_semana' => 'Dia da semana data de início',
            'inicio_semana_curto' => 'Dia da semana curto (seg, ter, qua) data de início',
            'data_extenso' => 'Período do evento',
        ];
    }

    static function getTemplateDefault()
    {
        return '<article class="elementor-post elementor-grid-item post-180 post type-post status-publish format-standard has-post-thumbnail hentry">
                    <div class="elementor-post__card">
                        <a class="elementor-post__thumbnail__link" href="{url_post}">
                            <div class="elementor-post__thumbnail retrilhar-img">
                                <img src="{url_imagem_card}" class="attachment-full size-full img-fluid" alt="{nome}">
                            </div>
                        </a>
                        <div class="elementor-post__text">
                            <h3 class="elementor-post__title">
                                <a href="{url_post}">{nome}</a>
                            </h3>
                            <a class="elementor-post__read-more" href="{url_post}">+ informações</a>
                        </div>
                    </div>
                </article>';
    }
}
