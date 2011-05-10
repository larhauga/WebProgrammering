<?php

/*
 * Liste ordre fra kunder og eventuelt ha muligheten til å endre / slette disse.
 */
echo '<h1><img src="images/Config-Tools.png" alt="Brukere" width="30" height="30" />Ordre</h1>
    <p>Søk etter ordrenummer, bruker eller ordredato.</p>
    <div id="sokefunksjon">
        <table>
            <tr>
                <td>Søk: </td>
                <td><input type="text" id="sok" name="sok" />
            </tr>
        </table>
    </div>
    <div id="resultat">
        <table width="100%">
            <tr>
                <td><b>Se på</b></td>
                <td><b>Bruker</b></td>
                <td><b>Ordredato</b></td>
                <td><b>Sendt</b></td>
            </tr>
';
        $Admin->visOrdre("");
    echo '
        </table>
    </div>
    <div id="forms">
    <div id="formVenstre">
    <p id="loading"></p>
        <h2>Ordreinfo</h2>
            <table width="100%">
                <tr>
                    <td>
                        <label id="fornavn" >Fornavn</label>
                        <label id="etternavn" >Etternavn</label>
                    </td>
                </tr>
                <tr>
                    <td><label id="adresse" >Adresse</label></td>
                </tr>
                <tr>
                    <td>
                        <label id="postnr" >Postnr</label>
                        <label id="poststed" >Poststed</label>
                   </td>
                </tr>
                <tr>
                    <td><label id="tlf" >Telefon</label></td>
                </tr>
                
            </table>
            <br />
            <table>
                <tr>
                    <td>Ordre id: </td>
                    <td><label id="ordreid" >Ordreid</label></td>
                </tr>
                <tr>
                    <td>Ordredato:</td>
                    <td><label id="ordredato" >Ordredato</label></td>
                </tr>
                <tr>
                    <td>Sendt: </td>
                    <td>Nei <label id="sendt" >Sendt</label></td>
                </tr>
            </table>
            <table>
                <tr class="submit">
                    <td><input type="submit" name="sendt" id="sendt" value="Varen er sendt" /></td>
                    <td><input type="submit" name="slett" id="slett" value="Slett ordre" /></td>
                </tr>
            </table>
    </div>
    <div id="formHoyre">
        <h2>Ordreinnhold</h2>
        <table width="100%">
            <tr>
                <td>idvare</td>
                <td>Vare</td>
                <td>Pris</td>
                <td>Antall</td>
                <td>Slett</td>
            </tr>
        </table>
        <table width="100%">
            <tr class="submit">
                <td width="65%"></td>
                <td><input type="submit" id="slettVare" name="slettVare" value="Slett varer" /></td>
            </tr>
        </table>
        
    </div>
    <div style="clear:both"></div>
    </div>
    <script src="ajax/ordre.js"></script>
';
/*
 * Ting som burde være med på siden:
 * Visning: Ved trykk på en ordre:
 * Brukerforavn, etternavn, adresse, postnr og sted, tlf
 * Idordre, ordredato, stendt,
 * Vare -> Pris -> antall
 *      Looper gjennom varene som er i orderen.
 *      Slette vare, endre antall.
 * 
 * Sette ordre til sendt
 * Avlyse ordre
 */

?>
