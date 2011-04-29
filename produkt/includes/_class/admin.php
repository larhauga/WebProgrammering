<?php

class Admin
{
	public $bruker;
	public $tilgangstype;
	
	function __constructor($bruker, $tilgangstype)
	{
		$this->$bruker;
		$this->$tilgangstype;
	}
	
	function brukere()
	{
		/*Vise alle brukere. Gi admintilgang, kun tilgang for brukere med superbrukertilgang*/
			
	}
	function nyKat($tittel, $aktiv)
	{
		$db = new db();
		$db->connect();
		$sql = "Insert into kategori(idkategori,tittel,aktiv) 
		Values(
		'',
		'$this->tittel',
		'$this->aktiv',
		)";
		$resultat = $db->db->db->query($sql);
		//$resultat = $this->dbc->query($sql);
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
		$db = new db();
		$db->connect();
		$sql = "SELECT COUNT(*) FROM varer";
		$result = mysqli_query($sql);
		mysqli_free_result($result);
	}
	function statsKat()
	{
		$sporringen = "SELECT COUNT(*) FROM kategori";
		echo $db->select($sporringen);
	}
	function statsBruker()
	{
		$sporringen = "SELECT COUNT(*) FROM bruker";
		echo $db->select($sporringen);
	}
}
?>