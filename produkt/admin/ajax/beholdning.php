<?php
    require("../../includes/_class/admin.php");
    $Admin = new Admin('local', 'sok', '2', '0', 'local', ''); //Dummydata for å slippe unna konstruktør
    
    if(isset($_GET['sok']))
    {   
        $sok = $_GET['sok'];
        echo '
            <table width="100%">
            <tr>
                <td></td>
                <td>Tittel</td>
                <td>Regdato</td>
                <td>Pris</td>
                <td>Kategori</td>
                <td>Sist oppdatert</td>
                <td>Antall varer</td>
                <td>Registrert av</td>
            </tr>';
             $Admin->visBeholdning(0, 2000, $sok);
    }
    if(isset($_GET['kategori']) && $_GET['kategori'] != "")
    {
        echo '
            <table width="100%">
            <tr>
                <td></td>
                <td>Tittel</td>
                <td>Regdato</td>
                <td>Pris</td>
                <td>Kategori</td>
                <td>Sist oppdatert</td>
                <td>Antall varer</td>
                <td>Registrert av</td>
            </tr>';
        $Admin->visBeholdningPrKategori($_GET['kategori']);
    }
    if(isset($_POST['varer']) && isset($_POST['antall']))
    {
        $antall = $_POST['antall'];
        foreach($_POST['varer'] as $idvare)
        {
            if(!$Admin->settAntVarer($idvare, $antall))
                    echo '<p>Varen nr. '.$idvare.' ble ikke oppdatert.</p>';
            
        }
    }
?>
