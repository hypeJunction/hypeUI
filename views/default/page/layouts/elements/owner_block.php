<?php

if (elgg_in_context('admin')) {
    return;
}

$owner = elgg_get_page_owner_entity();
if (!$owner instanceof ElggUser && !$owner instanceof ElggGroup) {
	return;
}

$items = [
	[
		'name' => 'profile',
		'text' => elgg_echo('profile'),
		'href' => $owner->getURL(),
		'title' => $owner->getDisplayName(),
		'priority' => 1,
	],
];

$filter = elgg_view_menu('owner_block', [
	'items' => $items,
	'entity' => $owner,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
	'menu_view' => 'navigation/menu/filter',
]);

?>
<div class="elgg-inner container">
    <div class="nav-left">
		<?= $filter ?>
    </div>
</div>

