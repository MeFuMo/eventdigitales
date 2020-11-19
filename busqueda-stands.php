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
foreach ($coincidences as $key => $coincidence) {
    $num_stand++;
    $show = stand_array_prepare($coincidence);
    $avatar = get_record_avatar($show['stand_logo']);

    $url = clean_url_text($show['stand_nombre']);

    $html .= '<div class="div_resultados_stands"><a href="../arpa-feria/'.$url.'" title="' . $show["stand_nombre"] . '">'.
        '<img class="avatar_stands" alt="'. $show["stand_nombre"] . '" src="' . $avatar . '" /></a>'.
        '<br>' . $show['stand_nombre'] . '</div>';
    if ($num_stand % 4 == 0) {
        $html = $html . '<br>';
    }
}
?>
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
                <select class="arpa_busqueda_select" name="select_entidad" id="select_entidad">
                    <option value="">Elija programa</option>
                    <option value="AR&amp;PA Instituciones">AR&amp;PA Instituciones</option>
                    <option value="AR&amp;PA Negocio">AR&amp;PA Negocio</option>
                    <option value="AR&amp;PA Empleo">AR&amp;PA Empleo</option>
                    <option value="AR&amp;PA Museos">AR&amp;PA Museos</option>
                    <option value="AR&amp;PA Iniciativas">AR&amp;PA Iniciativas</option>
                    <option value="AR&amp;PA Innovación">AR&amp;PA Innovación</option>
                </select>
            </label>
            <input type="submit" name="search-submit" class="search-submit arpa_submit" value="<?php echo esc_attr_x('Buscar', 'submit button') ?>"/>
        </form>
        <div id="parent_results">
            <div id="mostrar" class="rowItem col-md-7 col-sm-12 btTextLeft inherit">
                <?php echo $html; ?>
            </div>
        </div>
    </section>
</div>

<?php

get_footer();