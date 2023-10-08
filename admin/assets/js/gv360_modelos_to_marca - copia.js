jQuery(document).ready(function($) {


/*Logos de marcas en edición de coche*/
// Crear un objeto para almacenar las URLs de los logos
var logos = {};
// Hacer una consulta AJAX para obtener las URLs de los logos
$.ajax({
    url: '/wp-admin/admin-ajax.php',
    type: 'POST',
    data: {
        action: 'get_logos'
    },
    success: function(response) {
        console.log('Respuesta AJAX:', response);
        // Almacenar las URLs obtenidas en el objeto "logos"
        logos = response;
        // Agregar las imágenes a las opciones existentes
        $('#marca_edit input[type="radio"]').each(function() {
            var marca_id = $(this).val();
            if (logos[marca_id]) {
                $(this).next('span').prepend('<img src="' + logos[marca_id] + '" width="16" height="16"> ');
            }
        });
    }
});

   // Calculadora precio tiempo real AJAX
   var $precio = $('[data-name="precio"] input');
   var $descuento_financiacion = $('[data-name="descuento_financiacion"] input');
   var $precio_financiado = $('[data-name="precio_financiado"] input');
   
   // Crear un elemento para mostrar el mensaje de "Calculando..."
   var $calculando = $('<span>Calculando...</span>').insertBefore($precio_financiado).hide();
   
   // Escuchar cambios en los campos precio y descuento_financiacion
   $precio.add($descuento_financiacion).on('input', function() {
       // Esconder el campo precio_financiado y mostrar el mensaje de "Calculando..."
       $precio_financiado.hide();
       $calculando.show();
       
       // Obtener el ID del post y los valores de los campos
       var post_id = gv360_data.post_id;
       var precio = $precio.val();
       var descuento_financiacion = $descuento_financiacion.val();
       
       // Enviar la solicitud de AJAX
       $.post(ajaxurl, {
           action: 'gv360_actualizar_precio_financiado',
           post_id: post_id,
           precio: precio,
           descuento_financiacion: descuento_financiacion
       }, function(response) {
           // Actualizar el valor del campo precio_financiado
           $precio_financiado.val(response);
           
           // Mostrar el campo precio_financiado y ocultar el mensaje de "Calculando..."
           $precio_financiado.show();
           $calculando.hide();
       });
   });










   


// Detectar el valor seleccionado en el campo "marca" al cargar la página
var marca = $('#marca_edit input[type="radio"]:checked').val();
// Obtener el nombre de la marca seleccionada
var marca_name = $('#marca_edit input[type="radio"]:checked').next('span').text();
console.log('Marca seleccionada al cargar la página:', marca_name);
// Mostrar un mensaje en el campo "select_modelo_marca" mientras se cargan los modelos
$('#modelo_seleccionar select').empty();
$('#modelo_seleccionar select').append('<option value="">Cargando los modelos de ' + marca_name + '...</option>');
// Hacer una consulta AJAX para obtener los modelos de esa marca
$.ajax({
    url: '/wp-admin/admin-ajax.php',
    type: 'POST',
    data: {
        action: 'get_modelos',
        marca: marca
    },
    success: function(response) {
        console.log('Respuesta AJAX:', response);
        // Vaciar el campo "select_modelo_marca"
        $('#modelo_seleccionar select').empty();
        // Añadir las opciones obtenidas al campo "select_modelo_marca"
        $.each(response, function(index, value) {
            $('#modelo_seleccionar select').append('<option value="' + value + '">' + value + '</option>');
        });
        // Seleccionar el valor de la taxonomía "modelo" en el campo "select_modelo_marca"
        $('#modelo_seleccionar select').val(gv360_data.modelo);
    }
});








// Crear el botón y el campo de texto
// Crear los botones y el campo de texto
$('#modelo_seleccionar').append('<button id="show_add_modelo_button">Añadir modelo a [marca]</button>');
$('#modelo_seleccionar').append('<div id="add_modelo_container" style="display: none;"><input type="text" id="add_modelo_input"><button id="add_modelo_button">Añadir modelo</button></div>');

// Actualizar el texto del botón con el nombre de la marca seleccionada
function update_button_text() {
    // Obtener el nombre de la marca seleccionada
    var marca_name = $('#marca_edit input[type="radio"]:checked').next('span').text();
    // Actualizar el texto del botón y del campo de texto
    $('#show_add_modelo_button').text('Añadir modelo a ' + marca_name);
    $('#add_modelo_input').attr('placeholder', 'Escribe el nombre para el modelo de ' + marca_name);
}
update_button_text();

// Detectar cuándo se hace clic en el botón "Añadir modelo a [marca]"
$('#show_add_modelo_button').click(function() {
    // Mostrar el contenedor para añadir un nuevo modelo
    $('#add_modelo_container').show();
});

// Detectar cuándo se hace clic en el botón "Añadir"
$('#add_modelo_button').click(function() {
    // Obtener el valor del campo de texto
    var modelo_name = $('#add_modelo_input').val();
    // Obtener el nombre de la marca seleccionada
    var marca_name = $('#marca_edit input[type="radio"]:checked').next('span').text();
    // Mostrar un mensaje en el campo "select_modelo_marca" mientras se está creando la taxonomía
    $('#modelo_seleccionar select').append('<option value="">Añadiendo ' + modelo_name + '... Espera</option>');
    $('#modelo_seleccionar select').val('');
    // Obtener la marca seleccionada
    var marca = $('#marca_edit input[type="radio"]:checked').val();
    // Hacer una consulta AJAX para guardar el nuevo modelo
    $.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: 'POST',
        data: {
            action: 'add_modelo',
            modelo_name: modelo_name,
            marca: marca
        },
        success: function(response) {
            console.log('Respuesta AJAX:', response);
            // Eliminar el mensaje de "cargando" del campo "select_modelo_marca"
            $('#modelo_seleccionar select option[value=""]').remove();
            // Añadir la nueva opción al campo "select_modelo_marca"
            $('#modelo_seleccionar select').append('<option value="' + modelo_name + '">' + modelo_name + '</option>');
            // Seleccionar la nueva opción
            $('#modelo_seleccionar select').val(modelo_name);
            // Ocultar el contenedor para añadir un nuevo modelo
            $('#add_modelo_container').hide();
        }
    });
});







