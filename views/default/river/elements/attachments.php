<?php

$attachments = elgg_extract('attachments', $vars);

if (empty($attachments)) {
	return;
}
?>
<div class="elgg-river-attachments clearfix"><?= $attachments ?></div>
