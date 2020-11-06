<?php
/*
* Template Name: Busqueda de Stands
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
                <input type="hidden" value="stands" id="modo" name="modo" />
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

}

get_footer();