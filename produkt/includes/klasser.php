<?php

class db
{
	public $ip;
	public $brukernavn;
	public $passord;
	public $dbnavn;
	public $db;
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
	public $dbc; //Database tilkobling du bruker til å gjøre komandoer
	public $dbcc; //Database server connect kan settes til 0, og database connecten dør..
	
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
		$this->dbcc = new db();
		$this->dbc = $dbcc->connectDB();
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
			die();
			}
			else 
			{
				$antrader = $this->dbc->affected_rows;
				if($antrader == 0)
				{
					echo "Det skjedde en feil med innsettelse i databasen";
					die();
				}
			}
		echo "Du er nå registert";
	}
			
}
	?>