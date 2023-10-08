<?php
/**
* Funciones generales
* @package gv360
*
*/
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );
/*Añadimos Analytics*/
function insertar_codigo_ga() {
    // Recuperar el valor del campo personalizado
    $codigo_seguimiento = get_field('seguimiento_analytics', 'option');
    
    // Insertar el código de seguimiento en el encabezado
    if( $codigo_seguimiento ) {
        ?>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($codigo_seguimiento); ?>"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', '<?php echo esc_attr($codigo_seguimiento); ?>');
        </script>
        <?php
    }
}
add_action('wp_head', 'insertar_codigo_ga');


add_action( 'wp_footer', function() {
  ?>
  <!-- En funciones_generales. Mover y hacer solo disponible para archive y tax-->
  <link href="/wp-content/plugins/facetwp/assets/vendor/fSelect/fSelect.css" rel="stylesheet" type="text/css">
  <script src="/wp-content/plugins/facetwp/assets/vendor/fSelect/fSelect.js"></script>
  <script>
    document.addEventListener('facetwp-loaded', function() {
      fUtil('.facetwp-type-sort select').fSelect({showSearch: false});
    });
  </script>
  <?php
}, 100 );