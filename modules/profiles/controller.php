<?php
/**
 * Controller for profiles
 *
 * @author Amadeusz Dzięcioł <amadeusz.xd@gmail.com>
 */

require_once './inc/dbConnect.php';
require_once './inc/db/profiles.php';
$dbProfiles = new dbProfiles();


class Profiles
{
	
}


$Profiles = new Profiles();

$action = (isset($_GET['a']) AND !empty($_GET['a'])) ? $_GET['a'] : 'default';

$tplData = array();
switch ($action) {
	case 'dodaj':
		$pv_controller->tpl->file = 'add.tpl.php';
    	$pv_controller->tpl->data = $tplData;
		break;

	case 'import':
		$pv_controller->tpl->file = 'import.tpl.php';
    	$pv_controller->tpl->data = $tplData;
		break;
	
	default:
		if(isset($_GET['a'])){
			header("Location:?mod=profiles");
			return;
		}

		$pv_controller->tpl->file = 'index.tpl.php';
    	$pv_controller->tpl->data = $tplData;
		break;
}
$pv_controller->tpl->render();