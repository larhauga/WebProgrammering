<?php

class mysqli
{
	$mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
}
class db // du bare kaller new db for å opprette en database tilkobling ( eks $dbc = new db )
{	
		
	public $ip;
	public $brukernavn;
	public $passord;
	public $dbnavn;
	public $error;
	public function __construct()
	{
		$this->ip = "193.107.29.49";
		$this->brukernavn = "xzindor_db1";
		$this->passord = "lol123";
		$this->dbnavn = "xzindor_db1";

	}
	
	
	function errors($innError)
	{
		// skal lage så den sjekker for alle mysql errors
			$this->error = $innError;
			if(!file_exists("error_log.php"))
			{
				die("filen eksiterer ikke...noob admin");
			}
			else 
			{
				$fh = fopen("error_log.php");
				fwrite($fh, $this->error );
				fclose($fh);
			}
			
	}
	
	function settInn()
	{
		// felles innsettelse i databasen
	}
	
	function fjern()
	{
		// felles fjern fra databasen
	}
	function sikkerhet() // mot hackers.. for å kalle denne:  $this->db->sikkerhet()
	{
		if (($_SERVER['SERVER_NAME']!="localhost"))
		{
     	echo "Beklager, men denne databasen er privat..";
	 	die();
		}
	}
	
	function select()
	{
		//felles select fra databasen
	}
}



class bruker
{
	public $epost;
	public $passord;
	public $fornavn;
	public $etternavn;
	public $adresse;
	public $postnr;
	public $poststed;
	public $tlf;
	public $registert;
	public $rettigheter;
	
	function __construct($innepost,$innpassord,$innfornavn,$innetternavn,$innadresse,$innpostnr,$innpoststed,$inntlf)
	{
		$this->epost = $innepost;
		$this->passord = $innpassord;
		$this->fornavn = $innfornavn;
		$this->etternavn = $innetternavn;
		$this->adresse = $innadresse;
		$this->postnr = $innpostnr;
		$this->posted = $innpoststed;
		$this->tlf = $inntlf;
		$this->registert = 10;
		$this->rettigheter = 1; // 0: Superbruker, 1: vanlig bruker, 2: moderator?
	}
	
	function updateDB()
	{
		$sql = "Insert into bruker(epost,passord,passord,etternavn,adresse,postnr,registrert,rettigheter,tlf) 
		Values(
		'$this->epost',
		'$this->passord',
		'$this->fornavn',
		'$this->etternavn',
		'$this->adresse',
		'$this->postnr',
		'$this->registert',
		'$this->rettigheter',
		'$this->tlf'
		)";
		$resultat = $mysqli->query($sql);
			if(!$resultat)
			{
			echo "Error".$mysqli->error;
			$innerror = "Error".$mysqli->error;
			$mysqli->errors($innerror);
			die();
			}
			else 
			{
				$antrader = $mysqli->affected_rows;
				if($antrader == 0)
				{
					echo "Det skjedde en feil med innsettelse i databasen";
					$innerror = "databasefeil. Ingen ting ble lagt til i databasen - affected_rows";
					$mysqli->errors($innerror);
					die();
				}
			}
		echo "Du er nå registert";
	}
			
}
	?>