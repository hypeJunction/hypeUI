<?php

/**
 * 
 *
 * Replaces some of the most corky elements of Elgg UI
 * 
 * @author Ismayil Khayredinov <info@hypejunction.com>
 * @copyright Copyright (c) 2017, Ismayil Khayredinov
 */
require_once __DIR__ . '/autoloader.php';

use hypeJunction\UI\Lightbox;
use hypeJunction\UI\Menus;

elgg_register_event_handler('init', 'system', function() {

	elgg_register_css('fonts.opensans', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,700');
	elgg_load_css('fonts.opensans');

	elgg_register_plugin_hook_handler('register', 'menu:topbar', [Menus::class, 'setupTopbarMenu'], 999);

	elgg_unregister_plugin_hook_handler('prepare', 'menu:site', '_elgg_site_menu_setup');
	elgg_register_plugin_hook_handler('prepare', 'menu:site', [Menus::class, 'prepareSiteMenu'], 999);

	elgg_register_plugin_hook_handler('register', 'menu:entity', [Menus::class, 'setupEntityMenu'], 999);
	elgg_register_plugin_hook_handler('register', 'menu:entity_social', [Menus::class, 'setupEntitySocialMenu'], 999);
	elgg_register_plugin_hook_handler('register', 'menu:entity', [Menus::class, 'setupWidgetMenu'], 999);
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', [Menus::class, 'setupOwnerBlockMenu'], 999);
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', [Menus::class, 'setupUserHoverMenu'], 999);
	elgg_register_plugin_hook_handler('register', 'menu:extras', [Menus::class, 'setupExtrasMenu'], 999);
	elgg_register_plugin_hook_handler('register', 'menu:title', [Menus::class, 'setupTitleMenu'], 999);
	elgg_register_plugin_hook_handler('register', 'menu:page', [Menus::class, 'setupPageMenu'], 999);

	elgg_extend_view('elgg.css', 'bulma.css', 1);
	elgg_extend_view('admin.css', 'bulma.css', 1);
	elgg_extend_view('elgg.js', 'page/elements/topbar.js');

	elgg_unextend_view('page/elements/header', 'search/header');

	// Lightbox
	elgg_unregister_css('lightbox');
	elgg_extend_view('elgg.css', 'lightbox/elgg-colorbox-theme/colorbox.css');
	elgg_register_plugin_hook_handler('elgg.data', 'site', [Lightbox::class, 'configure']);

	if (elgg_is_active_plugin('likes')) {
		elgg_unregister_plugin_hook_handler('register', 'menu:river', 'likes_river_menu_setup');
		elgg_unregister_plugin_hook_handler('register', 'menu:entity', 'likes_entity_menu_setup');
		elgg_register_plugin_hook_handler('register', 'menu:entity_social', 'likes_entity_menu_setup', 400);
	}

	if (elgg_is_active_plugin('blog')) {
		elgg_unregister_plugin_hook_handler('register', 'menu:entity', 'blog_entity_menu_setup');
	}

	elgg_register_ajax_view('object/elements/menu/contents');

	elgg_unregister_menu_item('footer', 'powered');
});

/**
 * Determine entity page handler
 *
 * @param ElggEntity $entity
 * @return string
 */
function hypeapps_ui_get_entity_handler(ElggEntity $entity) {

	$map = [
		'object' => [
		'blog' => 'blog',
		'file' => 'file',
		'bookmarks' => 'bookmarks',
		'page' => 'pages',
		'page_top' => 'pages',
		'thewire' => 'thewire',
		'discussion' => 'discussion',
			],
		'user' => [
			'default' => 'profile',
		],
		'group' => [
			'default' => 'groups',
		],
	];

	$handler = elgg_extract($entity->getSubtype() ? : 'default', $map[$entity->type]);

	$params = ['entity' => $entity];
	return elgg_trigger_plugin_hook('entity:handler', $entity->type, $params, $handler);
}