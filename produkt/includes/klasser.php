<?php

class db // du bare kaller new db for å opprette en database tilkobling ( eks $dbc = new db )
{
	public $ip;
	public $brukernavn;
	public $passord;
	public $dbnavn;
	public $db;
	public $error;
	function __construct()
	{
		$this->ip = "localhost";
		$this->brukernavn = "xzindor_db1";
		$this->passord = "lol123";
		$this->dbnavn = "xzindor_db1";
		$this->db = new MySQLi("localhost","xzindor_db1","lol123","xzindor_db1");
		if($db->connect_error)
		{
			die("Kunne ikke koble til databasen".$this->db->connect_error);
		}
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
	public $dbc; //Database tilkobling du bruker til å gjøre komandoer med
	
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
		$this->dbc = new db();
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
		$resultat = $this->dbc->query($sql);
			if(!$resultat)
			{
			echo "Error".$this->dbc->error;
			$innerror = "Error".$this->dbc->error;
			$dbc->errors($innerror);
			die();
			}
			else 
			{
				$antrader = $this->dbc->affected_rows;
				if($antrader == 0)
				{
					echo "Det skjedde en feil med innsettelse i databasen";
					$innerror = "databasefeil. Ingen ting ble lagt til i databasen - affected_rows";
					$dbc->errors($innerror);
					die();
				}
			}
		echo "Du er nå registert";
	}
			
}
	?>