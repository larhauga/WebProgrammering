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
?>
