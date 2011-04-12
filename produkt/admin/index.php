<!DOCTYPE html>
<html>
<head>
	<title>Innlogging - Admin</title>
	<link href="style.css" rel="stylesheet" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php
if(false) //Not logged inn
{
	echo '
		<div id="containerLogin">
			<div id="menyline">
				<div id="menyLeft">
					<p><a href="../index.php">Tilbake</a></p>
				</div>
				<div id="menyRight">

				</div>
				<div style="clear:both;"></div>
			</div>
			<div id="loginboks">
				<h1>Login</h1>
				<p>Uavtorisert tilgang vil bli logget!</p>
				<form id="adminlogin">
				<p>Brukernavn: <input type="text" id="user" name="bruker" /></p>
				<p>Passord: <input type="password" id="psw" name="passord" /></p>
				<p class="forgetmenot">
					<label><input name="rememberme" type="checkbox" id="rememberme" value="forever" tabindex="90" /> Husk meg</label>
				</p>
				<p><input type="submit" value="Logg inn" /></p>
				</form>
			</div>
		</div>
		';
}
else
{
	echo '
	<div id="menyline">
		<div id="menyLeft">
		</div>
		<div id="menyRight">
			<p>Logg ut</p>
		</div>
		<div style="clear:both;"></div>
	</div>
	<div id="container">
		<div id="head">
			<h1>Admin - Hjem</h1>
		</div>
		<div id="meny">
			<ul>
				<li><a href="#">Hjem</a></li>
				<li><a href="#">Brukere</a></li>
				<li><a href="#">Kategorier</a></li>
				<li><a href="#">Produkter</a></li>
				<li><a href="#">Varebeholdning</a></li>
				<li><a href="#">Sikkerhet</a></li>
				<li><a href="#">Konfigurering</a></li>
			</ul>
		</div>
		<div id="content">
			<table width="100%">
				<tr>
					<td align="center"><img src="bilder/user-icon.png" alt="Brukere" width="150" height="150"/></td>
					<td align="center"><img src="bilder/folders.jpg" alt="Kategorier" width="150" height="150"/></td>
					<td align="center"><img src="bilder/Cardboard-Box.png" alt="Produkter" width="150" height="150"/></td>
				</tr>
				<tr>
					<td align="center">Brukere</td>
					<td align="center">Kategorier</td>
					<td align="center">Produkter</td>
				</tr>
				<tr>
					<td align="center"><img src="bilder/barcode.jpg" alt="Varebeholdning" width="150" height="150"/></td>
					<td align="center"><img src="bilder/windows-7-security-icon.png" alt="Sikkerhet" width="150" height="150"/></td>
					<td align="center"><img src="bilder/Config-Tools.png" alt="Konfigurering" width="150" height="150"/></td>
				</tr>
				<tr>
					<td align="center">Varebeholdning</td>
					<td align="center">Sikkerhet</td>
					<td align="center">Konfigurering</td>
				</tr>
			</table>
		</div>
		<div id="footer">
			
		</div>
	</div>
	';
}
?>
</body>
</html>