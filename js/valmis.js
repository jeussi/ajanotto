//Päivittää radan valmiuden tietokantaan.
$(document).ready(function() {
    $('#readyBtn').click(function() {
        let rataId = $('#joukkue option:selected').data('rataid');

        if (rataId) {
            valmis(rataId);
        } else {
            alert('Please select a team first!');
        }
    });
    function valmis(rataId) {
        $.ajax({
            url: 'inc/rata_valmis.php',
            method: 'POST',
            data: { rataid: rataId },
            success: function(response) {
                console.log(response)
                alert('Rata ' + rataId + ' on valmis!');
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
});