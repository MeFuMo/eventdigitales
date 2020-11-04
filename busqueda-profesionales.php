<?php
/*
* Template Name: Busqueda de Profesionales
*/

// cosas de WP

boldthemes_set_override();

get_header();

$action_slug = $wp_query->query_vars['name'];

?>

<section class="boldSection topSpaced bottomSemiSpaced gutter inherit">

    <form role="search" method="get" class="search-form">
        <label>
            <span class="screen-reader-text"><?php echo _x('Buscar:', 'label') ?></span>
            <input type="hidden" value="profesionales" id="modo" name="modo" />
            <input type="search" class="search-field" placeholder="<?php echo esc_attr_x('Introduzca su búsqueda...', 'placeholder') ?>"
                   value="<?php echo get_search_query() ?>" name="s" id="s"
                   title="<?php echo esc_attr_x('Buscar:', 'label') ?>"/>
        </label>

        <input type="submit" name="search-submit" class="search-submit" value="<?php echo esc_attr_x('Buscar', 'submit button') ?>"/>
    </form>

</section>
<section>
    <div id="mostrar"></div>
</section>

<?php

if ( isset( $_GET['search-submit'] ) ) {
/*
    // global de WP para la base de datos
    global $wpdb;
    // Haciendo query para todos los usuarios
    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}posts WHERE post_type = 'erforms_submission' and post_title like '%2016%'", OBJECT );
    // escapando la query de busqueda
    $keyword = sanitize_text_field($_POST['s']);
    // aquí guardaremos los resultados que coincidan
    $coincidences = [];

    foreach ($results as $result) {
        // decodificamos el post_content
        $result_array = json_decode($result->post_content);
        // si hay alguna coincidencia
        if( array_search_partial($result_array, $keyword) ) {
            // guardamos el resultado sin serializar
            $coincidences[] = $result_array;
        }
    }

    foreach($coincidences as $coincidence) {
        // AQUI SE MUESTRA EL RESULTADO
        var_dump($coincidence);
    }
*/
}

get_footer();