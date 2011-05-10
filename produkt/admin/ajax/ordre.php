<?php

/*
 * Ajax fil for administratorpanelets ordreside
 *  Utfører funksjoner som sletting, endring og visning av ordre
 */

    require("../../includes/_class/admin.php");
    $Admin = new Admin('local', 'sok', '2', '0', 'local', ''); //Dummydata for å slippe unna konstruktør
    
    if(isset($_GET['sok']))
    {   
        $sok = $_GET['sok'];
        echo '    
            <table width="100%">
            <tr>
                <td><b>Se på</b></td>
                <td><b>Bruker</b></td>
                <td><b>Ordredato</b></td>
                <td><b>Sendt</b></td>
            </tr>';
             $Admin->visOrdre($sok);
             echo '</table>
              
            ';
    }
    
    if(isset($_POST['hentData']))
    {
        /* Dette skal være med tilbake:
         *  Fornavn, Etternavn, adresse, postnr, poststed, telefon, ordreid, ordredato, sendt?
         */
        $mysqli = $Admin->adminConnect();
        if($mysqli->connect_error)
        {
            echo $mysqli->connect_error;
        }
        else
        {

                $verdi = mysqli_real_escape_string($mysqli, $_POST['hentData']);
                
                $sql = "SELECT  bruker.fornavn as fornavn,
                                bruker.etternavn as etternavn,
                                bruker.adresse as adresse,
                                bruker.postnr as postnr,
                                poststed.sted as poststed,
                                bruker.tlf as tlf,
                                ordre.idordre as idordre,
                                ordre.ordredato as ordredato,
                                ordre.sendtdato as sendtdato
                        FROM ordre, bruker, poststed
                        WHERE bruker.idbruker = ordre.idbruker AND
                                bruker.postnr = poststed.postnr AND
                                ordre.idordre = '$verdi'";
                $resultat = $mysqli->query($sql);
                $ant = $mysqli->affected_rows;
                if($ant == 1)
                {
                    $rad = $resultat->fetch_object();
                    $sendt = $Admin->ordreSendt($rad->sendtdato);
                    echo json_encode(array("fornavn"=>$rad->fornavn, 
                                           "etternavn"=>$rad->etternavn,
                                           "adresse"=>$rad->adresse, 
                                           "postnr"=>$rad->postnr, 
                                           "poststed"=>$rad->poststed,
                                           "tlf"=>$rad->tlf,
                                           "ordreid"=>$rad->idordre,
                                           "ordredato"=>$rad->ordredato,
                                           "sendt"=>$sendt));
                }
                else
                    echo "fail";
            }
    }
    if(isset($_GET['idordre']))
    {
        if(is_numeric($_GET['idordre']))
        {
            $idordre = $_GET['idordre'];
            $Admin->visOrdreInnhold($idordre);
        }
        else
        {
            echo "<p>Kunne ikke finne ordren.</p>";
        }
    }
    if(isset($_POST['slett']))
    {
        $Admin->slettOrdre($_POST['slett']);
    }
    if(isset($_POST['sendt']))
    {
        $Admin->settOrdreTilSendt($_POST['sendt']);
    }
    if(isset($_POST['slettVare']))
    {
        foreach($_POST['slettVare'] as $idvare)
        {
            $Admin->slettVare($idvare);
            
        }
    }
?>
