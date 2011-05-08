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
        echo '<table id = varer>';

        echo '</table>';

        echo '<ul>';
                    for($i=0;$i<$num;$i++)
                     {
                         $valg=mysqli_fetch_row($resultat);
                         echo('<li><a href="index.php?kat='.$valg[0].'">'.$valg[1].'</a></li>');
                     }
       echo '</ul>';

    }





    function varer($katid)
    {

        $mysqli = parent::connect();

        $varer = "SELECT vare.idvare,
                  vare.tittel as tittel, 
                  vare.pris as pris,
                  DATE_FORMAT(`date`, '%d.%m.%y %H:%i') as dato,
                  DATE_FORMAT(`sistoppdatert`, '%d.%m.%y %H:%i') as sisteDato,
                  vareregister.antall as antall
                  FROM vare, kategori, vareregister
                  WHERE vare.idkategori = kategori.idkategori
                  AND vare.idvare = vareregister.idvare AND kategori.idkategori = $katid " ;
        $resultat = mysqli_query($mysqli,$varer ) or die(mysqli_error($mysqli));
        $num=$resultat->num_rows;

        echo '<table id = varer>';
        if($num < 1)
        {
            echo '<tr><td>Ingen varer i denne kategorien</td></tr>';
        }

                     for($i=0;$i<$num;$i++)
                     {
						$kat = $_GET['kat'];
                         $valg=mysqli_fetch_row($resultat);
                         echo('<tr><td> Tittel: '.$valg[1].'</td><td> Dato oppdatert: '.$valg[4].'</td><td> Antall: '.$valg[5].'</td><td> Pris: '.$valg[2].'</td>
                             <td><a href="?kat='.$kat.'&action=add&id='.$valg[0].'">Kjop</a></td></tr>');
                     }
        echo '</table>';
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
                            vareregister.antall as antall
                            
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
                         echo('<tr><td> Tittel: '.$valg[3].'</td><td> Dato oppdatert: '.$valg[6].'</td><td> Antall: '.$valg[7].'</td><td> Pris: '.$valg[4].'</td>
                             <td><a href="?kat='.$valg[1].'&action=add&id='.$valg[0].'">Kjop</a></td></tr>');
                     }
        echo '</table>';
    
    }
}
?>