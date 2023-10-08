<?php
/**
* Buscador y lógica para los filtros de búsqueda
* @package gv360
*
*/

defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

/*Query todas las marcas*/
$marcas = get_terms(array(
  'taxonomy' => 'marca',  
  'hide_empty' => true,
  'post_status' => 'publish',
  'public' => 'true',
  ));
$nombre_del_stock = get_field('nombre_del_stock', 'option');
 $archive_link = get_post_type_archive_link( 'coche' );  
?>
<div class="wrapper-buscador">
  <div class="contenido-buscador">
    <?php /*echo do_shortcode('[facetwp facet="min_price"]');?>
    <?php echo do_shortcode('[facetwp facet="max_price"]');?>
    <?php echo do_shortcode('[facetwp facet="precio_range"]'); */?>
   <!-- <select id="min-price" name="min-price">
    <option value="">Precio mínimo</option>
    </select> -->

  <div class="wrapper-cerrar-buscador">
                  <!--  <span class="contador-filtros"></span> -->
                
                    <button class="boton-cierre"><span>Cerrar</span></button>
                </div>
<?php  include GV360_PLUGIN_DIR . 'includes/buscador-coches.php'; ?>
<!-- Contenedor del select marcas -->
<div class="select-marcas">
  <h3 class="marca">Filtros de búsqueda</h3>
  <i class="icon-help_outline ayuda-marcas"></i>

  <p class="label-help help-marcas">Selecciona una marca para ver todos los modelos disponibles</p>
  <!-- Opción seleccionada -->
  <?php if (is_tax('marca')) : 
    $term = get_queried_object();
    $logo_id = get_term_meta( $term->term_id, 'logo_marca', true );
    $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
  ?>
    <div class="selected-option">
    <?php if ($logo_url) : ?>
      <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $term->name ); ?>">
    <?php endif; ?>
      <span><?php echo esc_html( $term->name ); ?></span>
    </div>
    <?php else: ?>
    <div class="selected-option">
      <span>Todas las marcas</span>
    </div>
  <?php endif; ?>

  <!-- Lista de opciones -->
  <ul class="options-list">
  <?php if (is_tax('marca')) : ?>
    <li class="todas_las_marcas">
      <a href="<?php echo esc_url( $archive_link ); ?>" title="Todas las marcas">
      <span>Todas las marcas</span>
      </a>
    </li>
  <?php endif; ?>
<?php foreach ( $marcas as $marca ) :
  $logo_id = get_term_meta( $marca->term_id, 'logo_marca', true );
  $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
  $forma_del_logo = get_term_meta( $marca->term_id, 'forma_del_logo', true );
  $permalink = get_term_link( $marca );
if (is_tax('marca') && get_queried_object_id() === $marca->term_id) {
    $selected_class = 'seleccionado';
};?>
<li>
      <a href="<?php echo esc_url( $permalink ); ?>">
        <!-- Agregar el atributo loading="lazy" a la imagen -->
        <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $marca->name ); ?>" class="<?php echo esc_attr( $forma_del_logo ); ?>" loading="lazy">
        <span><?php echo esc_html( $marca->name ); ?></span>
      </a>
    </li>
  <?php endforeach; ?>
</ul>
<?php if (is_tax('marca')) : ?>
<a href="<?php echo esc_url( $archive_link ); ?>" title="<?php echo esc_attr( $nombre_del_stock )?>">Volver a todas las marcas</a>
<?php endif; ?>
</div> <!--select-marcas-->

  <?php if (is_tax('carroceria') || is_post_type_archive('coche')) : ?>
  <div>
    <p class="p-multi-marca label-help">Busca <b>varias marcas</b> a la vez:</p>
  <?php echo facetwp_display('facet', 'marcas'); ?>
  </div>
  <?php endif; ?>
<?php if (is_tax('marca')) : ?>
  <div class="h3-wrapper-filtros"   >
    <h3>Modelos</h3>
    <?php echo facetwp_display('facet', 'modelo'); ?>
  </div>
  <?php endif;?>
  <div class="h3-wrapper-filtros"  >
    <h3><i class="icon-euro"></i>Precio</h3>     
    <?php echo facetwp_display('facet', 'precio'); ?>
    <?php echo facetwp_display('facet', 'iva_deducible'); ?>
  </div>
  <div class="h3-wrapper-filtros" >
    <h3><i class="icon-map"></i> Kilometraje</h3>
    <?php echo facetwp_display('facet', 'kilometros'); ?>
  </div>
  <div class="h3-wrapper-filtros" >
    <h3><i class="icon-calendar_today"></i> Año</h3>
    <?php echo facetwp_display('facet', 'ano'); ?>
  </div>
  <div class="h3-wrapper-filtros">
    <h3><i class="icon-combustible"></i> Tipo de combustible</h3>
    <?php echo facetwp_display('facet', 'combustible'); ?>
  </div>
  <div class="h3-wrapper-filtros">
    <h3><i class="icon-cambio"></i>Transmisión</h3>
    <?php echo facetwp_display('facet', 'cambio'); ?>
  </div>
  <div class="h3-wrapper-filtros">
    <h3><i class="icon-car"></i>Tipo de carrocería</h3>
  <?php 
  if (is_tax('carroceria') ) {
    get_template_part('template-parts/filtros/select', 'carrocerias');
  } else { ?>
    <?php echo facetwp_display('facet', 'carrocerias');
  } ?>
  </div>
  <div>
    <button class="mas_filtros" aria-expanded="false" title="Mostrar más filtros">Más filtros</button>
  </div>
  <div class="mas_filtros_container">
    <div class="h3-wrapper-filtros" >
      <h3><i class="icon-emisiones"></i> Etiqueta medioambiental</h3>
      <?php echo facetwp_display('facet', 'etiqueta_medioambiental'); ?>
    </div>
    <div>
      <h3>Tracción</h3>
    </div>
    <div class="h3-wrapper-filtros">
      <h3><i class="icon-horse"></i> Potencia</h3>
      <?php echo facetwp_display('facet', 'potencia'); ?>
    </div>
    <div class="h3-wrapper-filtros">
      <h3><i class="icon-car-door"></i> Puertas</h3>
      <?php echo facetwp_display('facet', 'puertas'); ?>
    </div>
    <div class="h3-wrapper-filtros">
      <h3><i class="icon-asiento"></i> Plazas</h3>
      <?php echo facetwp_display('facet', 'plazas'); ?>
    </div>
    <div class="h3-wrapper-filtros">
      <h3><i class="icon-palette"></i> Color</h3>
    </div>
  </div> <!--mas_filtros_container-->
  <div id="ordenar-mobile-wrapper">
    <?php // echo facetwp_display('facet', 'ordenar_coches'); ?>
  </div>
  <?php echo facetwp_display("facet", "boton_reiniciar"); ?>
</div> <!-- Contenido buscador -->

</div> <!--wrapper-buscador-->
<div class="ver_coches_container">
    <button id="ver_coches">
      <svg class="loading-animation" viewBox="0 0 100 100" style="display: none;">
        <circle cx="50" cy="50" r="45" fill="none" stroke-width="10" stroke="var(--primary80)" stroke-dasharray="70,200" />
      </svg>
      <span class="button-text">Ver coches</span>
    </button>
  </div>