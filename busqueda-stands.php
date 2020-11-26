<?php
/*
* Template Name: Busqueda de Stands
*/

// cosas de WP

boldthemes_set_override();

get_header();

$action_slug = $wp_query->query_vars['name'];

/*Para cargar todos los stands al cargar la página*/

$results = $wpdb->get_results("SELECT id, post_content FROM {$wpdb->prefix}posts WHERE post_type = 'erforms_submission' and post_title like '%2016%'", OBJECT);

$coincidences = [];
$html = '';
foreach ($results as $result) {
    // decodificamos el post_content
    $result_array = json_decode($result->post_content);
    // preparamos un array asociativo con los campos de busqueda
    $searchable_array = array_search_prepare($result_array->fields_data);
    // si hay alguna coincidencia
    // guardamos el resultado para mostrar
    foreach ($searchable_array as $index => $string) {
        $coincidences[$result->id] = $result_array->fields_data;
    }
}
$num_stand = 0;
$url = true;
foreach ($coincidences as $key => $coincidence) {
    $num_stand++;
    $show = stand_array_prepare($coincidence);
    $avatar = get_record_avatar($show['stand_logo']);

    $url_stand = clean_url_text($show['stand_nombre'], $url);

    $html .= '<div class="div_resultados_stands"><div><a href="../arpa-feria/'.$url_stand.'" title="' . $show["stand_nombre"] . '">'.
        '<img class="avatar_stands" alt="'. $show["stand_nombre"] . '" src="' . $avatar . '" /></a></div>'.
        '<div><p>' . $show['stand_nombre'] . '</p></div></div>';
    if ($num_stand % 4 == 0) {
        $html = $html . '<br>';
    }
}
?>
    <div data-elementor-type="wp-page" data-elementor-id="4642" class="elementor elementor-4642" data-elementor-settings="[]" style="background-color:white;">
        <div class="elementor-inner">
            <div class="elementor-section-wrap">
                <section class="elementor-section elementor-top-section elementor-element elementor-element-e7e6742 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="e7e6742" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                    <div class="elementor-background-overlay"></div>
                    <div class="elementor-container elementor-column-gap-extended">
                        <div class="elementor-row">
                            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-b3d971d" data-id="b3d971d" data-element_type="column" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                <div class="elementor-column-wrap elementor-element-populated">
                                    <div class="elementor-widget-wrap">
                                        <div class="elementor-element elementor-element-5cd8f77 elementor-widget__width-inherit elementor-widget elementor-widget-image" data-id="5cd8f77" data-element_type="widget" data-widget_type="image.default">
                                            <div class="elementor-widget-container">
                                                <div class="elementor-image">
                                                    <img src="https://www.eventos-digitales.com/wp-content/uploads/elementor/thumbs/secciones_feria-scaled-oyarfcrpu7ym0omb6ykpzakwf2atx3i5yfbd583sso.jpg" title="secciones_feria" alt="secciones_feria">
                                                </div>
                                                <div class="elementor-image">
                                                    <a href="https://www.eventos-digitales.com/arpa-feria/junta-de-castilla-y-leon/"><img src="https://www.eventos-digitales.com/wp-content/uploads/2020/11/Stand_JCyL.jpg" title="stand_JCyL" alt="stand_JCyL"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div id="arpa_main_buscador">
    <section class="boldSection topSpaced bottomSemiSpaced gutter inherit">
        <form role="search" method="get" class="search-form">
            <label>
                <span class="screen-reader-text"><?php echo _x('Buscar:', 'label') ?></span>
                <input type="hidden" value="stands" id="modo" name="modo" />
                <input type="search" class="search-field arpa_busqueda_nombre" placeholder="<?php echo esc_attr_x('Introduzca su búsqueda...', 'placeholder') ?>"
                       value="<?php echo get_search_query() ?>" name="s" id="s"
                       title="<?php echo esc_attr_x('Buscar:', 'label') ?>"/>
                <select class="arpa_busqueda_select" name="select_entidad" id="select_entidad">
                    <option value="">Elija entidad expositora</option>
                    <option value="Institución">Institución</option>
                    <option value="Instituto de patrimonio">Instituto de patrimonio</option>
                    <option value="Fundación o asociación">Fundación o asociación</option>
                    <option value="Universidad, centro de investigación">Universidad, centro de investigación</option>
                    <option value="Escuela taller o casa de oficios">Escuela taller o casa de oficios</option>
                    <option value="Editorial o revista especializada">Editorial o revista especializada</option>
                    <option value="Empresa de restauración">Empresa de restauración</option>
                    <option value="Empresa de servicios">Empresa de servicios</option>
                    <option value="Otro">Otro</option>
                </select>
                <select class="arpa_busqueda_select" name="select_programa" id="select_programa">
                    <option value="">Elija programa</option>
                    <option value="AR&amp;PA Instituciones">AR&amp;PA Instituciones</option>
                    <option value="AR&amp;PA Negocio">AR&amp;PA Negocio</option>
                    <option value="AR&amp;PA Empleo">AR&amp;PA Empleo</option>
                    <option value="AR&amp;PA Museos">AR&amp;PA Museos</option>
                    <option value="AR&amp;PA Iniciativas">AR&amp;PA Iniciativas</option>
                    <option value="AR&amp;PA Innovación">AR&amp;PA Innovación</option>
                </select>
            </label>
            <i class="fas fa-search buscar_icon"></i><input type="submit" name="search-submit" class="search-submit arpa_submit" value="<?php echo esc_attr_x('Buscar', 'submit button') ?>"/>
        </form>
        <div id="parent_results">
            <div id="mostrar" class="rowItem btTextLeft inherit">
                <?php echo $html; ?>
            </div>
        </div>
    </section>
</div>

<?php

get_footer();