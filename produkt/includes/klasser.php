<?php
include "dbconnect.php";
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
		$this->registert = $regdato;
		$this->rettigheter = 0;
	}
	
	function updateDB()
	{
		if( $this->epost != null && $this->passord != null && $this->fornavn != null && $this->etternavn != null && $this->adresse != null && $this->postnr != null && $this->tlf != null)
		{
			
		$sql = "Insert into bruker(epost,passord,fornavn,etternavn,adresse,postnr,registert,rettigheter,tlf) VALUES('$this->epost','$this->passord','$this->fornavn','$this->etternavn','$this->adresse','$this->postnr','$this->registert','$this->rettigheter','$this->tlf');";
		$resultat = $db->query($sql);
			if(!$resultat)
			{
			echo "Error".$db->error;
			die();
			}
			else 
			{
				$antrader = $db->affected_rows;
				if($antrader == 0)
				{
					echo "Det skjedde en feil med innsettelse i databasen";
					die();
				}
			}
			}
			
			else
			{
			echo "noe feilet med innsettingen, feilen ligger i variabelen";
			die();
			}
			
		echo "Du er nå registert";
		}//slutt på fuksjonen
			
}
	?>