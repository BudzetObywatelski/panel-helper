<h2>Historia działań z serwera</h2>
<?php if (!empty($tplData['history'])) { ?>
<p>Pokazuję historę o UUID: <?php echo $tplData['history']['uuid']?>,
    ostatnia zmiana: <?php echo $tplData['history']['dt_change']?>.</p>
<?php } ?>
<div class="draw-history draw-history-full"></div>
<p><input type="button" name="history-not-current" value="Pokaż nie-bieżącą"
          onclick="location.href = location.href.replace(/&uuid=[^&]*/, '') + '&amp;not_uuid=' + drawHistory.historyId" /></p>
<script>
window.serverHistoryData = [];
<?php if (!empty($tplData['history'])) { ?>
    window.serverHistoryData = JSON.parse(<?php echo json_encode($tplData['history']['history_data'])?>);
<?php } ?>
</script>