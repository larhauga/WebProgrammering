<?php
    require_once("includes/head.php");
    $Vare = new Vare();

if(isset($_GET['loggut']))
{
    unset($_SESSION['bruker']);
    unset($_SESSION['loggetinn']);
}
if(isset($_GET['login']))
{
	$epost = ($_POST['epost']);
	$passord = ($_POST['passord']);

        
	if($epost != "" && $passord != "")
        {
            function login($passord,$epost)
            {

             //    $passord;
             //    $epost;
                 $passord = encrypt($passord, $epost);
                 $Vare = new Vare();
                 $mysqli = $Vare->vareConnect();
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
			if($antallRader == 1)
			{
				$rad = $sql->fetch_object();

				//Oppretter bruker objektet
				$bruker = new bruker($rad->epost, $rad->fornavn, $rad->etternavn, $rad->adresse, $rad->postnr, $rad->tlf, $rad->rettigheter);
				//Serialiserer og oppretter SESSIONs
				$_SESSION['bruker'] = serialize($bruker);
                                //$_SESSION['epost'] = $epost;
				$_SESSION['loggetinn'] = true;
                       
			}
                        else
                       {
                        $feilmelding = 'Epost eller brukernavn var ikke skre vet inn';
                        return $feilmelding;
                       }
               }
            }
            login($passord,$epost);
        }
       else
       {
           $feilmelding = 'Epost eller brukernavn var ikke skrevet inn';
       }
}
?>



<body>
	<div id="container">
		<div id="header">
		<div id="headervenstre">
			<h1><a href="index.php?hjem">Nettbutikken</a></h1>
		</div>
		  <div id="headerkolonne">
                      <?php 
                      if(isset($_GET['kat']))
                      {             
                           $kat =$_GET['kat'];
                      }
                      else
                      {
                           $kat = 0;
                      }
                      if(isset($_SESSION['loggetinn']))
                      {
                          
                        $bruker = unserialize($_SESSION['bruker']);
                        $epost=$bruker->epost;
                        echo 'Velkommen, '.$epost;
                        echo ' <a href="?kat='.$kat.'&loggut">Logg ut</a><br/><a href="?brukerpanel">Brukerpanel</a>';
                        
                        if($bruker->rettigheter == 0)
                        {
                            echo ' - <a href="admin/">Administrasjon</a>';
                        }
                      }
                      else 
                      {
                       if(isset($feilmelding))
                       {
                           echo '<div id=loginerror>'.$feilmelding.'</div>';
                       }
			echo '<div id="logginn">
                            
			    <form name="login" method="post" action="?kat='.$kat.'&login">
                                <table>
						  <tr>
							<td>Epost: </td>
							<td><input type="text" name="epost" id="epost" /></td>
					      </tr>
					      <tr>
					        <td>Passord: </td>
					        <td><input type="password" name="passord" id="passord" /></td>
				    	  </tr>
				          <tr>
					         <td></td>
						 	 <td><input type="submit" name="login" id="login" value="Logg inn" />
					           Registrer <a href="?reg">her</a><br/></td>
                                                         
					      </tr>
						</table>
					</form>
				</div>';
                      }
				?>
			<div id="sok">
				<form name="sok" method="post" action="?sok">
						<table>
							<tr>
								<td><input type="text" name="soktekst" id="soktekst" /></td>
								<td><input name="sok" type="submit" value="SØK" /></td>
							</tr>
						</table>
				</form>
			</div>
		 </div>

		</div>
	<?php	

		echo '<div id="meny">';
                    $Vare->meny();
		echo '</div>
		
		<div id="main">';
			
