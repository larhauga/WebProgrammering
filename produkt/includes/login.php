<?php

if(!isset($_GET['login']))
{echo '1';
	$epost = ($_POST['epost']);
	$passord = ($_POST['passord']);
	//Sette opp sessions
	if($epost != "" && $passord != "")
        {   echo '2';
            function login($passord,$epost)
            {  echo '3';
                echo'inne i funksjon login';
                 $passord;
                 $epost;
                // $passord = $bruker->encrypt($passord);
                 $mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
                 $sql = $mysqli->query("SELECT * FROM bruker WHERE epost = '".$epost."' AND passord = '".$passord."'");
                 if(!$sql)
                 {   echo '4';
                    echo "Error".$mysqli->error;
                    $this->error = "Error".$mysqli->error."\r\n";
                    $bruker->errorTilFil($this->error);
                    return false;
                 }
                
            else
             { echo '5';
			//Lager sjekk på om det kun er en bruker.
			$antallRader = $mysqli->affected_rows;
                        echo $antallRader;
			if($antallRader <= 0 || $antallRader > 1)
			{  echo '6';
				$feilmelding = "Feil brukernavn eller passord";
			}
			else if($antallRader == 1)
			{echo '7';
				$rad = $resultat->fetch_object();

				//Oppretter admin objektet
				$bruker = new bruker($rad->epost, $rad->passord, $rad->rettigheter, $rad->idbruker, $rad->fornavn, $_SERVER['REMOTE_ADDR']);
				
				//Serialiserer og oppretter SESSIONs
				$_SESSION['bruker'] = serialize($bruker);
				$_SESSION['login'] = true;
                        }
             }
            }
             login($epost,$passord);
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
