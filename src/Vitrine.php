<?php

namespace Retrilhar;

class Vitrine
{
   static function renderEventos()
   {
        $idAtividade = (int) sanitize_text_field($_POST['atividade']);
        $dtInicio = null;
        if (!empty($_POST['dtInicio'])) {
            $dtInicio = sanitize_text_field($_POST['dtInicio']);
        }
    
        $dtFim = null;
        if (!empty($_POST['dtFim'])) {
            $dtFim = sanitize_text_field($_POST['dtFim']);
        }

        $html = \do_shortcode('[retrilhar_vitrine_eventos atividade=' . $idAtividade . ' inicio="' . $dtInicio . '" fim="' . $dtFim . '" ajax=true]');
        $aReturn = [
            'idAtividade' => $idAtividade,
            'html'        => $html
        ];
        \wp_send_json_success($aReturn);
        \wp_die();
   }

   static function renderProdutos()
   {
        $idAtividade = (int) sanitize_text_field($_POST['atividade']);

        $html = \do_shortcode('[retrilhar_vitrine_produtos atividade=' . $idAtividade .' ajax=true]');
        $aReturn = [
            'idAtividade' => $idAtividade,
            'html'        => $html
        ];
        \wp_send_json_success($aReturn);
        \wp_die();
   }

   static function renderEventosPosts()
   {
        $idAtividade = (int) sanitize_text_field($_POST['atividade']);
        $dtInicio = null;
        if (!empty($_POST['dtInicio'])) {
            $dtInicio = sanitize_text_field($_POST['dtInicio']);
        }
    
        $dtFim = null;
        if (!empty($_POST['dtFim'])) {
            $dtFim = sanitize_text_field($_POST['dtFim']);
        }

        $html = \do_shortcode('[retrilhar_vitrine_eventos_posts atividade=' . $idAtividade . ' inicio="' . $dtInicio . '" fim="' . $dtFim . '" ajax=true]');
        $aReturn = [
            'idAtividade' => $idAtividade,
            'html'        => $html
        ];
        \wp_send_json_success($aReturn);
        \wp_die();
   }
}
