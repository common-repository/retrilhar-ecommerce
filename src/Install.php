<?php

namespace Retrilhar;

class Install
{
    /**
     * Ativação/instalação do plugin
     */
    static public function run()
    {
        global $wpdb;

        $tbProduto = Model\Produto::getTableName();
        $tbEvento  = Model\Evento::getTableName();
        $charset_collate = $wpdb->get_charset_collate();

        $sqlProduto = "CREATE TABLE $tbProduto (
            		id_produto integer NOT NULL,
                    st_id varchar(50),
            		st_nome varchar(200) NOT NULL,
            		st_slug varchar(200) NOT NULL,
            		id_tipo_atividade integer NOT NULL,
            		st_tipo_atividade varchar(150) NOT NULL,
            		re_valor float,
                    re_valor_online float,
            		st_link varchar(2000) NOT NULL,
            		bo_exibir_home boolean NOT NULL,
            		bo_ativo boolean NOT NULL,
            		url_imagem_card varchar(2000) NULL,
            		url_imagem_banner varchar(2000) NULL,
                    id_pais integer,
                    st_pais varchar(3),
                    st_regiao varchar(30),
                    id_estado integer,
                    st_estado varchar(2),
                    id_cidade integer,
                    st_destino varchar(100),
                    st_texto LONGTEXT,
                    st_resumo varchar(2000),
                    id_nivel_dificuldade integer,
                    st_nivel_dificuldade varchar(60),
            		PRIMARY KEY (id_produto)
            	) $charset_collate;";

        $sqlEvento = "CREATE TABLE $tbEvento (
            		id_evento integer NOT NULL,
                    st_codigo varchar(40) NOT NULL,
            		id_produto integer NOT NULL,
            		dt_inicio date NOT NULL,
            		qt_dias integer NOT NULL,
            		st_link varchar(2000) NOT NULL,
            		bo_ativo boolean NOT NULL,
                    re_valor float,
                    re_valor_online float,
            		PRIMARY KEY (id_evento)
            	) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        static::uninstall();
        dbDelta($sqlProduto);
        dbDelta($sqlEvento);

        add_option('retrilhar_ecommerce_version', Plugin::VERSION);
    }

    /**
     * Desativa o plugin
     */
    static public function uninstall()
    {
        global $wpdb;

        $aTabelas = [
            Model\Evento::getTableName(),
            Model\Produto::getTableName()
        ];

        foreach ($aTabelas as $sTabela) {
            $wpdb->query('DROP TABLE IF EXISTS ' . $sTabela);
        }
        delete_option("retrilhar_ecommerce_version");
    }
}
