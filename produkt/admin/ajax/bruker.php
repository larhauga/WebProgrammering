<?php
    require("../../includes/_class/admin.php");
    include("../../includes/config1.php");
    $Admin = new Admin('local', 'sok', '2', '0', 'local', ''); //Dummydata for å slippe unna konstruktør

    //Slett
    if(isset($_POST['slett']))
    {
        foreach($_POST['bruker'] as $idSlett){
            echo "<p>Brukeren ".$Admin->finnBrukernavn($idSlett)." er slettet</p>";
            $Admin->slettBrukere($idSlett);
        }
    }
    //Oppdater
    if(isset($_POST['upd']))
        $Admin->endreBruker($idbruker, $epost, $fornavn, $etternavn, $tlf, $passord);
    

    //Gjør til admin
    if(isset($_POST['admin']) && isset($_POST['rettigheter']))
    {
        $rettigheter = $_POST['rettigheter'];
        foreach($_POST['bruker'] as $idbruker)
        {
            $Admin->settTilAdmin($idbruker, $rettigheter);
        }
    }
    if(isset($_POST['hentData']))
    {
        $mysqli = $Admin->adminConnect();
        if($mysqli->connect_error)
        {
            echo $mysqli->connect_error;
        }
        else
        {
            if($_POST['hentData'] != "")
            {
                $sql = "SELECT * FROM bruker WHERE idbruker = ".$_POST['hentData'];
                $resultat = $mysqli->query($sql);
                $ant = $mysqli->affected_rows;
                if($ant == 1)
                {
                    $rad = $resultat->fetch_object();
                    echo json_encode(array("idbruker"=>$rad->idbruker, "epost"=>$rad->epost,"fornavn"=>$rad->fornavn,"etternavn"=>$rad->etternavn,"tlf"=>$rad->tlf));
                }
                else
                    echo "";
            }
        }
    }
    if(isset($_POST['send']))
    {
        
        $idbruker = $_POST['send'];
        $epost = $_POST['epost'];
        $fornavn = $_POST['fornavn'];
        $etternavn = $_POST['etternavn'];
        $tlf = $_POST['tlf'];
        $psw = $_POST['psw'];
        

        $psw1 = "";
        if($psw != "")
        {
            $psw1 = ", passord = '".encrypt($psw, $epost)."'";
        }
        $sql = "UPDATE bruker SET epost = '$epost', fornavn = '$fornavn', etternavn = '$etternavn', tlf = '$tlf'$psw1 WHERE idbruker = '$idbruker'";
        $Admin->endreBruker($sql);
    }
?>
