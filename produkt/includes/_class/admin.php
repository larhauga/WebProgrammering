<?php
include('dbase.php');

class Admin extends dbase
{
	public $epost;
	public $passord;
	public $tilgangstype;
	public $idbruker;
	public $fornavn;
	public $ip;
        public $error;
	
	public function __construct($epost, $passord, $tilgangstype, $idbruker, $fornavn, $ip)
	{
            parent::__construct();
            $this->epost = $epost;
            $this->passord = $passord;
            $this->tilgangstype = $tilgangstype;
            $this->idbruker = $idbruker;
            $this->fornavn = $fornavn;
            $this->ip = $ip;
	}
	public function getNavn()
	{
            return $this->fornavn;
	}

	
	//Brukere
        public function finnBrukernavn($idbruker)
        {
            $db = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');

            if($db->connect_error)
            {
                die("Kunne ikke koble til databasen: ".$db->connect_error);
            }
            else
            {
                $sql = "SELECT epost FROM bruker WHERE idbruker = '$idbruker'";
                $resultat = $db->query($sql);
                $antRader = $db->affected_rows;
                    
                if($antRader == 1)
                {
                    $rad = $resultat->fetch_object();
                    echo $rad->epost;
                }
            }
        }
	function visBrukere($fra, $til, $sok)
	{
	/*Vise alle brukere. Gi admintilgang, kun tilgang for brukere med superbrukertilgang*/
            $mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
            $sql = "SELECT idbruker, epost, fornavn, etternavn, registrert, rettigheter, tlf FROM bruker";
            $sql.= " LIMIT ".$fra.", ".$til;
            
            if($sok != "")
            {
                //Denne fungerer ikke per dags dato: Denne er mer stabil og bedre for databasen. Den andre settingen gjør akkurat det samme, men er tyngre for databaasen.
                //$sql = "SELECT idbruker, epost, fornavn, etternavn, registrert, rettigheter, tlf
		//		FROM bruker
		//		WHERE MATCH (idbruker, epost, fornavn, etternavn, tlf) 
		//		AGAINST ('$sok' WITH QUERY EXPANSION)";
                
                //Hvis søk etter rettigheter: Gjør om til text og ikke tall

                $sql = "SELECT idbruker, epost, fornavn, etternavn, registrert, rettigheter, tlf
                        FROM bruker
                        WHERE idbruker = '$sok' OR epost LIKE '%$sok%' OR fornavn LIKE '%$sok%' OR etternavn LIKE '%$sok%' OR registrert LIKE '%$sok%' OR rettigheter LIKE '$sok' OR tlf LIKE '%$sok%'";
                
		$resultat = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
		$antrader = $mysqli->affected_rows;
		if($antrader == 0){
			echo "<p>Ingen brukere med dette s&oslash;ket er registrert.</p>";
                }
                else if($antrader == -1){
                        echo "<p>Det skjedde en feil med søket</p>";
                }
		else
		{
                    while($rad = $resultat->fetch_object())
                    {
			echo '
                                <tr>
                                    <td><input type="checkbox" name="bruker[]" id="bruker" value="'.$rad->idbruker.'" /></td>
                                    <td>'.$rad->epost.'</td>
                                    <td>'.$rad->fornavn.'</td>
                                    <td>'.$rad->etternavn.'</td>
                                    <td>'.$rad->registrert.'</td>
                                    <td>';
                                        if($rad->rettigheter == 0)
                                            echo "Admin";
                                        else if($rad->rettigheter == 1)
                                            echo "Bruker";
                                        else if($rad->rettigheter == 2)
                                            echo "Moderator";
                                        echo '</td>
                                    <td>'.$rad->tlf.'</td>
				</tr>
				';
                    }
                }
            }
            else
            {	
		$resultat = mysqli_query($mysqli, $sql);
		$antrader = $mysqli->affected_rows;
                
		if($antrader == 0)
                    echo "<p>Ingen brukere er registrert</p>";
                else if($antrader == -1)
                        echo "<p>Det skjedde en feil med søket etter brukere</p>";
		else
		{
                    while($rad = $resultat->fetch_object())
                    {
                        echo '
                                <tr>
                                    <td><input type="checkbox" name="bruker[ ]" value="'.$rad->idbruker.'" /></td>
                                    <td>'.$rad->epost.'</td>
                                    <td>'.$rad->fornavn.'</td>
                                    <td>'.$rad->etternavn.'</td>
                                    <td>'.$rad->registrert.'</td>
                                    <td>';
                                        if($rad->rettigheter == 0)
                                            echo "Admin";
                                        else if($rad->rettigheter == 1)
                                            echo "Bruker";
                                        else if($rad->rettigheter == 2)
                                            echo "Moderator";
                                        echo '</td>
                                    <td>'.$rad->tlf.'</td>
                               </tr>';
                    } //while
		} //else
             } //else
	}
        
