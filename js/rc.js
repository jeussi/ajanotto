$(document).ready(function() {
    function tarkistaValmius() {
        $.ajax({
            url: 'inc/rata_tarkistus.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.valmis_count === 6) {
                    $("#startAllBtn").prop("disabled", false); // Nappia voi painaa vain jos on kaikki 6 rataa valmiina
                } else {
                    $("#startAllBtn").prop("disabled", true); // Muuten disabled
                }
            }
        });
    }

    setInterval(tarkistaValmius, 5000); //Päivitetään 5 sekunnin välein

    $("#startAllBtn").on("click", function() {
        $.ajax({
            url: 'inc/ajan_aloitus.php',
            method: 'POST',
            success: function(response) {
                console.log("Ajanotto käynnistetty kaikilla radoilla.");
            },
            error: function() {
                console.error("Ajanoton käynnistys epäonnistui.");
            }
        });
    });

    $("#resetAllBtn").on("click", function() {
        $.ajax({
            url: 'inc/reset_aika.php',
            method: 'POST',
            success: function(response) {
                console.log("Nollattiin ratojen valmius sekä ajan aloitus");
            },
            error: function() {
                console.error("Nollaus epäonnistui.");
            }
        });
    });
});
