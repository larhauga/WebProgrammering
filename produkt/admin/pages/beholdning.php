<?php
echo '
    <h1><img src="images/barcode.jpg" alt="Brukere" width="30" height="30" />Varebeholdning</h1>
    - Endre antall varer<br/>
    - Visning bassert p� kategori<br/>
    <p>Det er totalt '.$Admin->visAntVarer().' varer registrert.</p>
    <table width="100%">
            <tr>
                    <td width="10%">Kategorier: </td>
                    <td>
                <select name="kategoriID" id="kategoriID" onChange="">';
                    $Admin->listValgKat();
           echo '</select>
                    </td>
            </tr>
    </table>
    <table width="100%">
            <tr>
                    <td width="10%">Søk: </td>
                    <td><input type="text" id="sok" name="sok" /></td>
            </tr>
    </table>
    <script type="text/javascript">
        $("#sok").keyup(function() {
          $("#resultat").load("ajax/beholdning.php?sok=" + document.getElementById("sok").value);
        });
    </script>
    <div id="resultat">';
        $Admin->visBeholdning(0,35,"");
    echo '
    </div>
    <div id="formVenstre">
        <h2>Sett antall varer</h2>
    </div>
    <div id="formHoyre">
    <div style="clear:both"></div>
';
?>