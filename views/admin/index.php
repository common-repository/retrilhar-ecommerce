<?php
/**
 * Configuração do Retrilhar.
 */
defined('ABSPATH') || exit;
?>

<div class="wrap">
  <div class="health-check-header">
    <div class="health-check-title-section">
      <h1> Shortcodes </h1>
    </div><!--health-check-title-section-->
  </div><!--health-check-header-->

  <hr class="wp-header-end">
  
  <div class="health-check-body health-check-status-tab hide-if-no-js">
    <div class="site-status-has-issues">

    <div class="site-health-issues-wrapper">
        <h3>Retrilhar Ecommerce</h3>
        <div id="health-check-site-status-critical" class="health-check-accordion issues">
          <h4 class="health-check-accordion-heading">
            <button class="health-check-accordion-trigger" type="button" style="border-bottom: 1px solid #c3c4c7">
              <span class="title"><p>Configuração</p></span>
            </button>
          </h4>
          <div id="health-check-accordion-block-rest_availability" class="health-check-accordion-panel"> 
            <p>
              <form method="post" action="<?php echo admin_url('admin-post.php?action=retrlhar_config'); ?>">
                <span class="title">URL do Ecommerce</span>
                <p><input type="text" class="form-control" name="url" id="url" aria-describedby="urlHelp" value="<?php echo esc_url($urlSistema); ?>"></p>
                <p>Exemplo: https://vendas.seudominio.com.br</p>
                <button type="submit" class="btn btn-primary">Gravar</button>
              </form>
            </p>
          </div>
        </div>
      </div><!--site-status-has-issues-->

      <h2>O que são shortcodes</h2>
      <p>Shortcode é um tipo de elemento do WordPress que permite que o usuário insira 
        desde pequenas informações personalizadas até controlar a exibição de parte do 
        conteúdo com um simples [shortcode].</p>
      <p>&nbsp;</p>

      <h2>Descrição do Plugin</h2>
      <p>O plugin Retrilhar faz uma integração de vários elementos visuais e funcionais, 
        que você pode usar no editor de postagem, editor de páginas ou até mesmo em arquivos 
        de modelo. Usando os shortcodes, você pode listar seus produtos e eventos, criar facilmente 
        filtros de data e categoria, e muito mais.</p>
      <p>&nbsp;</p>

      <div class="site-health-issues-wrapper">
        <h3>Data dos eventos</h3>
        <div id="health-check-site-status-critical" class="health-check-accordion issues">
          <h4 class="health-check-accordion-heading">
            <button class="health-check-accordion-trigger" type="button" style="border-bottom: 1px solid #c3c4c7">
              <span class="title"><p>[retrilhar_filtro_periodo]</p></span>
            </button>
          </h4>
          <div id="health-check-accordion-block-rest_availability" class="health-check-accordion-panel"> 

            <p>Este shortcode é responsável por criar dois campos de data, 
              como no exemplo abaixo, que irá filtrar seus eventos de acordo 
              com o período escolhido e exibi-los na vitrine.</p>
            <p>Exemplo:</p>
            <p><?php echo \do_shortcode('[retrilhar_filtro_periodo]'); ?></p>
          </div>
        </div>
      </div><!--site-status-has-issues-->

      <p>&nbsp;</p>

      <div class="site-health-issues-wrapper" >
      <h3>Categorias dos produtos</h3>
        <div id="health-check-site-status-critical" class="health-check-accordion issues">
          <h4 class="health-check-accordion-heading">
            <button class="health-check-accordion-trigger" type="button" style="border-bottom: 1px solid #c3c4c7">
              <span class="title"><p>[retrilhar_filtro_atividade]</p></span>
            </button>
          </h4>
          <div id="health-check-accordion-block-rest_availability" class="health-check-accordion-panel">   
            <p>Este shortcode é responsável por criar uma caixa de escolha, 
              como no exemplo abaixo, que irá filtrar seus produtos de acordo 
              com sua categoria na vitrine.</p>
            
            <p>Exemplo:</p>
            <p><?php echo \do_shortcode('[retrilhar_filtro_atividade]'); ?></p>
          </div>
        </div>
      </div><!--site-status-has-issues-->

      <p>&nbsp;</p>

      <div class="site-health-issues-wrapper" >
      <h3>Vitrine de eventos</h3>
        <div id="health-check-site-status-critical" class="health-check-accordion issues">
          <h4 class="health-check-accordion-heading">
            <button class="health-check-accordion-trigger" type="button" style="border-bottom: 1px solid #c3c4c7">
              <span class="title"><p>[retrilhar_vitrine_eventos]</p></span>
            </button>
          </h4>
          <div id="health-check-accordion-block-rest_availability" class="health-check-accordion-panel">       
            <p>Este shortcode é responsável por mostrar todos os seus eventos,
              você támbem pode escolher seus eventos que irão aparecer a partir 
              de sua atividade e filtrar de acordo com a data e início e fim.
            </p>
            <p><a class="btn btn-primary" href="<?php echo esc_url(admin_url('admin.php?page=retrilhar-page-shortcode&slug=vitrine-eventos')); ?>">Personalizar</a></p>
            <p>Exemplo:</p>
            <p>[retrilhar_vitrine_eventos atividade="1" dtInicio="" dtFim="" quantidade=""]</p>
            <hr>
            <h3>Opções</h3>         
            <table class="wp-list-table widefat fixed striped table-view-list comments">
              <tbody id="the-comment-list">
                <tr>
                  <td scope="col">atividade</td>
                  <td>ID da atividade</td>
                </tr>
                <tr>
                  <td scope="col">dtInicio</td>
                  <td>Data de início do seus eventos</td>
                </tr>
                <tr>
                  <td scope="col">dtFim</td>
                  <td>Data de término do seus eventos</td>
                </tr>
                <tr>
                  <td scope="col">quantidade</td>
                  <td>Quantidade de registros que deve retornar</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div><!--site-status-has-issues-->

      <p>&nbsp;</p>

      <div class="site-health-issues-wrapper" >
      <h3>Vitrine os produtos</h3>
        <div id="health-check-site-status-critical" class="health-check-accordion issues">
          <h4 class="health-check-accordion-heading">
            <button class="health-check-accordion-trigger" type="button" style="border-bottom: 1px solid #c3c4c7">
              <span class="title"><p>[retrilhar_vitrine_produtos]</p></span>
            </button>
          </h4>
          <div id="health-check-accordion-block-rest_availability" class="health-check-accordion-panel">       
            <p>Este shortcode é responsável por mostrar todos os seus produtos,
               você támbem pode filtrar os produtos que irão aparecer a partir 
               de sua atividade.
            </p>
            <p><a class="btn btn-primary" href="<?php echo esc_url(admin_url('admin.php?page=retrilhar-page-shortcode&slug=vitrine-produtos')); ?>">Personalizar</a></p>
            <p>Exemplo:</p>
            <p>[retrilhar_vitrine_produtos atividade="1"]</p>
            <hr>
            <h3>Opções</h3>
            <table class="wp-list-table widefat fixed striped table-view-list comments">
              <tbody id="the-comment-list">
                <tr>
                  <td scope="col">atividade</td>
                  <td>ID da atividade</td>
                </tr>
                <tr>
                  <td scope="col">pais</td>
                  <td>Pais da atividade padrão ISO 3166-1 alfa-3. ex: pais="BRA"</td>
                </tr>
                <tr>
                  <td scope="col">pais</td>
                  <td>Filtro de diferente. ex: pais="!BRA"</td>
                </tr>
                <tr>
                  <td scope="col">estado</td>
                  <td>Estado/UF da atividade. ex: DF, GO, MG</td>
                </tr>
                <tr>
                  <td scope="col">posts</td>
                  <td>Exibi apenas produtos vinculados a página/post do WP. ex: posts="true"</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div><!--site-status-has-issues-->

      <p>&nbsp;</p>

      <div class="site-health-issues-wrapper">
      <h3>Vitrine de eventos vinculados a posts(WP)</h3>
        <div id="health-check-site-status-critical" class="health-check-accordion issues">
          <h4 class="health-check-accordion-heading">
            <button class="health-check-accordion-trigger" type="button" style="border-bottom: 1px solid #c3c4c7">
              <span class="title"><p>
                [retrilhar_vitrine_eventos_posts]
              </p></span>
            </button>
          </h4>
          <div id="health-check-accordion-block-rest_availability" class="health-check-accordion-panel">       
            <p>Este shortcode é responsável por mostrar todos os seus eventos 
              que possuem post/páginas vinculadas,você támbem pode escolher 
              seus eventos que irão aparecer a partir de sua atividade e 
              filtrar de acordo com a data e início e fim.
            </p>
            <p><a class="btn btn-primary" href="<?php echo esc_url(admin_url('admin.php?page=retrilhar-page-shortcode&slug=vitrine-eventos-posts')); ?>">Personalizar</a></p>
            <p>Exemplo:</p>
            <p>[retrilhar_vitrine_eventos_posts atividade="1" dtInicio="" dtFim="" quantidade=""]</p>
            <hr>
            <h3>Opções</h3>
            <table class="wp-list-table widefat fixed striped table-view-list comments">
              <tbody id="the-comment-list">
                <tr>
                  <td scope="col">atividade</td>
                  <td>ID da atividade</td>
                </tr>
                <tr>
                  <td scope="col">dtInicio</td>
                  <td>Data de início do seus eventos</td>
                </tr>
                <tr>
                  <td scope="col">dtFim</td>
                  <td>Data de término do seus eventos</td>
                </tr>
                <tr>
                  <td scope="col">quantidade</td>
                  <td>Quantidade de registros que deve retornar</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div><!--site-status-has-issues-->

      <p>&nbsp;</p>

      <div class="site-health-issues-wrapper">
      <h3>Valor do produto</h3>
        <div id="health-check-site-status-critical" class="health-check-accordion issues">
          <h4 class="health-check-accordion-heading">
            <button class="health-check-accordion-trigger" type="button" style="border-bottom: 1px solid #c3c4c7">
              <span class="title"><p>[retrilhar_produto_valor]</p></span>
            </button>
          </h4>
          <div id="health-check-accordion-block-rest_availability" class="health-check-accordion-panel">       
            <p>Este shortcode é responsável por mostrar o valor do seu produto.</p>
            <p>Exemplo:</p>
            <p>1.234,56</p>
          </div>
        </div>
      </div><!--site-status-has-issues-->

      <p>&nbsp;</p>

      <div class="site-health-issues-wrapper" >
        <h3>Data dos eventos</h3>
          <div id="health-check-site-status-critical" class="health-check-accordion issues">
            <h4 class="health-check-accordion-heading">
              <button class="health-check-accordion-trigger" type="button" style="border-bottom: 1px solid #c3c4c7">
                <span class="title"><p>[retrilhar_produto_eventos]</p></span>
              </button>
            </h4>
            <div id="health-check-accordion-block-rest_availability" class="health-check-accordion-panel">       
              <p>Este shortcode é responsável por mostrar apenas a data do seus eventos</p>
              <p><a class="btn btn-primary" href="<?php echo esc_url(admin_url('admin.php?page=retrilhar-page-shortcode&slug=produto-eventos')); ?>">Personalizar</a></p>
            </div>
          </div>
      </div>

      <p>&nbsp;</p>

      <div class="site-health-issues-wrapper" >
        <h3>Calendário</h3>
          <div id="health-check-site-status-critical" class="health-check-accordion issues">
            <h4 class="health-check-accordion-heading">
              <button class="health-check-accordion-trigger" type="button" style="border-bottom: 1px solid #c3c4c7">
                <span class="title"><p>[retrilhar_calendario]</p></span>
              </button>
            </h4>
            <div id="health-check-accordion-block-rest_availability" class="health-check-accordion-panel">       
              <p>Este shortcode é responsável por mostrar o calendário e os eventos por mês</p>
              <p><a class="btn btn-primary" href="<?php echo esc_url(admin_url('admin.php?page=retrilhar-page-shortcode&slug=calendario')); ?>">Personalizar</a></p>
            </div>
          </div>
      </div>
    </div><!--site-status-has-issues-->
  </div><!--health-check-body-->
</div>
