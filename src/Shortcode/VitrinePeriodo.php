<?php

namespace Retrilhar\Shortcode;

class VitrinePeriodo extends AbstractShortcode
{
    static $key = 'filtro_periodo';

    static function shortcode($atts, $content = null)
    {
        $oData = new \DateTime();
        $aDicionario['dtInicio'] = $oData->format('Y-m-d');
        $oData->add(new \DateInterval('P6M'));
        $aDicionario['dtFim']    = $oData->format('Y-m-d');
        return static::render($aDicionario);
    }

    static function getDicionarioShow()
    {
        return [];
    }

    static function getTemplateDefault()
    {
        return '<input type="date" id="retrilhar_dt_inicio" name="retrilhar_dt_inicio" value="{dtInicio}" class="retrilhar_vitrine_filtro">
        a <input type="date" id="retrilhar_dt_fim" name="retrilhar_dt_fim" value="{dtFim}" class="retrilhar_vitrine_filtro">';
    }
}
