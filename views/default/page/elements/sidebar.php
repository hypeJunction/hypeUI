<?php
/**
 * Elgg sidebar contents
 *
 * @uses $vars['sidebar'] Optional content that is displayed at the bottom of sidebar
 */

$new_items = [];

$params = $vars;
$params['sort_by'] = 'priority';
$params['class'] = 'menu-list';
$params['menu_view'] = 'navigation/menu/page';
$params['show_section_headers'] = true;

$entity = elgg_extract('entity', $vars);

if ($entity instanceof ElggEntity) {
	$params['handler'] = hypeapps_ui_get_entity_handler($entity);

	$entity_menu_sections = elgg()->menus->getMenu('entity', $params)->getSections();
	foreach ($entity_menu_sections as $section => $items) {
		foreach ($items as $item) {
			/* @var $item ElggMenuItem */
			$new_items[] = $item;
		}
	}
	unset($entity_menu_sections);

	if ($entity instanceof ElggUser) {
		$user_menu_sections = elgg()->menus->getMenu('user_hover', $params)->getSections();
		foreach ($user_menu_sections as $section => $items) {
			foreach ($items as $item) {
				/* @var $item ElggMenuItem */
				if ($item->getSection() == 'action') {
					$item->setSection('actions');
				}
				$new_items[] = $item;
			}
		}
	}
}

$title_menu_sections = elgg()->menus->getMenu('title', $params)->getSections();
foreach ($title_menu_sections as $section => $items) {
	foreach ($items as $item) {
		/* @var $item ElggMenuItem */
		if ($item->getSection() == 'default') {
			$item->setSection('actions');
		}
		$link_class = $item->getLinkClass();
		$link_classes = explode(' ', $link_class);
		$link_classes = array_diff($link_classes, ['elgg-button', 'elgg-button-action', 'elgg-button-submit']);
		$item->setLinkClass(implode(' ', $link_classes));
		$new_items[] = $item;
	}
}

$page_items = elgg()->menus->getUnpreparedMenu('page', $params)->getItems();
$new_items += $page_items;

if (empty($new_items)) {
	$owner = elgg_get_page_owner_entity();
	if ($owner) {
		$owner_block_params = $params;
		$owner_block_params['entity'] = $owner;
		$owner_block = elgg()->menus->getMenu('owner_block', $owner_block_params)->getSections();
		foreach ($owner_block as $section => $items) {
			foreach ($items as $item) {
				$item->setSection($owner->getType());
				$new_items[] = $item;
			}
		}
	}
}

$params['items'] = $new_items;

$page_menu = elgg_view_menu('sidebar', $params);
if ($page_menu) {
	echo elgg_format_element('div', [
		'class' => 'elgg-module menu',
	], $page_menu);
}

if (!empty($vars['sidebar'])) {
	echo $vars['sidebar'];
}

unset($params['items']);
$extras_menu = elgg_view_menu('extras', $params);
if ($extras_menu) {
	echo elgg_format_element('div', [
		'class' => 'elgg-module menu',
	], $extras_menu);
}
