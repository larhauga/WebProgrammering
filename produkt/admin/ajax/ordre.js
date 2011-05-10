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
                    
                    $.post("ajax/ordre.php", { "hentData": ordreid},
                     function(data){
                       $("#fornavn").html(data.fornavn);
                       $("#etternavn").html(data.etternavn);
                       $("#adresse").html(data.adresse);
                       $("#postnr").html(data.postnr);
                       $("#poststed").html(data.poststed);
                       $("#tlf").html(data.tlf);
                       $("#ordreid").html(data.ordreid);
                       $("#ordredato").html(data.ordredato);
                       $("#sendt").html(data.sendt);
                     }, "json");
                  $("#forms").slideDown("slow");
                  $('#loading').html('');
                  $('#innhold').html('<p><img src="../includes/images/ajax-loader.gif" /></p>');
                  $('#innhold').load("ajax/ordre.php?idordre=" + ordreid);
                      
            });
   $("#sendt").click(function() {
       var ordreid = document.getElementById("ordreid").html();
       alert(ordreid);
       $("#forms").fadeOut("fast");
       
       $.post("ajax/produkt.php", { "sendt": ordreid}, function() {});
       $("#forms").fadeIn("fast");
   });
   $("#slett").click(function() {
       var ordreid = document.getElementById("ordreid").html();
       $.post("ajax/produkt.php", { "slett": ordreid}, function() {});
   });

   $("#slettVare").click(function() {
       
   });