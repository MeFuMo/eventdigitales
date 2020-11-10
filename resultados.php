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
                    if (strpos(strtoupper($string), strtoupper($busqueda)) !== FALSE) {
                        $coincidences[$result->id] = $result_array->fields_data;
                    }
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
        foreach ($coincidences as $key => $coincidence) {
            $show = professional_array_prepare($coincidence);
            /*Invención para mostrar un avatar si no existe*/
            if(!$show['avatar']) {
                $avatar = '../wp-content/themes/eventim_child/img/no-avatar.png';
            } else {
                $avatar = $show['avatar'];
            }
            $html .= '<div class="div_resultados_prof"><span><img alt="avatar" class="avatar" src="'.$avatar.'" /></span><div class="datos_prof">Nombre: ' .
                $show["nombre"] . ' ' . $show["apellidos"] . ' <span style="margin-left:50px;">Cargo: ' . $show["cargo"] . '</span><br>Empresa: ' .
                $show["empresa"] . '</div><div id="'.$key.'" class="mostrar_mas" onclick="mostrar_modal('.$key.')">Mostrar más</div></div>';
        }
        return $html;
    }
}

function format_stand_results($coincidences) {

    $html = '';
    $num_stand = 0;
    if ($coincidences['no_results']) {
        $html = $coincidences['no_results'];
    } else {
        foreach ($coincidences as $coincidence) {
            $num_stand ++;
            $show = stand_array_prepare($coincidence);
            /*Invención para mostrar un avatar si no existe*/
            if(!$show['avatar']) {
                $avatar = '../wp-content/themes/eventim_child/img/no-avatar.png';
            } else {
                $avatar = $show['avatar'];
            }
            $html .= '<div class="div_resultados_stands">'.$show['stand_nombre'].'<br><a href="#" title="' . $show["stand_nombre"] . '"><img class="avatar_stands" alt="' . $show["stand_nombre"] . '" src="'.$avatar.'" /></a></div>';
            if ($num_stand % 4 == 0) {
                $html = $html . '<br>';
            }
        }
    }
    return $html;
}

function search_profesional($id_profesional){
    global $wpdb;
    $results = $wpdb->get_results( "SELECT id, post_content FROM {$wpdb->prefix}posts WHERE post_type = 'erforms_submission' and post_title like '%1888%' and id = {$id_profesional}", OBJECT );

    foreach ($results as $result) {
        if (count($result) > 0) {
            // decodificamos el post_content
            $result_array = json_decode($result->post_content);
            // preparamos un array asociativo con los campos de busqueda
            $searchable_array = array_search_prepare($result_array->fields_data);
            // si hay alguna coincidencia

            // guardamos el resultado para mostrar
            foreach ($searchable_array as $index => $string) {
                $coincidences[$result->id] = $result_array->fields_data;
            }
        } else {
            $coincidences['no_results'] = 'No hay resultados para la búsqueda';
        }
    }

    foreach ($coincidences as $key => $coincidence) {
        $data = professional_array_prepare($coincidence);
        /*Invención para mostrar un avatar si no existe*/
        if(!$data['avatar']) {
            $data['avatar'] = '../wp-content/themes/eventim_child/img/no-avatar.png';
        }
        $sectores = '';
        foreach ($data['sector_interes'] as $sector) {
            $sectores = $sectores . $sector .', ';
        }

        $html = '<div id="avatar_prof">
                            <img src="'. $data['avatar'] .'" class="avatar_prof" alt="avatar">
                        </div>
                        <h2 class="tit_modal">Datos del Profesional</h2>
                        <div style="margin: 0px;position: relative;top: -25px;">
                            <div class="label_popup" style="">Apellidos</div><div class="result_data" id="apellidos">'.$data['apellidos'].'</div>
                            <div class="label_popup">Nombre</div><div class="result_data" id="nombre">'.$data['nombre'].'</div>
                            <div class="label_popup">Empresa/Institución</div><div class="result_data" id="empresa" style="font-size:14px;">'.$data['empresa'].'</div>
                            <div class="label_popup">Cargo</div><div class="result_data" id="cargo">'.$data['cargo'].'</div>
                            <div class="label_popup">Otro cargo (si lo hubiera)</div><div class="result_data" id="otro_cargo">'.$data['otro_cargo'].'</div>
                            <div class="label_popup">Sector de actividad</div><div class="result_data" id="sector_actividad">'.$data['sector_actividad'].'</div>
                            <div class="label_popup">Sectores de interés</div><textarea disabled rows="5" cols="30" readonly id="sector_interes">'.$sectores.'</textarea>
                            <div class="label_popup">Perfil Profesional</div><textarea disabled rows="5" cols="30" readonly id="perfil">'.$data['perfilprof'].'</textarea>
                            <div class="label_popup">Intereses</div><textarea disabled rows="5" cols="30" readonly id="intereses">'.$data['descint'].'</textarea>
                        </div>';
    }

    return $html;
}