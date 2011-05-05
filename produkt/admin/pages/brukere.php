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
						<td><input type="checkbox" id="selectAll" name="selectAll" value="selectAll" /></td>
						<td><b>Epost</b></td>
						<td><b>Fornavn</b></td>
						<td><b>Etternavn</b></td>
						<td><b>RegDate</b></td>
						<td><b>Rettighet</b></td>
						<td><b>TLF</b></td>
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
                                <p>Trykk på checkboxene for å velge hvilken bruker du vil endre</p>
				<label id="melding" ></label>
                                <table width="100%">
                                        <tr>
                                            <td>ID: </td>
                                            <td><label name="idbruker" id="idbruker" ></label> </td>
                                        </tr>
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
                                
			</div>
			<div id="formHoyre" style="display: none">
				<h2>Sett til admin</h2>
                                <table="100%">
                                <tr>
                                    <td>
                                    <select name="status" id="status">
                                            <option value="0">Admin</option>
                                            <option value="1">Bruker</option>
                                            <option value="2">Moderator</option>
                                    </select>
                                    </td>
                                    <td><input type="submit" id="sendAdmin" name="sendAdmin" /></td>
                                </tr>
				</table>
			</div>
			<div id="slettet" style="display: none; clear:both;">';
                            
                        echo '
                            <h2>Brukeren ble slettet</h2>
                            <p></p>
			</div>
                        <div style="clear:both;"></div>

                        <script src="ajax/bruker.js"></script>
';
?>