var $ = jQuery.noConflict();

/*
Tengo que posponer el jquery, pero este archivo depende de él. Habría que sacar las funciones window on load y cosas así

obtenerPrimerCocheVisible(): Obtiene el primer coche que se está viendo (superior izquierda)
cargandoCoche(): 
*/
//Obtiene el primer coche visible del listado
function obtenerPrimerCocheVisible() {
  var primerCocheVisibleIndex = -1;
  $('.coche-card').each(function(index) {
      var cardTop = $(this).offset().top;
      var cardBottom = cardTop + $(this).outerHeight();
      var windowTop = $(window).scrollTop();
      var windowBottom = windowTop + $(window).height();
      if (cardBottom > windowTop && cardTop < windowBottom) {
          primerCocheVisibleIndex = index;
          return false;
      }
  });
  return primerCocheVisibleIndex;
}

function cargandoCoche() {
  // Obtener el índice del primer elemento .coche-card visible
  var primerCocheVisibleIndex = obtenerPrimerCocheVisible();
  // Quitar la clase .cargado de los elementos visibles
  $('.coche-card:visible, .buscador:visible').removeClass('cargado');

  // Animar elementos visibles
  var indices = [0, 4, 1, 7, 5, 3, 8, 6, 2];
  for (var i = 0; i < indices.length; i++) {
    setTimeout(function(index) {
      $('.coche-card').eq(primerCocheVisibleIndex + indices[index]).addClass('cargando');
    }, i * 20, i);
  }
}

function cargadoCoche() {
  // Obtener el índice del primer elemento .coche-card visible
  var primerCocheVisibleIndex = obtenerPrimerCocheVisible();
  $('.section-listado-coches .contador').removeClass('efecto_blur');
  $('.coche-card').addClass('cargando');
  // Animar elementos visibles
  var indices = [0, 4, 1, 7, 5, 3, 8, 6, 2];
  for (var i = 0; i < indices.length; i++) {
    setTimeout(function(index) {
      $('.coche-card').eq(primerCocheVisibleIndex + indices[index]).removeClass('cargando');
      $('.coche-card').eq(primerCocheVisibleIndex + indices[index]).addClass('cargado');
    }, i * 40 + 20, i);
  }
  
  setTimeout(function() {
    $('.coche-card').addClass('cargado');
    $('.coche-card').removeClass('cargando');
  }, indices.length * 40 + 20);
}

//Función desplazamiento texto
function desplazamientoTexto() {
  // Crea una nueva instancia de Intersection Observer
  const observer = new IntersectionObserver(function(chips) {
    // Itera sobre cada elemento observado
    chips.forEach(function(chipCaracteristica) {
      // Si el elemento está visible en la pantalla
      if (chipCaracteristica.isIntersecting) {
        // Activa la animación para el elemento
        toggleDeslizamiento(chipCaracteristica.target, true);
      } else {
        // Si el elemento no está visible en la pantalla, detiene la animación para el elemento
        toggleDeslizamiento(chipCaracteristica.target, false);
      }
    });
  });

  // Selecciona todos los elementos li dentro del contenedor .info-card
  const items = $('.coche-card .info-card li');

  // Itera sobre cada elemento li
  items.each(function() {
    // Observa el elemento li con Intersection Observer
    observer.observe(this);
  });
}

// Función auxiliar para agregar o quitar la clase .deslizamiento a un elemento li y actualizar el contenido de sus elementos span y div
function toggleDeslizamiento(li, deslizamiento) {
  li = $(li);
  const div = li.find('div');
  const span = li.find('.desplazamiento-span');
  const icon = li.find('i');
  const availableWidth = li.width() - icon.outerWidth(true);
  
  if (deslizamiento && div[0].scrollWidth > availableWidth) {
    li.addClass('deslizamiento');
    span.text(span.text() + '    ');
    const newSpan = $('<span>').text(span.text());
    div.append(newSpan);
  } else if (!deslizamiento) {
    li.removeClass('deslizamiento');
    span.text($.trim(span.text()));
    div.find('span:not(:first)').remove();
  }
}
 //Fin desplazamientoTexto()


