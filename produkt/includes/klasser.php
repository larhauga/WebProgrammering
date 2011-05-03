<?php

 /* class mysqli
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
	
		$db = new mysqli($this->ip,$this->brukernavn,$this->passord,$this->dbnavn);
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
	
	function select($sql)
	{
		//felles select fra databasen
		return $this->$db->query($sql);
		
	}
}
*/ 


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
	public $error;
	
	function __construct($innepost,$innfornavn,$innetternavn,$innadresse,$innpostnr,$innpoststed,$inntlf)
	{
		$this->epost = $innepost;
		$this->fornavn = $innfornavn;
		$this->etternavn = $innetternavn;
		$this->adresse = $innadresse;
		$this->postnr = $innpostnr;
		$this->posted = $innpoststed;
		$this->tlf = $inntlf;
		$this->registert = 10;
		$this->rettigheter = 1; // 0: Superbruker, 1: vanlig bruker, 2: moderator?
	}
	/*
	function encrypt($innpassord)
	{
   $salt = md5($innpassord."%*4!#$;\.k~'(_@"); 
   
   $innpassord = md5("$salt$string$salt"); 
   
   	$this->passord = $innpassord;
	} 
	*/
	function updateDB()
	{
		$mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
		$sql = "Insert into bruker(epost,passord,fornavn,etternavn,adresse,postnr,registrert,rettigheter,tlf) 
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
			$this->error = "Error".$mysqli->error."\r\n";
			$bruker->errorTilFil($this->error);
			die();
			}
			else 
			{
				$antrader = $mysqli->affected_rows;
				if($antrader == 0)
				{
					echo "Det skjedde en feil med innsettelse i databasen";
					$this->error = "databasefeil. Ingen ting ble lagt til i databasen - affected_rows"."\r\n";
					$bruker->errorTilFil($this->error);
					die();
				}
			}
		echo "Du er nå registert";
	}
	function errorTilFil($error)
	{
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
	
	

}
	
?>
