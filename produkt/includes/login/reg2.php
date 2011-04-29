<?php 
include "../head.php";

$innepost = $_GET['epost'];
$innepost2 = $_GET['epost2'];
$innpassord = $_GET['passord'];
$innpassord2 = $_GET['passord2'];
$innfornavn = $_GET['fornavn'];
$innetternavn = $_GET['etternavn'];

$innadresse = $_GET['adresse'];
$innpostnr = $_GET['postnr'];
$innpoststed = $_GET['poststed'];
$inntlf = $_GET['tlf'];
if($innepost == $innepost2)
	{
	if($innpassord == $innpassord2)
		{
			$bruker = new bruker($innepost,$innpassord,$innfornavn,$innetternavn,$innadresse,$innpostnr,$innpoststed,$inntlf);
			$bruker->updateDB();
		}
		else 
		{ echo "Du har ikke skrevet inn 2 like passord"; }
	}
 else
 { echo "du har ikke skrevet inn 2 like eposter"; }

?>