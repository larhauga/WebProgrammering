<?php
session_start();
function showCart()
{
	$db = mysql_connect("193.107.29.49", "xzindor_db1", "lol123") or die(mysql_error());
	$handlekurv = $_SESSION['handlekurv'];
	if ($handlekurv) {
		$varer = explode(',',$handlekurv);
		$liste = array();
		foreach ($varer as $vare) {
			$liste[$vare] = (isset($liste[$vare])) ? $liste[$vare] + 1 : 1;
		}
		$utskrift[] = '<form action="handlekurv.php?action=update" method="post" id="handlekurv">';
		$utskrift[] = '<table>';
		foreach ($liste as $id=>$antall) {
			$sql = 'SELECT * FROM varer WHERE idvare = '.$id;
			$result = mysql_query($sql); //$db->query($sql);
			$rad = mysql_fetch_array($result);
			extract($rad);
			$utskrift[] = '<tr>';
			$utskrift[] = '<td><a href="handlekurv.php?action=delete&id='.$id.'" class="r">Remove</a></td>';
			//$utskrift[] = '<td>'.$title.' by '.$author.'</td>';
			$utskrift[] = '<td>&pound;'.$price.'</td>';
			$utskrift[] = '<td><input type="text" name="qty'.$id.'" value="'.$antall.'" size="3" maxlength="3" /></td>';
			$utskrift[] = '<td>&pound;'.($price * $antall).'</td>';
			$total += $price * $antall;
			$utskrift[] = '</tr>';
		}
		$utskrift[] = '</table>';
		$utskrift[] = '<p>Grand total: <strong>&pound;'.$total.'</strong></p>';
		$utskrift[] = '<div><button type="submit">Opptater</button></div>';
		$utskrift[] = '</form>';
	} else {
		$utskrift[] = '<p>You shopping cart is empty.</p>';
	}
	return join('',$utskrift);
}

function writeShoppingCart() {
	$handlekurv = $_SESSION['handlekurv'];
	if (!$handlekurv) {
		return '<p>You have no items in your shopping cart</p>';
	} else {
		// Parse the cart session variable
		$varer = explode(',',$handlekurv);
		$s = (count($varer) > 1) ? 's':'';
		return '<p>You have <a href="handlekurv.php">'.count($varer).' item'.$s.' in your shopping cart</a></p>';
	}
}
?>