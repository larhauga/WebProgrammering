<?php
/* Kategorier */
	if(isset($_POST['registrer']) && isset($_POST['tittel']))
	{
		$tittel = sjekkFelt($_POST['tittel']);
		$aktiv = $_POST['aktiv'];

		if($tittel != null)
		{
			$Admin->nyKat($tittel, $aktiv);
			unset($_POST['tittel']);
			unset($_POST['aktiv']);
			unset($_POST['registrer']);
		}
		else
		{
			//Alle feltene var ikke skrevet inn. Skriv en feilmelding til dette	
		}
	}
	echo '
			<h1><img src="images/folders.jpg" alt="Brukere" width="30" height="30" />Kategorier</h1>
 			
 			<div id="formVenstre">
 			<h1>Ny kategori</h1>
 			<form action="" method="post">
	 				<table width="100%" border="0">
		 				<tr>
			 				<td>Tittel:</td>
			 				<td><input type="text" name="tittel" id="tittel" /></td>
		 				</tr>
		 				<tr>
			 				<td>Aktiv:</td>
			 				<td>
			 					<select name="aktiv" id="aktiv">
			 						<option value="TRUE">Aktiv</option>
			 						<option value="FALSE">Ikke aktiv</option>
			 					</select>
			 				</td>
		 				</tr>
		 				<tr class="submit">
			 				<td>Registrer</td>
			 				<td><input type="submit" name="registrer" id="registrer"/></td>
			 			</tr>
	 				</table>
 			</form>
 			<h1>Oppdater kategori</h1>
 			<form action="" method="post">
	 				<table width="100%" border="0">
		 				<tr>
			 				<td>ID:</td>
			 				<td></td>
		 				</tr>
		 				<tr>
			 				<td>Tittel:</td>
			 				<td><input type="text" name="tittel" id="tittel" /></td>
		 				</tr>
		 				<tr>
			 				<td>Aktiv:</td>
			 				<td>
			 					<select name="aktiv" id="aktiv">
			 						<option value="true">Aktiv</option>
			 						<option value="false">Ikke aktiv</option>
			 					</select>
			 				</td>
		 				</tr>
		 				<tr class="submit">
			 				<td>Registrer</td>
			 				<td><input type="submit" name="registrer" id="registrer" /></td>
			 			</tr>
	 				</table>
 			</form>
 			</div>
 			<div id="formHoyre">
	 			<h1>Kategorier</h1>';
	 			$Admin->visKat();
	 			
 			echo '</div>
 			<div style="clear:both;"></div>

';
?>