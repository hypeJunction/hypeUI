<?php

$responses = elgg_view('river/elements/responses', $vars);

if (!$responses) {
	return;
}

?>
<div class="elgg-river-item-footer"><?= $responses ?></div>
