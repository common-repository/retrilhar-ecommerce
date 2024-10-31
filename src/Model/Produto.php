<?php

namespace Retrilhar\Model;

class Produto extends AbstractModel
{
    static $table = 'retrilhar_produto';

    public function find(int $idProduto)
    {
        global $wpdb;

        $tbProduto = static::getTableName();
        $sql = 'select *
                from ' . $tbProduto . ' p
                where id_produto = %s';
        return current($wpdb->get_results($wpdb->prepare($sql, $idProduto)));
    }

    /**
     * Retornar produtos
     * @return array|object|NULL
     */
    public function all(array $filtro = null, bool $bPosts = false)
    {
        global $wpdb;

        $tbProduto = static::getTableName();
        $sql = 'SELECT * FROM ' . $tbProduto . ' p';

        if ($bPosts) {
            $sql .= '
                inner join ' . $wpdb->postmeta . " m on (m.meta_value = p.id_produto and meta_key = 'retrilhar_id_produto')
                inner join " . $wpdb->posts . ' pos on pos.ID = m.post_id';
        }

        $aWhere = [];

        if (!empty($filtro['bo_exibir_home'])) {
            $aWhere[] = 'bo_exibir_home = ' . (int) $filtro['bo_exibir_home'];
        }

        if (!empty($filtro['atividade'])) {
            $aWhere[] = 'id_tipo_atividade = ' . (int) $filtro['atividade'];
        }

        if (!empty($filtro['pais'])) {
            if ('!' == $filtro['pais'][0]) {
                $aWhere[] = 'st_pais <> "' . strtoupper(substr($filtro['pais'], 1)) . '"';
            } else {
                $aWhere[] = 'st_pais = "' . strtoupper($filtro['pais']) . '"';
            }
        }

        if (!empty($filtro['regiao'])) {
            $aWhere[] = 'st_regiao = "' . $filtro['regiao'] . '"';
        }

        if (!empty($filtro['estado'])) {
            $aWhere[] = 'st_estado = "' . strtoupper($filtro['estado']) . '"';
        }

        if (count($aWhere)) {
            $sql .= ' where ' . implode(' and ', $aWhere);
        }

        $sql .= ' order by st_nome';
        return $wpdb->get_results($sql);
    }

    /**
     * Retorna as atividades dos produtos
     * @return array|object|NULL
     */
    public function getAtividades()
    {
        global $wpdb;
        $tbProduto = static::getTableName();
        $sql = 'SELECT distinct id_tipo_atividade, st_tipo_atividade FROM ' . $tbProduto . ' where bo_ativo = true order by st_tipo_atividade';
        return $wpdb->get_results($sql);
    }
}
