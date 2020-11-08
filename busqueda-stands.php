<?php
/*
* Template Name: Busqueda de Stands
*/

echo '<style> 
.mainHeader{
display: none !important;
}
</style>';

// cosas de WP

boldthemes_set_override();

get_header();

$action_slug = $wp_query->query_vars['name'];

?>
    <section id="bt_section5fa58e86b011a" class="boldSection gutter inherit" style="background-color:#fbc100;">
        <div class="port">
            <div class="boldCell">
                <div class="boldCellInner">
                    <div class="boldRow ">
                        <div class="boldRowInner">
                            <div class="rowItem col-md-12 col-ms-12  btTextLeft inherit" style="background-color: rgba(255, 255, 255, 1);" data-width="12">
                                <div class="rowItemContent">
                                    <div class="btClear btSeparator bottomSemiSpaced noBorder"><hr></div>
                                    <div class="btText">
                                        <p>
                                            <img loading="lazy" class="alignnone wp-image-2104 size-full" src="https://www.eventos-digitales.com/wp-content/uploads/2020/09/Diseno-sin-titulo-19-1.png" alt="Logotipo ARPA 2020 del 26 al 28 de noviembre" srcset="https://www.eventos-digitales.com/wp-content/uploads/2020/09/Diseno-sin-titulo-19-1.png 957w, https://www.eventos-digitales.com/wp-content/uploads/2020/09/Diseno-sin-titulo-19-1-320x52.png 320w, https://www.eventos-digitales.com/wp-content/uploads/2020/09/Diseno-sin-titulo-19-1-768x125.png 768w, https://www.eventos-digitales.com/wp-content/uploads/2020/09/Diseno-sin-titulo-19-1-540x88.png 540w" sizes="(max-width: 957px) 100vw, 957px" width="957" height="156">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<div id="arpa_main_buscador">
    <section class="boldSection topSpaced bottomSemiSpaced gutter inherit">
        <form role="search" method="get" class="search-form">
            <label>
                <span class="screen-reader-text"><?php echo _x('Buscar:', 'label') ?></span>
                <input type="hidden" value="stands" id="modo" name="modo" />
                <input type="search" class="search-field arpa_busqueda_nombre" placeholder="<?php echo esc_attr_x('Introduzca su búsqueda...', 'placeholder') ?>"
                       value="<?php echo get_search_query() ?>" name="s" id="s"
                       title="<?php echo esc_attr_x('Buscar:', 'label') ?>"/>
            </label>
            <input type="submit" name="search-submit" class="search-submit arpa_submit" value="<?php echo esc_attr_x('Buscar', 'submit button') ?>"/>
        </form>
        <div id="parent_results">
            <div id="mostrar" class="rowItem col-md-6 col-sm-12 btTextLeft inherit"></div>
        </div>
    </section>
</div>

<?php

if ( isset( $_GET['search-submit'] ) ) {

}

get_footer();