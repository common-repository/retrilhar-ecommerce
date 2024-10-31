<?php

namespace Retrilhar\Model;

class Evento extends AbstractModel
{
    static $table = 'retrilhar_evento';


    public function pesquisar(int $idTipoAtividade = null, $dtInicio = null, $dtFim = null, int $iQuantidade = null)
    {
        global $wpdb;

        $tbProduto = Produto::getTableName();
        $tbEvento = static::getTableName();

        $sql = 'select p.*, e.dt_inicio, e.st_codigo, e.qt_dias
                from ' . $tbProduto . ' p
                inner join ' . $tbEvento . ' e on e.id_produto = p.id_produto
                where e.bo_ativo = true and e.dt_inicio >= now()';

        if ($dtInicio && $dtFim) {
            $sql .= ' and e.dt_inicio between "' . $dtInicio . '" and "' . $dtFim . '"';
        }

        if ($idTipoAtividade) {
            $sql .= ' and p.id_tipo_atividade = ' . $idTipoAtividade;
        } else {
            $sql .= ' and e.dt_inicio is not null';
        }

        //$sql .= ' order by -e.dt_inicio desc, p.st_nome';
        $sql .= ' order by e.dt_inicio asc, p.st_nome';

        if ($iQuantidade) {
            $sql .= ' limit ' . $iQuantidade;
        }
        return $wpdb->get_results($sql);
    }

    public function getPorProdutoSlug($slug, int $idProduto = null)
    {
        global $wpdb;
        $slug = wp_unslash((string) $slug);

        $tbProduto = Produto::getTableName();
        $tbEvento = static::getTableName();

        $sql = 'select p.*, e.dt_inicio, e.id_evento, e.st_codigo, e.qt_dias
                from ' . $tbProduto . ' p
                inner join ' . $tbEvento . ' e on e.id_produto = p.id_produto
                where e.bo_ativo = true and e.dt_inicio >= now()';

        // produto
        if ($idProduto) {
            $sql .= ' and p.id_produto = ' . $idProduto;
        } elseif ($slug) {
            $sql .= ' and p.st_slug = %s';
        }

        $sql .= ' order by e.dt_inicio asc';

        if ($idProduto) {
            return $wpdb->get_results($sql);
        }
        return $wpdb->get_results($wpdb->prepare($sql, $slug));
    }

    public function getPosts(int $idTipoAtividade = null, $dtInicio = null, $dtFim = null, int $iQuantidade = null)
    {
        global $wpdb;

        $tbProduto = Produto::getTableName();
        $tbEvento = static::getTableName();

        $sql = 'select 
                    pos.*, p.*,
                    e.dt_inicio,
                    e.id_evento,
                    e.st_codigo,
                    e.qt_dias,
                    e.re_valor evento_re_valor,
                    e.re_valor_online evento_re_valor_online
                from ' . $tbProduto . ' p
                inner join ' . $tbEvento . ' e on e.id_produto = p.id_produto
                inner join ' . $wpdb->postmeta . " m on (m.meta_value = p.id_produto and meta_key = 'retrilhar_id_produto')
                inner join " . $wpdb->posts . " pos on pos.ID = m.post_id
                where ( e.bo_ativo = true and e.dt_inicio >= now() )";

        if ($dtInicio && $dtFim) {
            $sql .= ' and e.dt_inicio between "' . $dtInicio . '" and "' . $dtFim . '"';
        }

        if ($idTipoAtividade) {
            $sql .= ' and p.id_tipo_atividade = ' . $idTipoAtividade;
        }
        $sql .= ' order by e.dt_inicio asc';

        if ($iQuantidade) {
            $sql .= ' limit ' . $iQuantidade;
        }
        
        return $wpdb->get_results($sql);
    }
}
