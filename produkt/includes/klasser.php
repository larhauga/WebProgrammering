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
	$cart = $_SESSION['cart'];
	if ($cart) 
	{
		$items = explode(',',$cart);
		$contents = array();
		foreach ($items as $item) 
		{
		$contents[$item] = (isset($contents[$item])) ? $contents[$item] + 1 : 1;
		}
	$output[] = '<form action="cart.php?action=update" method="post" id="cart">';
	$output[] = '<table>';
	foreach ($contents as $id=>$qty) {
	$sql = 'SELECT * FROM varer WHERE id = '.$id;
	$result = $db->query($sql);
	$row = $result->fetch();
	extract($row);
	$output[] = '<tr>';
	$output[] = '<td><a href="cart.php?action=delete&id='.$id.'" class="r">Slett</a></td>';
	$output[] = '<td>'.$title.' by '.$author.'</td>';
	$output[] = '<td>&pound;'.$price.'</td>';
	$output[] = '<td><input type="text" name="qty'.$id.'" value="'.$qty.'" size="3" maxlength="3" /></td>';
	$output[] = '<td>&pound;'.($price * $qty).'</td>';
	$total += $price * $qty;
	$output[] = '</tr>';
	}
	
		$output[] = '</table>';
		$output[] = '<pTotalsum:'.$total.'</p>';
		$output[] = '<div><button type="submit">Opptater handlevogn</button></div>';
		$output[] = '</form>';
	} else 
	{
		$output[] = '<p>Handlevogna er tom..</p>';
	}
return join('',$output);
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
