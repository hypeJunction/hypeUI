<?php

$entity = elgg_extract('entity', $vars);
$full = elgg_extract('full_view', $vars, false);
$is_gallery = elgg_in_context('gallery');

if ($full) {
	echo elgg_view('object/elements/full', $vars);
} else if ($is_gallery || !empty($vars['card'])) {
	if (elgg_extract('card', $vars, false)) {
		echo elgg_view('object/elements/card', $vars);
	} else {
		echo elgg_view('object/elements/icon', $vars);
	}
} else {
	echo elgg_view('object/elements/summary', $vars);
}
