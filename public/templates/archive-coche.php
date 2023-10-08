<?php
/**
 * Plantilla para mostrar una lista de coches.
 *
 * Esta plantilla se usa cuando se muestra una lista de todos los coches.
 *
 * @package gv360
 */
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );
get_header(); 

    //Desde aquí
    if ( function_exists('get_field') ) {
        $nombre_del_stock = get_field('nombre_del_stock', 'option');
        $nombre_del_stock_singular = get_field('nombre_del_stock_singular', 'option');
    } else {
        // ACF no está instalado o activado, muestra un mensaje de error o desactiva tu plugin
        // O utiliza valores predeterminados para tus opciones
        $nombre_del_stock = 'Coches de segunda mano';
        $nombre_del_stock_singular = 'coche de segunda mano';
    }
    
// Crear un objeto JavaScript con los datos que quieras pasar desde PHP
/**/
// Obtener el valor del campo de opciones de ACF
$coches_por_pag = get_field('numero_de_coches_por_pag', 'option');
$gv360_data = array(
  'nombre_del_stock' => esc_html($nombre_del_stock),
  'nombre_del_stock_singular' => esc_html($nombre_del_stock_singular),

    'minPrice' => $min_price,
    'maxPrice' => $max_price,
    //'maxMinPrice' => $max_min_price,
    'minKm' => $min_km,
    'maxKm' => $max_km,
    'minAno' => $min_ano,
    'maxAno' => $max_ano,
    'cochesPorPag' => $coches_por_pag,
    'contadorFacets' => $contador_facets,
);

// Localizar el script con el objeto creado
wp_localize_script( 'gv360-listado-coches-functions', 'gv360_data', $gv360_data );

/*Lo he quitado de enqueue scripts, así no utilizo variables globales y me ahorro vars */


?>
<div class="content-wrapper">
    <main id="archive_coche" class="main-listado">
        
            <aside class="buscador">

             







            <?php include GV360_PLUGIN_DIR .
                "public/templates/template-parts/filtros/filtro-coches.php"; ?>

        </aside>
        <section class="section-listado-coches">


       

           <div class="intro">
           <div class="display_small tenemos">Tenemos <div class="contador"><?php echo facetwp_display( 'facet', 'contador' ); ?> </div></div><h1 class="texto-stock"><?php echo esc_html($nombre_del_stock);?></h1><span class="texto-elegidos invisible">con las opciones que has elegido.</span></span>
           
           <p class="introduccion">En Escarpa, nos enorgullece ofrecer una amplia selección de coches <b>de alta gama</b> para satisfacer las necesidades y deseos de nuestros clientes más exigentes. Nuestros vehículos son cuidadosamente seleccionados y mantenidos para garantizar la <b>máxima calidad</b> y <b>rendimiento</b>. ¡Ven a visitarnos y descubre la elegancia y el lujo que te esperan en Escarpa!</p>
           </div>
        <div class="ordenar_por">
            <?php echo facetwp_display('selections');?>
<?php echo facetwp_display('facet','ordenar_por');?>
        </div>
        <?php
      
        if (have_posts()) {
            include GV360_PLUGIN_DIR .
                "public/templates/template-parts/content/loop-coches.php";
        } else {
            // No hay publicaciones para mostrar
            echo "No hay post";
            // Mostrar mensaje de "No se encontraron publicaciones" aquí
        }
        ?>
    
<div class="leer-facet">
<span><?php echo facetwp_display("facet", "mostrando_coches"); ?>
<div class="leer-facet-wrapper">
<?php echo facetwp_display("facet", "coches_por_pagina"); ?></span>
<span><?php echo facetwp_display("facet", "paginador_coches"); ?></span>
</div>

      </section>






     



        <div class="barra-filtros wrapper-padding">
        <button class="boton-filtro-ordenar"><i class="icon-filter_list"></i><div class="label">Ordenar por</div></button>
            <button class="boton-filtro-coches"><i class="icon-filter"></i><div class="label">Filtros</div></button>
            <button class="boton-filtro-buscar"><i class="icon-search"></i><div class="label">Buscar</div></button>
        </div>
    </main>
</div>
<?php get_footer(); ?>
