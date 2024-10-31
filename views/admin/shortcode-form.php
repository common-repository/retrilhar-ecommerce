<?php
if (!defined('RETRILHAR_PATH')) {
    exit('Acesso negado');
}
?>
<form method="post" action="<?php echo admin_url('admin-post.php?action=retrlhar_config_shortcode'); ?>">
<div class="wrap">
  <div id="poststuff">
    <h1>Retrilhar Ecommerce WP - Configuração do template</h1>
    <div id="post-body" class="metabox-holder columns-2">

      <div id="post-body-content" class="edit-form-section edit-comment-section" style="position: relative;">
        <input type="hidden" name="shortcode" value="<?php echo $shortCode; ?>" />
        <h2 class="title"><label for="conteudo" class="form-label">Template</label></h2>
        <textarea name="conteudo" id="conteudo" class="large-text code" required="required" rows="8" ><?php echo esc_html($template); ?></textarea>
      </div><!-- /post-body-content -->

      <div id="postbox-container-1" class="postbox-container">
        <div id="side-sortables" class="meta-box-sortables ui-sortable" style>
            <div class="postbox">
              <div class="postbox-header">
                <h2 class="hndle ui-sortable-handle">Editar Shortcodes</h2>
              </div>
              <div class="inside">
              <h3>Códigos</h3>
                <table class="table table-sm">
                  <?php foreach ($aDicionario as $nome => $descricao) { ?>
                  <tr>
                    <td><b>{<?php echo esc_html($nome); ?>}</b></td>
                    <td><?php echo esc_html($descricao); ?></td>
                  </tr>
                  <?php } ?>
                </table>  
              </div><!-- /inside -->
              <div id="major-publishing-actions">
                <div id="publishing-action">
                  <input type="submit" id="publish" class="button button-primary button-large" value="Atualizar">
                </div>
                <div class="clear"></div>
              </div>
            </div><!-- /postbox -->
          </div><!-- /side-sortables -->
        </div><!-- /postbox-container-1 -->

    </div><!-- /post-body -->
    <br class="clear">
  </div><!-- /poststuff -->
</div>
</form>