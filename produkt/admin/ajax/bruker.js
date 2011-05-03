        /* Utføres når man trykker slett: Skal utføre slettingen og sende et array */
        $("#slett").click(function (){
           
           var data = $(":checkbox:checked").map(function(i,n)
           {
              return $(n).val();
           }).get();

            $.post("ajax/bruker.php", { slett: 'true', 'bruker[]': data },
                  function(data){
                                $("#slettet").html("<h2>Brukerne er slettet</h2>" + data);
                                $('#resultat').fadeOut('slow', function() {});
                                $("#resultat").load("ajax/sok.php?sok=" + document.getElementById("sok").value);
                                $('#resultat').fadeIn('slow', function() {});
                                
                          });
                          
                $("#slettet").slideDown("slow");
                setTimeout(
                  function() 
                  {
                    $("#slettet").fadeOut("slow");
                    $("#slettet").slideUp("slow");
                  }, 5000);
        });
                                
                                
        /* Endre skal kun ta seg av slidinga */
        $("#endre").click(function () {
                $("#formVenstre").slideToggle("slow");
        });

        /* Må hente arrayet. Ajax for å sette brukere til admin */
        $("#sett").click(function () {
                $("#formHoyre").slideToggle("slow");

        });

        /* Setter data til endringsfeltet når en checkbox er valgt */
        $("#bruker").change(function() {
        /*
        var katID = $("#kategoriID").val();

            $.post("process.php", { \'deleteCB[]\': data },
                  function(){
                         $(\'body\').load(\'index.php\', function() {
                         $dialog.dialog({title: \'Item(s) Deleted\'});
                          });
           });
           */
        });

        $(function() {
            $("#selectAll").click(function()
              {
                var checked_status = this.checked;
                $('input[name="bruker[]"]').each(function()
                    {
                      this.checked = checked_status;
                    });
               });
            $("#brukerForm").submit(function(e) {
                  return false;       
              });
        });