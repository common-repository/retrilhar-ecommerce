<?php

namespace Retrilhar;

class Import
{
    /**
     * Importa os dados de produtos e eventos
     */
    static function run()
    {
        global $wpdb;

        $url = (new \Retrilhar\Config())->getUrl();
        if (!$url) {
            return false;
        }

        $tbProduto = Model\Produto::getTableName();
        $tbEvento  = Model\Evento::getTableName();

        $response = wp_remote_get($url . '/api/produtos');
        $body     = wp_remote_retrieve_body($response);
        if (!$body) {
            return false;
        }
        $aProdutos = json_decode($body, true);

        $aProdutosProcessados = $aEventosProcessados = [];
        foreach ($aProdutos as $aProduto) {
            $aProdutosProcessados[] = $aProduto['id_produto'];

            // produtos
            $aDadosProduto = [
                'id_produto'        => $aProduto['id_produto'],
                'st_id'             => $aProduto['st_id'],
                'st_nome'           => $aProduto['st_nome'],
                'st_slug'           => $aProduto['st_slug'],
                'id_tipo_atividade' => $aProduto['id_tipo_atividade'],
                'st_tipo_atividade' => $aProduto['st_tipo_atividade'],
                'bo_exibir_home'    => $aProduto['bo_exibir_home'],
                'bo_ativo'          => $aProduto['bo_ativo'],
                're_valor'          => $aProduto['re_valor'],
                'st_link'           => $aProduto['st_link'],
                'url_imagem_card'   => $aProduto['url_imagem_card'],
                'url_imagem_banner' => $aProduto['url_imagem_banner'],
                'id_pais'           => $aProduto['id_pais'],
                'st_pais'           => $aProduto['st_pais'],
                'st_regiao'         => $aProduto['st_regiao'],
                'id_estado'         => $aProduto['id_estado'],
                'st_estado'         => $aProduto['st_estado'],
                'id_cidade'         => $aProduto['id_cidade'],
                'st_destino'        => $aProduto['st_destino'],
                'st_texto'          => $aProduto['st_texto'],
                'st_resumo'         => $aProduto['st_resumo'],
                'id_nivel_dificuldade' => $aProduto['id_nivel_dificuldade'],
                'st_nivel_dificuldade' => $aProduto['st_nivel_dificuldade'],
            ];

            $result = $wpdb->get_results('SELECT * FROM ' . $tbProduto . ' WHERE id_produto = ' . $aProduto['id_produto']);

            //$wpdb->suppress_errors(false);
            // produto não importado
            if (!$result) {
                $exec = $wpdb->insert($tbProduto, $aDadosProduto);
                if (false == $exec) {
                    echo '<hr><pre>';
                    var_dump($result);
                    var_dump($exec);
                    print_r($aDadosProduto);
                    var_dump($wpdb->print_error());
                    var_dump($wpdb->last_error);
                }
            } else {
                $wpdb->update($tbProduto, $aDadosProduto, ['id_produto' => $aProduto['id_produto']]);
            }

            // eventos
            foreach ($aProduto['eventos'] as $aEvento) {
                $aEventosProcessados[] = $aEvento['id_evento'];

                // evento
                $aDadosEvento = [
                    'id_evento'  => $aEvento['id_evento'],
                    'st_codigo'  => $aEvento['st_codigo'],
                    'id_produto' => $aProduto['id_produto'],
                    'dt_inicio'  => $aEvento['dt_inicio'],
                    'qt_dias'    => $aEvento['qt_dias'],
                    'st_link'    => $aEvento['st_link'],
                    'bo_ativo'   => $aEvento['bo_ativo'],
                    're_valor'   => $aEvento['re_valor'],
                    're_valor_online'=> $aEvento['re_valor_online'],
                ];

                $result = $wpdb->get_results('SELECT * FROM ' . $tbEvento . ' WHERE id_evento = ' . $aDadosEvento['id_evento']);
                if (!$result) {
                    $exec = $wpdb->insert($tbEvento, $aDadosEvento);
                } else {
                    $wpdb->update($tbEvento, $aDadosEvento, ['id_evento' => $aDadosEvento['id_evento']]);
                }
            }
        }

        // processamento de eventos que não foram informados
        $rsEventos = $wpdb->get_results('SELECT * FROM ' . $tbEvento);
        foreach ($rsEventos as $rEvento) {
            if (!in_array($rEvento->id_evento, $aEventosProcessados)) {
                $wpdb->delete($tbEvento, ['id_evento' => $rEvento->id_evento]);
            }
        }

        \Retrilhar\Cache::clear();
        return true;
    }
}