function toggleResetButtonbien() {
  // Obtener el valor del elemento span.contador_filtros
  var contador = parseInt(document.querySelector('span.contador_filtros').textContent);
  // Obtener el elemento button con la clase facetwp-reset que está dentro de span.contador_filtros
  var boton = document.querySelector('span.contador_filtros').closest('.facetwp-facet-boton_reiniciar').querySelector('button.facetwp-reset');
  // Si el valor del contador es 0, ocultar el botón de reset
  if (contador == 0) {
      boton.style.display = 'none';
  }
  // Si el valor del contador no es 0, mostrar el botón de reset
  else {
      boton.style.display = 'flex';
  }
  return;
}

// define una función para actualizar el valor de visualización del facet "iva_deducible"
function updateIvaDeducibleFacet() {
  var displayValueElement = document.querySelector('.facetwp-facet-iva_deducible .facetwp-checkbox .facetwp-display-value');
  if (displayValueElement) {
    displayValueElement.textContent = 'Solo IVA deducible';
  }
}

// ejecuta la función updateIvaDeducibleFacet cuando se cargue la página y facetwp-loaded
window.addEventListener('load', updateIvaDeducibleFacet);
document.addEventListener('facetwp-loaded', updateIvaDeducibleFacet);

$(window).resize(function() {
  console.log('Window resized');
  desplazamientoTexto();
});

// Llama a la función cuando se redimensiona la ventana principal
$(window.top).resize(function() {
  desplazamientoTexto();
});

$(document).on('fullscreenchange', function() {
  desplazamientoTexto();
});


