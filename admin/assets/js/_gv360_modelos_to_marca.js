jQuery(document).ready(function($) {






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


$('body').on('change', '[data-name="marca"] input', function() {
    var marca = $(this).val();
    $.ajax({
        url: ajaxurl,
        method: 'POST',
        data: {
            action: 'get_modelos',
            marca: marca
        },
        success: function(response) {
            var modelos_select = $('[data-name="datos_generales"] [data-name="select_modelo_marca"] select');
            modelos_select.empty();
            $.each(response, function(index, modelo) {
                modelos_select.append('<option value="' + modelo + '">' + modelo + '</option>');
            });
        }
    });
});

    
});











