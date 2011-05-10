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
				$bruker = new bruker($rad->epost, $rad->fornavn, $rad->etternavn, $rad->adresse, $rad->postnr, $rad->tlf);
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
                        /* $kat = $_GET['kat'];
                       if($kat)
                       {*/
                        echo ' <a href="?kat='.$kat.'&loggut">Logg ut</a><br/><a href="?brukerpanel">Brukerpanel';/*
                       }
                       else
                       {
                        echo ' <a href="?kat=0&loggut">Logg ut</a>';
                       }*/
                      }
                      else 
                      {
                       if(isset($feilmelding))
                       {
                           echo '<div id=loginerror>'.$feilmelding.'</div>';
                       }
                       /*$kat = $_GET['kat'];
                       if($kat)
                       {
		  	echo '<div id="logginn">
                            
			    <form name="login" method="post" action="?kat='.$kat.'&login">';
                        }
                        else
                        {
                            '<div id="logginn">
                            
			    <form name="login" method="post" action="?kat=0&login">';
                        }*/
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
					           Registrer <a href="includes/registrer.php">her</a><br/></td>
                                                         
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
        echo 'hei';
        include 'includes/_class/brukerpanel.php';
        $b = new Brukerendring;
        $b->endrebruker();
    }
/*
    else
    {
		if(!isset($_GET['step']))
        {
			$Vare->nyheter();
		}
    }*/
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