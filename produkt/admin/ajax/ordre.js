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
    $("#sendtKnapp").click(function() {
       var ordreid = $("#ordreid").html();
           $("#forms").fadeOut("fast");
           $("#loading").html('<img src="../includes/images/ajax-loader.gif" />');
           $.post("ajax/produkt.php", { "sendt": ordreid}, function() {
                $("#loading").html("");
           });
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
           $("#forms").fadeIn("fast");
   });
   $("#slettKnapp").click(function() {
       var ordreid = $("#ordreid").html();
       $.post("ajax/ordre.php", { "slett": ordreid}, function() {});
       $("#forms").slideUp("slow");
   });

   $("#slettVare").click(function() {
       $("#innhold").fadeOut("fast");
       var data = $(":checkbox:checked").map(function(i,n)
       {
          return $(n).val();
       }).get();
        $.post("ajax/ordre.php", { 'slettVare[]': data },
          function(){
              
          });
          $('#innhold').html('<img src="../includes/images/ajax-loader.gif" />');
          $('#innhold').load("ajax/ordre.php?idordre=" + ordreid);
       $("#innhold").fadeIn('fast');
   });