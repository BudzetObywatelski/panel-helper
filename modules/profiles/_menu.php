<?php
    /* @var $pv_menuItem MenuItem */
    $pv_menuItem->title = 'Profile';
    $pv_menuItem->order = 6;
if ($configHelper->panel_stage == 'results') {
    $pv_menuItem->users = '';
}
else if ($configHelper->panel_stage != 'tests') {
    $pv_menuItem->users = AUTH_GROUP_OPS;
}
if ($pv_menuItem->authCheck($userName)) {
    include_once './inc/db/profiles.php';
    foreach (dbProfiles::$actions as $action)
    {
        $pv_menuItem->addSubItem($action);
    }
}