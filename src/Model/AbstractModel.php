<?php

namespace Retrilhar\Model;

abstract class AbstractModel
{
    static $table;

    /**
     * Retorna o nome da tabela do model
     * @return string Nome da tabela no banco de dados
     */
    static function getTableName()
    {
        global $wpdb;
        return $wpdb->prefix . static::$table;
    }
}
