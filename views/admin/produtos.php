<?php
/**
 * Configuração do Retrilhar.
 */
defined('ABSPATH') || exit;
?>

<div class="wrap">
  <div class="health-check-header">
    <div class="health-check-title-section">
      <h1> Retrilhar</h1>
    </div>
  </div>

  <hr class="wp-header-end">
  <div class="health-check-body health-check-status-tab hide-if-no-js">
    <div class="site-status-has-issues">

      <div class="site-health-issues-wrapper" >
      <h3>Produtos e eventos</h3>
        <div id="health-check-site-status-critical" class="health-check-accordion issues">
          <h4 class="health-check-accordion-heading">
            <button class="health-check-accordion-trigger" type="button" style="border-bottom: 1px solid #c3c4c7">
              <span class="title"><p>Eventos</p></span>
            </button>
          </h4>
          <div id="health-check-accordion-block-rest_availability" class="health-check-accordion-panel">       
            <p>Eventos integrados (<?php echo count($aEventos); ?>)</p>
            <table class="wp-list-table widefat fixed striped table-view-list comments">
              <tbody id="the-comment-list">
                <tr>
                  <td scope="col">Data</td>
                  <td>Produto</td>
                </tr>
                <?php foreach ($aEventos as $rEvento) : ?>
                <tr>
                  <td scope="col"><?php echo (new \DateTime($rEvento->dt_inicio))->format('d/m/Y'); ?></td>
                  <td><?php echo $rEvento->st_nome; ?></td>
                </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>

        <div id="health-check-site-status-critical" class="health-check-accordion issues">
          <h4 class="health-check-accordion-heading">
            <button class="health-check-accordion-trigger" type="button" style="border-bottom: 1px solid #c3c4c7">
              <span class="title"><p>Produtos</p></span>
            </button>
          </h4>
          <div id="health-check-accordion-block-rest_availability" class="health-check-accordion-panel">       
            <p>Produtos integrados (<?php echo count($aProdutos); ?>)</p>
            <table class="wp-list-table widefat fixed striped table-view-list comments">
              <tbody id="the-comment-list">
                <tr>
                  <th style="width: 2.5rem;;">Exibir</th>
                  <th style="width: 5.5rem;;">Atividade</tg>
                  <th>Produto</th>
                </tr>
                <?php foreach ($aProdutos as $rProduto) : ?>
                <tr>
                  <td><?php echo 1 == $rProduto->bo_exibir_home ? 'Sim' : 'Não'; ?></td>
                  <td><?php echo $rProduto->st_tipo_atividade; ?></td>
                  <td><?php echo $rProduto->st_nome; ?></td>
                </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div><!--site-status-has-issues-->

    </div><!--site-status-has-issues-->
  </div><!--health-check-body-->
</div>
