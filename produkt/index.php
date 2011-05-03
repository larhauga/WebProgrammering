<?php
include "includes/head.php";
if(isset($_GET['loggut']))
{
    unset($_SESSION['bruker']);
    unset($_SESSION['login']);
    unset($_SESSION['epost']);
}
if(isset($_GET['login']))
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
                    $passord = encrypt($passord, $epost);
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
			if($antallRader == 1)
			{
				$rad = $sql->fetch_object();

				//Oppretter bruker objektet
				$bruker = new bruker($rad->epost, $rad->fornavn, $rad->etternavn, $rad->adresse, $rad->postnr, $rad->poststed, $rad->tlf);
				//Serialiserer og oppretter SESSIONs
				$_SESSION['bruker'] = serialize($bruker);
                                $_SESSION['epost'] = $epost;
				$_SESSION['login'] = true;
                       
			}
			else
			{
				$feilmelding = "Feil brukernavn eller passord";
                                echo "Feil brukernavn eller passord";
                        
                        }
               }
            }
            login($passord,$epost);
        }
       else
       {
           $feilmelding = 'Epost eller brukernavn var ikke skrevet inn';
            echo 'Epost eller brukernavn var ikke skrevet inn';
       }

}
?>


<body>
	<div id="container">
		<div id="header">
		<div id="headervenstre">
			<h1>Nettbutikken</h1>
		</div>
		  <div id="headerkolonne">
                      <?php 
                      if(isset($_SESSION['login']))
                      {
                         
                        echo 'Velkommen, '.$_SESSION['epost'];
                        echo ' <a href="?loggut">Logg ut</a>';
                      }
                      else 
                      {
                       if(isset($feilmelding))
                       {
                           echo $feilmelding;
                       }
		  	echo '<div id="logginn">
                            
			    <form name="login" method="post" action="?login">
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
				<form name="sok" method="post" action="sok.php">
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
		

		<div id="meny">
		<ul>
			<li><a href="#">Datautstyr</a></li>
			<li><a href="#">PC</a></li>
			<li><a href="#">Lyd og Bilde</a></li>
			<li><a href="#">Foto og Video</a></li>
			<li><a href="#">Telefoni og Gps</a></li>
			<li><a href="#">Spill</a></li>
			<li><a href="#">Hjem og Fritid</a></li>
		</ul>
		</div>
		
		<div id="main">
			<div id="path">
				<a href="#">Hjem</a> <strong id="hjerte">&hearts;</strong> <a href="#">Datautstyr</a>
			</div><!--end of path-->
<?php
$default	= "hjem";	// fila som skal inkluderes hvis variabelen er tom.
$directory	= "includes";		// mappa filene dine ligger i.
$extension	= "php";		// filendingen på filene dine.

$page = $_GET['page'];

if (preg_match('/(http:\/\/|^\/|\.+?\/)/', $page)) echo "feil";


elseif (!empty($page))											// sjekke at variabelen ikke er tom.
{
	if (file_exists("$directory/$page.$extension"))				// sjekke om fila eksisterer.
	include("$directory/$page.$extension");					// inkluder fila.
	else														// hvis ikke,
	echo "<h1>Error 404</h1>\n<p>Finner ikke siden!</p>\n";	// skriv en feilmelding.
}
else															// eller,
	include("$directory/$default.$extension");					// inkluder fila som definert som $default.

?>
		</div><!--end of main-->
		<div id="rightbar">
		  <div id="handlevogn">
		    <h1>Handlevogn</h1>
		  	<p>Vare 1</p>
		  	<p>Vare 2</p>
	  	  </div>
		</div><!--end of rightbar -->
        <?php
		include "includes/footer.php";
		?>
	</div>
</body>
</html>