//Document ready
$(document).ready(function() {
  // zoomPortadaCoche();
   /* $('.coche-card').hover(
    function() {
      $('.coche-card').not(this).toggleClass('hover-en-otro');
    },
    function() {
      $('.coche-card').not(this).toggleClass('hover-en-otro');
    }
  ); */
  cargadoCoche();
  desplazamientoTexto();
  // Obtener los valores de las variables desde el objeto gv360_data
  var minPrice = gv360_data.minPrice;
  var maxPrice = gv360_data.maxPrice;
  var minKm = gv360_data.minKm;
  var maxKm = gv360_data.maxKm;
  var minAno = gv360_data.minAno;
  var maxAno = gv360_data.maxAno;
/*   
  var minPriceNumber = Number(minPrice);
  var maxPriceNumber = Number(maxPrice);
  var minKmNumber = Number(minKm);
  var maxKmNumber = Number(maxKm);
  var minAnoNumber = Number(minAno);
  var maxAnoNumber = Number(maxAno); */

  // Convertir las variables a números utilizando el operador unario +
  var minPriceNumber = +minPrice;
  var maxPriceNumber = +maxPrice;
  var minKmNumber = +minKm;
  var maxKmNumber = +maxKm;
  var minAnoNumber = +minAno;
  var maxAnoNumber = +maxAno;


  //Botones filtros
  $('.mas_filtros_container').hide();

  $('button.mas_filtros').click(function() {
    $('.mas_filtros_container').slideToggle();
    $(this).text($(this).text() == 'Más filtros' ? 'Menos filtros' : 'Más filtros');
  });

  $('.boton-filtro-coches').on('click', abrirCerrarFiltros);

  $('#ver_coches').on('click', () => {
    abrirCerrarFiltros();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  $('.boton-cierre').on('click', () => {
    cambiarVisibilidad(false);
  });

  function abrirCerrarFiltros() {
    cambiarVisibilidad(!$('aside.buscador').hasClass('visible'));
  }

  function cambiarVisibilidad(visible) {
    $('aside.buscador, .barra-filtros, .ver_coches_container').toggleClass('visible', visible);
    $('body').toggleClass('no-scroll', visible);
    $('.boton-filtro-coches').toggleClass('active', visible);

    if (visible && $('.barra-filtros').hasClass('no-fijado')) {
      $('.barra-filtros').css({'position': 'fixed', 'transform': 'scaleY(1.2)'});

      setTimeout(() => {
        $('.barra-filtros').css('transform', '');
      }, 300);
    } else {
      $('.barra-filtros').css('position', '');
    }
  }

  //Select marcas
  $('.ayuda-marcas').click(function() {
    $('.help-marcas').slideToggle();
  });

  if (!$('body').hasClass('tax-marca')) {
    $('.select-marcas .selected-option span').text('Todas las marcas');
  }

  //$('.select-marcas .selected-option').on('click', function() { 
    $(document).on('click', '.select-marcas .selected-option', function() {
    const optionsList = $('.select-marcas .options-list');
    if (optionsList.is(':visible')) {
      optionsList.animate({height: 0}, () => {
        optionsList.hide();
      });
      $(this).removeClass('active');
    } else {
      optionsList.show().css({'height': 'fit-content', 'display': 'flex'});
      const height = optionsList.height();
      optionsList.height(0).animate({height: height});
      $(this).addClass('active');
    }
  });
  
  $('.select-marcas .options-list li').each(function() {
    $(this).on('click', () => {
      const text = $(this).find('span').text();
      const img = $(this).find('img');
  
      $('.select-marcas .selected-option span').text(text);
      if (img.length) {
        $('.select-marcas .selected-option img')
          .attr('src', img.attr('src'))
          .removeClass('ocultar_logo');
      } else {
        $('.select-marcas .selected-option img').addClass('ocultar_logo');
      }
      $('.select-marcas').removeClass('open');
    });
  });

  $(window).on('beforeunload', function() { //Cuando se actualiza la página
    cargandoCoche();
    if ($('aside.buscador').hasClass('visible')) {
      $('#ver_coches .loading-animation').show();
      $('#ver_coches .button-text').hide();
      $('aside.buscador').removeClass('visible');
      $('html, body').animate({ scrollTop: 0 }, 'slow');
    }
  });

  function updateBarPosition() {
    const posicionFinalListado = $('section.section-listado-coches')[0].getBoundingClientRect().bottom;

    if (posicionFinalListado <= window.innerHeight) {
      $('.barra-filtros').addClass('no-fijado');
      $('.ver_coches_container').addClass('bottom8');
    } else {
      $('.barra-filtros').removeClass('no-fijado');
    }
  }

  function desabilitarFacetSiNoHayDatos(facetSelector) {
    if ($(facetSelector + ' .facetwp-slider').attr('data-disabled') === "true") {
        $(facetSelector).addClass('disabled');
    } else {
        $(facetSelector).removeClass('disabled');
    }
  }

  // Al hacer scroll
  $(window).on('scroll', updateBarPosition);


  //Al actualizar un facet
  $(document).on('facetwp-refresh', function() {
 
    $('.facetwp-type-slider').each(function() {
      var facetName = $(this).attr('data-name');
      if (FWP.facets[facetName].length > 0) {
          $(this).addClass('selected');
      } else {
          $(this).removeClass('selected');
      }
    });

    cargandoCoche();
    desplazamientoTexto();
    $('#ver_coches .loading-animation').show();
    $('#ver_coches .button-text').hide();
    $('.section-listado-coches .contador').addClass('efecto_blur');  
    
  }); //Fin facetwp refresh

  // Facetwp loaded: Cuando los facet se han cargado.
  $(document).on('facetwp-loaded', function() {
    cargadoCoche();
    desplazamientoTexto();
    var facets_en_uso = function() {
      var in_use = false;
      $.each(FWP.facets, function(name, val) {
        if (0 < val.length && 'paged' !== name) {
            in_use = true;
            return false; // exit loop
        }
      });
      return in_use;
    }

    if ( facets_en_uso() ) {
      // Cuando facets tienen selecciones
      $('.texto-elegidos').removeClass('invisible');
      $('.texto-elegidos').addClass('visible');
    } else {
      // Cuando facets NO tienen selecciones
      $('.texto-elegidos').addClass('invisible');
      $('.texto-elegidos').removeClass('visible');
    }

    // Obtener el número de resultados
    var num_results = FWP.settings.pager.total_rows;
    // Actualizar el texto en función del número de resultados
    if (num_results <= 1) {
        $('.texto-stock').text(gv360_data.nombre_del_stock_singular);
    } else {
        $('.texto-stock').text(gv360_data.nombre_del_stock);
    }

    // Asignar el valor inicial a la variable start_num
    var start_num = parseInt($('.contador').text().trim());
    // Calcular el incremento para la animación
    var increment;
    if (start_num <= num_results) {
        increment = num_results - start_num > 20 ? 10 : 1;
    } else {
        increment = start_num - num_results > 20 ? -10 : -1;
    }
    // Calcular el número total de incrementos
    var total_increments = Math.ceil(Math.abs(num_results - start_num) / Math.abs(increment));
    // Calcular la duración total de la animación
    var total_duration = 200; // 0.2 segundos
    // Calcular la duración de cada incremento
    var duration = total_duration / total_increments;
    // Actualizar el texto con el número inicial
    document.querySelector('.contador').textContent = start_num + ' ';
    // Animar el número hasta el número final
    var current_num = start_num;
    var interval = setInterval(function() {
        // Incrementar o decrementar el número actual
        current_num += increment;
        // Ajustar el último incremento si es necesario
        if ((increment > 0 && current_num > num_results) || (increment < 0 && current_num < num_results)) {
            current_num = num_results;
        }
        // Actualizar el texto con el número actual y un espacio después
        document.querySelector('.contador').textContent = current_num + ' ';
        // Detener la animación cuando se alcanza el número final
        if (current_num == num_results) {
            clearInterval(interval);
        }
    }, duration);

    //Muestro u oculto el contador de coches en los facets, si hemos elegido la opción
    var contadorCochesFacet = gv360_data.contadorFacets;
 // Verifica si el valor de la variable es verdadero
    if (contadorCochesFacet == 1) {
      // Agrega una clase al elemento
      // Selecciona los elementos .facetwp-counter
      var counters = $('span.facetwp-counter');
      // Recorre cada elemento .facetwp-counter
      counters.each(function() {
          // Obtén el contenido del elemento
          var content = $(this).text();
          // Elimina los paréntesis del contenido
          content = content.replace('(', '').replace(')', '');
          // Actualiza el contenido del elemento
          $(this).text(content);
      });
      $('span.facetwp-counter').removeClass('ocultar');
    } else {
      $('span.facetwp-counter').addClass('ocultar');
    }
    
    function actualizarSliderTooltip(facetSelector, unitSymbol, values) {
      var facet = $(facetSelector);
      var tooltips = facet.find('.noUi-tooltip');
      tooltips.each(function(index) {
          var tooltipValue = parseInt(values[index]);
          var isMinValue = index === 0;
          var roundedValue = isMinValue ? Math.floor(tooltipValue / 1000) * 1000 : Math.ceil(tooltipValue / 1000) * 1000;
          var formattedValue = roundedValue.toLocaleString('es-ES', { useGrouping: true }) + unitSymbol;
          $(this).text(formattedValue);
      });
    }
  
    // Actualizar el formato de los valores del slider de precio
    var precioFacet = $('.facetwp-facet-precio');
    var slider = precioFacet.find('.noUi-target')[0].noUiSlider;
    var values = slider.get();
    actualizarSliderTooltip('.facetwp-facet-precio', '€', values);
    
    // Actualizar valor del precio mientras se desliza el slider
    slider.on('slide', function(values) {
        actualizarSliderTooltip('.facetwp-facet-precio', '€', values);
    });
    slider.on('set', function(values) {
        actualizarSliderTooltip('.facetwp-facet-precio', '€', values);
    });
    
    // Actualizar el formato de los valores del slider de kilómetros
    var kilometrosFacet = $('.facetwp-facet-kilometros');
    slider = kilometrosFacet.find('.noUi-target')[0].noUiSlider;
    values = slider.get();
    actualizarSliderTooltip('.facetwp-facet-kilometros', 'km', values);
    
    // Actualizar valor de kilómetros mientras se desliza el slider
    slider.on('slide', function(values) {
        actualizarSliderTooltip('.facetwp-facet-kilometros', 'km', values);
    });
    slider.on('set', function(values) {
        actualizarSliderTooltip('.facetwp-facet-kilometros', 'km', values);
    });


    $('#ver_coches .loading-animation').hide();
    $('#ver_coches .button-text').show();

    const totalRows = FWP.settings.pager.total_rows;
    const cochesText = totalRows === 1 ? 'coche' : 'coches';
    $('#ver_coches .button-text').text(`Ver ${totalRows} ${cochesText}`);

    var count = 0;
    $('.facetwp-facet').each(function() {
        var facet_name = $(this).attr('data-name');
        var selections = FWP.facets[facet_name];
        if (Array.isArray(selections)) {
            count += selections.length;
        }
    });

    $('.facetwp-reset').html(`Eliminar filtros <span class="contador_filtros">${count}</span>`);
    
    desabilitarFacetSiNoHayDatos('.facetwp-facet-ano');
    // Deshabilitar el facet "kilometros" si el atributo data-disabled del elemento .facetwp-slider está establecido en "true"
    desabilitarFacetSiNoHayDatos('.facetwp-facet-kilometros');
    // Deshabilitar el facet "potencia" si el atributo data-disabled del elemento .facetwp-slider está establecido en "true"
    desabilitarFacetSiNoHayDatos('.facetwp-facet-potencia');
    toggleResetButtonbien();

  }); //Fin facetwp loaded


  if ('undefined' !== typeof FWP && 'undefined' !== typeof FWP.hooks) {
    FWP.hooks.addFilter('facetwp/set_options/slider', function(opts, facet) {
      if (facet.facet_name === 'precio') {
        opts.tooltips = [true, true];
             opts.format = { //tooltips salida
          to: function(value) {
            return nummy(value).format('0');
          },
          from: function(value) {
            return value;
          }
        };
        opts.margin = 15000; //El valor permitido entre el mínimo y el máximo. Ej. para 500, min 1000 - 1500 
        opts.range = {
            'min': minPriceNumber,
            'max': maxPriceNumber
        };
      } else if (facet.facet_name === 'ano') {
        
        opts.margin = 2;
        opts.tooltips = [true, true];
        opts.format = {
          to: function(value) {
            return nummy(value).format('0');
          },
          from: function(value) {
            return value ;
          },
        };
        opts.range = {
          'min': minAnoNumber,
          'max': maxAnoNumber
        }; 
        opts.animate = true;
        } else if (facet.facet_name === 'kilometros') {
          opts.margin = 20000;
          opts.tooltips = [true, true];
          opts.format = {
              to: function(value) {
                  return nummy(value).format('0');
              },
              from: function(value) {
                  return value;
              }
          };
          opts.range = {
            'min': minKmNumber,
            'max': maxKmNumber
          };
        } else if (facet.facet_name === 'potencia') {
          opts.margin = 20;
          opts.tooltips = [true, true];
          opts.format = {
            to: function(value) {
              return nummy(value).format('0');
            },
            from: function(value) {
              return value;
            }
          };
        } 
      return opts;
    });
  }
}); /*document ready functions acaba aquí*/