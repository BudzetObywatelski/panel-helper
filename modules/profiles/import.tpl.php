<h2>Import profili</h2>
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
<form action="?mod=profiles&a=import" method="POST" enctype="multipart/form-data">
	<div class="uploader">
		<input type="file" name="file">
	</div>
	<input type="submit" name="send">
</form>