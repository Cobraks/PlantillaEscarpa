<?php
/**
 * Galería interior, exterior y unificada
 * @package gv360
 */

 defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

 // Verificar si se deben unir las galerías
if ( $unir_galerias ) {
  $galeria = get_field( 'galeria_de_fotos_galeria_unida' );
  $total_fotos = $galeria ? count($galeria) : 0;
} else {
  $total_fotos = 0;
// Mostrar las galerías interior y exterior por separado
$galeria_interior = get_field( 'galeria_de_fotos_galeria_interior' );
//$tipo_gallería_interior = 'Gallería interior';

$galeria_exterior = get_field( 'galeria_de_fotos_galeria_exterior' );

if ($galeria_interior) {
  $total_fotos += count($galeria_interior);
  $total_fotos_interior = $galeria_interior ? count($galeria_interior) : 0;
}

if ($galeria_exterior) {
  $total_fotos += count($galeria_exterior);
  $total_fotos_exterior = $galeria_exterior ? count($galeria_exterior) : 0;
 // $fotos_por_galeria = $total_fotos_exterior;
}


 function mostrar_galeria_con_miniaturas($galeria, $id,$titulo,$nombre_marca, $nombre_modelo,$int_or_ext,$fotos_por_galeria) {
  
  if (!empty($galeria)) {
    echo '<div id="' . $id . '" class="splide cargando">';
   // echo '<h2>' . $titulo . '</h2>';
    echo '<div class="splide__track">';
    ?>
    <div class="loader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
    </div>

    <?php
    echo '<ul class="splide__list">';
    foreach ($galeria as $image_id) {
      list($url, $width, $height) = wp_get_attachment_image_src($image_id, 'full');
      $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
      echo '<li class="splide__slide popup-image">';
      echo '<div class="datos-fotos">' . esc_html($int_or_ext) .  ' del ' . $nombre_marca . ' ' . $nombre_modelo . ' <b> 1</b> / ' . $fotos_por_galeria . '</div>';
      echo '<img class="img-galeria" src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '" width="' . esc_attr($width) . '" height="' . esc_attr($height) . '" loading="lazy">';
      echo '</li>';
    } 
    echo '</ul>';
    echo '</div>';
    echo '</div>';

    // Miniaturas
    echo '<div id="' . $id . '-mini" class="splide">';
    echo '<div class="splide__track">';
    echo '<ul class="splide__list">';
    foreach ($galeria as $image_id) {
      list($url, $width, $height) = wp_get_attachment_image_src($image_id, 'thumbnail');
      $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
      echo '<li class="splide__slide">';
      echo '<img src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '" width="' . esc_attr($width) . '" height="' . esc_attr($height) . '">';
      echo '</li>';
    }
    echo '</ul>';
    echo '</div>';
    echo '</div>';
  }
}
}



 
?>
<section class="section-ficha" id="seccion-galeria">

  <div class="title-container">
    <h2>Fotografías</h2>
    <?php if (!( $unir_galerias )) { ?>
    <div class="switch">
      <input type="radio" class="option" id="exterior" name="switch"  >
      <input type="radio" class="option" id="interior" name="switch">
      <div class="selector"></div>
      <label for="exterior" class="label">Exterior</label>
      <label for="interior" class="label">Interior</label>
    </div>
    <?php } ?>
  </div>

  <div class="contenedor-galerias">
    <div class="contenedor-galeria" id="contenedor-galeria-exterior">
    <?php
    if (isset($galeria_exterior)) {
      $fotos_por_galeria = $total_fotos_exterior;
      $int_or_ext = 'exterior';
      mostrar_galeria_con_miniaturas($galeria_exterior, 'galeria-exterior', 'Fotografías exterior', $nombre_marca, $nombre_modelo,$int_or_ext,$fotos_por_galeria);
    }
    ?>
    </div>

    <div class="contenedor-galeria" id="contenedor-galeria-interior">
    <?php 
    if (isset($galeria_interior)) {
      $fotos_por_galeria = $total_fotos_interior;
      $int_or_ext = 'interior';
      mostrar_galeria_con_miniaturas($galeria_interior, 'galeria-interior','Fotografías interior', $nombre_marca, $nombre_modelo,$int_or_ext,$fotos_por_galeria); 
    } ?>
    </div>
</div> <!--contenedor galerias-->

</section>