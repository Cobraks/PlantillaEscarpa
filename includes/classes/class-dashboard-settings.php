<?php
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );
class DashboardSettings {
    public function __construct() {
        if (is_admin()) {
            add_filter('dashboard_glance_items', array($this, 'my_add_cpt_and_taxonomies_to_dashboard'));
            add_action('wp_dashboard_setup', array($this, 'remove_quick_draft_widget'));
            add_action('wp_dashboard_setup', array($this, 'add_clientes_interesados_dashboard_widget'));
            add_filter('dashboard_recent_posts_query_args', array($this, 'agregar_coche_a_actividad_escritorio'));
            add_action('admin_menu', array($this, 'ocultar_menu_comentarios')); 
            add_action('wp_ajax_ocultar_peticion', array($this, 'gv360_ocultar_peticion'));
        }
    }

    public function my_add_cpt_and_taxonomies_to_dashboard() {
         // Add "coche" post type to "At a Glance" widget
        $num_posts = wp_count_posts( 'coche' );
        $num = number_format_i18n( $num_posts->publish );
        $text = _n( 'Coche', 'Coches', intval($num_posts->publish) );
        $text = sprintf( '%s %s', $num, $text );
        echo '<li class="post-count coche-count"><a href="edit.php?post_type=coche">'.$text.'</a></li>';
        // Add "marca" taxonomy to "At a Glance" widget
        $num_terms = wp_count_terms( 'marca' );
        $num = number_format_i18n( $num_terms );
        $text = _n( 'Marca', 'Marcas', intval($num_terms) );
        $text = sprintf( '%s %s', $num, $text );
        echo '<li class="post-count marca-count"><a href="edit-tags.php?taxonomy=marca">'.$text.'</a></li>';
        // Add "carroceria" taxonomy to "At a Glance" widget
        $num_terms = wp_count_terms( 'carroceria' );
        $num = number_format_i18n( $num_terms );
        $text = _n( 'Carrocería', 'Carrocerías', intval($num_terms) );
        $text = sprintf( '%s %s', $num, $text );
        echo '<li class="post-count carroceria-count"><a href="edit-tags.php?taxonomy=carroceria">'.$text.'</a></li>';
        error_log( 'At a glance' );
    }

    public function remove_quick_draft_widget() {
         //Eliminar borrador rápido
         error_log( 'Eliminar borrador rápido' );
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    }

    public function agregar_coche_a_actividad_escritorio($args) {
        if ( ! is_array( $args ) ) {
            $args = array();
        }
        $args['post_type'] = array( 'post', 'page', 'coche' );
        error_log( 'Agregar coche a actividad - ' . uniqid() );
        return $args;
    }

    public function ocultar_menu_comentarios() {
        remove_menu_page( 'edit-comments.php' ); // Elimina el menú de comentarios
    }

    public function add_clientes_interesados_dashboard_widget() {
        wp_add_dashboard_widget(
            'clientes_interesados_dashboard_widget',
            'Clientes interesados',
            array($this, 'display_clientes_interesados_dashboard_widget')
        );
    }

