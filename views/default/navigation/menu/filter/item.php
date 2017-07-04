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
}

$item_class = $item->getItemClass();
if ($item->getSelected()) {
	$item->addLinkClass('is-active');
}

if (!empty($vars['link_class'])) {
	$item->addLinkClass($vars['link_class']);
}

$icon = $item->getData('icon');
if ($icon) {
	$icon = elgg_view_icon($icon);
	$text = $item->getText();
	$item->setText($icon . $text);
}

echo elgg_view_menu_item($item);

