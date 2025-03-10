$(document).ready(function() {
    $('#era').change(function() {
        var valittuEra = $(this).val(); 

        if (valittuEra) {
            $.ajax({
                url: 'inc/tulospalvelu_erat.php', 
                type: 'GET',
                data: { era: valittuEra },
                success: function(data) {
                    $('#era_numero').html(data);
                }
            });
        } else {
            $('#era_numero').html('<option value="">- Valitse eränumero -</option>');
        }
    });
});