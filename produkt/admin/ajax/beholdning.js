

$("#kategoriID").change(function () {
        $("#resultat").load("ajax/beholdning.php?kategori=" + $("#kategoriID").val());
    });
    $("#sok").keyup(function() {
      $("#resultat").load("ajax/beholdning.php?sok=" + document.getElementById("sok").value);
});

    $("#endreAntall").click(function () {
   var data = $(":checkbox:checked").map(function(i,n)
   {
      return $(n).val();
   }).get();
   var antallet = document.getElementById("antall").value;

    $.post("ajax/beholdning.php", { 'varer[]': data, antall: antallet },
          function(){
                        $('#resultat').fadeOut('slow', function() {});
                        $("#resultat").load("ajax/beholdning.php?sok=" + document.getElementById("sok").value);
                        $('#resultat').fadeIn('slow', function() {});
                        $("#formHoyre").slideUp("slow");
                  });
    });
            
            