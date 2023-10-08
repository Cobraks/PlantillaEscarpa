// Agregar un controlador de eventos para el evento click del botón "Ocultar esta petición"
jQuery(document).on('click', '.ocultar-peticion', function(e) {
    // Evitar el comportamiento predeterminado del botón
    e.preventDefault();
    // Obtener el ID del post y el índice de la fila del campo repetidor
    var postId = jQuery(this).data('post-id');
    var clienteIndex = jQuery(this).data('cliente-index');
    // Agregar registros de depuración
    console.log('postId:', postId);
    console.log('clienteIndex:', clienteIndex);
    // Enviar una solicitud AJAX a WordPress para actualizar el valor del campo ocultar_peticion
    jQuery.post(gv360_ajax.ajaxUrl, {
        action: 'ocultar_peticion',
        nonce: gv360_ajax.nonce,
        post_id: postId,
        cliente_index: clienteIndex
    }, function(response) {
        // Comprobar si la respuesta es exitosa
        if (response.success) {
            // Ocultar el elemento que contiene la petición
            jQuery(e.target).closest('div').hide();
            // Mostrar un mensaje de confirmación
            alert('Petición oculta. Puedes seguir viéndola en Mensajes o en la ficha de cada coche (desde donde también puedes volver a mostrarla aquí) ');
        } else {
            // Mostrar un mensaje de error
            alert('Ha ocurrido un error al ocultar la petición');
        }
    });
});