// Detectar cuándo se cambia la marca seleccionada
$('#marca_edit input[type="radio"]').change(function() {
    // Actualizar el texto del botón con el nuevo nombre de la marca seleccionada
    update_button_text();
});



/*

    // Detectar cambios en los campos que quieres actualizar en tiempo real
    // Usa selectores de atributos para seleccionar los campos por su nombre en lugar de por su ID
    $('[data-name="precio_y_descuentos_precio"], [data-name="precio_y_descuentos_descuento_financiacion"]').on('change', function() {
        // Obtener el ID del coche usando la función get_the_ID() de WordPress
        var coche_id = get_the_ID();

        // Enviar una llamada AJAX a la función PHP para actualizar el valor del campo
        $.post(ajaxurl, {
            action: 'my_update_field',
            coche_id: coche_id
        }, function(response) {
            if (response.success) {
                // Mostrar un mensaje de éxito si el campo se ha actualizado correctamente
                alert(response.data.message);
                // Actualizar el valor del campo "precio_financiado" en la página
                // Usa un selector de atributos para seleccionar el campo por su nombre en lugar de por su ID
                $('[data-name="precio_y_descuentos_precio_financiado"]').val(response.data.precio_financiado);
            } else {
                // Mostrar un mensaje de error si ha ocurrido un problema al actualizar el campo
                alert(response.data.message);
            }
        });
    });
*/

















    /*

    console.log('Script gv360_modelos_to-marca.js cargado correctamente');

    // Crear un objeto para almacenar las URLs de los logos
    var logos = {};

    // Hacer una consulta AJAX para obtener las URLs de los logos
    $.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: 'POST',
        data: {
            action: 'get_logos'
        },
        success: function(response) {
            console.log('Respuesta AJAX:', response);
            // Almacenar las URLs obtenidas en el objeto "logos"
            logos = response;
            // Agregar las imágenes a las opciones existentes
            $('#marca_edit input[type="radio"]').each(function() {
                var marca_id = $(this).val();
                if (logos[marca_id]) {
                    $(this).next('span').prepend('<img src="' + logos[marca_id] + '" width="16" height="16"> ');
                }
            });
        }
    });

    // Detectar cambios en el campo "marca"
    $('#marca_edit input[type="radio"]').change(function() {
        // ...
        // Añadir las opciones obtenidas al campo "select_modelo_marca"
        $.each(response, function(index, value) {
            $('#modelo_seleccionar select').append('<option value="' + value + '">' + value + '</option>');
        });
        // Añadir una opción "Añadir nuevo modelo" al campo "select_modelo_marca"
        $('#modelo_seleccionar select').append('<option value="add_new">Añadir nuevo modelo</option>');
    });

    // Detectar el valor seleccionado en el campo "marca" al cargar la página
    var marca = $('#marca_edit input[type="radio"]:checked').val();
    // Obtener el nombre de la marca seleccionada
    var marca_name = $('#marca_edit input[type="radio"]:checked').next('span').text();
    console.log('Marca seleccionada al cargar la página:', marca_name);
    // Mostrar un mensaje en el campo "select_modelo_marca" mientras se cargan los modelos
    $('#modelo_seleccionar select').empty();
    $('#modelo_seleccionar select').append('<option value="">Cargando los modelos de ' + marca_name + '...</option>');
    // Hacer una consulta AJAX para obtener los modelos de esa marca
    $.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: 'POST',
        data: {
            action: 'get_modelos',
            marca: marca
        },
        success: function(response) {
            console.log('Respuesta AJAX:', response);
            // Vaciar el campo "select_modelo_marca"
            $('#modelo_seleccionar select').empty();
            // Añadir las opciones obtenidas al campo "select_modelo_marca"
            $.each(response, function(index, value) {
                $('#modelo_seleccionar select').append('<option value="' + value + '">' + value + '</option>');
            });
            // Añadir una opción "Añadir nuevo modelo" al campo "select_modelo_marca"
            $('#modelo_seleccionar select').append('<option value="add_new">Añadir nuevo modelo</option>');
            // Seleccionar el valor de la taxonomía "modelo" en el campo "select_modelo_marca"
            $('#modelo_seleccionar select').val(gv360_data.modelo);
        }
    });

    // Detectar cambios en el campo "select_modelo_marca"
    $('#modelo_seleccionar select').change(function() {
        // Obtener el valor seleccionado
        var selectedValue = $(this).val();
        // Si el usuario ha seleccionado la opción "Añadir nuevo modelo"
        if (selectedValue == 'add_new') {
            // Mostrar un formulario para ingresar el nombre del nuevo modelo
            var nombreModelo = prompt('Ingrese el nombre del nuevo modelo:');
            // Obtener la marca seleccionada
            var marcaModelo = $('#marca_edit input[type="radio"]:checked').val();
            // Utilizar AJAX para enviar la información del nuevo modelo al servidor
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'anadir_modelo',
                    nombre: nombreModelo,
                    marca: marcaModelo
                },
                success: function(response) {
                    // Actualizar el campo de selección de modelos para incluir el nuevo modelo
                    $('#modelo_seleccionar select').append('<option value="' + nombreModelo + '">' + nombreModelo + '</option>');
                    // Seleccionar el nuevo modelo en el campo "select_modelo_marca"
                    $('#modelo_seleccionar select').val(nombreModelo);
                }
            });
        }
    });



*/



























    /*
    // Crear un objeto para almacenar las URLs de los logos
    var logos = {};

    // Hacer una consulta AJAX para obtener las URLs de los logos
    $.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: 'POST',
        data: {
            action: 'get_logos'
        },
        success: function(response) {
            console.log('Respuesta AJAX:', response);
            // Almacenar las URLs obtenidas en el objeto "logos"
            logos = response;
            // Agregar las imágenes a las opciones existentes
            $('#marca_edit input[type="radio"]').each(function() {
                var marca_id = $(this).val();
                if (logos[marca_id]) {
                    $(this).next('span').prepend('<img src="' + logos[marca_id] + '" width="16" height="16"> ');
                }
            });
        }
    });

    // Detectar cambios en el campo "marca"
    $('#marca_edit input[type="radio"]').change(function() {
        console.log('Evento change disparado en el campo "marca"');
        // Obtener el valor seleccionado
        var marca = $(this).val();
        // Obtener el nombre de la marca seleccionada
        var marca_name = $(this).next('span').text();
        console.log('Marca seleccionada:', marca_name);
        // Mostrar un mensaje en el campo "select_modelo_marca" mientras se cargan los modelos
        $('#modelo_seleccionar select').empty();
        $('#modelo_seleccionar select').append('<option value="">Cargando los modelos de ' + marca_name + '...</option>');
        // Hacer una consulta AJAX para obtener los modelos de esa marca
        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'get_modelos',
                marca: marca
            },
            success: function(response) {
                console.log('Respuesta AJAX:', response);
                // Vaciar el campo "select_modelo_marca"
                $('#modelo_seleccionar select').empty();
                // Añadir las opciones obtenidas al campo "select_modelo_marca"
                $.each(response, function(index, value) {
                    $('#modelo_seleccionar select').append('<option value="' + value + '">' + value + '</option>');
                });
            }
        });
    });

    // Detectar el valor seleccionado en el campo "marca" al cargar la página
    var marca = $('#marca_edit input[type="radio"]:checked').val();
    // Obtener el nombre de la marca seleccionada
    var marca_name = $('#marca_edit input[type="radio"]:checked').next('span').text();
    console.log('Marca seleccionada al cargar la página:', marca_name);
    // Mostrar un mensaje en el campo "select_modelo_marca" mientras se cargan los modelos
    $('#modelo_seleccionar select').empty();
    $('#modelo_seleccionar select').append('<option value="">Cargando los modelos de ' + marca_name + '...</option>');
    // Hacer una consulta AJAX para obtener los modelos de esa marca
    $.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: 'POST',
        data: {
            action: 'get_modelos',
            marca: marca
        },
        success: function(response) {
            console.log('Respuesta AJAX:', response);
            // Vaciar el campo "select_modelo_marca"
            $('#modelo_seleccionar select').empty();
            // Añadir las opciones obtenidas al campo "select_modelo_marca"
            $.each(response, function(index, value) {
                $('#modelo_seleccionar select').append('<option value="' + value + '">' + value + '</option>');
            });
            // Seleccionar el valor de la taxonomía "modelo" en el campo "select_modelo_marca"
            $('#modelo_seleccionar select').val(gv360_data.modelo);
        }
    });


*/

//Añadir botón para crear nuevo modelo:







    
});











