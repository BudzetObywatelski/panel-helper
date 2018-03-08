<?php
/**
 * Controller for profiles
 *
 * @author Amadeusz Dzięcioł <amadeusz.xd@gmail.com>
 */

require_once './inc/dbConnect.php';
require_once './inc/db/persons.php';
//$dbPersons = new dbPersons();


class Persons {
	public function import(){
		var_dump('xddd');
	}
}

$Persons = new Persons();

$action = (isset($_GET['a']) AND !empty($_GET['a'])) ? $_GET['a'] : 'default';

$tplData = array();
$tplData['errors'] = array();

switch ($action) {
	case 'import':
		if($_SERVER['REQUEST_METHOD'] != 'POST'){
			$tplData['errors'][] = 'Niedozwolona metoda';
			break;
		}

		$import = $Persons->import();
		break;
	
	default:

		break;
}


$Persons = new Persons();


$pv_controller->tpl->file = 'index.tpl.php';
$pv_controller->tpl->data = $tplData;
$pv_controller->tpl->render();