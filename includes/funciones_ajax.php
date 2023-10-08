<?php
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );
// Registrar la función "get_logos" como una acción de AJAX en WordPress
add_action('wp_ajax_get_logos', 'get_logos');
add_action('wp_ajax_nopriv_get_logos', 'get_logos');
// Definir la función "get_logos"
function get_logos() {
    global $marcas, $logos, $logo_url;
    // Obtener todos los términos de la taxonomía "marca"
    $marcas = get_terms(array(
        'taxonomy' => 'marca',
        'hide_empty' => false,
    ));
    // Crear un array para almacenar las URLs de los logos
    $logos = array();
    // Recorrer cada marca
    foreach ($marcas as $marca) {
        // Obtener el valor del campo "logo_marca" para esta marca
        $logo = get_field('logo_marca', $marca);
        // Si se ha asignado un logo a esta marca
        if ($logo) {
            // Obtener la URL del logo
            $logo_url = wp_get_attachment_image_url($logo, 'full');
            // Almacenar la URL del logo en el array
            $logos[$marca->term_id] = $logo_url;
        }
    }
    // Devolver los resultados en formato JSON
    wp_send_json($logos);
}



function obtener_modelos_por_marca() {
    global $marca_id, $post_id, $modelos, $opciones, $modelo_seleccionado;
    $marca_id = $_POST['marca_id'];
    $post_id = $_POST['post_id'];
    $args = array(
        'taxonomy' => 'modelo',
        'hide_empty' => false,
        'meta_query' => array(
            array(
                'key' => 'marca_en_modelo',
                'value' => $marca_id,
                'compare' => '='
            )
        )
    );
    $modelos = get_terms($args);
    $opciones = array();
    foreach ($modelos as $modelo) {
        $opciones[] = array(
            'value' => $modelo->term_id,
            'label' => $modelo->name
        );
    }
    $modelo_seleccionado = wp_get_object_terms($post_id, 'modelo', array('fields' => 'ids'));
    echo json_encode(array(
        'opciones' => $opciones,
        'modelo_seleccionado' => !empty($modelo_seleccionado) ? $modelo_seleccionado[0] : null
    ));
    wp_die();
}

add_action('wp_ajax_obtener_modelos_por_marca', 'obtener_modelos_por_marca');
add_action('wp_ajax_nopriv_obtener_modelos_por_marca', 'obtener_modelos_por_marca');


//Guardar modelo. field_649cc8024f999 es el campo grupo y field_648a74a288e72 es el select modelos vacío. 
function guardar_modelo($post_id) {
    global $modelo_id, $modelo, $post_id;
    if (isset($_POST['acf']['field_649cc8024f999']['field_648a74a288e72'])) {
        $modelo_id = $_POST['acf']['field_649cc8024f999']['field_648a74a288e72'];
        $modelo = get_term_by('id', $modelo_id, 'modelo');
        if ($modelo) {
            wp_set_object_terms($post_id, array($modelo->name), 'modelo');
        }
    }
}

add_action('save_post', 'guardar_modelo');


//Añadir modelo
function agregar_modelo() {
    global $modelo_nombre, $marca_id, $modelo_id, $term;
    $modelo_nombre = $_POST['modelo_nombre'];
    $marca_id = $_POST['marca_id'];
    $term = wp_insert_term($modelo_nombre, 'modelo');
    if (!is_wp_error($term)) {
        $modelo_id = $term['term_id'];
        update_field('marca_en_modelo', $marca_id, 'modelo_' . $modelo_id);
        echo json_encode(array(
            'status' => 'success',
            'modelo_id' => $modelo_id
        ));
    } else {
        echo json_encode(array(
            'status' => 'error',
            'message' => $term->get_error_message()
        ));
    }
    wp_die();
}

add_action('wp_ajax_agregar_modelo', 'agregar_modelo');
add_action('wp_ajax_nopriv_agregar_modelo', 'agregar_modelo');


//Función calcular precio financiado
function gv360_calcular_financiado( $post_id ) {
    global $precio, $descuento_financiacion, $precio_financiado;
    // Comprobar si el post es de tipo "coche"
    if ( get_post_type( $post_id ) != 'coche' ) {
        return;
    }
    $precio = get_field( 'precio_y_descuentos_precio', $post_id );
    $descuento_financiacion = get_field( 'precio_y_descuentos_descuento_financiacion', $post_id );
    // Calcular el valor del campo precio_financiado
    $precio_financiado = $precio - $descuento_financiacion;
    update_field( 'precio_y_descuentos_precio_financiado', $precio_financiado, $post_id );
}

function gv360_financiado_solo_lectura( $field ) {
    if ( $field['name'] == 'precio_financiado' ) {
        // Hacer que el campo sea de solo lectura
        $field['readonly'] = 1;
    }
    return $field;
}

add_action( 'acf/save_post', 'gv360_calcular_financiado' );
add_filter( 'acf/load_field', 'gv360_financiado_solo_lectura' );

// Nueva función para manejar la solicitud de AJAX
function gv360_actualizar_precio_financiado() {
    // Obtener el ID del post y los valores de los campos
    $post_id = $_POST['post_id'];
    $precio = $_POST['precio'];
    $descuento_financiacion = $_POST['descuento_financiacion'];
    
    // Calcular el valor del campo precio_financiado
    $precio_financiado = $precio - $descuento_financiacion;
    
    // Actualizar el campo precio_financiado
    update_field( 'precio_y_descuentos_precio_financiado', $precio_financiado, $post_id );
    
    // Devolver el valor calculado
    echo $precio_financiado;
    
    wp_die();
}

