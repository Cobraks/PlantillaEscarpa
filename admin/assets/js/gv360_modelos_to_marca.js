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



//Actualizar modelos
var post_id = $('#post_ID').val();

function actualizarModelos(marca_id) {
    var marca_nombre = $('#marca_edit input[type="radio"]:checked').next('span').text();
    var select = $('#modelo_seleccionar select');
    select.empty();
    select.append($('<option>', {
        value: '',
        text: 'Cargando modelos de ' + marca_nombre + '...'
    }));
    $.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: 'POST',
        data: {
            action: 'obtener_modelos_por_marca',
            marca_id: marca_id,
            post_id: post_id
        },
        success: function(response) {
            var data = JSON.parse(response);
            var opciones = data.opciones;
            var modelo_seleccionado = data.modelo_seleccionado;
            select.empty();
            $.each(opciones, function(index, opcion) {
                select.append($('<option>', {
                    value: opcion.value,
                    text: opcion.label,
                    selected: opcion.value == modelo_seleccionado
                }));
            });
        }
    });
}

$('#marca_edit input[type="radio"]').on('change', function() {
    var marca_id = $(this).val();
    actualizarModelos(marca_id);
});

var marca_seleccionada = $('#marca_edit input[type="radio"]:checked').val();
if (marca_seleccionada) {
    actualizarModelos(marca_seleccionada);
}


    






// Obtener el nombre de la marca seleccionada
var marca_nombre = $('#marca_edit input[type="radio"]:checked').next('span').text();

// Comprobar si se ha seleccionado una marca
if (marca_nombre) {
    // Si se ha seleccionado una marca, agregar el botón para mostrar el formulario de agregar modelo
    $('#modelo_seleccionar').after('<button id="show_add_modelo_button">Añadir modelo a ' + marca_nombre + '</button>');

    // Agregar el formulario para agregar un nuevo modelo
    $('#show_add_modelo_button').after('<div id="add_modelo_form" style="display: none;"><input type="text" id="add_modelo_input"><button id="add_modelo_button">Añadir</button></div>');

    // Mostrar el formulario para agregar un nuevo modelo
    $('#show_add_modelo_button').on('click', function() {
        $('#add_modelo_form').show();
    });
}

// Agregar un nuevo modelo
$('#add_modelo_button').on('click', function() {
    var modelo_nombre = $('#add_modelo_input').val();
    var marca_id = $('#marca_edit input[type="radio"]:checked').val();
    var marca_nombre = $('#marca_edit input[type="radio"]:checked').next('span').text();
    var select = $('#modelo_seleccionar select');
    select.append($('<option>', {
        value: '',
        text: 'Añadiendo ' + modelo_nombre + ' en ' + marca_nombre + '...'
    }));
    $.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: 'POST',
        data: {
            action: 'agregar_modelo',
            modelo_nombre: modelo_nombre,
            marca_id: marca_id
        },
        success: function(response) {
            var data = JSON.parse(response);
            if (data.status === 'success') {
                var modelo_id = data.modelo_id;
                select.find('option:last').remove(); // Eliminar el mensaje "Añadiendo [modelo] en [marca]"
                select.append($('<option>', {
                    value: modelo_id,
                    text: modelo_nombre,
                    selected: true
                }));
            } else {
                alert(data.message);
            }
        }
    });
});
// Función para actualizar el texto del botón
function actualizarTextoBoton() {
    var marca_nombre = $('#marca_edit input[type="radio"]:checked').next('span').text();
    $('#show_add_modelo_button').text('Añadir modelo a ' + marca_nombre);
}

// Actualizar el texto del botón cuando se selecciona una marca diferente
$('#marca_edit input[type="radio"]').on('change', function() {
    actualizarTextoBoton();
});


});











