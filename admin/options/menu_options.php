<?php
ob_start();//Poniendo esto, no genero el problema de los encabezados html
/**
* Añadir páginas de opciones para el menú de administración
*
*
* @package 360vo-theme
*/
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title' => 'Opciones de Finasssnciación',
        'menu_title' => 'Financiacióssssn',
        'menu_slug' => 'financiacionssss-360vo',
        'capability' => 'manage_options',
        'redirect' => false,
        'position' => 2,
        'icon_url' => 'dashicons-money-alt',
    ));
}


add_filter('acf/location/rule_values/options_page', 'localizar_opciones');
function localizar_opciones($choices) {
    $choices['ajustes_de_visualizacion'] = 'Ajustes de visualización';
    $choices['datos_de_contacto'] = 'Datos de contacto';
    $choices['personalizacion'] = 'Personalización';
    $choices['ayuda'] = 'Ayuda';
    return $choices;
}

    add_action('admin_menu', 'th360_add_menu_pages');
    function th360_add_menu_pages() {
        // Agregar página de opciones principal
        add_menu_page(
            'Gestión 360', // page title
            'Gestión 360', // menu title
            'edit_theme_options', // capability
            'gestion_360', // menu slug
            'th360_gestion_360_callback', // callback function
            'dashicons-admin-generic', // icon url
            3 // position
        );

        // Agregar subpáginas
        add_submenu_page(
            'gestion_360', // parent slug
            'Ajustes de visualización', // page title
            'Ajustes de visualización', // menu title
            'edit_theme_options', // capability
            'ajustes_de_visualizacion', // menu slug
            'th360_ajustes_de_visualizacion_callback' // callback function
        );
        add_submenu_page(
            'gestion_360',
            'Datos de contacto',
            'Datos de contacto',
            'edit_theme_options',
            'datos_de_contacto',
            'th360_datos_de_contacto_callback'
        );
        add_submenu_page(
            'gestion_360',
            'Personalización',
            'Personalización',
            'edit_theme_options',
            'personalizacion',
            'th360_personalizacion_callback'
        );
        add_submenu_page(
            'gestion_360',
            'Ayuda',
            'Ayuda',
            'edit_theme_options',
            'ayuda',
            'th360_ayuda_callback'
        );
    }

    //Añadir los estilos y js de ACF (cargarlo en todos los callbacks)
    function th360_enqueue_acf_scripts() {
        acf_enqueue_scripts();
        wp_enqueue_style('acf-global');
    }

    function th360_render_menu() {
        // Obtener el título de la página actual
        $current_page_title = get_admin_page_title();

        // Crear un array con las subpáginas y sus títulos
        $subpages = array(
            'ajustes_de_visualizacion' => 'Ajustes de visualización',
            'datos_de_contacto' => 'Datos de contacto',
            // Agregar más subpáginas aquí
        );

        // Iniciar la variable que contendrá el código HTML
        $html = '<ul class="th360-menu">';

        // Recorrer las subpáginas
        foreach ($subpages as $slug => $title) {
            // Agregar un elemento de lista para cada subpágina
            $html .= '<li>';

            // Si la subpágina es la página actual, agregar una clase al enlace
            if ($title === $current_page_title) {
                $html .= '<a href="' . admin_url('admin.php?page=' . $slug) . '" class="th360-current-page">' . $title . '</a>';
            } else {
                $html .= '<a href="' . admin_url('admin.php?page=' . $slug) . '">' . $title . '</a>';
            }

            $html .= '</li>';
        }

        // Finalizar la lista desordenada
        $html .= '</ul>';

        // Mostrar el código HTML
        echo $html;
    }

    // Funciones de devolución de llamada para generar el contenido de las páginas
    function th360_gestion_360_callback() {
        acf_form_head();
        include GV360_PLUGIN_DIR . 'admin/options/templates/gestion_360.php';
    }

    function th360_ajustes_de_visualizacion_callback() {
        // Llamar a acf_form_head()
        acf_form_head();
        // Incluir archivos de JavaScript y CSS de ACF
        th360_enqueue_acf_scripts();
        echo '<div class="wrap">';

        // Mostrar título de la página
        include GV360_PLUGIN_DIR . 'admin/options/templates/ajustes_de_visualizacion.php';

        echo '<div class="notice notice-info">';
        echo '<p>Este es un mensaje de atención.</p>';
        echo '</div>';

        // Mostrar menú
        th360_render_menu();

        // Obtener grupos de campos asignados a la subpágina de ayuda
        $field_groups = acf_get_field_groups(array(
            'options_page' => 'ajustes_de_visualizacion'
        ));

        // Mostrar campos personalizados utilizando acf_form
        if (!empty($field_groups)) {
            acf_form(array(
                'id' => 'ajustes_de_visualizacion',
                'post_id' => 'options',
                'field_groups' => wp_list_pluck($field_groups, 'key'),
                'submit_value' => 'Guardar opciones'
            ));
        }

        echo '</div>';
    }

    function th360_datos_de_contacto_callback() {
        acf_form_head();
        th360_enqueue_acf_scripts();
        echo '<div class="wrap">';
        // Mostrar título de la página
        echo '<h1>Datos de contacto</h1>';

        // Incluir archivos de JavaScript y CSS de ACF
        th360_enqueue_acf_scripts();

        // Obtener grupos de campos asignados a la subpágina de ayuda
        $field_groups = acf_get_field_groups(array(
            'options_page' => 'datos_de_contacto'
        ));

        // Mostrar campos personalizados utilizando acf_form
        if (!empty($field_groups)) {
            acf_form(array(
                'id' => 'datos_de_contacto',
                'post_id' => 'options',
                'field_groups' => wp_list_pluck($field_groups, 'key'),
                'submit_value' => 'Guardar datos de contacto'
            ));
        }
        echo '</div>';
    }


    function th360_personalizacion_callback() {
        acf_form_head();
        th360_enqueue_acf_scripts();
        echo '<div class="wrap">';
        // Mostrar título de la página
    echo '<h1>Personalización</h1>';
      //  include GV360_PLUGIN_DIR . 'admin/options/templates/personalizacion.php';
        echo '<div class="notice notice-warning">';
        echo '<p>Algunas de estas opciones deberían de cambiarse <b>una sola vez</b>. Si se cambian a menudo, perdemos posicionamiento SEO, ya que las URL del stock, de las carrocerías, de las marcas y de los coches cambiarán. Es por eso que <b>solo los administradores pueden modificarlas</b></p>';
        echo '</div>';
            // Mostrar menú
    th360_render_menu(); 
        
    echo '<div class="edit-post-layout__metaboxes">';
    echo '<div class="edit-post-meta-boxes-area is-normal">';
        // Obtener grupos de campos asignados a la subpágina de ayuda
        $field_groups = acf_get_field_groups(array(
            'options_page' => 'personalizacion'
        ));

        // Mostrar campos personalizados utilizando acf_form
        if (!empty($field_groups)) {
            acf_form(array(
                'id' => 'personalizacion',
                'post_id' => 'options',
                'field_groups' => wp_list_pluck($field_groups, 'key'),
                'submit_value' => 'Guardar ajustes'
            ));
        }
        echo '</div>';
        echo '</div>';
    }

    function th360_ajustes_avanzados_callback() {
        acf_form_head();
        th360_enqueue_acf_scripts();
        echo '<h1>Ajustes avanzados</h1>';
    
    }
    function th360_ayuda_callback() {
        acf_form_head();
        th360_enqueue_acf_scripts();

        echo '<div class="wrap">';
        include GV360_PLUGIN_DIR . 'admin/options/templates/ayuda.php';
        
        echo '</div>';
    }

    add_action('acf/save_post', 'my_acf_save_post', 20);
    function my_acf_save_post($post_id) {
        // Comprobar si se está guardando una página de opciones
        if ($post_id == 'options') {
            // Obtener el slug de la subpágina actual
            $page = isset($_GET['page']) ? $_GET['page'] : '';
    
            // Ejecutar diferentes acciones en función de la subpágina que se está guardando
            switch ($page) {
                case 'personalizacion':
                    // Recargar los archivos necesarios
                    require_once GV360_PLUGIN_DIR . 'includes/taxonomies.php';
                    require_once GV360_PLUGIN_DIR . 'includes/pre_get_posts.php';
                    require_once GV360_PLUGIN_DIR . 'includes/post_type_coche.php';
    
                    // Eliminar la opción rewrite_rules para actualizar los enlaces permanentes
                    delete_option('rewrite_rules');
                    break;
                // Agregar más casos aquí para otras subpáginas
            }
        }
    }
    
    add_action('admin_head', 'my_acf_form_success_message_css');
    function my_acf_form_success_message_css() {
        // Comprobar si estamos en una página de opciones
        if (isset($_GET['page'])) {
            // Ocultar el mensaje "Publicación actualizada"
            ?>
            <style type="text/css">
                #message.updated {
                    display: none;
                }
            </style>
            <?php
        }
    }
    

add_action('admin_notices', 'my_acf_form_success_message_notice');
function my_acf_form_success_message_notice() {
    // Comprobar si estamos en una página de opciones
    if (isset($_GET['page'])) {
        // Comprobar si se ha guardado el formulario
        if (isset($_GET['updated']) && $_GET['updated'] == 'true') {
            // Mostrar un mensaje diferente en cada página de opciones
            switch ($_GET['page']) {
                case 'personalizacion':
                    $message = 'Opciones de personalización guardadas correctamente';
                    break;
                case 'gestion_360':
                    $message = 'Opciones guardadas correctamente';
                    break;
                case 'datos_de_contacto':
                    $message = 'Datos de contacto guardados correctamente';
                    break;
                case 'ajustes_de_visualizacion':
                    $message = 'Ajustes de visualización guardados correctamente';
                    break;
                default:
                    $message = '';
            }

            // Mostrar el mensaje personalizado
            if (!empty($message)) {
                ?>
                <div class="notice notice-success is-dismissible">
                    <p><?php echo $message; ?></p>
                </div>
                <?php
            }
        }
    }
}

