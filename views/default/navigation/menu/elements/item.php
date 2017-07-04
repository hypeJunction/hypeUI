<?php
/**
 * A single element of a menu.
 *
 * @package Elgg.Core
 * @subpackage Navigation
 *
 * @uses $vars['item']       ElggMenuItem
 * @uses $vars['item_class'] Additional CSS class for the menu item
 */

$item = $vars['item'];
/* @var $item ElggMenuItem */

$children = $item->getChildren();
if ($children) {
	$link_class = 'elgg-menu-closed';
	if ($item->getSelected()) {
		$link_class = 'elgg-menu-opened';
	}
	$item->addLinkClass($link_class);
	$item->addLinkClass('elgg-menu-parent');
}

$item_class = $item->getItemClass();
if ($item->getSelected()) {
	$item->addItemClass('elgg-state-selected');
	$item->addLinkClass('is-active');
	$item->addItemClass('is-active');
}

if (!empty($vars['item_class'])) {
	$item->addItemClass($vars['item_class']);
}

if (!empty($vars['link_class'])) {
	$item->addLinkClass($vars['link_class']);
}

if (elgg_get_config('debug')) {
	$item->{'data-menu-item-name'} = $item->getName();
}

$view = elgg_view_menu_item($item);
if ($children) {
	$view .= elgg_view('navigation/menu/elements/section', array(
		'items' => $children,
		'class' => 'elgg-menu elgg-child-menu',
	));
}

echo elgg_format_element('li', [
	'class' => $item->getItemClass(),
], $view);
