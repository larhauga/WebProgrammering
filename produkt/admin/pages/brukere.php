<?php
	//Her må det være sjekk for at adminen er superbruker og ikke moderator (altså ha type 0-tilgang)

	echo '

			<h1><img src="images/user-icon.png" alt="Brukere" width="30" height="30" />Brukeradministrasjon</h1>

				<table width="100%">
					<tr>
						<td width="10%">Søk: </td>
						<td><input type="text" id="sok" name="sok" /></td>
					</tr>
				</table>
                                <script type="text/javascript">
                                    $("#sok").keyup(function() {
                                      $("#resultat").load("ajax/sok.php?sok=" + document.getElementById("sok").value);
                                    });
                               </script>
                               <div id="resultat">
                                    <table width="100%">
					<tr>
						<td>Alle:<input type="checkbox" id="selectAll" /></td>
						<td>Epost</td>
						<td>Fornavn</td>
						<td>Etternavn</td>
						<td>RegDate</td>
						<td>Rettighet</td>
						<td>TLF</td>
					</tr>';
					$Admin->visBrukere(0,30,"");
			echo'	</table>
                            
                            </div>
			<div id="functions">
				<p class="submit">
					<input type="submit" id="slett" value="Slett" />
					<input type="submit" name="endre" id="endre" value="Endre" />
					<input type="submit" id="sett" value="Sett til admin" />
				</p>
			</div>


			<div id="formVenstre" style="display: none">
                        <form action="" method="post" name="endre" id="endre">
				<h2>Endre bruker</h2>
				<table width="100%">
					<tr>
						<td>Epost:</td>
						<td><input type="text" id="epost" name="epost" /></td>
					</tr>
					<tr>
						<td>Fornavn:</td>
						<td><input type="text" id="fornavn" name="fornavn" /></td>
					</tr>
					<tr>
						<td>Etternavn:</td>
						<td><input type="text" id="etternavn" name="etternavn" /></td>
					</tr>
					<tr>
						<td>Tlf:</td>
						<td><input type="text" id="tlf" name="tlf" /></td>
					</tr>
					<tr>
						<td>Passord</td>
						<td><input type="passord" id="psw" name="psw" /></td>
					</tr>
					<tr class="submit">
						<td></td>
						<td><input type="submit" id="endreSend" name="endreSend" /></td>
					</tr>
				</table>
                                </form>
			</div>
			<div id="formHoyre" style="display: none">
				<h2>Sett til admin</h2>
					
			</div>
			<div id="slettet" style="display: none; clear:both;">';
                            
                        echo '
                            <h2>Bruker ... er slettet</h2>
                            <p>Ikke ferdig</p>
			</div>
                        <div style="clear:both;"></div>

			<script>
                                /* Utføres når man trykker slett: Skal utføre slettingen og sende et array */
				$("#slett").click(function (){
                                   var data = $(":checkbox:checked").map(function(i,n)
                                   {
                                      return $(n).val();
                                   }).get();
                                    $.post("ajax/bruker.php", { "bruker[]": data, slett: "true" },
                                          function(){
                                                        $("#formHoyre").html("Brukerne er slettet");
                                                  });
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
                                        $(\'input[name="bruker[]"]\').each(function()
                                            {
                                              this.checked = checked_status;
                                            });
                                       });
                                    $("#brukerForm").submit(function(e) {
                                          return false;       });
                                
			</script>
';
?>