	function slettBrukere($idSlett)
	{
            $mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
            if($mysqli->connect_error)
            {
                die("Kunne ikke koble til databasen: " . $mysqli->connect_error);
            }
            $sql = "DELETE FROM bruker WHERE idbruker = '".$idSlett."'";
            $resultat = $mysqli->query($sql);
            if(!$resultat)
            {
                $feilSlett = "Error ".$mysqli->error;
            }
            else 
            {
                $antallRader = $mysqli->affected_rows;
                if($antallRader == 0)
                    $feilSlett = "Kunne ikke slette brukeren";
                else
                    $feilSlett = "Brukeren er slettet";
            }
	}
        public function endreBruker($sqlRemote) //NB! Passordet må sendes kryptert før det kommer hit!!!!
        {
            $mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
            if($mysqli->connect_error)
            {
                echo "Kunne ikke koble til databasen: " . $mysqli->connect_error;
            }
            /*$sql = "UPDATE bruker SET idbruker = '$idbruker', epost = '$epost', fornavn = '$fornavn', etternavn = '$etternavn',
                    tlf = '$tlf', passord = '$passord' WHERE idbruker = '$idbruker'"; */
            $sql = $sqlRemote;
            
            $resultat = $mysqli->query($sql);
            if(!$resultat)
            {
                echo "Error ".$mysqli->error;
            }
            else 
            {
                $antallRader = $mysqli->affected_rows;
                if($antallRader == 0)
                    echo "<p style='color:red'>Kunne ikke oppdatere brukeren!</p>";
                else
                    echo "<p>Brukeren ble endret</p>";
            }
        }
        public function settTilAdmin($idbruker, $rettigheter)
        {
            $db = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
            //$dbase->connect();
            if($db->connect_error)
            {
                die("Kunne ikke koble til databasen: " . $db->connect_error);
            }
            $sql = "UPDATE bruker SET rettigheter = '$rettigheter' WHERE idbruker = '$idbruker'";
            $resultat = $db->query($sql);
            if(!$resultat)
            {
                $feilUpd = "Error ".$db->error;
            }
            else 
            {
                $antallRader = $db->affected_rows;
                if($antallRader == 0)
                    $feilUpd = "<p style='color:red'>Kunne ikke oppdatere brukeren!</p>";
            }
        }
	/* Kategorier */
	//Innsetting av nye kategorier
	function nyKat($tittel, $aktiv)
	{
		$mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
                $tittel = mysqli_real_escape_string($mysqli, $tittel);
                
		$sql = "Insert into kategori(idkategori,tittel,aktiv) VALUES(
			'',
			'$tittel',
			'$aktiv'
			);";
                
		$resultat = $mysqli->query($sql);
	
