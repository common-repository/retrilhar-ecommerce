<?php

namespace Retrilhar;

class Utils
{
    static function formatMoney(float $reValor)
    {
        return number_format($reValor, 2, ',', '.');
    }
}
