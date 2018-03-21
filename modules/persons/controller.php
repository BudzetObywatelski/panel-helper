<?php
/**
 * Controller for profiles
 *
 * @author Amadeusz Dzięcioł <amadeusz.xd@gmail.com>
 */

require_once './inc/dbConnect.php';
require_once './inc/db/personal.php';
//$dbPersons = new dbPersons();


class Persons {
	public function import(){
		$insertRows = array();
		$row = 1;
		$error = false;
		$file = $_FILES['file'];
		if (($handle = fopen($file['tmp_name'], "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $insertCell = array();
                $num = count($data);
                $row++;
                for ($c=0; $c < $num; $c++) {
                    $insertCell[] = $data[$c];
                }
                if(count($insertCell) != 18){
                	$error = true;
                }
                $insertRows[] = $insertCell;
            }
            fclose($handle);
        }

        if($error){
        	return false;
        }

        $profileMap = array(
			16 => 'dt',
			3 => 'miejsce',
			2 => 'plec',
			4 => 'wiek',
			14 => 'wyksztalcenie',
			0 => 'ankieta_id'
		);

		$personalMap = array(
			16 => 'dt',
			5 => 'imie',
			6 => 'nazwisko',
			13 => 'nr_tel',
			12 => 'e_mail',
			0 => 'ankieta_id',
			15 => 'jedzenie'
		);

		$insertProfiles = array();
		$insertPersonals = array();

		$id = 1;	
		foreach ($insertRows as $keyR => $row) {
			$profile = array('id' => $id);
			$personal = array('id' => $id);
			if($row[17] != 1){
				continue;
			}
			foreach ($row as $keyC => $cell) {
				if(isset($profileMap[$keyC])){
					$profile[$profileMap[$keyC]] = $cell;
				}
				if(isset($personalMap[$keyC])){
					$personal[$personalMap[$keyC]] = $cell;
				}
			}
			$insertProfiles[] = $profile;
			$insertPersonals[] = $personal;

			$id++;
		}

    	$dbProfile = new dbProfile();
    	$dbPersonal = new dbPersonal();

    	foreach ($insertPersonals as $keyP => $personal) {

    		$dbPersonal->pf_insRecord($personal);
    	}

    	foreach ($insertProfiles as $keyPr => $profile) {
    		$profile['plec'] = ($profile['plec'] == 'M') ? 'mężczyzna' : 'kobieta';
    		switch ($profile['wyksztalcenie']) {
    			case 'basic':
    				$profile['wyksztalcenie'] = 'p';
    				break;
    			
    			case 'medium':
    				$profile['wyksztalcenie'] = 's';
    				break;

    			case 'high':
    				$profile['wyksztalcenie'] = 'w';
    				break;
    		}
    		$dbProfile->pf_insRecord($profile);
    	}
		
		return true;
	}
}

$Persons = new Persons();

$action = (isset($_GET['a']) AND !empty($_GET['a'])) ? $_GET['a'] : 'default';

$tplData = array();
$tplData['errors'] = array();
$tplData['success'] = array();

switch ($action) {
	case 'import':
		if($_SERVER['REQUEST_METHOD'] != 'POST'){
			$tplData['errors'][] = 'Niedozwolona metoda.';
			break;
		}

		$import = $Persons->import();
		if(!$import){
			$tplData['errors'][] = 'Błędny plik CSV.';
		}else{
			$tplData['success'][] = 'Pomyślnie zaimportowano plik CSV.';
		}
		break;
	
	default:

		break;
}

$pv_controller->tpl->file = 'index.tpl.php';
$pv_controller->tpl->data = $tplData;
$pv_controller->tpl->render();