		if(!$resultat)
		{
                    echo "Error: " . mysqli_error($mysqli);
                    $bruker->errorTilFil($this->error);
                    die();
		}
		else 
		{
			$antrader = $mysqli->affected_rows;
			if($antrader == 0)
			{
				$feil = "<p style='color:red;'>Det skjedde en feil med innsettelse i databasen</p>";
                                
			}
                        else if($antrader == 1)
                        {
                            $feil = "<p>Du er nå registert</p>";
                        }
		}
	}
	//Vis eksisterende kategorier og setter opp slettingen
	public function visKat()
	{
		$mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
		$sql = "SELECT * FROM kategori ORDER BY idkategori ASC";
		$resultat = mysqli_query($mysqli, $sql);
		
		echo '
                <form action="" method="post" id="slettKat" name="slettKat">
		<table width="100%" border="0">
					<tr>
						<td><b>ID</b></td>
						<td><b>Tittel</b></td>
						<td><b>Aktiv</b></td>
						<td><b>Slett</b></td>
					</tr>';
		while($rad = $resultat->fetch_object())
		{
			echo '<tr>
						<td>'.$rad->idkategori.'</td>
						<td>'.$rad->tittel.'</td>
						<td>'.$rad->aktiv.'</td>
						<td><input type="checkbox" name="slettArr[]" value="'.$rad->idkategori.'" /></td>
                             </tr>';
		}
		echo '  <tr class="submit">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input type="submit" value="Slett" id="slett" name="slett" /></td>
                        </tr>
                        </table></form>';
	}
        public function listValgKat()
        {
            $db = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
            if($db->connect_error)
            {
                die("Kunne ikke koble til databasen: ".$db->connect_error);
            }
            else
            {
                $sql = "SELECT * FROM kategori ORDER BY idkategori ASC";
                $resultat = $db->query($sql);
                $antRader = $db->affected_rows;

                if($antRader >= 1)
                {
                    for($i = 0; $i < $antRader; $i++)
                    {
                        $rad = $resultat->fetch_object();
                        echo '<option value="'.$rad->idkategori.'">'.$rad->idkategori.' - '.$rad->tittel.'</option>';
                    }
                }
            }
        }
        public function slettKat($idSlett)
        {
            $mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
            if($mysqli->connect_error)
            {
                die("Kunne ikke koble til databasen: " . $mysqli->connect_error);
            }
            $sql = "DELETE FROM kategori WHERE idkategori = '".$idSlett."'";
            $resultat = $mysqli->query($sql);
            if(!$resultat)
            {
                $feilSlett = "Error ".$mysqli->error;
            }
            else 
            {
                $antallRader = $mysqli->affected_rows;
                if($antallRader == 0)
                    $feilSlett = "Kunne ikke slette kategorien";
            }
        }
        public function updateKat($idkat, $tittel, $aktiv)
        {
            $mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
            if($mysqli->connect_error)
            {
                die("Kunne ikke koble til databasen: " . $mysqli->connect_error);
            }
            $sql = "UPDATE kategori SET idkategori = '$idkat', tittel = '$tittel', aktiv = '$aktiv' WHERE idkategori = '$idkat'";
            $resultat = $mysqli->query($sql);
            if(!$resultat)
            {
                $feilUpd = "Error ".$mysqli->error;
            }
            else 
            {
                $antallRader = $mysqli->affected_rows;
                if($antallRader == 0)
                    $feilUpd = "<p style='color:red'>Kunne ikke oppdatere kategorien</p>";
            }
        }
	
	function nyttProdukt($idkategori, $dato, $aktiv, $tittel, $filnavn, $tekst, $pris, $idbruker)
	{
            $db = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
            if($db->connect_error)
                    die("Kunne ikke koble til databasen: " . $db->connect_error);

            $idkategori = mysqli_escape_string($db,$idkategori);
            $aktiv = mysqli_escape_string($db,$aktiv);
            $tittel = mysqli_escape_string($db,$tittel);
            $filnavn = mysqli_escape_string($db,$filnavn);
            $tekst = mysqli_escape_string($db,$tekst);
            $pris = mysqli_escape_string($db,$pris);

            $sql = "INSERT INTO vare (
                        idvare,
                        date, 
                        tittel, 
                        tekst, 
                        idkategori, 
                        bildeurl, 
                        pris, 
                        statusAktiv, 
                        idbruker) 
                VALUES('', '$dato','$tittel','$tekst','$idkategori','$filnavn','$pris','$aktiv','$idbruker')";

            $resultat = $db->query($sql);

            if(!$resultat)
            {
                echo "Det skjedde en feil med spørringen.";
            }
            else 
            {
                    $antrader = $db->affected_rows;
                    if($antrader == 0)
                    {
                            $feil = "<p style='color:red;'>Det skjedde en feil med innsettelse i databasen</p>";

                    }
                    else if($antrader == 1)
                    {
                        $feil = "<p>Produktet er registrert</p>";
                    }
            }
	}
        
 	public function visProdukter($fra, $til, $sok)
	{
            $db = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
            $fra = mysqli_escape_string($db, $fra);
            $til = mysqli_escape_string($db, $til);
            $sok = mysqli_escape_string($db, $sok);
            
            
            $sql = "SELECT idvare, kategori.tittel as kategori, vare.tittel as tittel, bildeurl, pris FROM vare, kategori WHERE vare.idkategori = kategori.idkategori";
            $sql.= " LIMIT ".$fra.", ".$til;
            
            if($sok != "")
            {

                $sql = "SELECT 
                            idvare, 
                            kategori.tittel as kategori, 
                            vare.tittel as tittel, 
                            bildeurl, pris 
                        FROM vare, kategori 
                        WHERE 
                            vare.idkategori = kategori.idkategori
                            AND (idvare = '$sok' 
                                OR kategori.tittel LIKE '$sok%' 
                                OR vare.tittel LIKE '%$sok%' 
                                OR bildeurl LIKE '%$sok%' 
                                OR pris LIKE '%$sok%')";
                
		$resultat = mysqli_query($db, $sql);
                    if($db->connect_error)
                    {
                        die("Kunne ikke koble til databasen: ".$db->connect_error);
                    }
		$antrader = $db->affected_rows;
		if($antrader == 0){
			echo "<p>Ingen varer med dette s&oslash;ket er registrert.</p>";
                }
                else if($antrader == -1){
                        echo "<p>Det skjedde en feil med søket</p>";
                }
		else
		{
                    while($rad = $resultat->fetch_object())
                    {
			echo '
                        <tr>
                            <td><input type="checkbox" name="produkt[]" id="bruker" value="'.$rad->idvare.'" /></td>
                            <td>'.$rad->kategori.'</td>
                            <td>'.$rad->tittel.'</td>
                            <td>'.$rad->bildeurl.'</td>
                            <td>'.$rad->pris.'</td>
                        </tr>
                        ';
                    }
                }
            }
            else
            {	
		$resultat = mysqli_query($db, $sql);
                if($db->connect_error)
                {
                    die("Kunne ikke koble til databasen: ".$db->connect_error);
                }
                
		$antrader = $db->affected_rows;
		if($antrader == 0)
                    echo "<p>Ingen varer er registrert</p>";
                else if($antrader == -1)
                        echo "<p>Det skjedde en feil med søket etter varer</p>";
		else
		{
                    while($rad = $resultat->fetch_object())
                    {
                        echo '
                            <tr>
                                <td><input type="checkbox" name="produkt[]" value="'.$rad->idvare.'" /></td>
                                <td>'.$rad->kategori.'</td>
                                <td>'.$rad->tittel.'</td>
                                <td>'.$rad->bildeurl.'</td>
                                <td>'.$rad->pris.'</td>
                           </tr>';
                    } //while
		} //else
             } //else
	}
        
        public function slettProd($idSlett)
        {
            $mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
            if($mysqli->connect_error)
            {
                die("Kunne ikke koble til databasen: " . $mysqli->connect_error);
            }
            $sql = "DELETE FROM produkt WHERE idprodukt = '".$idSlett."'";
            $resultat = $mysqli->query($sql);
            if(!$resultat)
            {
                $feilSlett = "Error ".$mysqli->error;
            }
            else 
            {
                $antallRader = $mysqli->affected_rows;
                if($antallRader == 0)
                    $feilSlett = "Kunne ikke slette produktet";
            }
        }
        
	function visBeholdning($fra, $til, $sok)
	{
            $db = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
            $fra = mysqli_escape_string($db, $fra);
            $til = mysqli_escape_string($db, $til);
            $sok = mysqli_escape_string($db, $sok);
            
            
            $sql = "SELECT idvare, kategori.tittel as kategori, vare.tittel as tittel, bildeurl, pris FROM vare, kategori WHERE vare.idkategori = kategori.idkategori";
            $sql.= " LIMIT ".$fra.", ".$til;
            
            if($sok != "")
            {

                $sql = "SELECT 
                            idvare, 
                            kategori.tittel as kategori, 
                            vare.tittel as tittel, 
                            bildeurl, pris 
                        FROM vare, kategori 
                        WHERE 
                            vare.idkategori = kategori.idkategori
                            AND (idvare = '$sok' 
                                OR kategori.tittel LIKE '$sok%' 
                                OR vare.tittel LIKE '%$sok%' 
                                OR bildeurl LIKE '%$sok%' 
                                OR pris LIKE '%$sok%')";
                
		$resultat = mysqli_query($db, $sql);
                    if($db->connect_error)
                    {
                        die("Kunne ikke koble til databasen: ".$db->connect_error);
                    }
		$antrader = $db->affected_rows;
		if($antrader == 0){
			echo "<p>Ingen varer med dette s&oslash;ket er registrert.</p>";
                }
                else if($antrader == -1){
                        echo "<p>Det skjedde en feil med søket</p>";
                }
		else
		{
                    while($rad = $resultat->fetch_object())
                    {
			echo '
                        <tr>
                            <td><input type="checkbox" name="produkt[]" id="bruker" value="'.$rad->idvare.'" /></td>
                            <td>'.$rad->kategori.'</td>
                            <td>'.$rad->tittel.'</td>
                            <td>'.$rad->bildeurl.'</td>
                            <td>'.$rad->pris.'</td>
                        </tr>
                        ';
                    }
                }
            }
            else
            {	
		$resultat = mysqli_query($db, $sql);
                if($db->connect_error)
                {
                    die("Kunne ikke koble til databasen: ".$db->connect_error);
                }
                
		$antrader = $db->affected_rows;
		if($antrader == 0)
                    echo "<p>Ingen varer er registrert</p>";
                else if($antrader == -1)
                        echo "<p>Det skjedde en feil med søket etter varer</p>";
		else
		{
                    while($rad = $resultat->fetch_object())
                    {
                        echo '
                            <tr>
                                <td><input type="checkbox" name="produkt[]" value="'.$rad->idvare.'" /></td>
                                <td>'.$rad->kategori.'</td>
                                <td>'.$rad->tittel.'</td>
                                <td>'.$rad->bildeurl.'</td>
                                <td>'.$rad->pris.'</td>
                           </tr>';
                    } //while
		} //else
             } //else
	}
	function sikkerhet()
	{
		
	}
	function konfig()
	{
		
	}
	
	/* Henter stats til admin siden */
	function statsVarer()
	{
                $mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
                $sql = "SELECT COUNT(*) AS count FROM vare";
                $resultat = mysqli_query($mysqli, $sql);
                $antrader = $mysqli->affected_rows;
                
                if($antrader == -1)
                    echo -1;
                else
                {
                    $rad = $resultat->fetch_object();
                    echo $rad->count;
                }

	}
	function statsKat()
	{
                $mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
                $sql = "SELECT COUNT(*) AS count FROM kategori";
                $resultat = mysqli_query($mysqli, $sql);
                $antrader = $mysqli->affected_rows;
                
                if($antrader == -1)
                    echo -1;
                else
                {
                    $rad = $resultat->fetch_object();
                    echo $rad->count;
                }

	}
	function statsBruker()
	{
                $mysqli = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
                $sql = "SELECT COUNT(*) AS count FROM bruker";
                $resultat = mysqli_query($mysqli, $sql);
                $antrader = $mysqli->affected_rows;
                
                if($antrader == -1)
                    echo -1;
                else
                {
                    $rad = $resultat->fetch_object();
                    echo $rad->count;
                }
	}
        function visAntVarer()
        {
            $db = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');

            if($db->connect_error)
            {
                die("Kunne ikke koble til databasen: ".$db->connect_error);
            }
            else
            {
                $sql = "SELECT count(*) as antall FROM vare";
                $resultat = $db->query($sql);
                
                if(!$resultat)
                {
                    return 0;
                }
                else
                {
                    $rad = $resultat->fetch_object();
                    return $rad->antall;
                }
            }
        }
        
	//Login 
	function hash($br, $pass)
	{
                $innpassord = sha1( $br.'aaaaa'.$pass );
		$this->passord = $innpassord;
	}
        
	function sjekkFelt($input)
	{
		return mysql_real_escape_string($input);
	}
}
?>