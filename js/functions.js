jQuery(document).ready(function() {
    jQuery('.search-form').on("submit", function (e) {
        e.preventDefault();
        var busqueda = jQuery('#s').val();
        var actividad = jQuery('#select_actividad').val();
        var interes = jQuery('#select_interes').val();
        var entidad = jQuery('#select_entidad').val();
        var programa = jQuery('#select_programa').val();
        if (programa){
            programa = programa.replace('&', '&amp;');
        }
        var modo = jQuery('#modo').val();
        jQuery("#mostrar").html('<p style="text-align:center"><img alt="Buscando" src="../wp-content/themes/eventim_child/img/loadingAnimation.gif"/><br>Buscando</p>');
        jQuery.ajax({
            url: arpaAjaxData.ajaxurl,
            data: {
                action: 'recoger_form',
                busqueda: busqueda,
                actividad: actividad,
                interes: interes,
                entidad: entidad,
                programa: programa,
                modo: modo
            },
            type: 'POST',
            success: function (data) {
                jQuery('#s').val('');
                jQuery('#select_actividad').val('');
                jQuery('#select_interes').val('');
                jQuery('#select_entidad').val('');
                jQuery('#select_programa').val('');
                jQuery("#mostrar").html('');
                jQuery("#mostrar").append(data);
                jQuery('#s').val('');
            }
        });
    });
});

function mostrar_modal(profesional_id){
    jQuery('html, body').animate({scrollTop:0}, 'slow');
    jQuery("html").css("overflow","hidden");
    var sectores = '';
    jQuery(".contenido_popup").html('<p style="text-align:center"><img alt="Buscando" src="../wp-content/themes/eventim_child/img/loadingAnimation.gif"/><br>Buscando</p>');
    jQuery.ajax({
        url: arpaAjaxData.ajaxurl,
        data: {
            action: 'datos_profesional',
            id_profesional: profesional_id,
            contentType: "application/json",
            dataType: 'json',
        },
        type: 'POST',
        success: function (data) {
            jQuery(".contenido_popup").html('');
            jQuery(".contenido_popup").append(data);

        }
    });
    jQuery('#popup').fadeIn('slow');
    jQuery('.popup-overlay').fadeIn('slow');
    jQuery('.popup-overlay').height(jQuery(window).height());
    return false;
}

function cerrar_modal(){
    jQuery('#popup').fadeOut('slow');
    jQuery('.popup-overlay').fadeOut('slow');
    jQuery("html").css("overflow","scroll");
    return false;
}