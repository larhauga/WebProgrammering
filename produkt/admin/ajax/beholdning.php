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
?>
