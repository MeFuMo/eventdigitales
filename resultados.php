<?php

function tratar_resultados($busqueda, $modo){
    // global de WP para la base de datos
    global $wpdb;
    $busqueda = sanitize_text_field($busqueda);
    $modo = sanitize_text_field($modo);
    $coincidences = [];

    if($modo == 'profesionales') {
        $post_title = '1888';
    } elseif ($modo == 'stands') {
        $post_title = '2016';
    }
    // Haciendo query para todo lo que sea
    $results = $wpdb->get_results( "SELECT id, post_content FROM {$wpdb->prefix}posts WHERE post_type = 'erforms_submission' and post_title like '%{$post_title}%'", OBJECT );

    if (count($results )> 0) {
        foreach ($results as $result) {
            // decodificamos el post_content
            $result_array = json_decode($result->post_content);
            // preparamos un array asociativo con los campos de busqueda
            $searchable_array = array_search_prepare($result_array->fields_data);
            // si hay alguna coincidencia

                // guardamos el resultado para mostrar
                foreach($searchable_array as $index => $string) {
                    if (strpos(strtoupper($string), strtoupper($busqueda)) !== FALSE)
                        $coincidences[$result->id] = $result_array->fields_data;
                }

        }
    }

    else {
        $coincidences['no_results'] = 'No hay resultados para la búsqueda';
    }


    return $coincidences;

}

function format_professional_results($coincidences) {

    $html = '';
    if ($coincidences['no_results']) {
        $html = $coincidences['no_results'];
    } else {
        foreach ($coincidences as $coincidence) {
            $show = professional_array_prepare($coincidence);
            $html .= '<div class="div_resultados_prof"><span class="nombre">Nombre: ' . $show["nombre"] . ' Apellidos: ' . $show["apellidos"] . '</span><span class="cargo"> Cargo: ' . $show["cargo"] . '</span> <span class="empresa">Empresa: ' . $show["empresa"] . '</span><span class="mostrar_mas">Mostrar más</span></div>';
        }
        return $html;
    }
}

function format_stand_results($coincidences) {

    $html = '';
    if ($coincidences['no_results']) {
        $html = $coincidences['no_results'];
    } else {
        foreach ($coincidences as $coincidence) {
            $show = stand_array_prepare($coincidence);
            $html .= '<div class="div_resultados_stands">Nombre: ' . $show["stand_nombre"] . '</div>';
        }
    }
    return $html;
}