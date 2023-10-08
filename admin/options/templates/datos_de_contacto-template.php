<?php
    // Mostrar título de la página
    echo '<h1>Datos de contacto</h1>';

    // Incluir archivos de JavaScript y CSS de ACF
    acf_enqueue_scripts();
    wp_enqueue_style('acf-global');

    // Obtener grupos de campos asignados a la subpágina de ayuda
    $field_groups = acf_get_field_groups(array(
        'options_page' => 'th360_datos_de_contacto'
    ));

    // Mostrar campos personalizados utilizando acf_form
    if (!empty($field_groups)) {
        acf_form(array(
            'post_id' => 'options',
            'field_groups' => wp_list_pluck($field_groups, 'key'),
            'submit_value' => 'Guardar datos de contacto'
        ));
    }