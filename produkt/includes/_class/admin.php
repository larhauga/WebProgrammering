<?php

class Admin
{
	public $brukernavn;
	public $passord;
	public $tilgangstype;
	public $brukerid;
	public $fornavn;
	public $ip;
	
	function __constructor($brukernavn, $passord, $tilgangstype, $brukerid, $fornavn, $ip)
	{
		$this->$brukernavn;
		$this->$passord;
		$this->$tilgangstype;
		$this->$brukerid;
		$this->$fornavn;
		$this->$ip;
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
		$sql = "Insert into kategori(idkategori,tittel,aktiv) 
		Values(
			'',
			'$this->tittel',
			'$this->aktiv',
			)";
		$resultat = $mysqli->query($sql);
	
		if(!$resultat)
		{
		echo "Error".$dbc->error;
		die();
		}
		else 
		{
			$antrader = $dbc->affected_rows;
			if($antrader == 0)
			{
				echo "Det skjedde en feil med innsettelse i databasen";
				die();
			}
		}
		echo "Du er nå registert";
	}
	//Vis eksisterende kategorier
	public function visKat()
	{
		$db = new db();
		$db->connect();
		$sql = "SELECT * FROM kategori";
		$resultat = mysqli_query($db, $sql);
		
		echo '
		<table width="100%" border="0">
					<tr>
						<td>ID</td>
						<td>Tittel</td>
						<td>Aktiv</td>
						<td>Slett</td>
					</tr>';
		/*while(mysql setning ikke tom )
			{*/
			echo '	<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>';
		//}
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