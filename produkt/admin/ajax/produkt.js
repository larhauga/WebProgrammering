        $(':checkbox').click(function() {
            if($(this).val() != "selectAll"){
            var brukerid = $(this).val();


                    $.post("ajax/produkt.php", { "hentData": brukerid},
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