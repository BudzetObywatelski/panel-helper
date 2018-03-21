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

<form action="" method="POST" class="form">
	<div class="form-control">
		<label> Dzielnica: </label>
		<input type="text" name="quarter">
	</div>
	<div class="form-control">
		<label>Płeć: </label>
		<select name="sex"><option value="m">Mężczyzna</option><option value="k">Kobieta</option></select>
	</div>
	<div class="form-control">
		<label>Wiek Od: </label>
		<input type="number" name="age_from"> 
	</div>
	<div class="form-control">
		<label>Wiek Do: </label>
		<input type="number" name="age_to">
	</div>
	<div class="form-control">
		<label>Wykształcenie: </label>
		<select name="education"><option value="p">Podstawowe</option><option value="s">Średnie</option><option value="w">Wyższe</option></select>
	</div>

	<input type="submit" name="send" value="Dodaj">
</form>