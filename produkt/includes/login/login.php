<?php
if(isset($_GET['login']))
{
	$epost = mysql_real_escape_string($_POST['epost']);
	$passord = mysql_real_escape_string($_POST['passord']);
	
	//Sette opp sessions
	if($epost != "" && $passord != "")
	{
            $sql = "SELECT idbrukere, tilgang, epost FROM brukere WHERE epost = '" . $epost . "' AND passord = '" . $passord . "'";
            $sql = mysql_query($sql);
            if(!sql)
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
