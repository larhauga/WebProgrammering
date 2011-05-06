<?php
echo '
    <h1><img src="images/barcode.jpg" alt="Brukere" width="30" height="30" />Varebeholdning</h1>
    <p>Det er totalt '.$Admin->visAntVarer().' varer registrert.</p>
    <table width="100%">
            <tr>
                    <td width="10%">Kategorier: </td>
                    <td>
                <select name="kategoriID" id="kategoriID">';
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
            $("#kategoriID").change(function () {
                $("#resultat").load("ajax/beholdning.php?kategori=" + $("#kategoriID").val());
            });
            $("#sok").keyup(function() {
              $("#resultat").load("ajax/beholdning.php?sok=" + document.getElementById("sok").value);
            });
   </script>

    <div id="resultat">
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
        </tr>
';
        $Admin->visBeholdning(0,35,"");
    echo '
    </table>
    </div>
    <div id="formVenstre">
        <h2>Sett antall varer</h2>
        <table width="100%">
            <tr>
                <td width="20%"><input type="text" id="antall" name="antall" /></td>
                <td class="submit"><input type="submit" id="endreAntall" name="endreAntall" /></td>
            </tr>
        </table>
    </div>
    <div id="formHoyre"></div>
    <div style="clear:both"></div>
';
?>