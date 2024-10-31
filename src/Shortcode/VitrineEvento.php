<?php

namespace Retrilhar\Shortcode;

class VitrineEvento extends AbstractShortcode
{
    static $key = 'vitrine-evento';

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
        $rsEventos = (new \Retrilhar\Model\Evento())->pesquisar($idTipoAtividade, $dtInicio, $dtFim, $iQuantidade);
        $shortcode = new \Retrilhar\Shortcode();
        $rsTiposAtividade = (new \Retrilhar\Model\Produto())->getAtividades();
        $aTiposAtividade = [];
        foreach ($rsTiposAtividade as $rAtividade) {
            $aTiposAtividade[$rAtividade->id_tipo_atividade] = $rAtividade->st_tipo_atividade;
        }

        $html = '';
        foreach ($rsEventos as $idx => $rEvento) {
            $dtInicio = new \DateTime($rEvento->dt_inicio);

            $aDicionario['idx']  = $idx;
            $aDicionario['nome'] = $rEvento->st_nome;
            $aDicionario['url_imagem_card']  = $rEvento->url_imagem_card;
            $aDicionario['inicio']       = $dtInicio->format('d/m/Y');
            $aDicionario['inicio_semana']  = $shortcode->formatarDiaSemana($dtInicio);
            $aDicionario['inicio_semana_curto'] = $shortcode->formatarDiaSemana($dtInicio, true);
            $aDicionario['data_extenso'] = $shortcode->formatarEventoDatas($rEvento);
            $aDicionario['url_evento']   = $rEvento->st_link;
            $aDicionario['url_reserva']  = $urlSistema . '/pre-reserva?evento=' . $rEvento->st_codigo;
            $aDicionario['atividade_nome'] = $aTiposAtividade[$rEvento->id_tipo_atividade];
            $html .= static::render($aDicionario);
        }

        if (empty($atts['ajax'])) {
            $html = '<div id="retrilhar_div_vitrine_eventos">' . $html . '</div>';
        }
        return $html;
    }

    static function getDicionarioShow()
    {
        return [
            'nome' => 'Nome do produto',
            'url_evento' => 'URL do produto',
            'url_reserva' => 'URL do produto',
            'url_imagem_card' => 'URL da imagem do card',
            'inicio' => 'Data de início (d/m/a)',
            'inicio_semana' => 'Dia da semana data de início',
            'inicio_semana_curto' => 'Dia da semana curto (seg, ter, qua) data de início',
            'data_extenso' => 'Período do evento',
            'atividade_nome' => 'Nome da atividade',
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
