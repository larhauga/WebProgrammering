<?php

    require("../../includes/_class/admin.php");
    include("../../includes/config1.php");
    $Admin = new Admin('local', 'sok', '2', '0', 'local', '');
    $mysqli = $Admin->adminConnect();
     
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
