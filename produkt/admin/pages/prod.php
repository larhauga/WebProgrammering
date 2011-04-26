<?php
	echo '
			<h1><img src="images/Cardboard-Box.png" alt="Brukere" width="30" height="30" />Produkter</h1>

			- Endre og Slette<br />
			<div id="formVenstre">
			<h2>Legg til produkt</h2>
				<form action="?id=4" name="vare" method="post">
				<table width="100%">
					<tr>
						<td>Kategori: </td>
						<td>
			 					<select name="grad" id="grad">
			 						<option value="">Kat1</option>
			 						<option value="">k2</option>
			 						<option value="">k3</option>
			 					</select>
						</td>
					</tr>
					<tr>
						<td>Navn: </td>
						<td><input type="text" id="navn" name="navn" /></td>
					</tr>
					<tr>
						<td>Bilde: </td>
						<td>
			 					<form action="upload.php" method="post" enctype="multipart/form-data" target="upload_target" >
			 						<input type="file" size="10" name="filstreng" />
			 						<input type="submit" name="knapp" value="Last opp"/>
			 					</form>
						</td>
					</tr>
					<tr>
						<td>Tekst: </td>
						<td>
							<textarea rows="12" cols="55" name="text" id="text" style="max-width:350px; max-height:400px;">
							</textarea>
						</td>
					</tr>
					<tr>
						<td>Pris: </td>
						<td><input type="text" id="pris" name="pris" /></td>
					</tr>
					<tr class="submit">
						<td></td>
						<td><input type="submit" name="regVare" id="regVare" /></td>
					</tr>
				</table>
				</form>
			</div>
			<div id="formHoyre">
			<h2>Produkter</h2>
				<form action="?id=4" name="masseopperasjon" method="get">
				<table width="100%">
					<tr>
						<td><input type="text" id="sok" name="sok" /></td>
					</tr>
				</table>
				<table width="100%">
					<tr>
						<td></td>
						<td>Kat</td>
						<td>Navn</td>
						<td>Bilde</td>
						<td>Pris</td>
					</tr>
					<tr>
						<td><input type="checkbox" name="meldinger[ ]" value="'.$rad[0].'" /></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</table>
				</form>
			</div>
			<div style="clear:both;">
			</div>
';
?>