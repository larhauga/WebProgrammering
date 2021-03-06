<?php
include('dbase.php');

class Admin extends dbase
{
	private $epost;
	private $passord;
	private $tilgangstype;
	public $idbruker;
	private $fornavn;
	private $ip;
        private $error;
	
	public function __construct($epost, $passord, $tilgangstype, $idbruker, $fornavn, $ip)
	{
            parent::__construct(); //Kjører konstruktøren til dbase (databaseklasse)
            
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
        public function getTilgang()
        {
            return $this->tilgangstype;
        }
        /* Brukes av ytterfiler for å koble til database.
         * Ingen tilkobling til databasen blir gjort uten denne funksjonen eller den overordnede dbase->connect();
         */
        public function adminConnect()
        {
            return parent::connect();
        }

	
	//Brukere
        public function finnBrukernavn($idbruker)
        {
            $db = parent::connect();

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
            $mysqli = parent::connect();
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
                               </tr>';
                    } //while
		} //else
             } //else
	}
        
	function slettBrukere($idSlett)
	{
            $mysqli = parent::connect();
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
            $mysqli = parent::connect();
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
            $db = parent::connect();
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
        /* Slutt brukere */
	/* Kategorier */
	//Innsetting av nye kategorier
	function nyKat($tittel, $aktiv)
	{
		$mysqli = parent::connect();
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
		$mysqli = parent::connect();
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
            $db = parent::connect();
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
                        echo '<option value="'.$rad->idkategori.'">'.$rad->tittel.'</option>';
                    }
                }
            }
        }
        public function slettKat($idSlett)
        {
            $mysqli = parent::connect();
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
            $mysqli = parent::connect();
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
	/* Slutt kategori */
        /* Produktsiden */
	function nyttProdukt($idkategori, $dato, $aktiv, $tittel, $filnavn, $tekst, $pris, $antall, $idbruker)
	{
            /*$db = new mysqli('193.107.29.49','xzindor_db1','lol123','xzindor_db1');
            if($db->connect_error)
                    die("Kunne ikke koble til databasen: " . $db->connect_error);
            */
            $db = parent::connect();
            
            $db->autocommit(false);
            $idkategori = mysqli_escape_string($db,$idkategori);
            $aktiv = mysqli_escape_string($db,$aktiv);
            $tittel = mysqli_escape_string($db,$tittel);
            $filnavn = mysqli_escape_string($db,$filnavn);
            $tekst = mysqli_escape_string($db,$tekst);
            $pris = mysqli_escape_string($db,$pris);
            $antall = mysqli_escape_string($db, $antall);

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
            $ok = true;
            if(!$resultat)
            {
                $ok = false;
            }
            else 
            {
                    if($db->affected_rows == 0)
                    {
                            $ok = false;
                    }
                    else
                    {
                        $idvare = $db->insert_id;
                    }
            }
            $sqlregister = "INSERT INTO vareregister (
                                idvareregister,
                                idvare,
                                sistoppdatert,
                                antall)
                            VALUES('',$idvare,'".date('Y-m-d H:i:s')."','$antall');
                                ";
            $resultat = $db->query($sqlregister);
            if(!$resultat)
            {
                $ok = false;
            }
            else
            {
                if($db->affected_rows == 0)
                {
                    $ok = false;
                }
            }
            if($ok)
            {
                $db->commit();
                return $feilProd = "<p>Varen ble registrert</p>";
            }
            else
            {
                $db->rollback();
                return $feilProd = "<p style='color:red;'>Varen ble ikke registrert.</p>";
            }
	}
        
 	public function visProdukter($fra, $til, $sok)
	{
            $db = parent::connect();
            $fra = mysqli_escape_string($db, $fra);
            $til = mysqli_escape_string($db, $til);
            $sok = mysqli_escape_string($db, $sok);
            
            
            $sql = "SELECT 
                            vare.idvare, 
                            kategori.tittel as kategori, 
                            vare.tittel as tittel, 
                            vare.bildeurl, 
                            vare.pris 
                   FROM vare, kategori 
                   WHERE vare.idkategori = kategori.idkategori";
            $sql.= " LIMIT ".$fra.", ".$til;
            
            if($sok != "")
            {

                $sql = "SELECT 
                            vare.idvare, 
                            kategori.tittel as kategori, 
                            vare.tittel as tittel, 
                            vare.bildeurl, 
                            vare.pris 
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
                            <td><input type="checkbox" name="produkt[]" id="produkt" value="'.$rad->idvare.'" /></td>
                            <td>'.$rad->tittel.'</td>
                            <td>'.$rad->kategori.'</td>
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
                                <td>'.$rad->tittel.'</td>
                                <td>'.$rad->kategori.'</td>
                                <td>'.$rad->bildeurl.'</td>
                                <td>'.$rad->pris.'</td>
                           </tr>';
                    } //while
		} //else
             } //else
	}
        
        public function slettProd($idSlett)
        {
            $db = parent::connect();
            if($db->connect_error)
            {
                die("Kunne ikke koble til databasen: " . $db->connect_error);
            }
            $db->autocommit(false);
            $ok = true;
            
            $sql = "DELETE FROM vare WHERE idvare = '".$idSlett."'";
            $resultat = $db->query($sql);
            if(!$resultat)
            {
                //$feilSlett = "Error ".$db->error;
                $ok = false;
            }
            else 
            {
                if($db->affected_rows == 0)
                        $ok = false;
                    //$feilSlett = "Kunne ikke slette produktet";
            }
            $sql = "DELETE FROM vareregister WHERE idvare = $idSlett";
            $resultat = $db->query($sql);
            if(!$resultat)
            {
                $ok = false;
            }
            else
            {
                if($db->affected_rows == 0)
                        $ok = false;
            }
            
            if($ok)
            {
                $db->commit();
                $feilSlett = "Varen ble slettet";
            }
            else
            {
                $db->rollback();
                $feilSlett = "<p style='color:red'>Det skjedde en feil ved slettingen. Prøv igjen senere.</p>";
            }
        }
        /* Slutt produktsiden */
        /* Admin beholdningsside */
	function visBeholdning($fra, $til, $sok)
	{
            $db = parent::connect();
            $fra = mysqli_escape_string($db, $fra);
            $til = mysqli_escape_string($db, $til);
            $sok = mysqli_escape_string($db, $sok);
            
            
            $sql = "SELECT  vare.idvare, 
                            kategori.tittel as kategori, 
                            vare.tittel as tittel, 
                            vare.pris as pris, 
                            DATE_FORMAT(`date`, '%d.%m.%y %H:%i') as dato,
                            DATE_FORMAT(`sistoppdatert`, '%d.%m.%y %H:%i') as sisteDato,
                            vareregister.antall as antall,
                            bruker.fornavn as fornavn
                    FROM vare, kategori, bruker, vareregister
                    WHERE vare.idkategori = kategori.idkategori
                        AND vare.idbruker = bruker.idbruker
                        AND vare.idvare = vareregister.idvare";
            $sql.= " LIMIT ".$fra.", ".$til;
            
            if($sok != "")
            {

                $sql = "SELECT  
                            vare.idvare, 
                            kategori.tittel as kategori, 
                            vare.tittel as tittel, 
                            vare.pris as pris, 
                            DATE_FORMAT(`date`, '%d.%m.%y %H:%i') as dato,
                            DATE_FORMAT(`sistoppdatert`, '%d.%m.%y %H:%i') as sisteDato,
                            vareregister.antall as antall,
                            bruker.fornavn as fornavn
                    FROM vare, kategori, bruker, vareregister
                    WHERE vare.idkategori = kategori.idkategori
                        AND vare.idbruker = bruker.idbruker
                        AND vare.idvare = vareregister.idvare
                            AND (
                                   vare.idvare = '$sok' 
                                OR kategori.tittel LIKE '$sok%' 
                                OR vare.tittel LIKE '%$sok%' 
                                OR pris LIKE '$sok')";
                
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
                            <td><input type="checkbox" name="produkt[]" id="produkt" value="'.$rad->idvare.'" /></td>
                            <td>'.$rad->tittel.'</td>
                            <td>'.$rad->dato.'</td>
                            <td>'.$rad->pris.'</td>
                            <td>'.$rad->kategori.'</td>
                            <td>'.$rad->sisteDato.'</td>
                            <td>'.$rad->antall.'</td>
                            <td>'.$rad->fornavn.'</td>
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
                else if($antrader == -1){
                        echo "<p>Det skjedde en feil med søket etter varer</p>";
                }
		else
		{
                    while($rad = $resultat->fetch_object())
                    {
                        echo '
                        <tr>
                            <td><input type="checkbox" name="produkt[]" id="produkt" value="'.$rad->idvare.'" /></td>
                            <td>'.$rad->tittel.'</td>
                            <td>'.$rad->dato.'</td>
                            <td>'.$rad->pris.'</td>
                            <td>'.$rad->kategori.'</td>
                            <td>'.$rad->sisteDato.'</td>
                            <td>'.$rad->antall.'</td>
                            <td>'.$rad->fornavn.'</td>
                        </tr>';
                    } //while
		} //else
             } //else
             $db->close();
	}
        public function visBeholdningPrKategori($kategori)
        {
            $db = parent::connect();
            $kategori = mysqli_escape_string($db, $kategori);

            if(!is_numeric($kategori))
                die("Kategori må være et tall");
            
            $sql = "SELECT  vare.idvare, 
                            kategori.tittel as kategori, 
                            vare.tittel as tittel, 
                            vare.pris as pris, 
                            DATE_FORMAT(`date`, '%d.%m.%y %H:%i') as dato,
                            DATE_FORMAT(`sistoppdatert`, '%d.%m.%y %H:%i') as sisteDato,
                            vareregister.antall as antall,
                            bruker.fornavn as fornavn
                    FROM vare, kategori, bruker, vareregister
                    WHERE vare.idkategori = kategori.idkategori
                        AND vare.idbruker = bruker.idbruker
                        AND vare.idvare = vareregister.idvare
                        AND vare.idkategori = '$kategori'";
            
                $resultat = $db->query($sql);
                if($db->connect_error)
                {
                    die("Kunne ikke koble til databasen");
                }
                
		$antrader = $db->affected_rows;
		if($antrader == 0)
                    echo "<p>Ingen varer er registrert</p>";
                else if($antrader == -1){
                        echo "<p>Det skjedde en feil med søket etter varer</p>";
                }
		else
		{
                    while($rad = $resultat->fetch_object())
                    {
                        echo '
                        <tr>
                            <td><input type="checkbox" name="produkt[]" id="produkt" value="'.$rad->idvare.'" /></td>
                            <td>'.$rad->tittel.'</td>
                            <td>'.$rad->dato.'</td>
                            <td>'.$rad->pris.'</td>
                            <td>'.$rad->kategori.'</td>
                            <td>'.$rad->sisteDato.'</td>
                            <td>'.$rad->antall.'</td>
                            <td>'.$rad->fornavn.'</td>
                        </tr>';
                    } //while
		} //else
        }
        public function settAntVarer($idvare, $antall)
        {
            $db = parent::connect();
            $antall = mysqli_escape_string($db,$antall);
            
            $sql = "UPDATE vareregister
                        SET antall = '$antall'
                    WHERE
                        idvare = '$idvare';";
            $resultat = $db->query($sql); 
            if($db->connect_error)
            {
                echo "<p>Det skjedde en feil med spørringen.</p>";
                return false;
            }
            else
            {
                if($db->affected_rows == 1)
                {
                        echo "<p>Antallet ble oppdatert.</p>";
                        return true;
                }
            }
              
        }
        /* Slutt på varebeholdningssiden */
        /* Ordrevisning */
        public function visOrdre($sok)
        {
            /* Innhold:
             *  Bruker, Ordredato, Sendt, Antall varer, Sum
             *  bruker.epost, ordre.ordredato, ordre.sendtdato, count(*) from ordrelinje where idordre = idordre
             */
            
            $db = parent::connect();
            $fra = mysqli_escape_string($db, $sok);
     
            $sql = "SELECT  ordre.idordre as idordre,
                            bruker.epost as brukernavn,
                            ordre.ordredato as ordredato, 
                            ordre.sendtdato as sendtdato
                            
                    FROM ordre, bruker
                    WHERE bruker.idbruker = ordre.idbruker";
            
            if($sok != "")
            {

                $sql .= "
                            AND (
                                   ordre.idordre = '$sok' 
                                OR bruker.epost LIKE '$sok%' 
                                OR ordredato LIKE '$sok%' )";
            }
            $sql .= " ORDER BY idordre DESC LIMIT 0, 20";

		$resultat = mysqli_query($db, $sql);
                if($db->connect_error)
                {
                    die("Kunne ikke koble til databasen: ".$db->connect_error);
                }
                
		$antrader = $db->affected_rows;
		if($antrader == 0)
                    echo "<p>Ingen ordre på dette søket</p>";
                else if($antrader == -1){
                        echo "<p>Det skjedde en feil.</p>";
                }
		else
		{
                    while($rad = $resultat->fetch_object())
                    {
                        echo '
                        <tr>
                            <td><input type="radio" name="produkt[]" id="produkt" value="'.$rad->idordre.'" /></td>
                            <td>'.$rad->brukernavn.'</td>
                            <td>'.$rad->ordredato.'</td>
                            <td>'.$this->ordreSendt($rad->sendtdato).'</td>
                        </tr>';
                    } //while
		} //else
             $db->close();

        }
        public function ordreSendt($input)
        {
            if($input == "0000-00-00 00:00:00")
            {
                return "Ikke sendt";
            }
            else if($input == null || $input == "")
            {
                return "Ikke sendt";
            }
            else
            {
                return "Sendt";
            }
        }
        public function visOrdreInnhold($idordre)
        {
            $db = parent::connect();
            $kategori = mysqli_escape_string($db, $idordre);

            if(!is_numeric($idordre))
            {
                echo "Ordreid må være et tall";
                return false;
            }
             else {

            
            $sql = "SELECT  ordrelinje.ordrelinje as ordrelinje,
                            ordrelinje.idvare as idvare,
                            vare.tittel as vare,
                            ordrelinje.prisPrEnhet as pris,
                            ordrelinje.antall as antall
                    FROM ordrelinje, vare 
                    WHERE ordrelinje.idvare = vare.idvare AND ordrelinje.idordre = '$idordre';";
            
                $resultat = $db->query($sql);
                if($db->connect_error)
                {
                    die("Kunne ikke koble til databasen");
                }
                
		$antrader = $db->affected_rows;
		if($antrader == 0)
                    echo "<p>Ordren har ingen varer</p>";
                else if($antrader == -1){
                        echo "<p>Det skjedde en feil med innhentingen av varer</p>";
                }
		else
		{
                    echo '
                        <table width="100%">
                        <tr>
                            <td><b>idvare</b></td>
                            <td><b>Vare</b></td>
                            <td><b>Pris</b></td>
                            <td><b>Antall</b></td>
                            <td><b>Slett</b></td>
                        </tr>';
                    
                    while($rad = $resultat->fetch_object())
                    {
                        echo '
                        <tr>
                            <td>'.$rad->idvare.'</td>
                            <td>'.$rad->vare.'</td>
                            <td>'.$rad->pris.'</td>
                            <td>'.$rad->antall.'</td>
                            <td><input type="checkbox" name="slett[]" id="slett" value="'.$rad->ordrelinje.'" /></td>
                        </tr>';
                    } //while
                    echo '</table>';
		} //else
             }
        }
        public function slettOrdre($idordre)
        {
            $db = parent::connect();
            $antall = mysqli_escape_string($db,$idordre);
            
            $sql = "DELETE FROM ordre";
            $resultat = $db->query($sql); 
            if($db->connect_error)
            {
                echo "<p>Det skjedde en feil med spørringen.</p>";
                return false;
            }
            else
            {
                if($db->affected_rows == 1)
                {
                        echo "<p>Ordren ble sendt.</p>";
                        return true;
                }
            }
        }
        public function settOrdreTilSendt($idordre)
        {
            $db = parent::connect();
            $antall = mysqli_escape_string($db,$idordre);
            $sendtdato = date('Y-m-d H:i:s');
            
            $sql = "UPDATE ordre
                        SET sendtdato = '$sendtdato'
                    WHERE
                        idordre = '$idordre';";
            $resultat = $db->query($sql); 
            if($db->connect_error)
            {
                echo "<p>Det skjedde en feil med spørringen.</p>";
                return false;
            }
            else
            {
                if($db->affected_rows == 1)
                {
                        echo "<p>Ordren ble sendt.</p>";
                        return true;
                }
            }
        }
        public function slettVare($ordrelinje)
        {
            $db = parent::connect();
            $antall = mysqli_escape_string($db,$ordrelinje);
            
            $sql = "DELETE FROM ordrelinje
                        WHERE ordrelinje = '$ordrelinje'";
            $resultat = $db->query($sql); 
            if($db->connect_error)
            {
                echo "<p>Det skjedde en feil med spørringen.</p>";
                return false;
            }
            else
            {
                if($db->affected_rows == 1)
                {
                        echo "<p>Varen ble slettet.</p>";
                        return true;
                }
            }
        }
        /* Slutt ordre */
	function sikkerhet()
	{
		
	}

	
	/* Henter stats til admin siden */
	function statsVarer()
	{
                $mysqli = parent::connect();
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
                $mysqli = parent::connect();
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
                $mysqli = parent::connect();
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
        function statsOrdre()
        {
            $db = parent::connect();

            if($db->connect_error)
            {
                die("Kunne ikke koble til databasen: ".$db->connect_error);
            }
            else
            {
                $sql = "SELECT count(*) as antall FROM ordre";
                $resultat = $db->query($sql);
                
                if(!$resultat)
                {
                    echo 0;
                }
                else
                {
                    $rad = $resultat->fetch_object();
                    echo $rad->antall;
                }
            }
        }
        function visAntVarer()
        {
            $db = parent::connect();

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