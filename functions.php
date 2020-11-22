<?php

function my_theme_enqueue_styles()
{

    $parent_style = 'parent-style'; // Estos son los estilos del tema padre recogidos por el tema hijo.

    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array($parent_style), wp_get_theme()->get('Version'));
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');

function my_custom_scripts()
{
    wp_enqueue_script('functions', get_stylesheet_directory_uri() . '/js/functions.js', array('jquery'), '', true);
}

add_action('wp_enqueue_scripts', 'my_custom_scripts');

/*Incluimos el archivo js que llamará al ajax desde el front y lo vinculamos con la función ajax de Wordpress*/
add_action('wp_enqueue_scripts', 'agregar_ajax');

function agregar_ajax()
{
    wp_register_script('functions', get_stylesheet_directory_uri() . '/js/functions.js', array('jquery'), 1.1, true);
    wp_enqueue_script('functions');
    wp_localize_script(
        'functions',
        'arpaAjaxData',
        array('ajaxurl' => admin_url('admin-ajax.php'))
    );
}

//Declarar las funciones que devolverán los datos por ajax
add_action('wp_ajax_nopriv_recoger_form', 'recoger_form');
add_action('wp_ajax_recoger_form', 'recoger_form');

add_action('wp_ajax_nopriv_datos_profesional', 'datos_profesional');
add_action('wp_ajax_datos_profesional', 'datos_profesional');

function array_search_partial($arr, $keyword)
{
    foreach ($arr as $index => $string) {
        if (strpos($string, $keyword) !== FALSE)
            return $index;
    }

    return FALSE;
}

function recoger_form()
{
    include('resultados.php');
    $html = '';
    $busqueda = $_POST['busqueda'];

    /*Estos campos son los nuevos de profesionales*/
    $actividad = $_POST['actividad'];
    $interes = $_POST['interes'];

    /*Estos son los nuevos campos de stands*/
    $entidad = $_POST['entidad'];
    $programa = $_POST['programa'];

    /*Discrimina stands o profesionales*/
    $modo = $_POST['modo'];

    // Por defecto los resultados están vacíos
    $html = '<div class="warning">No hay resultados para la búsqueda</div>';

    // estas funciones están en resultados.php
    $coincidences = tratar_resultados($busqueda, $actividad, $interes, $programa, $entidad, $modo);

    if (!empty($coincidences)) {
        if ($modo == 'profesionales') {
            $html = format_professional_results($coincidences);
        } elseif ($modo == 'stands') {
            $html = format_stand_results($coincidences);
        }
    }
    echo $html;
    wp_die();
}

function datos_profesional()
{
    include('resultados.php');
    $id = $_POST['id_profesional'];

    /*Para traer los datos de un profesional y mostrarlos en la ventana modal*/
    $html = search_profesional($id);

    echo $html;
    wp_die();
}

function array_search_prepare($array)
{
    $search_array = [];
    foreach ($array as $key => $values) {
        switch ($values->f_name) {
            case 'field-iAengUTB3aB4rty';
                $search_array['nombre'] = $values->f_val;
                break;
            case 'field-5DKUfW4Nrkc8GA1';
                $search_array['apellidos'] = $values->f_val;
                break;
            case 'field-SrYGGSOjVPMD6x9';
                $search_array['cargo'] = $values->f_val;
                break;
            case 'field-qf0eWawUTEF1uB8';
                $search_array['descint'] = $values->f_val;
                break;
            case 'text-AvdZzL';
                $search_array['email'] = $values->f_val;
                break;
            case 'field-djz2cWDp6OWAXFJ';
                $search_array['sector_actividad'] = $values->f_val;
                break;
            case 'field-bW5jAypv7ChtpZE';
                $search_array['sector_interes'] = $values->f_val;
                break;
            case 'field-fJ3ygLH1oBUWCaG';
                $search_array['empresa'] = $values->f_val;
                break;
            case 'field-wXJY5MEoR6tXU0M';
                $search_array['img'] = $values->f_val;
                break;
            case 'field-bR0fGRzA4VW6DXA';
                $search_array['stand_logo'] = $values->f_val;
                break;
            case 'field-TojtGMOYMBTfoSm';
                $search_array['stand_tematica'] = $values->f_val;
                break;
            case 'field-NLEJnYxoTYtGias';
                $search_array['stand_nombre'] = $values->f_val;
                break;
            case 'field-nbLfsqdNGBDPR6t';
                $search_array['stand_productos'] = $values->f_val;
                break;
            case 'field-2ozDegS8qIUOmrN';
                $search_array['stand_asociaciones'] = $values->f_val;
                break;
            case 'field-R0uGutwILmX5mX4';
                $search_array['stand_programa'] = $values->f_val;
                break;
            case 'field-Tg2DBc7q8SqBvux';
                $search_array['stand_entidad'] = $values->f_val;
                break;
        }
    }
    return $search_array;
}

function professional_array_prepare($array)
{

    $show_array = array_search_prepare($array);

    return $show_array;
}

function stand_array_prepare($array)
{

    $show_array = array_search_prepare($array);

    return $show_array;
}

function get_record_avatar($id)
{

    global $wpdb;
    $return = '../wp-content/themes/eventim_child/img/no-avatar.png';
    $query = "SELECT meta_value FROM w47fa_postmeta w where meta_key = '_wp_attached_file' and post_id = '{$id}'";
    $result = $wpdb->get_col($query);
    if (!empty($result[0])) {
        $return = '../wp-content/uploads/'.$result[0];
    }
    return $return;
}
/*Eliminar tildes y caracteres especiales del nombre para generar las URLs de los stands*/
function clean_url_text($cadena, $url = false){

    $cadena = mb_strtolower($cadena, 'UTF-8');

    if (strpos($cadena, 'moleiro')){
        $cadena = 'm. moleiro - el arte de la perfección';
    }

    //Reemplazamos la A y a
    $cadena = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª', 'Ã','ã'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a','A', 'a'),
        $cadena
    );

    //Reemplazamos la E y e
    $cadena = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
        $cadena );

    //Reemplazamos la I y i
    $cadena = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
        $cadena );

    //Reemplazamos la O y o
    $cadena = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô', 'Õ' ,'õ'),
        array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o', 'O', 'o'),
        $cadena );

    //Reemplazamos la U y u
    $cadena = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
        $cadena );

    //Reemplazamos la N, n, C y c
    $cadena = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç'),
        array('N', 'n', 'C', 'c'),
        $cadena
    );

    //Eliminamos signos de puntuación
    $cadena = str_replace(
        array(':', '.', ',', ';', "'", '(', ')', '¡', '!' , '?', '¿'),
        array('', '', '', '', '', '', '', '', '', '', ''),
        $cadena
    );

    if ($url) {
        $cadena = str_replace('/','-',$cadena);

        $cadena = str_replace('_','-',$cadena);

        $cadena = str_replace(' - ',' ',$cadena);

        $cadena = str_replace('"','',$cadena);

        $cadena = trim($cadena);

        $cadena = str_replace(' ','-',$cadena);

        $cadena = rtrim($cadena, '-');
    }

    return $cadena;
}


