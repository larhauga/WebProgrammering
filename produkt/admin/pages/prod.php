<?php  
$Admin = unserialize($_SESSION['admin']);

/* Produktoppdateringsside */
if(isset($_POST['slett']) && isset($_POST['produkt']))
    {
        foreach ($_POST['produkt'] as $idSlett)
        {
            $Admin->slettProd($idSlett);
        }
        unset($_POST['slett']);
        unset($_POST['produkt']);
    }
 if(isset($_POST['regVare']))
 {
     $idkategori = $_POST['kategori'];
     $dato = date("Y-m-d H:i:s");
     $aktiv = $_POST['aktiv'];
     $tittel = $_POST['tittel'];
     $filnavn = "";
     $tekst = $_POST['text'];
     $pris = $_POST['pris'];
     $idbruker = $Admin->idbruker;
     $antall = $_POST['antall'];
     
     
     $Admin->nyttProdukt($idkategori, $dato, $aktiv, $tittel, $filnavn, $tekst, $pris, $antall ,$idbruker);
     
        //header('Location:'.$_SERVER["PHP_SELF"].'?id=4');
 }
	echo '
        <h1><img src="images/Cardboard-Box.png" alt="Brukere" width="30" height="30" />Produkter</h1>
        <div id="formVenstre">
        <h2>Legg til produkt</h2>
                <form action="" name="ny" id="ny" method="post">';
                    if(isset($feilProd))
                        echo $feilProd;
        echo '
                <table width="100%">
                        <tr>
                                <td>Kategori: </td>
                                <td>
                                                <select name="kategori" id="kategori">';
                                                    $Admin->listValgKat();
                                                    echo '
                                                </select>
                                </td>
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
                        <tr>
                                <td>Tittel: </td>
                                <td><input type="text" id="tittel" name="tittel" /></td>
                        </tr>
                        <tr>
                                <td>Bilde: </td>
                                <td>
                                    <form action="upload.php" method="post" enctype="multipart/form-data" target="upload_target" />
                                            <input type="file" size="10" name="filstreng" />
                                            <input type="submit" name="knapp" value="Last opp"/>
                                    </form>
                                </td>
                        </tr>
                        <tr>
                                <td>Tekst: </td>
                                <td>
                                        <textarea rows="12" cols="55" name="text" id="text" style="max-width:350px; max-height:400px;">
                                        </textarea>
                                </td>
                        </tr>
                        <tr>
                                <td>Pris: </td>
                                <td><input type="text" id="pris" name="pris" /></td>
                        </tr>
                        <tr>
                            <td>Antall: </td>
                            <td><input type="text" id="antall" name="antall" /></td>
                        </tr>
                        <tr class="submit">
                                <td></td>
                                <td><input type="submit" name="regVare" id="regVare" /></td>
                        </tr>
                </table>
                </form>
        </div>
        <div id="formHoyre">
        <h2>Produkter</h2>
        <p>Det er totalt '.$Admin->visAntVarer().' varer.</p>';
                if(isset($feilSlett))
                    echo $feilSlett;
        echo'<table width="100%">
                        <tr>
                                <td><input type="text" id="sok" name="sok" /></td>
                        </tr>
                        <script type="text/javascript">
                            $("#sok").keyup(function() {
                              $("#resultat").load("ajax/produkt.php?sok=" + document.getElementById("sok").value);
                            });
                       </script>
                </table>
                <form action="" name="slett" method="POST">
                <div id="resultat">
                <table width="100%">
                        <tr>
                                <td></td>
                                <td>Kategori</td>
                                <td>Navn</td>
                                <td>Bilde</td>
                                <td>Pris</td>
                        </tr>';
                             $Admin->visProdukter(0,10,"");
               echo '
                </table>
                </div>                                
                <table width="100%">
                    <tr class="submit">
                        <td width="80%"></td>
                        <td><input type="submit" id="slett" name="slett" value="Slett" /></td>
                    </tr>
               </table>

                </form>
        </div>
        <div style="clear:both;">
        </div>
';
?>