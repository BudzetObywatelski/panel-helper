<?php if (empty($pv_mainMenu)) { ?>
    <span class="empty">Menu jest puste</span>
<?php } else { ?>
    <ul>
    <?php foreach ($pv_mainMenu as $m) { ?>
    <?php if (empty($m->submenu)) { ?>
                <li><a href="<?php echo $m->url?>"><?php echo htmlspecialchars($m->title)?></a></li>
    <?php } else { ?>
                <li><a href="<?php echo $m->url?>"><?php echo htmlspecialchars($m->title)?></a>
                    <ul>
        <?php foreach ($m->submenu as $sm) { ?>
                            <li><a href="<?php echo $sm['url']?>"><?php echo htmlspecialchars($sm['title'])?></a></li>
        <?php } ?>
                    </ul>
                </li>
    <?php } ?>
    <?php } ?>
    </ul>
<?php } ?>