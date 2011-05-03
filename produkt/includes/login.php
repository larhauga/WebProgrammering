<?php
session_start();
include "head.php";
if(!isset($_get['login']))
{
	$epost = ($_POST['epost']);
	$passord = ($_POST['passord']);
       // $passord = encrypt($pass);
	//Sette opp sessions
	if($epost != "" && $passord != "")
        {
            function login($passord,$epost)
            {

             //    $passord;
             //    $epost;
                // $passord = $bruker->encrypt($passord);
                 $mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1') or die(mysqli_error());
                 $sql = $mysqli->query("SELECT * FROM bruker WHERE epost = '".$epost."' AND passord = '".$passord."'") or die(mysqli_error());
                 
                 if(!$sql)
                 {
                    echo "Error".$mysqli->error;
                    $this->error = "Error".$mysqli->error."\r\n";
                    $bruker->errorTilFil($this->error);
                    die();
                 }
                
                 else
                 {
                 
			//Lager sjekk på om det kun er en bruker.
			$antallRader = $mysqli->affected_rows;
			if($antallRader <= 0 || $antallRader > 1)
			{  
				$feilmelding = "Feil brukernavn eller passord";
                                echo "Feil brukernavn eller passord";
                                echo '<br/> <a href="../index.php">Tilbake</a>';
                                die();
			}
			else if($antallRader == 1)
			{
				$rad = $sql->fetch_object();

				//Oppretter admin objektet
				$bruker = new bruker($rad->epost, $rad->fornavn, $rad->etternavn, $rad->adresse, $rad->postnr, $rad->poststed, $rad->tlf);
				//Serialiserer og oppretter SESSIONs
				$_SESSION['bruker'] = serialize($bruker);
                                $_SESSION['epost'] = $epost;
				$_SESSION['login'] = true;
                                
                                echo 'logget inn';
                                echo '<br/> <a href="../index.php">Tilbake</a>';
                        }
               }
            }
            login($passord,$epost);
        }
 else {
     echo 'Epost eller brukernavn var ikke skrevet inn';
     echo '<br/> <a href="../index.php">Tilbake</a>';
    die();
}
}
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
?>