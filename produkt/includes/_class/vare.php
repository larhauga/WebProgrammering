<?php
include('dbase.php');

class Vare extends dbase
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function vareConnect()
    {
        return parent::connect();
    }
    
    function meny()
    {
        $mysqli = parent::connect();
        $kategori = "select * from kategori where aktiv ='1' limit 7;";
        $resultat = mysqli_query($mysqli,$kategori ) or die(mysqli_error($mysqli));
        $num=$resultat->num_rows;

        echo '<ul>';
                    for($i=0;$i<$num;$i++)
                     {
                         $valg=mysqli_fetch_row($resultat);
                         echo('<li><a href="index.php?kat='.$valg[0].'">'.$valg[1].'</a></li>');
                         echo "\n\t\t";
                     }
       echo '</ul>';

    }





    function varer($katid)
    {

        $mysqli = parent::connect();

        $varer = "SELECT vare.idvare,
                  vare.tittel as tittel, 
                  vare.pris as pris,
                  vare.tekst as tekst,
                  DATE_FORMAT(`sistoppdatert`, '%d.%m.%y %H:%i') as sisteDato,
                  vareregister.antall as antall,
                  vare.bildeurl
                  FROM vare, kategori, vareregister
                  WHERE vare.idkategori = kategori.idkategori
                  AND vare.idvare = vareregister.idvare AND kategori.idkategori = $katid " ;
        $resultat = mysqli_query($mysqli,$varer ) or die(mysqli_error($mysqli));
        $num=$resultat->num_rows;

        echo '<div id="kategori">';
            if($num < 1)
            {
                echo '<p>Ingen varer i denne kategorien</p>';
            }
            
        $rader = $num % 3;
        $kat = $_GET['kat'];
        $tekst;
        $teller = 0;
        
        echo '<table>';
        for($r = 0; $r < $rader; $r++)
        {

            echo '<tr class="katRad">';
                 for($i=0; $i < 3; $i++)
                 {
                     if($teller < $num)
                     {
                         $teller++;
                         $valg = mysqli_fetch_row($resultat);

                         echo '<td class="katKol">';
                             echo '
                                    <a href="index.php?idvare='.$valg[0].'"><img src="bilder/opplastet/'.$valg[6].'" width = "230" /></a>
                                    <h1><a href="index.php?idvare='.$valg[0].'">'.$valg[1].'</a></h1> 
                                    <p>'.$this->parseTekst($valg[3]).'<br/><br/>
                                        <a href="index.php?idvare='.$valg[0].'">Les mer</a></p>
                                    <p>'.$this->paLager($valg[5]).'</p> 
                                    <h2>'.$valg[2].',-<a href="?kat='.$kat.'&action=add&id='.$valg[0].'">
                                        <img src="includes/images/kjop.jpg" style="float:right" /></a></h2>';
                         echo '</td>';
                         echo "\n\t\t\t\t";
                     }
                 }
           echo '</tr>';
        }
        echo '</table></div>';
        
    }
    function parseTekst($tekst)
    {
        $array = explode(" ", $tekst);
        $lengde = count($array);
        
        if($lengde <= 30)
        {
            return $tekst;
        }
        else
        {
            $string = "";
            for($i = 0; $i < 30; $i++)
            {
                $string .= $array[$i] . " ";
            }
  
                $string .= "...";
            return $string;
        }
    }

    function paLager($antall)
    {   
        if($antall == 0)
            return '<img src="includes/images/ikkepalager.gif" /> Ikke på lager.';
        else if (isset($_GET['idvare']))    
        {
            return '<img src="includes/images/palager.gif" alt="'.$antall.' på lager." title="'.$antall.' på lager." /> Lagerstatus: '.$antall.' på lager';
        }
         else {
             return '<img src="includes/images/palager.gif" alt="'.$antall.' på lager." title="'.$antall.' på lager." /> På lager';
        }
        
    }
    function getkat($katid)
    {
        $mysqli = parent::connect();

        $varer = "select tittel from kategori where idkategori = $katid " ;
        $resultat = mysqli_query($mysqli,$varer ) or die(mysqli_error($mysqli));
        $valg=mysqli_fetch_row($resultat);
        return $valg[0];
    }

    function varesok($soktekst)
    {
        $mysqli = parent::connect();

        $varer = "SELECT  
                            vare.idvare, 
                            kategori.idkategori as katid,
                            kategori.tittel as kategori, 
                            vare.tittel as tittel, 
                            vare.pris as pris, 
                            DATE_FORMAT(`date`, '%d.%m.%y %H:%i') as dato,
                            DATE_FORMAT(`sistoppdatert`, '%d.%m.%y %H:%i') as sisteDato,
                            vareregister.antall as antall,
                            bildeurl
                            
                    FROM vare, kategori, bruker, vareregister
                    WHERE vare.idkategori = kategori.idkategori
                        AND vare.idbruker = bruker.idbruker
                        AND vare.idvare = vareregister.idvare
                            AND (vare.idvare = '$soktekst' 
                                OR kategori.tittel LIKE '$soktekst%' 
                                OR vare.tittel LIKE '%$soktekst%' 
                                OR pris LIKE '$soktekst')";
        $resultat = mysqli_query($mysqli,$varer ) or die(mysqli_error($mysqli));
        $num=$resultat->num_rows;

        echo '<table id = varer>';
        if($num < 1)
        {
            echo '<tr><td>Ingen varer i denne kategorien</td></tr>';
        }

                     for($i=0;$i<$num;$i++)
                     {
						//$kat = $_GET['kat'];
                         $valg=mysqli_fetch_row($resultat);
                         echo('<tr><td>Tittel: <a href="index.php?idvare='.$valg[0].'">'.$valg[3].'</a></td><td> Dato oppdatert: '.$valg[6].'</td><td> Antall: '.$valg[7].'</td><td> Pris: '.$valg[4].'</td></td>
                             <td><a href="?kat='.$valg[1].'&action=add&id='.$valg[0].'">Kj&oslash;p</a></td></tr>');
                     }
        echo '</table>';
    
    }
    function visvare($idvare)
    {
        $mysqli = parent::connect();

        $varer = "SELECT vare.idvare,
                  kategori.idkategori as katid,
                  vare.tittel as tittel, 
                  vare.pris as pris,
		  vare.tekst as tekst,
		  vare.bildeurl as bildeurl,
                  DATE_FORMAT(`date`, '%d.%m.%y %H:%i') as dato,
                  DATE_FORMAT(`sistoppdatert`, '%d.%m.%y %H:%i') as sisteDato,
                  vareregister.antall as antall
                  FROM vare, kategori, vareregister
                  WHERE vare.idkategori = kategori.idkategori
                  AND vare.idvare = vareregister.idvare AND vare.idvare = $idvare;" ;
        $resultat = mysqli_query($mysqli,$varer ) or die(mysqli_error($mysqli));
        $num=$resultat->num_rows;

        echo '<div id="vare">';
        if($num < 1)
        {
            echo '<h3>Varen finnes ikke</h3>';
        }
        else
        {
             $valg = $resultat->fetch_object();
             echo '<h1>'.$valg->tittel.'</h1>';
             echo '<img id="prodVareImg" src="bilder/opplastet/'.$valg->bildeurl.'" alt="'.$valg->tittel.'"  />';
             echo '<h1 style="padding-left:10px;">'.$valg->pris.',-
                    <a href="?kat='.$valg->katid.'&action=add&id='.$valg->idvare.'">
                         <img src="includes/images/kjop.jpg" style="float:right; padding: 0 40px;" />
                    </a></h1>';
                   echo $this->paLager($valg->antall);
             echo '<p>'.$valg->tekst.'</p>';
        }
        echo '</div>';
    
    }
    
    function nyheter()
    {

        $mysqli = parent::connect();

        $varer = "SELECT vare.idvare as idvare,
                  kategori.idkategori as katid,
                  vare.tittel as tittel, 
                  vare.pris as pris,
                  vare.tekst as tekst,
                  DATE_FORMAT(`date`, '%d.%m.%y %H:%i') as dato,
                  DATE_FORMAT(`sistoppdatert`, '%d.%m.%y %H:%i') as sisteDato,
                  vareregister.antall as antall,
                  vare.bildeurl as bildeurl
                  FROM vare, kategori, vareregister
                  WHERE vare.idkategori = kategori.idkategori
                  AND vare.idvare = vareregister.idvare order by dato desc limit 3;";
        $resultat = mysqli_query($mysqli,$varer ) or die(mysqli_error($mysqli));
        $num=$resultat->num_rows;

        echo '<div id="nyhet">';
        if($num < 1)
        {
            echo '<h1>Det er ingen varer til salgs akkurat nå.</h1>';
        }
        else
        {
            echo '<h1>Nyheter</h1>';
             $valg = $resultat->fetch_object();
             
            echo '<div class="forsideNyhet">';
            echo '<a href="index.php?idvare='.$valg->idvare.'">
                        <img id="nyhetbilde" src="bilder/opplastet/'.$valg->bildeurl.'" /></a>
                  <a href="index.php?idvare='.$valg->idvare.'">         
                        <h1>'.$valg->tittel.'</h1>
                  </a>
                  <p>'.$valg->tekst.'</p>
                                <h2>Nå '.$valg->pris.',- <a href="?kat='.$valg->katid.'&action=add&id='.$valg->idvare.'">
                                 <img src="includes/images/kjop.jpg" style="padding-left:20px;"/></a></h2>
                  ';
            echo '</div>';
                     for($i=1; $i<$num; $i++)
                     {
                        $valg = $resultat->fetch_object();
                        echo '<div class="forsideNyhetLiten">';
                        
                         echo '
                             <img class="bildeNyhetLiten" src="bilder/opplastet/'. $valg->bildeurl.'" />
                            <a href="index.php?idvare='.$valg->idvare.'">
                                <h1>'.$valg->tittel.'</h1>
                               </a>
                               <p>'.$valg->tekst.'</p>
                                <h2>Nå '.$valg->pris.',- <a href="?kat='.$valg->katid.'&action=add&id='.$valg->idvare.'">
                                 <img src="includes/images/kjop.jpg" style="padding-left:20px;"/></a></h2>
                                 
';
                         echo '</div>';
                     }
        }
        echo '</div>';
    }
}
?>