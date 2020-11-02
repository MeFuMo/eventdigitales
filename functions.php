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
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script( 'functions', plugins_url('js/functions.js',dirname(__FILE__)), array ( 'jquery' ), 1.1, true);
    wp_localize_script(
        'functions',
        'arpaAjaxData',
        array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) )
    );
});

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

    $html = tratar_resultados($busqueda);

    echo $html;
    wp_die();
}


function tratar_resultados(){

}