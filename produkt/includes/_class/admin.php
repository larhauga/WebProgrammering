<?php

class Admin
{
	public $epost;
	public $passord;
	public $tilgangstype;
	public $idbruker;
	public $fornavn;
	public $ip;
        public $error;
	
	public function __construct($epost, $passord, $tilgangstype, $idbruker, $fornavn, $ip)
	{
		$this->epost = $epost;
		$this->passord = $passord;
		$this->tilgangstype = $tilgangstype;
		$this->idbruker = $fornavn; //$idbruker;
		$this->fornavn = $fornavn;
		$this->ip = $ip;
	}
	public function getNavn()
	{
		return $this->fornavn;
	}
	public function db()
	{
		$mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
	}
	
	function brukere()
	{
		/*Vise alle brukere. Gi admintilgang, kun tilgang for brukere med superbrukertilgang*/
			
	}
	/* Kategorier */
	//Innsetting av nye kategorier
	function nyKat($tittel, $aktiv)
	{
		$mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
		$sql = "Insert into kategori(idkategori,tittel,aktiv) VALUES(
			'',
			'$tittel',
			'$aktiv'
			);";
                
		$resultat = $mysqli->query($sql);
	
		if(!$resultat)
		{
                    echo "Error: " . mysqli_error($mysqli);
                    $bruker->errorTilFil($this->error);
                    die();
		}
		else 
		{
			$antrader = $mysqli->affected_rows;
			if($antrader == 0)
			{
				echo "Det skjedde en feil med innsettelse i databasen";
				die();
			}
                        else if($antrader == 1)
                        {
                            echo "<p>Du er nå registert</p>";
                        }
		}
	}
	//Vis eksisterende kategorier
	public function visKat()
	{
		$mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
		$sql = "SELECT * FROM kategori";
		$resultat = mysqli_query($mysqli, $sql);
		
		echo '
		<table width="100%" border="0">
					<tr>
						<td>ID</td>
						<td>Tittel</td>
						<td>Aktiv</td>
						<td>Slett</td>
					</tr>';
		while($rad = $resultat->fetch_object())
		{
			echo '<tr>
						<td>'.$rad->idkategori.'</td>
						<td>'.$rad->tittel.'</td>
						<td>'.$rad->aktiv.'</td>
						<td></td>
					</tr>';
		}
		echo '</table>';
	}
	
	function produkter()
	{
		
	}
	function varebeholdning()
	{
		
	}
	function sikkerhet()
	{
		
	}
	function konfig()
	{
		
	}
	
	/* Henter stats til admin siden */
	function statsVarer()
	{

		$sql = "SELECT COUNT(*) FROM varer";

	}
	function statsKat()
	{
		$sql = "SELECT COUNT(*) FROM kategori";

	}
	function statsBruker()
	{
		$sql = "SELECT COUNT(*) FROM bruker";
	}
	
	//Login 
	function encrypt($innpassord)
	{
		$salt = md5($innpassord."%*4!#$;\.k~'(_@"); 
		$innpassord = md5("$salt$string$salt"); 
		$this->passord = $innpassord;
	} 
	function login()
	{
		
	}
}
?>