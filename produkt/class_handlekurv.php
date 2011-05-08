<?php
session_start();
function showCart()
{
	$mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
	$handlekurv = $_SESSION['handlekurv'];
	if ($handlekurv) {
		$varer = explode(',',$handlekurv);
		$liste = array();
		foreach ($varer as $vare) {
			$liste[$vare] = (isset($liste[$vare])) ? $liste[$vare] + 1 : 1;
		}
		$utskrift[] = '<form action="?action=update" method="post">';
		$utskrift[] = '<table>';
		foreach ($liste as $id=>$antall) {
			$sql = "SELECT * FROM vare WHERE idvare =".$id;
			$resultat = $mysqli->query($sql);
			if(!$resultat)
			{
				echo "failed  sql";
				die();
			}
			while($rad = $resultat->fetch_array(MYSQLI_ASSOC))
			{
				$rader[] = $rad;
			}
			
			foreach($rader as $rad)
			{
				
				$utskrift[] = '<tr>';
				$utskrift[] = '<td><a href="?action=delete&id='.$id.'">Slett</a></td>';
				$utskrift[] = '<td>'.$rad[3].' '.$rad[7].'</td>';
				$utskrift[] = '<td>'.$rad['$pris'].'</td>';
				$utskrift[] = '<td><input type="text" name="qty'.$id.'" value="'.$antall.'" size="3" maxlength="3" /></td>';
				$utskrift[] = '<td>'.($rad['$pris'] * $antall).'</td>';
				$total += $rad['$pris'] * $antall;
				$utskrift[] = '</tr>';
				
			}
		}	
		$utskrift[] = '</table>';
		$utskrift[] = "<p>Sum å betale <strong>".$total.',- kr'." "."</strong></p>";
		$utskrift[] = '<div><button type="submit">Opptater</button></div>';
		$utskrift[] = '</form>';
	} else {
		$utskrift[] = '<p>Handlekurven er tom</p>';
	}
	return join('',$utskrift);
}
?>