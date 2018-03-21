<?php 
if(!empty($tplData['errors'])){
	foreach ($tplData['errors'] as $keyE => $error) {
?>
<div class="bar error">
	<h3>Błąd</h3>
	<p><?php echo $error; ?></p>
</div>
<?php 
}
}elseif(!empty($tplData['success'])){
foreach ($tplData['success'] as $keys => $success) {
?>
<div class="bar success">
	<h3>Sukces</h3>
	<p><?php echo $success; ?></p>
</div>
<?php
}} ?>
<table>
	<thead>
		<th>ID</th>
		<th>Dzielnica</th>
		<th>Wiek</th>
		<th>Płeć</th>
		<th>Wykształcenie</th>
		<th>Akcje</th>
	</thead>
	<?php 
		foreach ($tplData['profiles'] as $keyP => $profile) {
			echo '<tr>';
			echo '<td>'.$profile['id'].'</td>';
			echo '<td>'.$profile['quarter'].'</td>';
			echo '<td>'.$profile['age'].'</td>';
			echo '<td>'.$profile['sex'].'</td>';
			echo '<td>'.$profile['education'].'</td>';
			echo '<td> <a class="btn" href="?mod=profiles&a=delete&id='.$profile['id'].'">Usuń</a> </td>';
			echo '</tr>';
		}
	?>
</table>