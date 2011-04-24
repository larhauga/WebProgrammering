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
			
	}
	public function visKat()
	{
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
	
}
?>