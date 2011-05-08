<?php

class handlekurv2
{
	public $fin;
	
	function __construct($innfin)
	{
		$this->fin = $innfin;
	}
public function visHandlekurv()
{
    if(isset($_GET['kat']))
                      {             
                           $kat =$_GET['kat'];
                      }
                      else
                      {
                           $kat = 0;
                      }
        $total = 0;
		$mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
		$handlekurv = $_SESSION['handlekurv'];
		if ($handlekurv) 
		{
		$varer = explode(',',$handlekurv);
		$liste = array();
		foreach ($varer as $vare) {
			$liste[$vare] = (isset($liste[$vare])) ? $liste[$vare] + 1 : 1;
		}
		//$kat = $_GET['kat'];
		$utskrift[] = '<form action="?kat='.$kat.'&action=update" method="post">';
		$utskrift[] = '<h2>Handlekurv</h2>';
		$utskrift[] = '<table>';
		foreach ($liste as $id=>$antall) {
			$sql = "SELECT * FROM vare WHERE idvare = $id;";
			$resultat = $mysqli->query($sql);
			if(!$resultat)
			{
				echo "failed  sql";
				die();
			}
                        $num=$resultat->num_rows;
			 for($i=0;$i<$num;$i++)
			{
				//$kat = $_GET['kat'];
				$rad=mysqli_fetch_row($resultat);
				$utskrift[] = '<tr>';
				$utskrift[] = '<td><a href="index.php?idvare='.$rad[0].'">'.$rad[2].'</a></td><td>'.$rad[6].',-</td>';
				$utskrift[] = '<td>x<input type="text" name="antall'.$id.'" value="'.$antall.'" size="1" maxlength="2" />stk</td>';
				$utskrift[] = '<td>'.($rad[6] * $antall).',-'.'</td>';
				$utskrift[] = '<td><a href="?kat='.$kat.'&action=delete&id='.$id.'">x</a></td>';
				$total += $rad[6] * $antall;
               	$utskrift[] = '</tr>';
				
			}
		}	
		$utskrift[] = '</table>';
		$utskrift[] = "<p><br>Sum å betale <strong>".$total.',- kr'." "."</strong></p>";
		$utskrift[] = '<div><button type="submit">Oppdater</button></div>';
		$utskrift[] = '</form>';
		} 
	else 
	{
		$utskrift[] =	'<h2>Handlekurv</h2>';
		$utskrift[] = '<p>Handlekurven er tom</p>';
	}
	return join('',$utskrift);
}

public function lol()
{
	echo "lol";
}
}// end of class
?>