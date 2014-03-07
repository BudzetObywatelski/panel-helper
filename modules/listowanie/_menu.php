<?
	/* @var $pv_menuItem MenuItem */
	$pv_menuItem->title = 'Listowanie';
	$pv_menuItem->order = 3;
	if ($configHelper->panel_stage == 'draw')
	{
		$pv_menuItem->users = 'admin';
	}
	else
	{
		$pv_menuItem->users = 'anon,admin,maciej.j,marcin.g';
	}
	
	require_once ('./inc/db/profile.php');
	foreach (dbProfile::$pv_grupy as $grupa)
	{
		if ($grupa == 'w puli' || $grupa == 'robocza')
		{
			continue;
		}
		$pv_menuItem->addSubItem($grupa);
	}
?>