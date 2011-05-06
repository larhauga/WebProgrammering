<?php
    require("../../includes/_class/admin.php");
    $Admin = new Admin('local', 'sok', '2', '0', 'local', ''); //Dummydata for å slippe unna konstruktør

    if(isset($_GET['sok']))
    {
        $fra = 0;
        $til = 10;
        $sok = $_GET['sok'];
        
        if(isset($_GET['fra']))
            $fra = $_GET['fra'];
        if(isset($_GET['til']))
            $til = $_GET['til'];
        
        echo '
        <table width="100%">
                <tr>
                        <td></td>
                        <td>Navn</td>
                        <td>Kategori</td>
                        <td>Bilde</td>
                        <td>Pris</td>
                </tr>';
        $Admin->visProdukter($fra, $til, $sok);
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
                $sql = "SELECT  vare.idkategori,
                                vare.statusAktiv,
                                vare.tittel,
                                vare.bildeurl,
                                vare.tekst,
                                vare.pris,
                                vareregister.antall
                        FROM vare, vareregister
                        WHERE vare.idvare = vareregister.idvare AND idvare = ".$_POST['hentData'];
                $resultat = $mysqli->query($sql);
                $ant = $mysqli->affected_rows;
                if($ant == 1)
                {
                    $rad = $resultat->fetch_object();
                    echo json_encode(array("idkategori"=>$rad->idkategori, "statusAktiv"=>$rad->statusAktiv,"tittel"=>$rad->tittel,"bildeurl"=>$rad->bildeurl,"tekst"=>$rad->tekst,"pris"=>$rad->pris,"antall"=>$rad->antall));
                }
                else
                    echo "";
            }
        }
    }
?>
