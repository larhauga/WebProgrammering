<?php
//include "../head.php";

if(!isset($_GET['login']))
{
	$epost = ($_POST['epost']);
	$passord = ($_POST['passord']);
	//Sette opp sessions
	if($epost != "" && $passord != "")
        {   
            
            function login($passord,$epost)
            {
                 $passord;
                 $epost;
                 $passord = $bruker->encrypt($passord);
                 $mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
                 $sql = "select * from bruker where brukernavn = '$epost' and passord = '$passord'";
                 $resultat = $mysqli->query($sql);
                 if(!resultat)
                 {
                    echo "Error".$mysqli->error;
                    $this->error = "Error".$mysqli->error."\r\n";
                    $bruker->errorTilFil($this->error);
                    die();
                 }
            else
             {
                 return $this->brukernavn;
             } 
                $bruker->login($passord,$epost);
          }
            /*
            mysqli() or die(mysqli_error());
            $sql = "SELECT idbrukere, tilgang, epost FROM brukere WHERE epost = '" . $epost . "' AND passord = '" . $passord . "'";
            $sql = mysqli_query($sql) or die(mysqli_error());*/
            if(!$bruker)
            {
                echo "Det skjedde en feil";
            }
            else
            {
                /*
            	$rad = mysql_fetch_row($sql);
				$_SESSION['login'] = true;
				$_SESSION['brukerid'] = $rad[0];
				$_SESSION['tilgang'] = $rad[1];
				$_SESSION['epost'] = $rad[2];
				unset($passordfeil);
			}
			else{
				$passordfeil = "Epost eller passordet er feil!";
			}*/
	}
	else
	{
		$passordfeil = "Epost eller passordet er feil!";
	}
	
}

?>
