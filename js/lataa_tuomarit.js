$(document).ready(function () {
    $(document).ready(function () {
        $('#eraForm').on('submit', function () {
            let selectedOption = $("#era_numero option:selected");
            let vaihe = selectedOption.data("vaihe");
            $('#vaihe').val(vaihe);
        });
    });
    
    function getSelectedEraVaihe() {
        let eraNumero = $("#selected-era").text().trim();
        let vaihe = $("#selected-vaihe").text().trim();
        return { eraNumero, vaihe };
    }
    // Lataa erän tuomarit ja radat
    function lataaTuomarit() {
        let { eraNumero, vaihe } = getSelectedEraVaihe();

        if (!eraNumero || !vaihe) {
            console.log("Erä numero tai vaihe puuttuu.");
            return;
        }

        $.ajax({
            url: 'inc/rata_tuomarit.php',
            method: 'GET',
            data: { era_numero: eraNumero, vaihe: vaihe },
            dataType: 'json',
            success: function (response) {
                if (response.error) {
                    console.error("Error:", response.error);
                    return;
                }

                $('td[id^="status-"]').html("-"); // Tyhjennä vanhat tiedot

                response.forEach((rata) => {
                    var status = rata.valmis ? "✅ Valmiina" : "❌ Ei Valmiina";
                    $("#status-" + rata.rataid).html(status);
                });
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
            }
        });
    }

    // Päivitä 5 sekunnin välein
    setInterval(lataaTuomarit, 5000);

    $('#era_numero, #vaihe').change(lataaTuomarit);
});
