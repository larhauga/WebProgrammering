<?php
//include('dbase.php');

class Brukerendring extends dbase
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function brukerConnect()
    {
        return parent::connect();
    }

    function endrebruker()
    {
$bruker = unserialize($_SESSION['bruker']);
echo'<form name="endre" method="post" action="?brukerpanel&endrebruker">
<h2>Endre bruker</h2><p>Alle felter utenom passord må fylles ut</p>
                                
				
                                <table width="100%">
                                        
					<tr>
						<td>Epost:</td>
						<td><input type="text" id="epost" value = "'.$bruker->epost.'" name="epost" /></td>
					</tr>
					<tr>
						<td>Fornavn:</td>
						<td><input type="text" id="fornavn" value = "'.$bruker->fornavn.'" name="fornavn" /></td>
					</tr>
					<tr>
						<td>Etternavn:</td>
						<td><input type="text" id="etternavn" value = "'.$bruker->etternavn.'" name="etternavn" /></td>
					</tr>
                                        <tr>
						<td>Adresse:</td>
						<td><input type="text" id="etternavn" value = "'.$bruker->adresse.'" name="adresse" /></td>
					</tr>
                                        <tr>
						<td>Postnummer:</td>
						<td><input type="text" id="etternavn" value = "'.$bruker->postnr.'" name="postnr" /></td>
					</tr>
					<tr>
						<td>Tlf:</td>
						<td><input type="text" id="tlf" value = "'.$bruker->tlf.'" name="tlf" /></td>
					</tr>
					<tr>
						<td>Nytt passord</td>
						<td><input type="passord" id="psw"  name="psw" /></td>
					</tr>
					<tr class="submit">
						<td></td>
						<td><input type="submit" name="endre" id="endre" value="Endre" /></td>
					         
					</tr>
				</table></form>';
    if(isset($_GET['endrebruker']))
    {
        
        $epost = $_POST['epost'];
        $fornavn = $_POST['fornavn'];
        $etternavn = $_POST['etternavn'];
        $adresse = $_POST['adresse'];
        $postnr= $_POST['postnr'];
        $tlf = $_POST['tlf'];
        $psw = $_POST['psw'];
        if($psw)
        {
        $psw = encrypt($psw,$epost);
        $this->sendendringpassord($epost,$fornavn,$etternavn,$adresse,$postnr,$tlf,$psw);
        }
        else if(!$psw)
        $this->sendendring($epost,$fornavn,$etternavn,$adresse,$postnr,$tlf);
    }
    }
    function sendendring($epost,$fornavn,$etternavn,$adresse,$postnr,$tlf)
    {
        
        
        $mysqli = parent::connect();
        $bruker = unserialize($_SESSION['bruker']);
        $brukerid= "select idbruker from bruker where epost = '$bruker->epost';";
        $bruker = mysqli_query($mysqli,$brukerid) or die(mysqli_error($mysqli));
        $id = mysqli_fetch_row($bruker);
        $id = $id[0];
        $endrebruker= 
        "update bruker set 
        epost = '$epost',
                fornavn = '$fornavn',
                etternavn = '$etternavn',
                adresse = '$adresse',
                postnr = '$postnr',
                tlf = '$tlf'
        where idbruker = '$id';";
       
       mysqli_query($mysqli,$endrebruker) or die(mysqli_error($mysqli));
    }
        function sendendringpassord($epost,$fornavn,$etternavn,$adresse,$postnr,$tlf,$psw)
    {
        
        
        $mysqli = parent::connect();
        $bruker = unserialize($_SESSION['bruker']);
        $brukerid= "select idbruker from bruker where epost = '$bruker->epost';";
        $bruker = mysqli_query($mysqli,$brukerid) or die(mysqli_error($mysqli));
        $id = mysqli_fetch_row($bruker);
        $id = $id[0];
        $endrebruker= 
        "update bruker set 
        epost = '$epost',
                fornavn = '$fornavn',
                etternavn = '$etternavn',
                adresse = '$adresse',
                postnr = '$postnr',
                tlf = '$tlf',
                passord = '$psw'
        where idbruker = '$id';";
       
       mysqli_query($mysqli,$endrebruker) or die(mysqli_error($mysqli));
    }
}   
?>