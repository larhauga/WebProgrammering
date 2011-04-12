<!DOCTYPE html>
<html>
<head>
	<title>Innlogging - Admin</title>
	<link href="style.css" rel="stylesheet" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php
if(true)
{
	echo '
		<div id="containerLogin">
			<div id="menyline">
				<div id="menyLeft">
					<p><a href="../index.php">Tilbake</a></p>
				</div>
				<div id="menyRight">
					<p>Logg ut</p>
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
		</div>
		<div style="clear:both;"></div>
	</div>
	<div id="container">
		<div id="head">
			
		</div>
		<div id="meny">
			
		</div>
		<div id="content">
			
		</div>
		<div id="footer">
			
		</div>
	</div>
	';
}
?>
</body>
</html>