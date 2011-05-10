/* 
 * Javascriptfil som hjelper php ajax fil og utfører requestene
 */

    $("#sok").keyup(function() {
      $("#resultat").load("ajax/ordre.php?sok=" + document.getElementById("sok").value);
      $("#test").append('<script src="ajax/ordre.js"></script>');
});
    

        $('input:radio').click(function() {
            var ordreid = $(this).val();
                $('#loading').html('<img src="../includes/images/ajax-loader.gif" />');
                    $.post("ajax/produkt.php", { "hentData": ordreid},
                     function(data){
                       $("#fornavn").val("");
                       $("#etternavn").val(data.etternavn);
                       $("#adresse").val(data.adresse);
                       $("#postnr").val(data.postnr);
                       $("#poststed").val(data.poststed);
                       $("#tlf").val(data.tlf);
                       $("#ordreid").val(data.ordreid);
                       $("#ordredato").val(data.ordredato);
                       $("#sendt").val(data.sendt);
                     }, "json");
                  $('#loading').html('');
                  $('#formHoyre').html('<p><img src="../includes/images/ajax-loader.gif" /></p>');
                  $('#formHoyre').load("ajax/ordre.php?idordre=" + ordreid);
                      
            });
   $("#sendt").click(function() {
       var ordreid = document.getElementById("ordreid").val();
       $.post("ajax/produkt.php", { "sendt": ordreid}, function() {});
   });
   $("#slett").click(function() {
       var ordreid = document.getElementById("ordreid").val();
       $.post("ajax/produkt.php", { "slett": ordreid}, function() {});
   });
