<?php
 error_log('Se está cargando el gv360_buscador_ajax.php');

// Función para modificar la cláusula WHERE de la consulta SQL
function gv360_filtrar_titulo( $where, $wp_query ) {
  global $wpdb;
  if ( $termino = $wp_query->get( 'gv360_termino' ) ) {
      // Escapar los caracteres especiales en el término de búsqueda
      $termino = preg_quote( $termino );
      // Reemplazar los espacios en blanco por una expresión regular que coincida con cualquier número de espacios en blanco
      $termino = str_replace( ' ', '\\s+', $termino );
      // Agregar la condición a la cláusula WHERE utilizando una expresión regular
      $where .= ' AND ' . $wpdb->posts . '.post_title REGEXP \'' . esc_sql( $termino ) . '\'';
  }
  return $where;
}
add_filter( 'posts_where', 'gv360_filtrar_titulo', 10, 2 );


// Función para manejar la petición AJAX de búsqueda por título
function gv360_buscar_por_titulo() {
  // Verificar el nonce
  check_ajax_referer( 'gv360-nonce', 'nonce' );
  // Obtener el término de búsqueda
  $termino = isset($_POST['termino']) ? sanitize_text_field($_POST['termino']) : '';
  // Buscar en la taxonomía "marca"
  $marcas = get_terms( array(
      'taxonomy' => 'marca',
      'name__like' => $termino,
      'fields' => 'id=>name',
      'hide_empty' => false,
  ) );
  // Mostrar los resultados de la búsqueda en la taxonomía "marca"
  foreach ( $marcas as $id => $name ) {
      $url = get_term_link( $id, 'marca' );
      $count = get_term( $id, 'marca' )->count;
      $coches = ( $count === 1 ) ? 'coche' : 'coches';
      echo '<div><a href="' . esc_url( $url ) . '">' . esc_html( $name ) . '</a> (' . intval( $count ) . ' ' . $coches . ')</div>';
  }
  // Buscar en la taxonomía "carrocería"
  $carrocerias = get_terms( array(
      'taxonomy' => 'carroceria',
      'name__like' => $termino,
      'fields' => 'id=>name',
      'hide_empty' => false,
  ) );
  // Mostrar los resultados de la búsqueda en la taxonomía "carrocería"
  foreach ( $carrocerias as $id => $name ) {
      $url = get_term_link( $id, 'carroceria' );
      $count = get_term( $id, 'carroceria' )->count;
      $coches = ( $count === 1 ) ? 'coche' : 'coches';
      echo '<div><a href="' . esc_url( $url ) . '">' . esc_html( $name ) . '</a> (' . intval( $count ) . ' ' . $coches . ')</div>';
      // Realizar una consulta adicional para buscar coches con la taxonomía "carrocería" buscada
      $args = array(
          'post_type' => 'coche',
          'tax_query' => array(
              array(
                  'taxonomy' => 'carroceria',
                  'field' => 'term_id',
                  'terms' => array( $id ),
              ),
          ),
          'suppress_filters' => false,
      );
      $query = new WP_Query($args);
      // Mostrar los resultados de la búsqueda
      if ( $query->have_posts() ) {
          while ( $query->have_posts() ) {
              $query->the_post();
              echo '<div>' . get_the_title() . '</div>';
          }
          wp_reset_postdata();
      }
  }
  // Realizar la consulta a la base de datos
  $args = array(
    'post_type' => 'coche',
    'gv360_termino' => $termino,
    'suppress_filters' => false
  );
  $query = new WP_Query($args);
  // Mostrar los resultados de la búsqueda
  if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
      $query->the_post();
      echo '<div>' . get_the_title() . '</div>';
    }
    wp_reset_postdata();
  } else {
    echo '<div>No se encontraron resultados</div>';
  }
  // Finalizar la petición AJAX
  wp_die();
}
add_action( 'wp_ajax_buscar_por_titulo', 'gv360_buscar_por_titulo' );
add_action( 'wp_ajax_nopriv_buscar_por_titulo', 'gv360_buscar_por_titulo' );



