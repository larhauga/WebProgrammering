
<?php
function meny()
{
    $mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1') or die(mysqli_error());
    $kategori = "select * from kategori;";
    $resultat = mysqli_query($mysqli,$kategori ) or die(mysqli_error($mysqli));
    $num=$resultat->num_rows;
    echo '<table id = varer>';
                 
    echo '</table>';
    
    echo '<ul>';
		for($i=0;$i<$num;$i++)
                 {
                     $valg=mysqli_fetch_row($resultat);
                     echo('<li><a href="kategori.php?'.$valg[0].'">'.$valg[1].'</a></li>');
                 }
   echo '</ul>';
    
}





function varer($katid)
{
    $mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1') or die(mysqli_error());

    $varer = "SELECT  vare.idvare,
              kategori.tittel as kategori, 
              vare.tittel as tittel, 
              vare.pris as pris, 
              DATE_FORMAT(`date`, '%d.%m.%y %H:%i') as dato,
              DATE_FORMAT(`sistoppdatert`, '%d.%m.%y %H:%i') as sisteDato,
              vareregister.antall as antall
              FROM vare, kategori, vareregister
              WHERE vare.idkategori = kategori.idkategori
              AND vare.idvare = vareregister.idvare AND kategori.idkategori = $katid";
    $resultat = mysqli_query($mysqli,$varer ) or die(mysqli_error($mysqli));
    $num=$resultat->num_rows;
    echo '<table id = varer>';
    if($num < 1)
    {
        echo '<tr><td>Ingen varer i denne kategorien</td></tr>';
    }

                 for($i=0;$i<$num;$i++)
                 {
                     
                     $valg=mysqli_fetch_row($resultat);
                     echo('<tr><td>Kategori: '.$valg[1].'</td><td> Tittel: '.$valg[2].'</td><td> Pris: '.$valg[3].'</td><td> Dato oppdatert: '.$valg[5].'</td><td> Antall: '.$valg[6].'</td></tr>');
                 }
    echo '</table>';
}
?>