add_action( 'wp_ajax_gv360_actualizar_precio_financiado', 'gv360_actualizar_precio_financiado' );
add_action( 'wp_ajax_nopriv_gv360_actualizar_precio_financiado', 'gv360_actualizar_precio_financiado' );

// Registrar la acción de AJAX para usuarios autenticados
add_action('wp_ajax_my_update_field', 'my_update_field');

function my_update_field() {
    // Comprobar si se ha enviado el ID del coche
    if (isset($_POST['coche_id'])) {
        $coche_id = $_POST['coche_id'];

        // Obtener los valores de los campos "precio" y "descuento_financiacion"
        $precio = get_field('precio_y_descuentos_precio', $coche_id);
        $descuento_financiacion = get_field('precio_y_descuentos_descuento_financiacion', $coche_id);

        // Calcular el valor del campo "precio_financiado"
        $precio_financiado = $precio - $descuento_financiacion;

        // Actualizar el valor del campo "precio_financiado"
        update_field('precio_y_descuentos_precio_financiado', $precio_financiado, $coche_id);

        // Devolver una respuesta en formato JSON
        wp_send_json_success(array(
            'message' => 'Campo actualizado correctamente',
            'precio_financiado' => $precio_financiado
        ));
    } else {
        // Devolver un error si no se han enviado los datos necesarios
        wp_send_json_error(array(
            'message' => 'Faltan datos'
        ));
    }
}


// Obtén el valor del campo de opciones de ACF
$contador_facets = '';
if ( function_exists( 'get_field' ) ) {
$contador_facets = get_field('mostrar_contador_facets', 'option');
}
global $wpdb;

// Obtener todos los coches
$coches = get_posts( array(
   'post_type' => 'coche',
   'posts_per_page' => -1
) );

// Inicializar las variables para almacenar los valores mínimo y máximo
$min_price = PHP_INT_MAX;
$max_price = 0;
$min_km = PHP_INT_MAX;
$max_km = 0;
$min_ano = PHP_INT_MAX;
$max_ano = 0;






// Recorrer todos los coches y obtener el precio, los kilómetros, año , etc de cada uno
foreach ( $coches as $coche ) {


   if ( function_exists( 'get_field' ) ) {
       $precio_field = get_field( 'precio_y_descuentos_precio', $coche->ID );
       $km_field = get_field( 'especificaciones_tecnicas_kilometros', $coche->ID );
       $ano_field = get_field( 'datos_generales_ano', $coche->ID );
   } else {
       // Manejar el caso en el que la función get_field no está disponible
       $precio_field = 0;
       $km_field = 0;
       $ano_field = 0;
       error_log( 'Error: La función get_field no está disponible. Por favor, asegúrate de que el plugin Advanced Custom Fields esté activado.' );
       //Sacar del loop, porque si no saldría repetido.
   }

   // Actualizar los valores mínimo y máximo de precio
   if ( $precio_field < $min_price ) {
       $min_price = $precio_field;
   }
   if ( $precio_field > $max_price ) {
       $max_price = $precio_field;
   }

   // Actualizar los valores mínimo y máximo de kilómetros
   if ( $km_field < $min_km ) {
       $min_km = $km_field;
   }
   if ( $km_field > $max_km ) {
       $max_km = $km_field;
   }
   
   // Actualizar los valores mínimo y máximo de Año
   if ( $ano_field < $min_ano ) {
       $min_ano = $ano_field;
   }
   if ( $ano_field > $max_ano ) {
       $max_ano = $ano_field;
   }




}

// Mostrar los valores en la pantalla
/*echo 'Precio mínimo: ' . $min_price;
echo '<br>Precio máximo: ' . $max_price;
echo '<br>Km mínimo: ' . $min_km;
echo '<br>Km máximo: ' . $max_km; 
echo '<br>Año mínimo: ' . $min_ano;
echo '<br>Año máximo: ' . $max_ano;  */

/*Selector min y max precio*/
// Obtener una referencia al selector desplegable



// funciones-ajax.php
add_action('wp_ajax_mi_funcion', 'mi_funcion');
add_action('wp_ajax_nopriv_mi_funcion', 'mi_funcion');

function mi_funcion() {
    global $wpdb;

    // Recupera los valores enviados por AJAX
    $value_tin = $_POST['value_tin'];
    $seguro = $_POST['seguro'];
    $meses = $_POST['meses'];

    // Log para depuración
    error_log("Valor de value_tin: " . $value_tin);
    error_log("Valor de seguro: " . $seguro);
    error_log("Valor de meses: " . $meses);

    // Prepara la consulta SQL
    $tabla = $wpdb->prefix . 'financiacion_360vo';
    $query = "SELECT coeficiente FROM $tabla WHERE tin = %f AND seguro = %d AND meses = %d";
    
    // Ejecuta la consulta SQL
    $coeficiente = $wpdb->get_var($wpdb->prepare($query, $value_tin, $seguro, $meses));

    // Log para depuración
    error_log("Valor de coeficiente: " . $coeficiente);

    // Devuelve el resultado
    echo $coeficiente;

    wp_die();
}

