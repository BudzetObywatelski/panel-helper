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
	public function import($dbProfiles){
		$insertRows = array();
		$row = 1;
		$errors = false;
		$file = $_FILES['file'];
		if (($handle = fopen($file['tmp_name'], "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $insertCell = array();
                $num = count($data);
                $row++;
                for ($c=0; $c < $num; $c++) {
                    $insertCell[] = $data[$c];
                }
                if(count($insertCell) > 100){
                	$errors = true;
                }
                $insertRows[] = $insertCell;
            }
            fclose($handle);
        }

        if($errors){
        	return false;
        }

        $profilesMap = array(
        	2 => 'sex',
        	3 => 'age',
        	4 => 'quarter',
        	5 => 'education'
        );

        $insertProfile = array();
        foreach ($insertRows as $keyR => $row) {
        	$profile = array();
			foreach ($row as $keyC => $cell) {
				if(isset($profilesMap[$keyC])){
					$profile[$profilesMap[$keyC]] = $cell;
				}
			}
			$insertProfile[] = $profile;
		}
		foreach ($insertProfile as $keyP => $profile) {
			$profile['sex'] = ($profile['sex'] == 'Kobieta') ? 'kobieta' : 'mężczyzna';
			$profile['quarter'] = strtoupper($profile['quarter']);
			$dbProfiles->pf_insRecord($profile);
		}

		return true;
    }

    public function addProfile($dbProfiles, $dataToAdd){
    	$dbProfiles->pf_insRecord($dataToAdd);
    	return true;
    }

    public function deleteProfile($dbProfiles, $id){
    	$pv_constraints = array();
    	$pv_constraints['id'] = $id;

    	$dbProfiles->pf_delRecords($pv_constraints);
    	return true;
    }
}


$Profiles = new Profiles();

$action = (isset($_GET['a']) AND !empty($_GET['a'])) ? $_GET['a'] : 'default';


$tplData = array();

$dbProfiles->pf_getRecords($profiles);
$tplData['profiles'] = $profiles;

$tplData['errors'] = array();
$tplData['success'] = array();
switch ($action) {
	case 'dodaj':
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$dataToAdd = array();
			if(isset($_POST['quarter']) AND !empty($_POST['quarter'])){
				$dataToAdd['quarter'] = strtoupper(htmlspecialchars($_POST['quarter']));
			}

			if(isset($_POST['sex']) AND !empty($_POST['sex']) AND in_array($_POST['sex'], array('k', 'm'))){
				$dataToAdd['sex'] = ($_POST['sex'] == 'k') ? 'kobieta' : 'mężczyzna';
			}

			if(isset($_POST['age_from']) AND !empty($_POST['age_from']) AND is_numeric($_POST['age_from']) AND (!isset($_POST['age_to']) OR empty($_POST['age_to']) OR !is_numeric($_POST['age_to']))){
				$dataToAdd['age'] = htmlspecialchars($_POST['age_from']).'+';
			}elseif(isset($_POST['age_from']) AND !empty($_POST['age_from']) AND is_numeric($_POST['age_from']) AND isset($_POST['age_to']) AND !empty($_POST['age_to']) AND is_numeric($_POST['age_to'])){
				$dataToAdd['age'] = htmlspecialchars($_POST['age_from']).'-'.htmlspecialchars($_POST['age_to']);
			}elseif(isset($_POST['age_to']) AND !empty($_POST['age_to']) AND is_numeric($_POST['age_to']) AND (!isset($_POST['age_from']) OR empty($_POST['age_from']) OR !is_numeric($_POST['age_from']))){
				$dataToAdd['age'] = '-'.htmlspecialchars($_POST['age_to']);
			}

			if(isset($_POST['education']) AND !empty($_POST['education']) AND in_array($_POST['education'], array('p', 's', 'w'))){
				$dataToAdd['education'] = htmlspecialchars($_POST['education']);
			}

			if(empty($dataToAdd)){
				$tplData['errors'][] = 'Nie wysłano nic do dodania.';
			}else{
				$addProfile = $Profiles->addProfile($dbProfiles, $dataToAdd);
				$tplData['success'][] = 'Pomyślnie dodano profil osobisty';
			}
		}
		$pv_controller->tpl->file = 'add.tpl.php';
    	$pv_controller->tpl->data = $tplData;
		break;

	case 'import':
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$import = $Profiles->import($dbProfiles);
			if(!$import){
				$tplData['errors'][] = 'Błędny plik CSV.';
			}else{
				$tplData['success'][] = 'Pomyślnie zaimportowano profile.';
			}
		}
		$pv_controller->tpl->file = 'import.tpl.php';
    	$pv_controller->tpl->data = $tplData;
		break;

	case 'delete':
		if(!isset($_GET['id'])){
			$tplData['errors'][] = 'Nie podano ID profilu do usunięcia.';
		}else{
			$newProfilesArray = array();
        	foreach ($profiles as $key => $profile) {
        	    $newProfilesArray[$profile['id']] = $profile;
        	    $newProfilesArray[$profile['id']]['key'] = $key;
        	}

        	if(!isset($newProfilesArray[$_GET['id']])){
        		$tplData['errors'][] = 'Nie istnieje profil o takim ID.';
        	}else{
        		$deleteProfile = $Profiles->deleteProfile($dbProfiles, $_GET['id']);
        		unset($profiles[$newProfilesArray[$_GET['id']]['key']]);
        		$tplData['profiles'] = $profiles;
        		$tplData['success'][] = 'Pomyślnie usunięto profil.';
        	}
		}
		$pv_controller->tpl->file = 'index.tpl.php';
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