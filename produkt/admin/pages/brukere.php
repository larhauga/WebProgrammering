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
					$Admin->visBrukere();
			echo'	</table>
			<div id="functions">
				<p class="submit"><input type="submit" id="slett" value="Slett" />
				<input type="submit" id="endre" value="Endre" />
				
				<input type="submit" id="sett" value="Sett til admin" />
				</p>
			</div>
			<div id="formVenstre">

			</div>
			<div id="formHoyre">
				
			</div>
			<div style="clear:both;">
			</div>
';
?>