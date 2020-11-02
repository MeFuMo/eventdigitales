jQuery(document).ready(function() {
    jQuery('.search-form').on("submit", function (e) {
        e.preventDefault();
        var busqueda = jQuery('#s').val();
        jQuery.ajax({
            url: arpaAjaxData.ajaxurl,
            data: {
                action: 'recoger_form',
                busqueda: busqueda
            },
            type: 'POST',
            success: function (data) {
                jQuery("#mostrar").html('');
                jQuery("#mostrar").append(data);
            }
        });
    });
});