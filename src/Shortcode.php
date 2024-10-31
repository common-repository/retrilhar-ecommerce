<?php

namespace Retrilhar;

class Shortcode
{
    public function init()
    {
        // vitrine
        add_shortcode('retrilhar_filtro_atividade', ['\Retrilhar\Shortcode\VitrineAtividade', 'shortcode']);
        add_shortcode('retrilhar_filtro_periodo', ['\Retrilhar\Shortcode\VitrinePeriodo', 'shortcode']);
        add_shortcode('retrilhar_vitrine_eventos', ['\Retrilhar\Shortcode\VitrineEvento', 'shortcode']);
        add_shortcode('retrilhar_vitrine_eventos_posts', ['\Retrilhar\Shortcode\VitrineEventoPost', 'shortcode']);
        add_shortcode('retrilhar_vitrine_produtos', ['\Retrilhar\Shortcode\VitrineProduto', 'shortcode']);
        add_shortcode('retrilhar_calendario', ['\Retrilhar\Shortcode\Calendario', 'shortcode']);
        
        // produto
        add_shortcode('retrilhar_produto_valor', ['\Retrilhar\Shortcode\ProdutoValor', 'shortcode']);
        add_shortcode('retrilhar_produto_eventos', ['\Retrilhar\Shortcode\ProdutoEvento', 'shortcode']);
    }

    static function getClasse($shortCode)
    {
        switch ($shortCode) {
            case 'produto-eventos' :
                return '\Retrilhar\Shortcode\ProdutoEvento';
                break;
            case 'vitrine-eventos' :
                return '\Retrilhar\Shortcode\VitrineEvento';
                break;
            case 'vitrine-eventos-posts' :
                return '\Retrilhar\Shortcode\VitrineEventoPost';
                break;
            case 'vitrine-produtos' :
                return '\Retrilhar\Shortcode\VitrineProduto';
                break;
            case 'calendario' :
                return '\Retrilhar\Shortcode\Calendario';
                break;
        }
    }

    /**
     * Formata data de início e fim do evento
     * @var mixed $rEvento
     * @return string
     */
    public function formatarEventoDatas($rEvento)
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

        $qtDias = $rEvento->qt_dias;
        $dtEvento = new \DateTime($rEvento->dt_inicio);
        $iMesInicio = (int) $dtEvento->format('m');

        if (2 > $qtDias) {
            return (int) $dtEvento->format('d') . ' de ' . $aMeses[$iMesInicio];
        }

        $dtFim = clone $dtEvento;
        $dtFim->add(new \DateInterval('P' . ($qtDias -1) . 'D'));

        $iMesFim = (int) $dtFim->format('m');

        if ($iMesInicio == $iMesFim) {
            return 'De ' . (int) $dtEvento->format('d') . ' a ' . (int) $dtFim->format('d') . ' de ' . $aMeses[$iMesInicio];
        }

        return 'De ' . (int) $dtEvento->format('d') . ' de ' . $aMeses[$iMesInicio] . ' a ' . (int) $dtFim->format('d') . ' de ' . $aMeses[$iMesFim];
    }

    public function formataTextoProduto($sTexto)
    {
        $sReturn = strip_tags($sTexto);
        if (!trim($sReturn)) {
            return;
        }
        return substr($sReturn, 0, 210) . '...';
    }

     /**
     * Formata o dia da semana
     * @var DateTime $dtEvento
     * @return string
     */
    public function formatarDiaSemana(\DateTime $dtEvento, bool $short = false)
    {
        // 0 (para domingo) a 6 (para sábado)
        $aDias = [
            0 => 'Domingo',
            1 => 'Segunda',
            2 => 'Terça',
            3 => 'Quarta',
            4 => 'Quinta',
            5 => 'Sexta',
            6 => 'Sábado',
        ];

        $iDia = $dtEvento->format('w');
        $sDia = $aDias[$iDia];

        $qtLetras = 3;
        if (6 == $iDia) {
            $qtLetras++;
        }
        return $short ? substr($sDia, 0, $qtLetras) : $sDia;
    }
}
