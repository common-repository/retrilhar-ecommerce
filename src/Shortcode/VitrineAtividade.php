<?php

namespace Retrilhar\Shortcode;

class VitrineAtividade extends AbstractShortcode
{
    static $key = 'filtro_atividades';

    static function shortcode($atts, $content = null)
    {
        global $wpdb;
        $wpdb->suppress_errors(false);
        $defaults = [
            'id'      => 'retrilhar_id_tipo_atividade',
            'name'    => 'retrilhar_id_tipo_atividade',
            'default' => 'Todas as categorias',
        ];
        $config = shortcode_atts($defaults, $atts);
        $aAtividades = (new \Retrilhar\Model\Produto())->getAtividades();
    
        $html = '<select id="' . esc_html($config['id']) . '" name="' . esc_html($config['name']) . '" class="retrilhar_vitrine_filtro">';
        if ($config['default']) {
            $html .= '<option value="">' . esc_html($config['default']) . '</option>';
        }
    
        foreach ($aAtividades as $rAtividade) {
            $html .= '<option value="' . esc_html($rAtividade->id_tipo_atividade) . '">' . esc_html($rAtividade->st_tipo_atividade) . '</option>';
        }
        $html .= '</select>';
        return $html;
    }

    static function getDicionarioShow()
    {
        return [];
    }

    static function getTemplateDefault()
    {
        return '';
    }
}
