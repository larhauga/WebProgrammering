<?php 
if(isset($_GET['registrer']))
{
include "head.php";
$innepost = $_POST['epost'];
$innepost2 = $_POST['epost2'];
$innpassord = $_POST['passord'];
$innpassord2 = $_POST['passord2'];
$innfornavn = $_POST['fornavn'];
$innetternavn = $_POST['etternavn'];

$innadresse = $_POST['adresse'];
$innpostnr = $_POST['postnr'];

$inntlf = $_POST['tlf'];
if($innepost == $innepost2)
	{
	if($innpassord == $innpassord2)
		{
                        $passord = encrypt($innpassord, $innepost);
			$bruker = new bruker($innepost,$innfornavn,$innetternavn,$innadresse,$innpostnr,$inntlf);
			$bruker->passord = $passord;
			$bruker->updateDB();
		}
		else 
		{ echo "Du har ikke skrevet inn 2 like passord"; }
	}
 else
 { echo "du har ikke skrevet inn 2 like eposter"; }
}
?>

<body>
<center>
<br><br><hr>
<form action="?registrer" method="post" name="registrer">
<h2>Registering av ny kunde</h2>
<table width="248" summary="Kunde info">
<tr>
<td>Epost:</td><td><input name="epost" type="text"></td></tr>
<tr><td>Gjenta Epost:</td><td><input name="epost2" type="text"></td><tr>
<tr><td height="22">Passord:</td><td><input name="passord" type="text"></td><tr>
<tr><td>Gjenta Passord:</td><td><input name="passord2" type="text"></td><tr>
<tr><td>Fornavn:</td><td><input name="fornavn" type="text"></td><tr>
<tr><td>Etternavn:</td><td><input name="etternavn" type="text"></td><tr>
</table>
<br>
<table width="248" height="104" summary="adresse">
<tr>
<td width="66">Adresse:</td><td width="170"><input name="adresse" type="text"></td></tr>
<tr><td>Postnr:</td><td><input name="postnr" type="text"></td><tr>
<tr><td>Tlf:</td><td><input name="tlf" type="text"></td><tr>
</table>
<input name="submit" type="submit" value="Register">
</form>
</center>
<hr><br><br>
</body>
</html>
