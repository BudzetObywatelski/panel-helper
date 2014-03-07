<div id="dane_kontaktowe_container">
	<?php
			foreach($tplData['personal'] as $i=>&$row) {
				$row['e_mail'] = "<span class='dane' style='display:none'>{$row['e_mail']}</span>";
				$row['nr_tel'] = "<span class='dane' style='display:none'>{$row['nr_tel']}</span>";
			}
			ModuleTemplate::printArray($tplData['personal'],
					array(
						'nazwisko_imie'=>'nazwisko, imię',
						'e_mail'=>'e-mail',
						'nr_tel'=>'telefon',
					)
			);
	?>
</div>
<p>
	<input type="submit" id="dane_kontaktowe_show" value="Pokaż dane kontaktowe" data-value-hide="Schowaj dane kontaktowe">
</p>
<script>
(function($){
	var hidden = true;
	var $dane = $('#dane_kontaktowe_container .dane');
	var $trigger = $('#dane_kontaktowe_show');
	var text = {
		show : $trigger.val(),
		hide : $trigger.attr('data-value-hide')
	};
	$trigger.click(
		function (e)
		{
			if (hidden) {
				if (confirm('Czy na pewno chcesz odkryć PRYWATNE dane?')) {
					$dane.show();
					hidden = false;
				}
			} else {
				$dane.hide();
				hidden = true;
			}
			if (hidden) {
				$trigger.val(text.show);
			} else {
				$trigger.val(text.hide);
			}
			e.preventDefault();
		}
	);
})(jQuery);
</script>
