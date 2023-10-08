<?php
get_header();
?>
<main id="archive_coche">
<aside class="buscador">
<?php 
include( GV360_PLUGIN_DIR . 'public/templates/template-parts/filtros/filtro-coches.php' );
?>
</aside>
</main>

<?php
$term = get_queried_object();
$logo_marca = get_field( 'logo_marca', $term );
$complemento_nombre = get_field('complemento_nombre', 'option');

include( GV360_PLUGIN_DIR . 'public/templates/template-parts/filtros/filtro-coches.php' );

echo facetwp_display('sort');
?>
<div class="facetwp">
<?php
echo 'Número de coches: ' . $term->count;
echo 'Logo marca:';
if( $logo_marca ) {
         echo wp_get_attachment_image( $logo_marca, 'full', false, array(
            'alt' =>  $term->name . ' ' . $complemento_nombre,
            'title' => $term->name
        ) );
}
if ( have_posts() ) :
  echo 'Hay post';
  // get_template_part( '/template-parts/loop', 'coches' );
  ?>
  <section class="contenedor-wrapper-coches">
  <?php
  include( GV360_PLUGIN_DIR . 'public/templates/template-parts/loop-coches.php' );
  ?>
  </section>
  <?php
else :
  // No hay publicaciones para mostrar
  echo 'No hay post';
  // Mostrar mensaje de "No se encontraron publicaciones" aquí
endif;  
      ?>
    <div class="leer-facet">
      <p>LEER FACET</p>
<span><?php  echo facetwp_display( 'facet', 'mostrando_coches' );?>
<div class="leer-facet-wrapper">
<?php  echo facetwp_display( 'facet', 'coches_por_pagina' );?></span>
<span><?php  echo facetwp_display( 'facet', 'paginador_coches' );?></span>
</div>
</div>

<?php get_footer(); ?>