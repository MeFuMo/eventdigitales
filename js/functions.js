jQuery(document).ready(function() {
    jQuery('.search-form').on("submit", function (e) {
        e.preventDefault();
        var busqueda = jQuery('#s').val();
        var modo = jQuery('#modo').val();
        jQuery("#mostrar").html('<p style="text-align:center"><img alt="Buscando" src="../wp-content/themes/eventim_child/js/loadingAnimation.gif"/><br>Buscando</p>');
        jQuery.ajax({
            url: arpaAjaxData.ajaxurl,
            data: {
                action: 'recoger_form',
                busqueda: busqueda,
                modo: modo
            },
            type: 'POST',
            success: function (data) {
                jQuery("#mostrar").html('');
                jQuery("#mostrar").append(data);
                jQuery('#s').val('');
            }
        });
    });
});