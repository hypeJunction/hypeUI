<?php

$full = elgg_extract('full_view', $vars);
$entity = elgg_extract('entity', $vars);

if (!$entity instanceof ElggFile) {
	return;
}

if ($full) {
	$vars['attachments'] = elgg_view('object/file/attachments', $vars);
	echo elgg_view('object/elements/full', $vars);
} elseif (elgg_in_context('gallery')) {
	echo elgg_view('object/elements/card', $vars);
} else {
	echo elgg_view('object/elements/summary', $vars);
}
