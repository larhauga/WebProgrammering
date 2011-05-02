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
						<td></td>
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
				<h2>Endre bruker</h2>
				<table width="100%">
					<tr>
						<td>Epost:</td>
						<td><input type="text" id="epost" /></td>
					</tr>
					<tr>
						<td>Fornavn:</td>
						<td><input type="text" id="fornavn" /></td>
					</tr>
					<tr>
						<td>Etternavn:</td>
						<td><input type="text" id="etternavn" /></td>
					</tr>
					<tr>
						<td>Tlf:</td>
						<td><input type="text" id="tlf" /></td>
					</tr>
					<tr>
						<td>Passord</td>
						<td><input type="passord" id="passord" /></td>
					</tr>
					<tr class="submit">
						<td></td>
						<td><input type="submit" id="endreSend" name="endreSend" /></td>
					</tr>
				</table>
			</div>
			<div id="formHoyre" style="display: none">
				<h2>Sett til admin</h2>
					
			</div>
			<div id="slettet" style="display: none; clear:both;">';
                            //if(isset($_GET['']))
                        echo '
                            <h2>Bruker ... er slettet</h2>
                            <p>Ikke ferdig</p>
			</div>
                        <div style="clear:both;"></div>

			<script>
				$("#slett").click(function (){
					$("#slettet").slideToggle("slow");
					});
				$("#endre").click(function () {
					$("#formVenstre").slideToggle("slow");
				});
				$("#sett").click(function () {
					$("#formHoyre").slideToggle("slow");
				});

			</script>
';
?>