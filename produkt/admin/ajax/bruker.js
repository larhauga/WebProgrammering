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

        /* Når man trykker på set til admin, kommer en ny boks opp hvor man må velge hvilken tilgangstype den skal ha. */
        $("#sett").click(function () {
                $("#formHoyre").slideToggle("slow");
        });
        
        /* Kjører funksjonen som setter adminrettighetene.*/
        $("#sendAdmin").click(function () {
           var data = $(":checkbox:checked").map(function(i,n)
           {
              return $(n).val();
           }).get();
           var tilgang = document.getElementById("status").value;
           
            $.post("ajax/bruker.php", { admin: 'true', 'bruker[]': data, rettigheter: tilgang },
                  function(){
                                $('#resultat').fadeOut('slow', function() {});
                                $("#resultat").load("ajax/sok.php?sok=" + document.getElementById("sok").value);
                                $('#resultat').fadeIn('slow', function() {});
                                $("#formHoyre").slideUp("slow");
                          });
        });
        
        /* Setter data til endringsfeltet når en checkbox er valgt 
         * Bruker også denne metoden til å selecte alle. Bare for enkelhetens skyld*/
        $(':checkbox').click(function() {
            if($(this).val() != "selectAll"){
            var brukerid = $(this).val();


                    $.post("ajax/bruker.php", { "hentData": brukerid},
                     function(data){
                       $("#idbruker").html(data.idbruker); // Henter og printer ut ID
                       $("#epost").val(data.epost); // EPOST
                       $("#fornavn").val(data.fornavn); // Fornavn
                       $("#etternavn").val(data.etternavn); // Etternavn
                       $("#tlf").val(data.tlf); //Telefonnummer
                       //Passordet skrives ikke ut av sikkerhetsmessige årsaker!
                     }, "json");
            }
            else if($(this).val() == "selectAll")
            {
                // Denne metoden velger alle checkboxene.
                var checked_status = this.checked;
                $(':checkbox').each(function()
                    {
                      this.checked = checked_status;
                    });
            }

        });
        //Sender dataene til ajax side ved endring av bruker
        $('#endreSend').click(function(){
            var idbruker = $("#idbruker").html();
            var epost = $("#epost").val();
            var fornavn = $("#fornavn").val();
            var etternavn = $("#etternavn").val();
            var tlf = $("#tlf").val();
            var psw = $("#psw").val();
            $.post("ajax/bruker.php", { "hentData": brukerid},
             function(data){
                 
             });
        });
