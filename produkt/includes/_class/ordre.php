<?php

class ordre extends dbase
{
	public $kundeid;
	public $dato;
	public $betalt;
	public $total;
	public $ordreid;
	
	    public function __construct()
    	{
        parent::__construct();
    	}
		
		
	function addOrdreLinje($innAntall,$innID)
	{
		//komando for å skrive dette til sqlen
		$mysqli = parent::connect();
		$sql2 = "select pris from vare where idvare= '$innID';";
		$resultat = mysqli_query($mysqli,$sql2) or die(mysqli_error($mysqli));
		// mysql sjekk her :)
		$arraytt = mysqli_fetch_row($resultat);
		$pris = $arraytt[0];
		$resultat = "";
		$sql = "Insert into ordrelinje(idordre,idvare,prisPrEnhet,antall) 
		Values(
		'$this->ordreid',
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
		  
			$mysqli = parent::connect();
			$sql2 = "select idbruker from bruker where epost= '$epost';";
			$resultat = mysqli_query($mysqli, $sql2);
        	  if(!$resultat)
					{
						echo "Error";//.$db->error;
					}     
     	   $valg = mysqli_fetch_row($resultat);
			$idbruker = $valg[0];
            //$resultat->query($sql2);
		//	$resultat = "";// feil her !!! !!!!!!!§!!// feil her !!! !!!!!!!§!!// feil her !!! !!!!!!!§!!// feil her !!! !!!!!!!§!!// feil her !!! !!!!!!!§!!// feil her !!! !!!!!!!§!!// feil her !!! !!!!!!!§!!
			$sql = "Insert into ordre(ordredato,idbruker)  
			Values(
			
				'$ordredato',
      	          '$idbruker')";
			$resultat = mysqli_query($mysqli,$sql);
			//$this->ordreid = $mysqli->insert_id;
			if(!$resultat)
					{
						echo "Error222";//.$db->error;
					}
			//return $ordreid;
			//$mysqli->query();
		  }
		  else {
			  return null;
		  }
	}
}
