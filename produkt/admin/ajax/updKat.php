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


            }
            else
                echo "";
        }
    }

?>
