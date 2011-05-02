<?php
	session_start();
	require("../includes/_class/admin.php");
	require("../includes/klasser.php");
	include("../includes/config.php");


?>
<!DOCTYPE html>
<html>
<head>
	<title>Innlogging - Admin</title>
	<link href="style.css" rel="stylesheet" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script src="../includes/jquery.js"></script>
</head>
<body>
<?php

/*	
	Sjekker om du er i ferd med å logge inn
	Hvis du er det registrerer den data
	Oppretter Admin objektet og sender deg videre til index siden.
*/
if(isset($_GET['login']) && isset($_POST['user']) && isset($_POST['psw']))
{
	if($_POST['user'] != "" && $_POST['psw'] != "")
	{
		$db = new mysqli("193.107.29.49","xzindor_db1","lol123","xzindor_db1");
                
                    //Henter inn dataene etter at mysqli connectionen er satt opp (for å bruke escape)
                    $brukernavn = mysqli_real_escape_string($db,$_POST['user']);
                    $passord = mysqli_real_escape_string($db,$_POST['psw']);
                    
		$resultat = $db->query("SELECT * FROM bruker WHERE epost = '".$brukernavn."' AND passord = '".$passord."'");
		if(!$resultat)
		{
			echo "Det oppstod en feil: ".$db->error."<br/>";
		}
		else
		{
			//Lager sjekk på om det kun er en bruker.
			$antallRader = $db->affected_rows;
			if($antallRader <= 0 || $antallRader > 1)
			{
				$feilmelding = "Feil brukernavn eller passord";
			}
			else if($antallRader == 1)
			{
				$rad = $resultat->fetch_object();

				//Oppretter admin objektet
				$Admin = new Admin($rad->epost, $rad->passord, $rad->rettigheter, $rad->idbruker, $rad->fornavn, $_SERVER['REMOTE_ADDR']);
				
				//Serialiserer og oppretter SESSIONs
				$_SESSION['admin'] = serialize($Admin);
				$_SESSION['login'] = true;

			}
		} // Else
	} //Brukernavnsjekk	
} //If login
/*
	Funksjon for å logge ut.
	Unsetter alle sessionsa.
*/
if(isset($_GET['logout']))
{
	unset($_SESSION['admin']);
	unset($_SESSION['login']);
}

/*
	Hvis du ikke er logget inn, eller i ferd med å logge inn:
	Setter opp login siden (HTML)
*/
if(!isset($_SESSION['login']) || $_SESSION['login'] == false) //Not logged inn
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
					<p>Uavtorisert tilgang vil bli logget!</p>';
				
				if(isset($feilmelding) && $feilmelding != "")
					echo '<p style="color:red">'.$feilmelding.'</p>';
				
				echo '<form id="adminlogin" action="?login=true" method="post">
				<p>Epost: <input type="text" id="user" name="user" /></p>
				<p>Passord: <input type="password" id="psw" name="psw" /></p>
				<p class="forgetmenot">
					<label><input name="rememberme" type="checkbox" id="rememberme" value="forever" tabindex="90" /> Husk meg</label>
				</p>
				<p><input type="submit" value="Logg inn" /></p>
				</form>
			</div>
		</div>
		';
}
/*
	Hvis du er logget inn (og ikke i ferd med å logge inn)
	Setter opp en av sidene gitt ved ID og henter objektet fra Session.
	Kjører først sjekk på at det er en lovelig side og importerer den i HTMLen
*/
else if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > '1' && $_GET['id'] < '8')
{
	$id = $_GET['id'];
	$Admin = unserialize($_SESSION['admin']);
	
	echo '
	<div id="menyline">
		<div id="menyLeft">
			<p>Velkommen <b>'.$Admin->fornavn.'</b></p>
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
/*
*/
else if(isset($_SESSION['login']))
{

	$Admin = unserialize($_SESSION['admin']);
	echo '
	<div id="menyline">
		<div id="menyLeft">
			<p>Velkommen <b>'.$Admin->fornavn.'</b></p>
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
else{
	echo '<h1>404 - Siden eksisterer ikke. Det har skjedd en feil.</h1>';
}
?>
</body>
</html>