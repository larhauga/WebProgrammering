<?php
    require("../../includes/_class/admin.php");
    $Admin = new Admin('local', 'sok', '2', '0', 'local', ''); //Dummydata for å slippe unna konstruktør
    
    if(isset($_GET['sok']))
    {   
        $sok = $_GET['sok'];
        echo '
            <table width="100%">
                <tr>
                    <td><input type="checkbox" id="selectAll" name="selectAll" value="selectAll" /></td>
                    <td><b>Epost</b></td>
                    <td><b>Fornavn</b></td>
                    <td><b>Etternavn</b></td>
                    <td><b>RegDate</b></td>
                    <td><b>Rettighet</b></td>
                    <td><b>TLF</b></td>
                </tr>';
             $Admin->visBrukere(0, 2000, $sok);
             
    }
?>
