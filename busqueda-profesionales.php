<?php
/*
* Template Name: Busqueda de Profesionales
*/

// cosas de WP

boldthemes_set_override();

get_header();

$action_slug = $wp_query->query_vars['name'];

/*Para mostrar todos los profesionales al cargar la página*/

$results = $wpdb->get_results("SELECT id, post_content FROM {$wpdb->prefix}posts WHERE post_type = 'erforms_submission' and post_title like '%1888%'", OBJECT);

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

foreach ($coincidences as $key => $coincidence) {
    $show = professional_array_prepare($coincidence);

    $show['apellidos'] = mb_strtolower($show['apellidos'], 'UTF-8');
    $show['nombre'] = mb_strtolower($show['nombre'], 'UTF-8');
    $show['empresa'] = mb_strtolower($show['empresa'], 'UTF-8');

    $show['cargo'] = str_replace ('O', 'o', $show['cargo']);
    $array_cargo = explode('/',$show['cargo']);
    $cargo = trim($array_cargo[0]);

    $show['avatar'] = get_record_avatar($show['img']);
    $html .= '<div class="div_resultados_prof"><div class="avatar"><img alt="avatar" src="' . $show['avatar'] . '" /></div><div class="datos_prof"><span class="nombre">' .
        $show["nombre"] . ' ' . $show["apellidos"] . '</span><span class="cargo">' . $cargo . '</span><span class="empresa">' .
        $show["empresa"] . '</span><span id="' . $key . '" class="mostrar_mas" onclick="mostrar_modal(' . $key . ')">Mostrar más</span></div></div>';
}
?>
    <div data-elementor-type="wp-page" data-elementor-id="3719" class="elementor elementor-3719" data-elementor-settings="[]" style="background-color:white;">
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
                                                    <img src="https://www.eventos-digitales.com/wp-content/uploads/2020/11/secciones_profesionales-1200x382.jpg" class="attachment-large size-large" alt="" loading="lazy" srcset="https://www.eventos-digitales.com/wp-content/uploads/2020/11/secciones_profesionales-1200x382.jpg 1200w, https://www.eventos-digitales.com/wp-content/uploads/2020/11/secciones_profesionales-320x102.jpg 320w, https://www.eventos-digitales.com/wp-content/uploads/2020/11/secciones_profesionales-768x245.jpg 768w, https://www.eventos-digitales.com/wp-content/uploads/2020/11/secciones_profesionales-1536x490.jpg 1536w, https://www.eventos-digitales.com/wp-content/uploads/2020/11/secciones_profesionales-2048x653.jpg 2048w, https://www.eventos-digitales.com/wp-content/uploads/2020/11/secciones_profesionales-540x172.jpg 540w" sizes="(max-width: 1200px) 100vw, 1200px" width="1200" height="382">											</div>
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
                <input type="hidden" value="profesionales" id="modo" name="modo" />
                <input type="search" class="search-field arpa_busqueda_nombre" placeholder="<?php echo esc_attr_x('Introduzca su búsqueda...', 'placeholder') ?>"
                       value="<?php echo get_search_query() ?>" name="s" id="s"
                       title="<?php echo esc_attr_x('Buscar:', 'label') ?>"/>
            </label>
            <label>
                <select class="arpa_busqueda_select" name="select_actividad" id="select_actividad">
                    <option value="">Todas las actividades</option>
                    <option value="Institución Pública">Institución Pública</option>
                    <option value="Institución Privada">Institución Privada</option>
                    <option value="Instituto de Patrimonio">Instituto de Patrimonio</option>
                    <option value="Fundación o Asociación">Fundación o Asociación</option>
                    <option value="Universidad, curso o máster">Universidad, curso o máster</option>
                    <option value="Escuela taller">Escuela taller</option>
                    <option value="Casa de oficios">Casa de oficios</option>
                    <option value="Empresa de Restauración">Empresa de Restauración</option>
                    <option value="Empresa de Arqueología">Empresa de Arqueología</option>
                    <option value="Empresa de Servicios">Empresa de Servicios</option>
                    <option value="Empresa de Materiales">Empresa de Materiales</option>
                    <option value="Restaurador">Restaurador</option>
                    <option value="Arquitecto">Arquitecto</option>
                    <option value="Arqueólog">Arqueólogo</option>
                    <option value="Artesano">Artesano</option>
                    <option value="Historiador">Historiador</option>
                    <option value="Gestor cultural">Gestor cultural</option>
                    <option value="Feria o Bienal">Feria o Bienal</option>
                    <option value="Museo">Museo</option>
                    <option value="Editorial o Revista especializada">Editorial o Revista especializadae</option>
                    <option value="Prensa especializada">Prensa especializada</option>
                    <option value="Otro">Otro</option>
                </select>

            </label>
            <select class="arpa_busqueda_select" name="select_interes" id="select_interes">
                <option value="">Todos los intereses</option>
                <option value="AR&amp;PA Feria">AR&amp;PA Feria</option>
                <option value="AR&amp;PA Foro">AR&amp;PA Foro</option>
                <option value="AR&amp;PA Premios">AR&amp;PA Premios</option>
                <option value="AR&amp;PA Innovación">AR&amp;PA Innovación</option>
                <option value="Institución pública">Institución pública</option>
                <option value="AR&amp;PA Museos">AR&amp;PA Museos</option>
                <option value="Instituto de Patrimonio">Instituto de Patrimonio</option>
                <option value="Fundación o Asociación">Fundación o Asociación</option>
                <option value="Universidad, curso o máster">Universidad, curso o máster</option>
                <option value="Escuela taller o Casa de oficios">Escuela taller o Casa de oficios</option>
                <option value="Casa de oficios">Casa de oficios</option>
                <option value="Editorial o Revista especializada">Editorial o Revista especializada</option>
                <option value="Empresa de Restauración">Empresa de Restauración</option>
                <option value="Empresa de Arqueología">Empresa de Arqueología</option>
                <option value="Empresa de Servicios">Empresa de Servicios</option>
                <option value="Empresa de Materiales">Empresa de Materiales</option>
                <option value="Gestión Cultural">Gestión Cultural</option>

            </select>
            <i class="fas fa-search buscar_icon"></i><input type="submit" name="search-submit" class="search-submit arpa_submit" value="<?php echo esc_attr_x('Buscar', 'submit button') ?>"/>
        </form>
        <div id="parent_results">
            <div id="mostrar" class="rowItem col-md-6 col-sm-12 btTextLeft inherit">
                <?php echo $html; ?>
            </div>
        </div>
        <div id="popup" style="display: none;">
            <div class="content-popup">
                <div class="close"><a href="#" id="close" onclick="cerrar_modal();">X</a></div>
                <div class="margen_popup">
                    <div class="contenido_popup">
                    </div>
                </div>
            </div>
        </div>
        <div class="popup-overlay"></div>
    </section>
</div>
<?php

get_footer();