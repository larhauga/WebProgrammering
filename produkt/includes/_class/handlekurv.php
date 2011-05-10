<?php
class handlekurv
{
	public $total;
	public $utskrift;
	public $vareid;
	public $antall;
	
	function __construct()
	{
		$this->total = 0;
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
		if(isset($_GET['handlevogn']))
		{
				
	
			$step = $_GET['step'];
			$utskrift[] = '<form action="?action=update&handlevogn=1&step='.$step.'"'.'method="post">';

		}
		else
		{
			$utskrift[] = '<form action="?kat='.$kat.'&action=update" method="post">';
		}
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
				//$kat = if(isset($_GET['handlevogn']));
				$rad=mysqli_fetch_row($resultat);
				$utskrift[] = '<tr>';
				$utskrift[] = '<td><a href="index.php?idvare='.$rad[0].'">'.$rad[2].'</a></td><td>'.$rad[6].',-</td>';
				$utskrift[] = '<td>x<input type="text" name="antall'.$id.'" value="'.$antall.'" size="1" maxlength="2" />stk</td>';
				$utskrift[] = '<td>'.($rad[6] * $antall).',-'.'</td>';
				$utskrift[] = '<td><a href="?kat='.$kat.'&action=delete&id='.$id.'">x</a></td>';
				$total += $rad[6] * $antall;
				$this->total = $total;
               	$utskrift[] = '</tr>';
				
				//lagrer ting i klassen
				$this->vareid = $id;
				$this->antall = $antall;
				//$ordre->addOrdrelinje($id,$antall);
			}
		}	
		$utskrift[] = '</table>';
		$utskrift[] = "<p><br>Sum å betale <strong>".$this->total.',- kr'." "."</strong></p>";
		$utskrift[] = '<div><button type="submit">Oppdater</button></div>';
		$utskrift[] = '</form>';
		$this->total = $total;
                if(!isset($_GET['step']))
                    if(!$_GET['step']==2)
		$utskrift[] = '<form action="?handlevogn=1&step=2" method="post"><button type="submit">Kjøp</button></form>';
		
		}
                
	else 
	{
		$utskrift[] =	'<h2>Handlekurv</h2>';
		$utskrift[] = '<p>Handlekurven er tom</p>';
	}
	return join('',$utskrift);
}

public function handlevognsjekk()
{
 //start av handlekurv
if(isset($_GET['handlevogn']))
{
	if(is_numeric($_GET['handlevogn']))
	{
		if($_GET['handlevogn'] == 1)
		{
			$this->visHandleSide();
		}
	}
}

}//end of handlevognsjekk

function visHandleSide()
{
	echo $this->visHandlekurv();
	if(!isset($_SESSION['loggetinn']))
	{
		echo "<br>";
		echo "<strong>Du må logge inn for å kunne forsette handelen din</strong>";
	}
	else
	{
		echo '<form action="?step=3" method="post"><button type="submit">Bekreft</button></form>';
	}
}// end of visHandleSide
function betalingsjekk() //error handler må til her :)
{
	if(isset($_GET['step']))
{
	if(is_numeric($_GET['step']))
	{
		if($_GET['step'] == 3)
		{
			echo "Betalingen har nå gått igjenomm<br>";
                        $ordre = new ordre();
			$ordre->sendOrdre($this->total);
		}
		else
		{
			echo "Nå har du endret på noe i urlen";
		}
	}
	else
	{
		echo "Nå har du endret på noe i urlen";
	}
}
	
	
}// end of betalingsjekk
}// end of class
?>