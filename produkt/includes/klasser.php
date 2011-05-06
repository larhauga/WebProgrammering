<?php
 
class handlekurv
{
	public $varer;
	public $pris;
	public $navn;
	
	function handlekurv()
	{
		$this->varer = array();
		$this->pris = array();
		$this->navn = array();
	}
	
	function leggtil($innvare)
	{
		if($this->varer[$innvare])
		{
			$this->varer[$innvare] +=1;
		}
		else
		{
			$this->varer[$innvare] = 1;
		}
	}
	
	function slettvare($innvare)
	{
		$this->varer[$innvare] = 0;
	}
	
	function antallAvEnVare($innvare,$innantall)
	{
		if($innaltall == 0)
		{
			$this->slettvare($innvare);
		}
		else
		{
			$this->varer[$innvare] = $innatall;
		}
	function aktivHandlekurv()
	{
	}
	}


}// end of class 
		


class bruker
{
	public $epost;
	public $passord;
	public $fornavn;
	public $etternavn;
	public $adresse;
	public $postnr;
	public $tlf;
	public $registert;
	public $rettigheter;
	public $error;
	
	function __construct($innepost,$innfornavn,$innetternavn,$innadresse,$innpostnr,$inntlf)
	{
		$this->epost = $innepost;
		$this->fornavn = $innfornavn;
		$this->etternavn = $innetternavn;
		$this->adresse = $innadresse;
		$this->postnr = $innpostnr;
		$this->tlf = $inntlf;
		$this->registert = 10;
		$this->rettigheter = 1; // 0: Superbruker, 1: vanlig bruker, 2: moderator?
	}

	function updateDB()
	{
                $regtid = date('Y-m-d H:i:s');
		$mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
		$sql = "Insert into bruker(epost,passord,fornavn,etternavn,adresse,postnr,registrert,rettigheter,tlf) 
		Values(
		'$this->epost',
		'$this->passord',
		'$this->fornavn',
		'$this->etternavn',
		'$this->adresse',
		'$this->postnr',
		'$regtid',
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