if(isset($_GET['kat']))
{
    if(is_numeric($_GET['kat']))
    {
        $side = $Vare->getkat($_GET['kat']);
        echo '<div id="path">
                <a href="index.php?hjem">Hjem</a> <strong id="hjerte">&hearts;</strong> <a href="?kat='.$_GET['kat'].'">'.$side.'</a>
                    </div><!--end of path-->';
    }
}  
else
{
    echo '<div id="path">
          </div>
          <!--end of path-->';
}

    if(isset($_GET['kat']))
    {
        if(is_numeric($_GET['kat']))
        $Vare->varer($_GET['kat']);
    }
    else if(isset($_GET['sok']))
    {
        $soktekst = $_POST['soktekst'];
        $Vare->varesok($soktekst);
    }
    else if(isset($_GET['idvare']))
    {
        
        $Vare->visvare($_GET['idvare']);
    }
    else if(isset($_GET['handlevogn']))
    {
        
    }
    else if(isset($_GET['brukerpanel']))
    {
        include 'includes/_class/brukerpanel.php';
        $b = new Brukerendring;
        $b->endrebruker();
    }
    else if(isset($_GET['reg']))
    {
        include('includes/registrer.php');
    }
    else if(isset($_GET['registrer']))
    {
        include('includes/regBruker.php');
    }
    else if(isset($_GET['kontakt']))
    {
        $epost = $_POST['epost'];
        $tekst = $_POST['tekst'];
        
        if($epost != "" && $tekst != "")
        {
            mail($epost,
                    "Kontaktskjema Webprogrammering",
                    $tekst,
                    "From : Webprogrammering \r\n");
                    echo "<h1>Eposten er sendt</h1>
                            <p>Eposten er sendt. Du vil motta epost på ".$epost.".</p>";
        }
    }

    else
    {
        echo '<h1>Prosjektoppgave HiO våren 2011</h1>
                <p>Velkommen til prosjektoppgaven for:</p>
                    <ul>
                        <li><b>Lars Haugan</b> - s171201</li>
                        <li><b>Ole Henrik Paulsen</b> - s171194</li>
                        <li><b>Anders Struksn&aelig;s</b> - s171192</li>
                    </ul>
                <p>Denne siden har også <a href="admin/">administrasjonssider</a>.
                    Link til denne siden kommer opp hvis du logger inn som administrator, <br/>eller går til adressen <a href="admin/">/admin</a>. </p>
                <h2>Innlogging</h2>
                <p>For å logge inn kan du benytten den ferdige brukeren test.<br />
                    <b>Brukernavn:</b> test<br />
                    <b>Passord:</b> test<br/>
                    
                    Dette er en administratorbruker som også kan brukes på administratorsiden.</p>
                <h2>Ved implementering på andre tjenere</h2>
                    <p>Hvis siden skulle vært implementert på en annen tjener, må noen endringer bli gjort i koden.</p>
                    <h3>Database</h3>
                    <p>Vedlagt ligger en kjørbar SQL fil som importerer alle tabellene som er brukt.<br />
                        Adressen, brukernavnet og passordet blir endret i klassen dbase.php som ligger under includes/_class/. Denne blir inkludert og brukt i alle klasser.</p>
                    <p>Error_handleren trenger en Absoluttpath til loggfilen.</p>
                    
                <h2>Kontakt oss</h2>
                <form action="?kontakt" method="post" name="registrer">
                    <table>
                    <tr>
                        <td>Epost:</td>
                        <td><input type="text" id="epost" name="epost"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><textarea id="tekst" name="tekst" cols="40" rows="10"></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="sendEpost" id="sendEpost" /></td>
                    </tr>
                    </table>
                </form>
                <h2>Kreditering</h2>
                <p>Vi har på enkelte sider brukt et javascript bibliotek kalt <a href="http://jquery.com/">jquery</a>.<br />
                Dette er et mye brukt bibliotek med refferanser fra blant annet, Google, Wordpress og Drupal.</p>
                
                <h2>Kjente feil og mangler</h2>
                    <p>På enkelte sider hvor jquery brukes har det oppstått et kjent problem ved ajax request.<br />
                        Problemet går ut på at knapper slutter å virke etter en ajax request. Dette ble oppdaget sent i testingen, og har derfor ikke blitt utrettet.
                        Link til jquery sin FAQ: <a href="http://docs.jquery.com/Frequently_Asked_Questions#Why_do_my_events_stop_working_after_an_AJAX_request.3F">http://docs.jquery.com/Frequently_Asked_Questions#Why_do_my_events_stop_working_after_an_AJAX_request.3F</a>
                        Her er det en veiledning om hvordan dette skal fikses, og dette blir utbedret i en senere versjon.</p>';
        /*
         * Denne delen av siden er ikke ferdig og er derfor byttet ut med informasjon.
         * Det som er i denne else setningen er det som kommer frem på hovedsiden.
	if(!isset($_GET['step']))
        {
			$Vare->nyheter();
	}
        */
    
    }
$kurv->handlevognsjekk();
if(isset($_GET['step']) && $_GET['step'] == 3)
{
    $kurv->betalingsjekk();
}
?>
		</div><!--end of main-->
		<div id="rightbar">
		  <div id="handlevogn">
          <?php
		  include "handlekurv.php";
		  ?>
	  	  </div>
		</div><!--end of rightbar -->
        <?php
		include "includes/footer.php";
		?>
	</div>
</body>
</html>