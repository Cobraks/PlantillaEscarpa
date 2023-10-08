<?php
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

class CF7_Functions {
    public function __construct() {
        if ( function_exists( 'wpcf7' ) ) {
            add_filter( 'wpcf7_special_mail_tags', array($this, 'wpcf7_special_mail_tags_coche'), 10, 3 );
            add_action( 'wpcf7_mail_sent', array($this, 'my_wpcf7_mail_sent_function') );
        }
    }

    public function wpcf7_special_mail_tags_coche( $output, $name, $html ) {
        $submission = WPCF7_Submission::get_instance();
        if ( $submission ) {
            $url = $submission->get_meta( 'url' );
            $postid = url_to_postid( $url );
            $edit_post_url = get_edit_post_link( $postid );
            $name = preg_replace( '/^wpcf7\./', '_', $name ); // for back-compat
            if ( '_field_ano' == $name ) {
                return get_field( 'datos_generales_ano', $postid );
            } elseif ( '_field_kilometros' == $name ) {
                return number_format( get_field( 'especificaciones_tecnicas_kilometros', $postid ), 0, ',', '.' );
            } elseif ( '_field_precio' == $name ) {
                if ( get_field( 'mostrar_contado', 'option' ) ) {
                    return number_format( get_field('precio_y_descuentos_precio', $postid ), 0, ',', '.' );
                } else {
                    return number_format( get_field('precio_y_descuentos_precio_financiado', $postid ), 0, ',', '.' );
                }
            } elseif ( '_field_telefono_principal' == $name ) {
                return get_field( 'correo_y_telefono_telefono_principal', 'option' );
            } elseif ( '_field_correo_principal' == $name ) {
                return get_field( 'correo_y_telefono_correo_principal', 'option' );
            } elseif ( '_direccion_concesionario' == $name ) {
                $direccion = get_field( 'direccion_del_concesionario', 'option' );
                return $direccion['direccion'] . ', ' . $direccion['codigo_postal'] . ', ' . $direccion['localidad'] . ', ' . $direccion['provincia'];
            } elseif ( '_logotipo_png' == $name ) {
                return get_field( 'logotipo_png', 'option' );
            }  elseif ( '_editar_coche' == $name ) {
                return $edit_post_url;
            } elseif ( '_texto_precio' == $name ) {
                if ( get_field( 'mostrar_contado', 'option' ) ) {
                    return "Precio";
                } else {
                    return "Precio financiado";
                }
            } elseif ( '_taxonomia_modelo' == $name ) {
                // Obtener los términos de la taxonomía "modelo" para el post con ID `$postid`
                // y devolver el nombre del primer término
                return wp_list_pluck(wp_get_post_terms($postid, 'modelo'), 'name')[0];
            } elseif ( '_taxonomia_marca' == $name ) {
                // Obtener los términos de la taxonomía "marca" para el post con ID `$postid`
                // y devolver el nombre del primer término
                return wp_list_pluck(wp_get_post_terms($postid, 'marca'), 'name')[0];
            } elseif ( '_taxonomia_carroceria' == $name ) {
                // Obtener los términos de la taxonomía "carroceria" para el post con ID `$postid`
                // y devolver el nombre del primer término
                return wp_list_pluck(wp_get_post_terms($postid, 'carroceria'), 'name')[0];
            }  elseif ( '_logo_marca_png' == $name ) {
                // Obtener los términos de la taxonomía "marca" para el post con ID `$postid`
                $terms = wp_get_post_terms($postid, 'marca');
                if (!empty($terms) && !is_wp_error($terms)) {
                    // Obtener el primer término
                    $term = reset($terms);
                    // Obtener el valor del campo personalizado "logo_marca_png" del término
                    if(function_exists('get_field')){
                        // ACF está activo
                        // Obtener el valor del campo personalizado "logo_marca_png" del término
                        $image_id = get_field('logo_marca_png', $term);
                    } else {
                        // ACF no está activo
                        // Obtener el valor del campo personalizado "logo_marca_png" del término
                        $image_id = get_term_meta($term->term_id, 'logo_marca_png', true);
                    }
                    if ($image_id) {
                        // Obtener la URL de la imagen y devolverla
                        return wp_get_attachment_image_url($image_id, 'full');
                    }
                }
            } elseif ( '_correo_principal' == $name ) {
                return get_field( 'correo_y_telefono_correo_principal', 'option' );
            }
        }
        return $output;
    }

    public function my_wpcf7_mail_sent_function( $contact_form ) {
        // Obtener el título del formulario
        $form_title = $contact_form->title();
        // Comprobar si el título del formulario es el que nos interesa
        if ( $form_title == 'Me interesa' ) { // Reemplaza 'Me interesa' por el título de tu formulario
            // Este es el formulario que nos interesa
            $submission = WPCF7_Submission::get_instance();
            if ( $submission ) {
                // Obtener los datos del formulario
                $posted_data = $submission->get_posted_data();
                // Obtener la URL de la página desde donde se envió el formulario
                $url = $submission->get_meta( 'url' );
                // Obtener el ID del post a partir de la URL
                $postid = url_to_postid( $url );
                // Obtener los valores de los campos del formulario
                $nombre_cliente_reserva = $posted_data['nombre_cliente_ficha'];
                $telefono_cliente = $posted_data['telefono_cliente_ficha'];
                $correo_cliente = $posted_data['email_cliente_ficha'];
                $fecha_hora_consulta = date('Y-m-d H:i:s');
                // Crear un nuevo valor para el repeater field
                $new_value = array(
                    'nombre_cliente_reserva' => $nombre_cliente_reserva,
                    'telefono_cliente' => $telefono_cliente,
                    'correo_cliente' => $correo_cliente,
                    'fecha_hora_consulta' => $fecha_hora_consulta,
                    'enlace_telefono' => array(
                        'title' => 'Llamar',
                        'url' => 'tel:' . $telefono_cliente,
                        'target' => ''
                    ),
                    'enlace_correo' => array(
                        'title' => 'Enviar correo',
                        'url' => 'tel:' . $correo_cliente,
                        'target' => ''
                    ),
                );
                // Agregar el nuevo valor al final del repeater field utilizando la función "add_row" de ACF
                add_row( 'clientes_interesados', $new_value, $postid );
            }
        }
    }
}

