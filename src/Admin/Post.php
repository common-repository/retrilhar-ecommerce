<?php

namespace Retrilhar\Admin;

class Post
{

    /**
     * Adiciona coloca no produto na listagem de post e page
     *
     * @param [type] $columns
     * @return void
     */
    static public function wpListPostProduto($columns)
    {
        return (array) $columns + ['id_produto' => 'Retrilhar'];
    }

    static public function wpListPostProdutoColumn($column_name)
    {
        global $post;
        if ('id_produto' === $column_name) {

            $idProduto = (int) get_post_meta(get_the_ID(), 'retrilhar_id_produto', true);
            if (!$idProduto) {
                return;
            }

            $rProduto = (new \Retrilhar\Model\Produto())->find($idProduto);
            if (!$rProduto) {
                return;
            }
            echo $rProduto->st_nome;
        }
    }

    static public function quickEditProduto($column_name, $post_type)
    {
        //if ('id_produto' !== $column_name || !in_array($post_type, ['page', 'post'])) {
        if ('id_produto' !== $column_name) {
            return;
        }

        $idProduto = (int) get_post_meta(get_the_ID(), 'retrilhar_id_produto', true);
        $aProdutos = (new \Retrilhar\Model\Produto())->all();

?>
        <fieldset class="inline-edit-col-right">
            <div class="inline-edit-col">
                <div class="inline-edit-group wp-clearfix">
                    <label class="inline-edit-group">
                        <span class="title">Produto no Retrilhar</span>
                        <select name="id_produto" class="retrilhar_id_produto">
                            <option value="">[Sem vínculo]</option>
                            <?php foreach ($aProdutos as $rProduto) : ?>
                                <option value="<?php echo $rProduto->id_produto; ?>" <?php echo $idProduto == $rProduto->id_produto ? ' selected="selected"' : ''; ?>><?php echo $rProduto->st_nome; ?></option>
                            <?php endforeach ?>
                        </select>
                        <?php
                        ?>
                    </label>
                </div>

            </div>
        </fieldset>
<?php
    }

    static public function quickEditSave($post_id, $post)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        /*
        if (!in_array($post->post_type, ['page', 'post']) || !\current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        if (!isset($_REQUEST['_inline_edit']) || !\wp_verify_nonce($_REQUEST['_inline_edit'], 'inlineeditnonce')) {
            return $post_id;
        }
        */

        if (isset($_POST['id_produto'])) {
            //\update_post_meta($post_id, 'retrilhar_id_produto', (int) $_POST['id_produto']);
            /*
            // Make sure meta is added to the post, not a revision.
            $the_post = wp_is_post_revision($post_id);
            if ($the_post) {
                $post_id = $the_post;
            }

            \update_metadata($post->post_type, $post_id, 'retrilhar_id_produto', $idProduto);
            */
            $idProduto = $_POST['id_produto'];
            \update_post_meta($post_id, 'retrilhar_id_produto', $idProduto);
        }

        return $post_id;
    }

    /**
     * Carrega o produto do post/page do quickeditor
     *
     * @return void
     */
    public function getQuickJson()
    {
        $idPost = (int) sanitize_text_field($_POST['post_id']);
        $idProduto = (int) get_post_meta($idPost, 'retrilhar_id_produto', true);
        $aReturn = [
            'idProduto' => $idProduto,
        ];
        \wp_send_json_success($aReturn);
        \wp_die();
    }
}
