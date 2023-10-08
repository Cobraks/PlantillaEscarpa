var $ = jQuery.noConflict();
//document.querySelector('.img-galeria').addEventListener('load', function() {
  //document.querySelector('.loader').style.display = 'none';
//});

//QUITAR EL LOADER
/*
window.addEventListener('load', function() {
  setTimeout(() => {
    document.querySelector('.loader').style.display = 'none';
  }, 900); // Retrasa la ocultación del spinner en 2 segundos
}); */

function formatearMiles(numero) {
  return numero.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

  // Función para mostrar el contenedor de galería seleccionado con animación
  function mostrarContenedorGaleria() {
    const index = $('.option:checked').index();
    const translateX = -index * 100 + '%';
    $('.contenedor-galerias').css('transform', 'translateX(' + translateX + ')');

    // Mueve el selector
    const left = index * 100; // 100% dividido en dos opciones
    $('.selector').css('transform', 'translateX(' + left + '%)');
  }


document.addEventListener('DOMContentLoaded', function () {

//WOrking//
// Función para inicializar un slider con miniaturas

function inicializarSliderConMiniaturas(id) {
  const elemento = document.querySelector(id);
  
  if (elemento) {
    const sliderPrincipal = new Splide(id, {
      type: 'loop',
      perPage: 1,
      cover: false,
      height: '600px',
      lazyLoad: 'nearby',
      pagination: false,
      arrows: true,
      focus: 'center',
      autoplay: true,
      interval: 3500,
      speed: 1600,
    }).mount();

    const sliderMiniaturas = new Splide(id + '-mini', {
      perPage: 4,
      isNavigation: true,
      focus: 'center',
      pagination: false,
      cover: false,
      gap: 'var(--espacioTarjeta)',
      height: '17.2rem',
      updateOnMove: true,
      padding: {},
     // direction: 'ttb',
      breakpoints: {
        640: {
          perPage: 3,
        },
        480: {
          perPage: 2,
        },
      },
    }).mount();

    // Sincroniza los sliders
    sliderPrincipal.sync(sliderMiniaturas);

    return sliderPrincipal; // Devolvemos el slider principal
  } else {
    console.log(`No se encontró ningún elemento con el ID ${id}`);
    return null;
  }
}


  // Inicializa los sliders con miniaturas
  const galeriaExterior = inicializarSliderConMiniaturas('#galeria-exterior');
  const galeriaInterior = inicializarSliderConMiniaturas('#galeria-interior');

  // Función para mostrar el contenedor de galería seleccionado con animación
 //mostrarContenedorGaleria();

  // Escucha el evento "change" de los elementos de entrada (input)
  $('.label').click(function () {
    const index = $('.label').index(this);
    $('.option').prop('checked', false); // Desmarca todos los inputs
    $('.option').eq(index).prop('checked', true); // Marca el input correspondiente
    $('.label').removeClass('selected');
    $(this).addClass('selected');
    mostrarContenedorGaleria();
  });







  $('.splide__slide.popup-image').on('click', function() {
    // Encuentra la imagen dentro del contenedor <li>
    const imageUrl = $(this).find('img').attr('src');

    // Abre el popup Magnific Popup con la imagen en grande
    $.magnificPopup.open({
      items: {
        src: imageUrl
      },
      type: 'image'
    });
});

});

$(document).ready(function() {









  $('.splide').removeClass('cargando');
  $('#exterior').prop('checked', true);
  $('.label').eq(0).addClass('selected');

  // Función para mostrar el contenedor de galería seleccionado con animación
  mostrarContenedorGaleria();
  // Inicialmente, selecciona "Exterior" por defecto y muestra el contenedor de galería correspondiente


  



  
  /*

// Obtener el ID del video de los datos pasados por PHP
var videoId = gv360_single_coche_data.video_id;

// Crear un objeto de opciones para el reproductor
var playerOptions = {
  height: '100%',
  width: '100%',
  host: 'https://www.youtube-nocookie.com',
  videoId: videoId,
  playerVars: {
    autoplay: 1,
    loop: 1,
    // playlist: videoId, 
    controls: 0,
    showinfo: 0,
    rel: 0,
    mute: 1,
    modestbranding: 1
  },
  events: {
    onReady: function(event) {
      event.target.mute();
    },
    onStateChange: function(event) {
      if (event.data == YT.PlayerState.ENDED) {
        player.seekTo(0);
        player.playVideo();
      }
    }
  }
};

// Crear el reproductor de YouTube
var player = new YT.Player('video-player', playerOptions);




/*alert('Id del vídeo para la API:' + videoId); */

//Fin Youtube


}); /*document ready functions acaba aquí*/
















/*
HACER CON GOOGLE TAG MANAGER Y REVISAR BIEN

// Enviar una alerta cuando se envíe un formulario
document.addEventListener( 'wpcf7mailsent', function( event ) {
    // Mostrar una alerta
    alert( "Formulario enviado" );
  }, false );
  
  */

//Youtube
/*
// En su archivo JavaScript
const apiKey = 'AIzaSyAIUjB4lGLbN9kRZHjOBKN9CUT2GbKkSc8';
const videoId = 'a9-tGfYNi-s';

$.get(`https://www.googleapis.com/youtube/v3/videos?id=${videoId}&key=${apiKey}&part=player`, function(data) {
    // Aquí puede acceder a los datos del video
    const videoUrl = data.items[0].player.embedHtml;

    // Envíe los datos del video al archivo PHP utilizando AJAX
    $.post('video.php', {videoUrl: videoUrl}, function(response) {
        // Muestre el reproductor de video en el div
        $('#video-player').html(response);
    });
});
*/




  // Enviar un evento a Google Analytics cuando se envíe un formulario
// Enviar un evento a Google Analytics cuando se envíe un formulario
document.addEventListener( 'wpcf7mailsent', function( event ) {
    // Agregar una alerta para verificar si el evento wpcf7mailsent se está disparando
    alert( "Evento wpcf7mailsent disparado" );
  
    // Acceder al título del post y los datos del formulario
    var post_title = pasarVariablesSingleCoche.post_title;
    var form_data = pasarVariablesSingleCoche.form_data;
  
    // Utilizar el título del post y los datos del formulario
    console.log(post_title);
    console.log(form_data);
  
    // Verificar si el objeto pasarVariablesSingleCoche está definido
    if (typeof pasarVariablesSingleCoche === 'object') {
        // Agregar un registro de depuración para verificar si el objeto pasarVariablesSingleCoche está definido
        console.log( "Objeto pasarVariablesSingleCoche: ", pasarVariablesSingleCoche );
    } else {
        // Mostrar un mensaje de error en la consola del navegador
        console.error( "El objeto pasarVariablesSingleCoche no está definido" );
        alert( "El objeto pasarVariablesSingleCoche no está definido" );
    }
  
    // Verificar si la función gtag está definida
    if (typeof gtag === 'function') {
      // Enviar un evento a Google Analytics con el título del post y los datos del formulario
      gtag('event', 'Form Submission', {
        'event_category': post_title,
        'event_label': form_data,
        'value': Date.now()
      });
  
      // Agregar una alerta para verificar si el evento se está enviando a Google Analytics
      alert( "Evento enviado a Google Analytics: " + post_title + ", " + form_data );
  
      // Agregar un registro de depuración en la consola del navegador
      console.log( "Evento enviado a Google Analytics: ", post_title, form_data );
    } else {
      // Mostrar un mensaje de error en la consola del navegador
      console.error( "La función gtag no está definida" );
      alert( "La función gtag no está definida" );
    }
}, false );








$(document).ready(function() {




/*
  var slider = document.getElementById("entradaSlider");
  var output = document.getElementById("valorEntrada");
  output.innerHTML = slider.value; // Muestra el valor inicial del control deslizante

  // Actualiza el valor actual cada vez que se mueve el control deslizante
  slider.oninput = function() {
    output.innerHTML = this.value;
  } */





  function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
  }
  
  var slider = document.getElementById('entradaSliderNoUi');
  
  noUiSlider.create(slider, {
      start: [0],
      step: 300,
      connect: [true, false],
      padding: [80, 80],
      range: {
          'min': [0],
          'max': [Number(precioFinanciado) - 1000] // Resta 1000 al precio financiado
      }
  });
  
  slider.noUiSlider.on('update', function (values, handle) {
    var valor = parseFloat(values[handle]);
    var valorFormateado = formatNumber(valor.toFixed(0));
    $('#valorEntradaNoUi').text(valorFormateado);
  });
  
  
  










  var $container = $('.container-secciones');
  var $menu = $('<ul id="menu-navegacion"></ul>');
  
  $container.find('h2').each(function(index) {
    var $h2 = $(this);
    var titleText = $h2.text();
    var $section = $h2.closest('section');
    
    if ($section.length > 0) {
      var sectionId = $section.attr('id');
      var $menuItem = $('<li><a href="#' + sectionId + '">' + titleText + '</a></li>');
      $menu.append($menuItem);
    }
  });
  
  $('#menu-navegacion-container').append($menu);
 
  $menu.find('a').on('click', function(event) {
    event.preventDefault();
    
    var targetId = $(this).attr('href');
    var $targetSection = $(targetId);
    
    if ($targetSection.length > 0) {
      var offset = $targetSection.offset().top - 199; // Ajustar el valor de desplazamiento aquí
      
      $('html, body').animate({
        scrollTop: offset
      }, 400);
    }
  });
 
  $(window).scroll(function() {
    var currentPosition = $(this).scrollTop();
    
    $container.find('section').each(function() {
      var $section = $(this);
      var top = $section.offset().top;
      var bottom = top + $section.outerHeight();
      
      if (currentPosition >= top - 200 && currentPosition <= bottom - 200) {
        var sectionId = $section.attr('id');
        $menu.find('li').removeClass('menu-activo');
        $menu.find('a[href="#' + sectionId + '"]').parent('li').addClass('menu-activo');
      }
    });
  });




  $('.personalizar-financiacion').click(function(e) {
    if (!$(e.target).is('.deslizar-financiacion, .deslizar-financiacion *')) {
      var deslizarDiv = $(this).find('.deslizar-financiacion');
      if ($(this).hasClass('abierto')) {
        deslizarDiv.slideUp(); // Cierra el div
        $(this).removeClass('abierto');
      } else {
        deslizarDiv.slideDown(); // Abre el div
        $(this).addClass('abierto');
      }
    }
  });
  
  













//Financiación:
var ajaxurl = objeto_financiacion.ajaxurl;
var precio_financiado = objeto_financiacion.precio_financiado;

$('input[type=radio][name=meses], #entrada').on('input', function() {
    var meses = $('input[type=radio][name=meses]:checked').val();
    $('#meses').html(meses + ' meses');  // Actualiza el div#meses

    var entrada = $('#entrada').val() ? parseInt($('#entrada').val().replace(/\./g, '')) : 0;
    if (entrada >= precio_financiado) {
        alert('La entrada no puede ser mayor o igual que el precio financiado');
        return;
    }
    $('#entrada').val(entrada ? formatearMiles(entrada) : '');  // Muestra la entrada formateada

    var precio_restante = precio_financiado - entrada;
    var data = {
        'action': 'mi_funcion',
        'value_tin': objeto_financiacion.value_tin,
        'seguro': objeto_financiacion.seguro,
        'meses': meses
    };
    $.post(ajaxurl, data, function(response) {
        var coeficiente = parseFloat(response);
        $('#coeficiente').html(coeficiente);  // Muestra el coeficiente
        var resultado = coeficiente * precio_restante;
        $('#cuota').html(resultado);  // Muestra el resultado

        var resultado_redondeado = Math.round(resultado);
        // Añade el separador de miles
        var resultado_formateado = formatearMiles(resultado_redondeado);
        $('#cuota-redondeada').html(resultado_formateado);  // Muestra el resultado redondeado
    });
    
});
$('input[type=radio][name=meses]:checked, #entrada').trigger('input');












});







var titleOriginalPosition = $('.title-ficha-container').offset().top;
var addedClass = false;

$(window).scroll(function() {
  var scrollPosition = $(this).scrollTop();
  if (scrollPosition >= titleOriginalPosition && !addedClass) {
    $('.title-ficha-container').addClass('fijado');
    addedClass = true;
  } else if (scrollPosition < titleOriginalPosition && addedClass) {
    $('.title-ficha-container').removeClass('fijado');
    addedClass = false;
  }
});






