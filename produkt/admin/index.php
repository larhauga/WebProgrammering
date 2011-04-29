<?php
	session_start();
	include("../includes/_class/admin.php");
	include("../includes/klasser.php");
	$db = new db();
	$Admin = new Admin();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Innlogging - Admin</title>
	<link href="style.css" rel="stylesheet" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php
	$db = new mysqli("193.107.29.49","xzindor_db1","lol123","xzindor_db1");
	$resultat = $db->query("SELECT * FROM bruker");
	if(!$resultat)
	{
		echo "error: ".$db->error."<br/>";
	}
	else
	{
		$antallRader = $db->affected_rows;
		for($i=0;$i<$antallRader;$i++)
		{
			$radObjekt = $resultat->fetch_object();
			echo $radObjekt->etternavn." ". $radObjekt->fornavn."</br>";
		}
	}



if(isset($_GET['login']))
{
	//validerer input
	//Sette opp sessions
	$_SESSION['login'] = true;
	$_SESSION['brukerid'] = '';
	$_SESSION['brukernavn'] = '';
	$_SESSION['tilgang'] = '';
	//IP $_SESSION['ip'] = $_SERVER['REMOTE_ADDR']; 
	
}
if(isset($_GET['logout']))
{
	unset($_SESSION['login']);
	unset($_SESSION['brukerid']);
	unset($_SESSION['brukernavn']);
	unset($_SESSION['tilgang']);
}

if(!isset($_SESSION['login']) && $_SESSION['login'] == false) //Not logged inn
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
				<form id="adminlogin" action="?login=true" method="post">
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
else if(isset($_GET['id']) && $_GET['id'] > '1' && $_GET['id'] < '8')
{
	$id = $_GET['id'];
	echo '
	<div id="menyline">
		<div id="menyLeft">
			<p>Velkommen <b>Lars</b></p>
		</div>
		<div id="menyRight">
			<p><a href="?logout"><img src="images/key.png" width="15" height="15" alt="Logg ut" />Logg ut</a></p>
		</div>
		<div style="clear:both;"></div>
	</div>
	<div id="container">
		<div id="head">
			<h1>Admin</h1>
		</div>
		<div id="meny">
			<ul>
				<li><a href="?id=1">Hjem</a></li>
				<li><a href="?id=2">Brukere</a></li>
				<li><a href="?id=3">Kategorier</a></li>
				<li><a href="?id=4">Produkter</a></li>
				<li><a href="?id=5">Varebeholdning</a></li>
				<li><a href="?id=6">Sikkerhet</a></li>
				<li><a href="?id=7">Konfigurering</a></li>
			</ul>
		</div>
		<div id="content">';
		
			/* Her hentes ekstern fil som inkluderes */
			if($id == 2){
				include('pages/brukere.php');
			}
			if($id == 3){
				include('pages/kat.php');
			}
			if($id == 4){
				include('pages/prod.php');
			}
			if($id == 5){
				include('pages/beholdning.php');
			}
			if($id == 6){
				include('pages/sec.php');
			}
			if($id == 7){
				include('pages/conf.php');
			}
		echo '
		</div>
		<div id="footer">
			
		</div>
	</div>
	';
}
else
{
	echo '
	<div id="menyline">
		<div id="menyLeft">
			<p>Velkommen <b>Lars</b></p>
		</div>
		<div id="menyRight">
			<p><a href="?logout"><img src="images/key.png" width="15" height="15" alt="Logg ut" />Logg ut</a></p>
		</div>
		<div style="clear:both;"></div>
	</div>
	<div id="container">
		<div id="head">
			<h1>Admin - Hjem</h1>
		</div>
		<div id="meny">
			<ul>
				<li><a href="?id=1">Hjem</a></li>
				<li><a href="?id=2">Brukere</a></li>
				<li><a href="?id=3">Kategorier</a></li>
				<li><a href="?id=4">Produkter</a></li>
				<li><a href="?id=5">Varebeholdning</a></li>
				<li><a href="?id=6">Sikkerhet</a></li>
				<li><a href="?id=7">Konfigurering</a></li>
			</ul>
		</div>
		<div id="content">
			<div id="maincontent">
			<table width="100%">
				<tr>
					<td align="center"><a href="?id=2"><img src="images/user-icon.png" alt="Brukere" width="150" height="150"/></a></td>
					<td align="center"><a href="?id=3"><img src="images/folders.jpg" alt="Kategorier" width="150" height="150"/></a></td>
					<td align="center"><a href="?id=4"><img src="images/Cardboard-Box.png" alt="Produkter" width="150" height="150"/></a></td>
				</tr>
				<tr>
					<td align="center"><a href="?id=2">Brukere</a></td>
					<td align="center"><a href="?id=3">Kategorier</a></td>
					<td align="center"><a href="?id=4">Produkter</a></td>
				</tr>
				<tr>
					<td align="center"><a href="?id=5"><img src="images/barcode.jpg" alt="Varebeholdning" width="150" height="150"/></a></td>
					<td align="center"><a href="?id=6"><img src="images/windows-7-security-icon.png" alt="Sikkerhet" width="150" height="150"/></a></td>
					<td align="center"><a href="?id=7"><img src="images/Config-Tools.png" alt="Konfigurering" width="150" height="150"/></a></td>
				</tr>
				<tr>
					<td align="center"><a href="?id=5">Varebeholdning</a></td>
					<td align="center"><a href="?id=6">Sikkerhet</a></td>
					<td align="center"><a href="?id=7">Konfigurering</a></td>
				</tr>
			</table>
			</div>
			<div id="maincontentright">
				<h1>Innhold</h1>
				<table width="100%">
					<tr>
						<td align="right" class="colorTall">';
							$Admin->statsVarer();
					echo'</td>
						<td>Varer</td>
					</tr>
					<tr>
						<td align="right" class="colorTall1">';
							$Admin->statsKat();
					echo '</td>
						<td>Kategorier</td>
					</tr>
					<tr>
						<td align="right" class="colorTall2">';
							$Admin->statsBruker();
					echo'</td>
						<td>Brukere</td>
					</tr>
				</table>
				<h1>Info</h1>
				<p>Muligheter for implementasjon av google analythics vil bli implementert ved en senere versjon</p>
				<h1>Feilvisning</h1>
				<p>Prøve å utvikle et overvåkingsverktøy som sjekker phplogg-filene for å se om det er noe feil med nettsiden.</p>

			</div>
			<div style="clear:both;"></div>
		</div>
		<div id="footer">
			
		</div>
	</div>
	';
}
?>
</body>
</html>