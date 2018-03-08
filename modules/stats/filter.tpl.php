<!-- filtr -->
<form id="search" method="post" action=""  style="margin: 1em">
    <div class="buttonset" style="float:left">
        <?php foreach (dbProfile::$pv_grupy as $i=>$grupa) { ?>
    <?php if ($grupa == 'w puli' || $grupa == 'robocza') { continue; 
    } ?>
            <input id="grupa_<?php echo $i?>" type="checkbox" name="grupa[]" value="<?php echo $grupa?>"
                        <?php echo in_array($grupa, $tplData['prev']['grupa']) ? 'checked' : ''?>
                   >
            <label for="grupa_<?php echo $i?>"><?php echo $grupa?></label>
        <?php } ?>
    </div>
    <div style="float:left; margin-left: 1em">
        <input type="submit" name="search" value="Zmień" />
    </div>
    <br clear="all" />
</form>