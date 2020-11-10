<?php

function my_theme_enqueue_styles()
{

    $parent_style = 'parent-style'; // Estos son los estilos del tema padre recogidos por el tema hijo.

    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array($parent_style), wp_get_theme()->get('Version'));
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');

function my_custom_scripts() {
    wp_enqueue_script( 'functions', get_stylesheet_directory_uri() . '/js/functions.js', array( 'jquery' ),'',true );
}

add_action( 'wp_enqueue_scripts', 'my_custom_scripts' );

/*Incluimos el archivo js que llamará al ajax desde el front y lo vinculamos con la función ajax de Wordpress*/
add_action('wp_enqueue_scripts', 'agregar_ajax');

function agregar_ajax() {
    wp_register_script( 'functions', get_stylesheet_directory_uri().'/js/functions.js', array ( 'jquery' ), 1.1, true);
    wp_enqueue_script( 'functions');
    wp_localize_script(
        'functions',
        'arpaAjaxData',
        array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) )
    );
}

//Declarar las funciones que devolverán los datos por ajax
add_action('wp_ajax_nopriv_recoger_form','recoger_form');
add_action('wp_ajax_recoger_form','recoger_form');

add_action('wp_ajax_nopriv_datos_profesional','datos_profesional');
add_action('wp_ajax_datos_profesional','datos_profesional');

function array_search_partial($arr, $keyword) {
    foreach($arr as $index => $string) {
        if (strpos($string, $keyword) !== FALSE)
            return $index;
    }

    return FALSE;
}

function recoger_form() {
    include('resultados.php');

    $busqueda = $_POST['busqueda'];
    $modo = $_POST['modo'];
    // Por defecto los resultados están vacíos
    $html = 'No hay resultados para la búsqueda';

    // estas funciones están en resultados.php
    $coincidences = tratar_resultados($busqueda, $modo);

    if(!empty($coincidences)) {
        if ($modo == 'profesionales') {
            $html = format_professional_results($coincidences);
        } elseif ($modo == 'stands') {
            $html = format_stand_results($coincidences);
        }
    }

    echo $html;
    wp_die();
}

function datos_profesional(){
    include('resultados.php');
    $id = $_POST['id_profesional'];
/*Para traer los datos de un profesional y mostrarlos en la ventana modal*/
    $html = search_profesional($id);

    echo $html;
    wp_die();
}

function array_search_prepare($array) {
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
            case 'field-6c5pMGRjtLbDWY1';
                $search_array['perfilprof'] = $values->f_val;
                break;
            case 'field-qf0eWawUTEF1uB8';
                $search_array['descint'] = $values->f_val;
                break;
            case 'field-NLEJnYxoTYtGias';
                $search_array['stand_nombre'] = $values->f_val;
                break;
            case 'field-nbLfsqdNGBDPR6t';
                $search_array['stand_productos'] = $values->f_val;
                break;
            case 'field-JRnfP7QR4htDszo';
                $search_array['otro_cargo'] = $values->f_val;
                break;
            case 'field-djz2cWDp6OWAXFJ';
                $search_array['sector_actividad'] = $values->f_val;
                break;
            case 'field-bW5jAypv7ChtpZE';
                $search_array['sector_interes'] = $values->f_val;
                break;
            case 'field-fJ3ygLH1oBUWCaG';
                $show_array['empresa'] = $values->f_val;
                break;
        }
    }
   return $search_array;
}

function professional_array_prepare($array) {

    $show_array = array_search_prepare($array);

    return $show_array;
}

function stand_array_prepare($array) {

    $show_array = array_search_prepare($array);

    return $show_array;
}

function get_record_avatar($id) {

    global $wpdb;
    $query = "SELECT meta_value FROM w47fa_postmeta w where meta_key = '_wp_attached_file' and post_id = '{$id}'";
    $result = $wpdb->get_col($query);
    return $result[0];
}


