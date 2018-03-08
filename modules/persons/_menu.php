<?php
    /* @var $pv_menuItem MenuItem */
    $pv_menuItem->title = 'Osoby - import';
    $pv_menuItem->order = 7;
if ($configHelper->panel_stage == 'results') {
    $pv_menuItem->users = '';
}
else if ($configHelper->panel_stage != 'tests') {
    $pv_menuItem->users = AUTH_GROUP_OPS;
}