 <?php


include_once("includes/_class/handlekurv.php");
$handlekurv = $_SESSION['handlekurv'];
//$action = $_GET['action'];
if(isset($_GET['action']))
{
    $action = $_GET['action'];
switch ($action) {
	case 'add':
		if ($handlekurv) {
			$handlekurv .= ','.$_GET['id'];
		} else {
			$handlekurv = $_GET['id'];
		}
		break;
	case 'delete':
		if ($handlekurv) {
			$varer = explode(',',$handlekurv);
			$newcart = '';
			foreach ($varer as $vare) {
				if ($_GET['id'] != $vare) {
					if ($newcart != '') {
						$newcart .= ','.$vare;
					} else {
						$newcart = $vare;
					}
				}
			}
			$handlekurv = $newcart;
		}
		break;
	case 'update':
	if ($handlekurv) {
		$newcart = '';
		foreach ($_POST as $key=>$value) {
			if (stristr($key,'antall')) {
				$id = str_replace('antall','',$key);
				$varer = ($newcart != '') ? explode(',',$newcart) : explode(',',$handlekurv);
				$newcart = '';
				foreach ($varer as $vare) {
					if ($id != $vare) {
						if ($newcart != '') {
							$newcart .= ','.$vare;
						} else {
							$newcart = $vare;
						}
					}
				}
				for ($i=1;$i<=$value;$i++) {
					if ($newcart != '') {
						$newcart .= ','.$id;
					} else {
						$newcart = $id;
					}
				}
			}
		}
	}
	$handlekurv = $newcart;
	break;
}
}
$_SESSION['handlekurv'] = $handlekurv;
echo $kurv->visHandlekurv();
?>