    public function display_clientes_interesados_dashboard_widget() {
          // Obtener todos los posts de tipo "coche"
        $args = array(
            'post_type' => 'coche',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'clientes_interesados',
                    'compare' => 'EXISTS'
                )
            )
        );
        $query = new WP_Query( $args );
        $clientes = array();
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                // Obtener los valores del campo personalizado "clientes_interesados" utilizando la función "get_field" de ACF
                $clientes_interesados = get_field( 'clientes_interesados' );
                if ( ! empty( $clientes_interesados ) && is_array( $clientes_interesados ) ) {
                    foreach ( $clientes_interesados as $cliente ) {
                    // Comprobar si el campo "ocultar_peticion" está establecido en "false"
                        if ( isset( $cliente['ocultar_peticion'] ) && ! $cliente['ocultar_peticion'] ) {
                            // Agregar el cliente al array de clientes
                            $cliente['post_id'] = get_the_ID();
                            $cliente['post_title'] = get_the_title();
                            $cliente['post_permalink'] = get_the_permalink();
                            // Obtener el valor del campo personalizado "otros_datos_portada_coche"
                            $image_id = get_field( 'otros_datos_portada_coche' );
                            if ( ! empty( $image_id ) ) {
                                // Obtener la URL de la imagen a partir del ID de la imagen
                                $cliente['post_image'] = wp_get_attachment_image_url( $image_id, 'full' );
                            }
                            $clientes[] = $cliente;
                        }
                    }
                }
            }
        }
        wp_reset_postdata();
        // Ordenar el array de clientes por fecha y hora de consulta
        usort( $clientes, function( $a, $b ) {
            return strtotime( $b['fecha_hora_consulta'] ) - strtotime( $a['fecha_hora_consulta'] );
        });
        // Mostrar los 10 clientes más recientes
        for ( $i = 0; $i < min( 10, count( $clientes ) ); $i++ ) {
            // Mostrar los valores del campo personalizado
            echo '<div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">';
            echo '<h3><a href="' . esc_url( $clientes[$i]['post_permalink'] ) . '">' . esc_html( $clientes[$i]['post_title'] ) . '</a></h3>';
            // Mostrar la imagen del coche
            if ( ! empty( $clientes[$i]['post_image'] ) ) {
                echo '<img src="' . esc_url( $clientes[$i]['post_image'] ) . '" alt="' . esc_attr( get_the_title() ) . '" style="width: 100%; max-width: 300px; height: auto;">';
            }
            echo '<ul>';
            echo '<li>';
            echo '<strong>Nombre del cliente:</strong> ' . esc_html( $clientes[$i]['nombre_cliente_reserva'] ) . '<br>';
            echo '<strong>Fecha y hora de consulta:</strong> ' . esc_html( $clientes[$i]['fecha_hora_consulta'] ) . '<br>';
            if ( isset( $clientes[$i]['enlace_telefono'] ) && is_string( $clientes[$i]['enlace_telefono'] ) ) {
                echo '<strong>Teléfono del cliente:</strong> <a href="' . esc_url( $clientes[$i]['enlace_telefono'] ) . '">' . esc_html( $clientes[$i]['telefono_cliente'] ) . '</a><br>';
            }
            if ( isset( $clientes[$i]['enlace_correo'] ) && is_string( $clientes[$i]['enlace_correo'] ) ) {
                echo '<strong>Email del cliente:</strong> <a href="' . esc_url( $clientes[$i]['enlace_correo'] ) . '">' . esc_html( $clientes[$i]['correo_cliente'] ) . '</a><br>';
            }
            // Mostrar el botón "Ocultar esta petición"
            echo '<button class="ocultar-peticion" data-post-id="' . esc_attr( $clientes[$i]['post_id'] ) . '" data-cliente-index="' . esc_attr( $i ) . '">Ocultar esta petición</button>';
            echo '</li>';
            echo '</ul>';
            echo '</div>';
        }
    }

    public function gv360_ocultar_peticion() {
        // Verificar el nonce
        if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'gv360-nonce' ) ) {
        // Enviar una respuesta de error
            wp_send_json_error( array( 'message' => 'Nonce inválido' ) );
        }
        // Obtener los parámetros de la solicitud
        $post_id = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0;
        $cliente_index = isset( $_POST['cliente_index'] ) ? intval( $_POST['cliente_index'] ) : 0;
        // Agregar registros de depuración
        error_log('gv360_ocultar_peticion: post_id = ' . $post_id);
        error_log('gv360_ocultar_peticion: cliente_index = ' . $cliente_index);
        // Comprobar si los parámetros son válidos
        if ( $post_id > 0 && $cliente_index >= 0 ) {
            // Actualizar el valor del campo ocultar_peticion a true utilizando la función update_row de ACF
            $updated = update_row( 'clientes_interesados', $cliente_index + 1, array( 'ocultar_peticion' => true ), $post_id );
            // Comprobar si la actualización fue exitosa
            if ( $updated ) {
                // Enviar una respuesta de éxito
                wp_send_json_success();
            } else {
                // Agregar un registro de depuración
                error_log( 'gv360_ocultar_peticion: No se pudo actualizar el campo' );
                // Enviar una respuesta de error
                wp_send_json_error( array( 'message' => 'No se pudo actualizar el campo' ) );
            }
        } else {
            // Agregar un registro de depuración
            error_log( 'gv360_ocultar_peticion: Parámetros inválidos' );
            // Enviar una respuesta de error
            wp_send_json_error( array( 'message' => 'Parámetros inválidos' ) );
        }
    }
}

new DashboardSettings();
