        $(':checkbox').click(function() {
            if($(this).val() != "selectAll"){
            var brukerid = $(this).val();


                    $.post("ajax/produkt.php", { "hentData": brukerid},
                     function(data){
                       $("#kategori").val(data.idkategori);  // kategori til id
                       $("#aktiv").val(data.statusAktiv);      // aktiv
                       $("#tittel").val(data.tittel);           // tittel
                       $("#file").val(data.bildeurl);            // Bildeurl
                       $("#text").val(data.tekst);             // Tekst
                       $("#pris").val(data.pris);               // Pris
                       $("#antall").val(data.antall);           // Antall
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