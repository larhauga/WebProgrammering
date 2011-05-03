<?php
    $mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
    if($mysqli->connect_error)
    {
        echo $mysqli->connect_error;
    }
    else
    {
        if(isset($_POST['sok']) && $_POST['sok'] != "")
        {
            $sql = "SELECT * FROM kategori WHERE idkategori = ".$_POST['sok'];
            $resultat = $mysqli->query($sql);
            $ant = $mysqli->affected_rows;
            if($ant == 1)
            {
                $rad = $resultat->fetch_object();
                if($rad->aktiv == 0)
                        $aktiv = "aktiv";
                else
                     $aktiv = "ikke aktiv";

                echo json_encode(array("tittel"=>$rad->tittel,"aktiv"=>$aktiv));

     /*           if(isset($_GET['type']) && $_GET['type'] == "tittel" && isset($_GET['sok']))
                {

                    echo $rad->tittel;
                }
                if(isset($_GET['type']) && $_GET['type'] == "aktiv" && isset($_GET['sok']))
                {
                    if($rad->aktiv == 1)
                    {
                        echo '
                                <option value="true">Aktiv</option>
                                <option value="false">Ikke aktiv</option>                        
                             ';
                    }
                    else
                    {
                        echo '
                                <option value="false">Ikke aktiv</option>
                                <option value="true">Aktiv</option>
                             ';
                    }
                }
      *                     $.ajax({
                          url: "ajax/updKat.php?type=tittel&sok=" + document.getElementById("kategoriID"),
                          cache: false,
                          success: function(html){
                            $("#updtittel").val(html);
                          }
                        });
                        $.ajax({
                          url: "ajax/updKat.php?type=aktiv&sok=" + document.getElementById("kategoriID"),
                          cache: false,
                          success: function(html){
                            $("#updaktiv").html(html);
                          }
                        });
      * 
      */
            }
            else
                echo "";
        }
    }

?>
