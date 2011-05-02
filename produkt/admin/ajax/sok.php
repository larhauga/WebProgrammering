<?php
    require("../../includes/_class/admin.php");
    $Admin = new Admin('local', 'sok', '2', '0', 'local', '');
    
    if(isset($_GET['sok']))
    {   
        $sok = $_GET['sok'];
        echo '
            <table width="100%">
                <tr>
                        <td></td>
                        <td>Epost</td>
                        <td>Fornavn</td>
                        <td>Etternavn</td>
                        <td>RegDate</td>
                        <td>Rettighet</td>
                        <td>TLF</td>
                </tr>';
             $Admin->visBrukere(0, 2000, $sok);
             
    }
?>
