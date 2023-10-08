// En tu archivo JavaScript

jQuery(document).ready(function($) {
    $('#taxonomy-marca').on('change', function() {
        var marca_id = $(this).val();
        $.ajax({
            url: coche.ajax_url,
            method: 'POST',
            data: {
                action: 'filtrar_modelos_por_marca',
                marca_id: marca_id,
                nonce: coche.nonce,
            },
            beforeSend: function() {
                $('#tagsdiv-modelo .tagchecklist').empty();
                $('#tagsdiv-modelo .spinner').addClass('is-active');
            },
            success: function(response) {
                if (response.success) {
                    $('#tagsdiv-modelo .spinner').removeClass('is-active');
                    $('#tagsdiv-modelo .tagchecklist').html(response.data);
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });

    $('#taxonomy-modelo').append('<input type="hidden" name="marca_id" value="">');
    $('#taxonomy-modelo').on('submit', function() {
        var marca_id = $('#taxonomy-marca').val();
        $('input[name="marca_id"]').val(marca_id);
    });
});