<?php
    /* @var $pv_controller ModuleController */

    require_once './inc/dbConnect.php';
    require_once './inc/db/profile.php';
    require_once './inc/db/profiles.php';
    $dbProfile = new dbProfile();
    $dbProfiles = new dbProfiles();

    //
    // Przetwarzanie danych
    //
    $tplData = array();

    $dbProfiles->pf_getRecords($profiles);
    $tplData['getprofiles'] = $profiles;

    // spr. liczników
    $dbProfile->pf_getStats($tplData['grupy_liczniki'], 'grupy');

    // wrong group check
    $tplData['wrong-group'] = false;
if ($configHelper->panel_stage != 'results' && $pv_controller->action != 'w puli') {
    $tplData['wrong-group'] = true;
}

    // wypełnienie pól wyboru
    $pv_ograniczeniaStats = array();
if (!empty($pv_controller->action)) {
    $pv_ograniczeniaStats['grupa'] = $pv_controller->action;
}
    $dbProfile->pf_getStats($tplData['miejsce'], 'miejsce', $pv_ograniczeniaStats);
    $dbProfile->pf_getStats($tplData['wyksztalcenie'], 'wyksztalcenie', $pv_ograniczeniaStats);

    $tplData['prev'] = array();
    $pv_choices = array('miejsce', 'plec', 'wyksztalcenie', 'wiek_od', 'wiek_do', 'profiles');
foreach ($pv_choices as $choice)
{
    $tplData['prev'][$choice] = (!empty($_POST[$choice])) ? $_POST[$choice] : '';
}
if (empty($tplData['prev']['wyksztalcenie'])) {
    $tplData['prev']['wyksztalcenie'] = array();
}
$tplData['checkedProfile'] = 0;
if (!empty($_POST['search'])) {
    $pv_ograniczenia = array();
    if (!empty($pv_controller->action)) {
        $pv_ograniczenia['grupa'] = $pv_controller->action;
    }
    if($_POST['profiles'] != 'default'){
        $newProfilesArray = array();
        foreach ($profiles as $key => $profile) {
            $newProfilesArray[$profile['id']] = $profile;
        }
        $checkedProfile = htmlspecialchars($_POST['profiles']);
        $tplData['checkedProfile'] = $checkedProfile;
        $profileOne = array();
        if(isset($newProfilesArray[$checkedProfile])){
            $profileOne = $newProfilesArray[$checkedProfile];
        }

        if(!empty($profileOne['quarter'])){
            $pv_ograniczenia['miejsce'] = $profileOne['quarter'];
        }
        
        if(!empty($profileOne['sex'])){
            $pv_ograniczenia['plec'] = $profileOne['sex'];
        }
        
        if(!empty($profileOne['education'])){
            $pv_ograniczenia['wyksztalcenie'] = $profileOne['education'];
        }

        if(!empty($profileOne['age'])){
            $ageArray = explode('-', $profileOne['age']);
            if(count($ageArray) <= 1){
                $ageArray = explode('+', $profileOne['age']);
            }
            if (isset($ageArray[0]) AND !empty($ageArray[0])) {
                $pv_ograniczenia['wiek'] = array('>=', intval($ageArray[0]));
            }
            if (isset($ageArray[1]) AND !empty($ageArray[1])) {
                $pv_ograniczenia['wiek '] = array('<=', intval($ageArray[1]));
            }
        }
    }else{
        // radio or single value
        $pv_allow = array('miejsce', 'plec', 'wyksztalcenie');
        foreach ($pv_allow as $name)
        {
            if (!empty($_POST[$name])) {
                $pv_ograniczenia[$name] = $_POST[$name];
            }
        }
        // extra ograniczenia
        // checkbox
        /**
            if (!empty($_POST['wyksztalcenie']))
            {
                $pv_ograniczenia['wyksztalcenie'] = array('IN', $_POST['wyksztalcenie']);
            }
            /**/
        if (!empty($_POST['wiek_od']) || !empty($_POST['wiek_do'])) {
            if (!empty($_POST['wiek_od'])) {
                $pv_ograniczenia['wiek'] = array('>=', intval($_POST['wiek_od']));
            }
            if (!empty($_POST['wiek_do'])) {
                $pv_ograniczenia['wiek '] = array('<=', intval($_POST['wiek_do']));
            }
        }
    }

    // get
    $dbProfile->pf_getRecords(
        $tplData['profiles'], $pv_ograniczenia, 
        array('id', 'ankieta_id', 'miejsce', 'plec', 'wiek', 'wyksztalcenie', 'grupa')
    );
}

    $pv_controller->tpl->file = 'search.tpl.php';
    $pv_controller->tpl->data = $tplData;

    //
    // Wyświetlanie template
    //
    $pv_controller->tpl->render();
?>