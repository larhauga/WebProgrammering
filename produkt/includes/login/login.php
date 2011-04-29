<?php
include "../head.php";

if(!isset($_GET['login']))
{
	$brukernavn = ($_POST['brukernavn']);
	$passord = ($_POST['passord']);
	//Sette opp sessions
	if($brukernavn != "" && $passord != "")
        {   
            $bruker->login($passord,$brukernavn);
            /*
            mysqli() or die(mysqli_error());
            $sql = "SELECT idbrukere, tilgang, epost FROM brukere WHERE epost = '" . $epost . "' AND passord = '" . $passord . "'";
            $sql = mysqli_query($sql) or die(mysqli_error());*/
            if(!$sql)
            {
                echo "Det skjedde en feil";
            }
            else if ( mysql_affected_rows() == 1)
            {
            	$rad = mysql_fetch_row($sql);
				$_SESSION['login'] = true;
				$_SESSION['brukerid'] = $rad[0];
				$_SESSION['tilgang'] = $rad[1];
				$_SESSION['epost'] = $rad[2];
				unset($passordfeil);
			}
			else{
				$passordfeil = "Epost eller passordet er feil!";
			}
	}
	else
	{
		$passordfeil = "Epost eller passordet er feil!";
	}
	
}
?>
