<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggGroup) {
	return;
}

if (!elgg_group_gatekeeper(false, $entity->guid)) {
	return;
}

if (elgg_is_active_plugin('search')) {
	$sidebar .= elgg_view('groups/sidebar/search', ['entity' => $entity]);
}

echo $sidebar;
