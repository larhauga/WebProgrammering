<?php
$innepost = $_POST['epost'];
$innepost2 = $_POST['epost2'];
$innpassord = $_POST['passord'];
$innpassord2 = $_POST['passord2'];
$innfornavn = $_POST['fornavn'];
$innetternavn = $_POST['etternavn'];

$innadresse = $_POST['adresse'];
$innpostnr = $_POST['postnr'];

$inntlf = $_POST['tlf'];
if($innepost != "" && $innpassord != "" && $innfornavn != "" && $innetternavn != "" && $innadresse != "" && $innpostnr != "")
{
    if($innepost == $innepost2)
    {
            if($innpassord == $innpassord2)
                    {
                            $passord = encrypt($innpassord, $innepost);
                            $bruker = new bruker($innepost,$innfornavn,$innetternavn,$innadresse,$innpostnr,$inntlf, '1');
                            $bruker->passord = $passord;
                            $bruker->updateDB();
                    }
                    else 
                    { 
                        echo "Du har ikke skrevet inn 2 like passord";    
                    }
    }
    else
    { 
         echo "Du har ikke skrevet inn 2 like eposter";    
    }
}
else
{
    echo "<p>Du må fylle inn alle feltene.</p>";
    include('includes/registrer.php');
}

?>
