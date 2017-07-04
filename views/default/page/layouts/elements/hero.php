<?php

$hero = elgg_extract('hero', $vars);
if (!$hero) {
	return;
}

?>
<div class="elgg-page-hero">
	<?= $hero ?>
</div>
