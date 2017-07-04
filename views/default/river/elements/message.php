<?php

$message = elgg_extract('message', $vars);

if (!$message) {
	return;
}

?>
<div class="elgg-river-message"><?= $message ?></div>
