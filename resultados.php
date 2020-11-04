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

    foreach ($results as $result) {
        // decodificamos el post_content
        $result_array = json_decode($result->post_content);
        // preparamos un array asociativo con los campos de busqueda
        $searchable_array = array_search_prepare($result_array->fields_data);
        // si hay alguna coincidencia
        if( array_search_partial( $searchable_array, $busqueda ) ) {
            // guardamos el resultado para mostrar
            $coincidences[$result->id] = $result_array->fields_data;
        }
    }

    return $coincidences;

}

function format_professional_results($coincidences) {

    $html = '';
    foreach ($coincidences as $coincidence) {
        $show = professional_array_prepare($coincidence);
        $html .= '<div class="result">Nombre: ' . $show["nombre"] . ' Apellidos: ' . $show["apellidos"] . ' Cargo: ' . $show["cargo"] . ' Empresa: ' . $show["empresa"] . '</div>';
    }
    return $html;

}

function format_stand_results($coincidences) {

    $html = '';
    foreach ($coincidences as $coincidence) {
        $show = stand_array_prepare($coincidence);
        $html .= '<div class="result">Nombre: ' . $show["stand_nombre"] . '</div>';
    }
    return $html;

}