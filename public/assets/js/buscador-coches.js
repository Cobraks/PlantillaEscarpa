// En buscador-coches.js
// En buscador-coches.js
jQuery(document).ready(function($) {
    // Capturar el evento keyup del campo de búsqueda
    $('#campo-buscador-coches').on('keyup', function() {
      // Obtener el valor del campo de búsqueda
      var termino = $(this).val();
      // Comprobar si el término de búsqueda tiene al menos 3 caracteres
      if (termino.length >= 2) {
        // Mostrar un alert con el término de búsqueda
       // alert('Término buscado: ' + termino);
        // Mostrar el término buscado en la caja de resultados
        $('#div-resultados-busqueda').html('Término buscado: ' + termino);
        // Enviar una petición AJAX al back-end con el término de búsqueda
        $.post(gv360_ajax.ajaxUrl, {
          action: 'buscar_por_titulo',
          termino: termino,
          nonce: gv360_ajax.nonce
        }, function(response) {
          // Mostrar los resultados de la búsqueda en la caja de resultados
          $('#div-resultados-busqueda').html(response);
        });
      }
    });
  });
  
  