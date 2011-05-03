<?php
/* Kategorier */
    if(isset($_POST['registrer']) && isset($_POST['tittel']))
    {
        $tittel = $_POST['tittel'];
        $aktiv = $_POST['aktiv'];

        if($tittel != null)
        {
                $Admin->nyKat($tittel, $aktiv);
                unset($_POST['tittel']);
                unset($_POST['aktiv']);
                unset($_POST['registrer']);
        }
        else
        {
                //Alle feltene var ikke skrevet inn. Skriv en feilmelding til dette	
                $feil = "Du må skrive inn en tittel!";
                unset($_POST['tittel']);
                unset($_POST['aktiv']);
                unset($_POST['registrer']);
        }
    }
    if(isset($_POST['slett']) && isset($_POST['slettArr']))
    {
        $array = $_POST['slettArr'];
        foreach($array as $teller=>$idSlett)
        {
            $Admin->slettKat($idSlett);
        }
        unset($_POST['slett']);
        unset($_POST['slettArr']);
    }
    //For oppdatering
    if(isset($_POST['upd']) && $_POST['updtittel'] != "")
    {
        $Admin->updateKat($_POST['kategoriID'], $_POST['updtittel'], $_POST['updaktiv']);
        unset($_POST['upd']);
        unset($_POST['updtittel']);
        unset($_POST['updaktiv']);
        unset($_POST['kategoriID']);
    }
    echo '
        <h1><img src="images/folders.jpg" alt="Brukere" width="30" height="30" />Kategorier</h1>

        <div id="formVenstre">
        <h1>Ny kategori</h1>';
            if(isset($feil))
                echo $feil;
        echo '
        <form action="" method="post">
                        <table width="100%" border="0">
                                <tr>
                                        <td>Tittel:</td>
                                        <td><input type="text" name="tittel" id="tittel" /></td>
                                </tr>
                                <tr>
                                        <td>Aktiv:</td>
                                        <td>
                                                <select name="aktiv" id="aktiv">
                                                        <option value="1">Aktiv</option>
                                                        <option value="0">Ikke aktiv</option>
                                                </select>
                                        </td>
                                </tr>
                                <tr class="submit">
                                        <td>Registrer</td>
                                        <td><input type="submit" name="registrer" id="registrer"/></td>
                                </tr>
                        </table>
        </form>
        <h1>Oppdater kategori</h1>';
            if(isset($feilUpd))
                echo $feilUpd;
echo '        <form action="" method="post">
                        <table width="100%" border="0">
                                <tr>
                                        <td>ID:</td>
                                        <td>
                                            <select name="kategoriID" id="kategoriID" onChange="">';
                                            $Admin->listValgKat();
                                    echo '</select></td>
                                </tr>
                                <tr>
                                        <td>Tittel:</td>
                                        <td><input type="text" name="updtittel" id="updtittel" /></td>
                                </tr>
                                <tr>
                                        <td>Aktiv:</td>
                                        <td>
                                                <select name="updaktiv" id="updaktiv">
                                                        <option value="1">Aktiv</option>
                                                        <option value="0">Ikke aktiv</option>
                                                </select>
                                        </td>
                                </tr>
                                <tr class="submit">
                                        <td>Oppdater</td>
                                        <td><input type="submit" name="upd" id="upd" value="Oppdater" /></td>
                                </tr>
                        </table>
        </form>
            <script type="text/javascript">
                $(document).ready(function() {
                    var katID = $("#kategoriID").val();
                        $.post("ajax/updKat.php", { "sok": katID},
                         function(data){
                           $("#updtittel").val(data.tittel); // Tittel
                           $("#updaktiv").value(data.aktiv); //  Aktiv eller ikke aktiv
                         }, "json");
                });
                
                $("#kategoriID").change(function() {
                var katID = $("#kategoriID").val();
                    $.post("ajax/updKat.php", { "sok": katID},
                     function(data){
                       $("#updtittel").val(data.tittel); // Tittel
                       $("#updaktiv").value(data.aktiv); //  Aktiv eller ikke aktiv
                     }, "json");
                });
            </script>
        </div>
        <div id="formHoyre">
                <h1>Kategorier</h1>';
                if(isset($feilSlett))
                    echo "<p style='color:red;'>".$feilSlett."</p>";
                $Admin->visKat();

        echo '</div>
        <div style="clear:both;"></div>

';
?>