<?php

namespace Retrilhar\Shortcode;

class Calendario extends AbstractShortcode
{
    static $key = 'calendario';

    static function shortcode($atts, $content = null)
    {
        global $wpdb;
        global $wp;

        $wpdb->suppress_errors(false);
        $atts = array_change_key_case((array) $atts, CASE_LOWER);

        $ano = date('Y');
        if (isset($_GET['ano'])) {
            $ano = (int) $_GET['ano'];
        }
        $mes = date('m');;
        if (isset($_GET['mes'])) {
            $mes = (int) $_GET['mes'];
        }

        $dtReferencia = new \DateTime($ano . '-' . $mes . '-01'); 

        $urlSistema = (new \Retrilhar\Config())->getUrl();
        $rsEventos  = (new \Retrilhar\Model\Evento())->getPosts(null, $dtReferencia->format('Y-m-d'), $dtReferencia->format('Y-m-t'));
        $shortcode  = new \Retrilhar\Shortcode();
        $template = static::getTemplate();
        
        $templateCalendario = static::getTemplateChild('calendario', $template, []);

        // agenda
        $html = static::getHtmlAgenda($templateCalendario, \home_url($wp->request), $dtReferencia);

        // lista de eventos
        $templateLista = static::getTemplateChild('evento-lista', $template, []);
        $html .= static::getHtmlEventos($rsEventos, $templateLista, $shortcode, $urlSistema);
        return $html;
    }

    static function getHtmlAgenda($templateCalendario, $urlWp, \DateTime $dtReferencia)
    {
        $aMeses = static::getMeses();
        $anoMesSelecionado = (int) $dtReferencia->format('Ym');
        $templateMes = static::getTemplateChild('mes', $templateCalendario, []);
        $html = '';
        foreach ($aMeses as $aMes) {
            $aMes['classAtivo'] = '';
            if ($anoMesSelecionado == (int) ($aMes['ano'] . str_pad($aMes['mes'], 2, '0', STR_PAD_LEFT))) {
                $aMes['classAtivo'] = 'ano-mes-selecionado';
            }
            $aMes['url_agenda'] = $urlWp . '?ano=' . $aMes['ano'] . '&mes=' . $aMes['mes'];
            $html .= static::render($aMes, $templateMes);
        }
        return str_replace('<mes>' . $templateMes . '</mes>', $html, $templateCalendario);
    }

    static function getHtmlEventos($rsEventos, $templateLista, $shortcode, $urlSistema)
    {
        $html = '';
        $templateEvento = static::getTemplateChild('evento', $templateLista, []);
        foreach ($rsEventos as $idx => $rEvento) {
            $aDicionario['idx']  = $idx;
            $aDicionario['nome'] = $rEvento->st_nome;
            $aDicionario['qt_dias'] = $rEvento->qt_dias;
            $aDicionario['re_valor'] = number_format($rEvento->evento_re_valor, 2, ',', '.');
            $aDicionario['re_valor_online'] = number_format($rEvento->evento_re_valor_online, 2, ',', '.');
            $aDicionario['url_imagem_card'] = $rEvento->url_imagem_card;
            $aDicionario['inicio']       = (new \DateTime($rEvento->dt_inicio))->format('d/m/Y');
            $aDicionario['data_extenso'] = $shortcode->formatarEventoDatas($rEvento);
            $aDicionario['url_evento']   = $rEvento->st_link;
            $aDicionario['st_texto']     = $shortcode->formataTextoProduto($rEvento->st_texto);
            $aDicionario['url_reserva']  = $urlSistema . '/pre-reserva?evento=' . $rEvento->st_codigo;
            $aDicionario['url_post']     = get_post_permalink($rEvento->ID);
            $aDicionario['st_nivel_dificuldade'] = $rEvento->st_nivel_dificuldade;
            $html .= static::render($aDicionario, $templateEvento);
        }
        return str_replace('<evento>' . $templateEvento . '</evento>', $html, $templateLista);
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
            'data_extenso' => 'Período do evento',
        ];
    }

    static function getTemplateDefault()
    {
        return '
                <calendario>
                    <div class="agenda">
                        <ul>
                            <mes><li class="mes {classAtivo}"><a href="{url_agenda}">{mes_nome}<br><strong>{ano}</strong></a></li></mes>
                        </ul>
                    </div>
                </calendario>

                <evento-lista>
                    <h3>Lista de eventos</h3>
                    <evento>
                        <article class="elementor-post elementor-grid-item post-180 post type-post status-publish format-standard has-post-thumbnail hentry">
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
                                    R$ {re_valor}
                                    <p>{st_texto}</p>
                                    <br />
                                    Nível: {st_nivel_dificuldade} <br />
                                    <a class="elementor-post__read-more" href="{url_post}">+ informações</a>
                                </div>
                            </div>
                        </article>
                    </evento>
                </evento-lista>';
    }


    /**
     * Formata dados para os próximos 12 meses
     * @return array
     */
    static function getMeses()
    {
        $aMeses = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro'
        ];

        $dtEvento = new \DateTime(date('Y-m-01'));
        $aReturn = [];
        for ($i=1; $i <= 12; $i++) {
            $iMes = (int) $dtEvento->format('m');
            
            $aReturn[] = [
                'mes' => $iMes,
                'mes_nome' => $aMeses[$iMes],
                'ano' => (int) $dtEvento->format('Y'),
            ];
            $dtEvento->add(new \DateInterval('P1M'));
        }
        return $aReturn;
    }
}
