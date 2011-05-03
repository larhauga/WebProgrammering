<?php
    require("../../includes/_class/admin.php");
    $Admin = new Admin('local', 'sok', '2', '0', 'local', ''); //Dummydata for å slippe unna konstruktør

    //Slett
    if(isset($_POST['slett']))
    {
        foreach($_POST['bruker'] as $idSlett){
            $Admin->slettBrukere($idSlett);
            echo "<p>Bruker ".$Admin->finnBrukernavn($idSlett)." er slettet</p>";
        }
    }
    //Oppdater
    if(isset($_POST['upd']))
        $Admin->endreBruker($idbruker, $epost, $fornavn, $etternavn, $tlf, $passord);
    //Gjør til admin
    if(isset($_POST['admin']) && isset($_POST['rettigheter']))
    {
        $rettigheter = $_POST['rettigheter'];
        foreach($_POST['admin'] as $idbruker)
        {
            $Admin->settTilAdmin($idbruker, $rettigheter);
        }
    }
?>
