<?php

class ordre
{
	public $kundeid;
	public $dato;
	public $betalt;
	public $total;
	
	function __construct()
	{
	}
	function addOrdreLinje($innAntall,$innID)
	{
		//komando for å skrive dette til sqlen
		$mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
		$sql2 = "SELECT pris FROM vare WHERE idvare = $id;";
		$resultat = $mysqli->query($sql2); 
		// mysql sjekk her :)
		$pris = $resultat;
		$resultat = "";
		$sql = "Insert into ordrelinje(idvare,prisPrEnhet,antall) 
		Values(
		'$innID',
		'$pris',
		'$innAntall')";
		$resultat = $mysqli->query($sql);
			if(!$resultat);
			//mysql sjekk
	}
	function sendOrdre()
	{
		//komando for å lagre ordreren
		 $ordredato = date('Y-m-d H:i:s');
		if(isset($_SESSION['loggetinn']))
          {
                          
           $bruker = unserialize($_SESSION['bruker']);
           $epost=$bruker->epost;
		  }
		$mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
		$sql2 = "select idbruker from bruker where epost= $epost;";
		$resultat = $mysqli->query($sql2); 
		//mysql sjekk her
		$idbruker = $resultat;
		$resultat = "";
		$sql = "Insert into ordre(ordredato,idbruker) 
		Values(
		'$ordredato',
		'$idbruker')";
		$resultat = $mysqli->query($sql);
			if(!$resultat);
			//mysql sjekk
	}
}
