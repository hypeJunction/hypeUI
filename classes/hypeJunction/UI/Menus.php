<?php

namespace hypeJunction\UI;

use ElggGroup;
use ElggMenuItem;
use ElggUser;

class Menus {

	/**
	 * Setup topbar menu
	 *
	 * @param string         $hook   "register"
	 * @param string         $type   "menu:topbar"
	 * @param ElggMenuItem[] $return Menu
	 * @param array          $params Hook params
	 *
	 * @return ElggMenuItem[]
	 */
	public static function setupTopbarMenu($hook, $type, $return, $params) {

		$remove = ['friends', 'dashboard'];

		$walled = elgg_get_config('walled_garden') && !elgg_is_logged_in();

		if (elgg_is_active_plugin('search') && !$walled) {
			$return[] = ElggMenuItem::factory([
				'name' => 'search',
				'section' => 'default',
				'priority' => 1,
				'text' => elgg_view('search/search_box'),
				'href' => false,
			]);
		}

		if (elgg_is_logged_in()) {
			$user = elgg_get_logged_in_user_entity();
			$return[] = ElggMenuItem::factory([
				'name' => 'profile',
				'section' => 'default',
				'priority' => 900,
				'text' => $user->getDisplayName(),
				'icon' => elgg_view_entity_icon($user, 'small', [
					'use_link' => false,
					'href' => false,
				]),
				'href' => $user->getURL(),
				'link_class' => 'has-hidden-label',
			]);
		}

		if (!elgg_is_logged_in()) {

			if (!$walled || !elgg_in_context('main')) {
				$return[] = ElggMenuItem::factory([
					'name' => 'login',
					'href' => '#login-box',
					'text' => elgg_echo('login'),
					'priority' => 900,
					'link_class' => 'elgg-lightbox-inline button is-white outlined',
				]);

				if (elgg_get_config('allow_registration')) {
					$return[] = ElggMenuItem::factory([
						'name' => 'register',
						'href' => elgg_get_registration_url(),
						'text' => elgg_echo('register'),
						'priority' => 900,
						'link_class' => 'button is-white is-outlined',
					]);
				}
			}
		}

		foreach ($return as $key => $item) {
			if (in_array($item->getName(), $remove)) {
				unset($return[$key]);
				continue;
			}

			if ($item->getSection() == 'alt') {
				$item->setParentName('global');
				$item->setSection('default');
				$show_account_toggle = true;
			}

			switch ($item->getName()) {
				case 'messages' :
					if (!$item->icon) {
						$item->icon = 'envelope-o';
					}
					if (!$item->badge && is_callable('messages_count_unread')) {
						$count = messages_count_unread();
						$item->badge = $count ?: '';
					}
					$item->setText(elgg_echo('messages'));
					$item->addLinkClass('has-hidden-label');
					$item->setPriority(300);
					break;

				case 'quarantine' :
					$item->icon = 'archive';
					break;

				case 'logout' :
					$item->icon = 'sign-out';
					break;
			}

			$return[$key] = $item;
		}

		if ($show_account_toggle) {
			$return[] = ElggMenuItem::factory([
				'name' => 'global',
				'href' => '#',
				'text' => '',
				'icon' => 'cog',
				'section' => 'default',
				'priority' => 400,
			]);
		}

		return $return;
	}

	/**
	 * Setup site menu
	 *
	 * @param string         $hook   "register"
	 * @param string         $type   "menu:site"
	 * @param ElggMenuItem[] $return Menu
	 * @param array          $params Hook params
	 *
	 * @return ElggMenuItem[]
	 */
	public static function setupSiteMenu($hook, $type, $return, $params) {
		$custom_menu_items = elgg_get_config('site_custom_menu_items');

		if ($custom_menu_items) {
			// add custom menu items
			$n = 1;
			foreach ($custom_menu_items as $title => $url) {
				$item = new ElggMenuItem("custom$n", $title, $url);
				$return[] = $item;
				$n++;
			}
		}

		if (elgg_is_logged_in() && elgg_is_active_plugin('dashboard')) {
			$return[] = ElggMenuItem::factory([
				'name' => 'dashboard',
				'text' => elgg_echo('dashboard'),
				'href' => 'dashboard',
			]);
		}

		return $return;
	}

	/**
	 * Set up the site menu
	 *
	 * Handles default, featured, and custom menu items
	 *
	 * @access private
	 */
	public static function prepareSiteMenu($hook, $type, $return, $params) {

		$featured_menu_names = array_values((array)elgg_get_config('site_featured_menu_names'));

		$registered = $return['default'];
		/* @var ElggMenuItem[] $registered */

		$has_selected = false;
		$priority = 500;
		foreach ($registered as &$item) {
			if (in_array($item->getName(), $featured_menu_names)) {
				$featured_index = array_search($item->getName(), $featured_menu_names);
				$item->setPriority($featured_index);
			} else {
				$item->setPriority($priority);
				$priority++;
			}
			if ($item->getSelected()) {
				$has_selected = true;
			}
		}

		if (!$has_selected) {
			$is_selected = function ($item) {
				$current_url = current_page_url();
				if (strpos($item->getHref(), elgg_get_site_url()) === 0) {
					if ($item->getName() == elgg_get_context()) {
						return true;
					}
					if ($item->getHref() == $current_url) {
						return true;
					}
				}

				return false;
			};
			foreach ($registered as &$item) {
				if ($is_selected($item)) {
					$item->setSelected(true);
					break;
				}
			}
		}

		usort($registered, [\ElggMenuBuilder::class, 'compareByPriority']);

		$max_display_items = elgg_get_plugin_setting('site_menu_count', 'hypeUI', 5);

		$num_menu_items = count($registered);

		$more = [];
		if ($max_display_items && $num_menu_items > ($max_display_items + 1)) {
			$more = array_splice($registered, $max_display_items);
		}

		if (!empty($more)) {
			$dropdown = ElggMenuItem::factory([
				'name' => 'more',
				'href' => 'javascript:void(0);',
				'text' => elgg_echo('more') . elgg_view_icon('caret-down', ['class' => 'elgg-menu-icon-after']),
				'priority' => 999,
			]);

			foreach ($more as &$item) {
				$item->setParentName('more');
			}

			$dropdown->setChildren($more);

			$registered[] = $dropdown;
		}

		$return['default'] = $registered;

		return $return;
	}

	/**
	 * Setup entity menu
	 *
	 * @param string         $hook   "register"
	 * @param string         $type   "menu:entity"
	 * @param ElggMenuItem[] $return Menu
	 * @param array          $params Hook params
	 *
	 * @return ElggMenuItem[]
	 */
	public static function setupEntityMenu($hook, $type, $return, $params) {

		$user = elgg_get_logged_in_user_entity();
		$entity = elgg_extract('entity', $params);

		$remove = [
			'access',
		];

		if ($entity instanceof ElggUser) {
			$remove[] = 'location';
		}

		if ($entity instanceof ElggGroup) {
			$remove[] = 'membership';
			$remove[] = 'members';

			if (elgg_is_active_plugin('groups')) {
				$return = groups_prepare_profile_buttons(null, null, $return, $params);
			}

			if (elgg_is_active_plugin('notifications') && $entity->isMember($user)) {
				$subscribed = false;

				$methods = elgg_get_notification_methods();
				foreach ($methods as $method) {
					$relationship = check_entity_relationship($user->guid, "notify$method", $entity->guid);
					if ($relationship) {
						$subscribed = true;
						break;
					}
				}

				$return[] = ElggMenuItem::factory([
					'name' => 'subscription_status',
					'text' => $subscribed ? elgg_echo('groups:subscribed') : elgg_echo('groups:unsubscribed'),
					'icon' => 'bell-o',
					'href' => "notifications/group/$user->username",
					'section' => $subscribed ? 'danger' : 'actions',
				]);
			}
		}

		if ($entity instanceof \ElggObject) {
			switch ($entity->getSubtype()) {
				case 'messages' :
					if ($entity->canEdit()) {
						$return[] = ElggMenuitem::factory([
							'name' => 'delete',
							'href' => "action/messages/delete?guid={$entity->guid}",
							'is_action' => true,
							'text' => elgg_echo('delete'),
							'confirm' => elgg_echo('deleteconfirm'),
						]);
					}
			}
		}

		if ($entity instanceof \ElggFile) {
			if (elgg_trigger_plugin_hook('permissions_check:download', 'file', $params, true)) {
				$return[] = ElggMenuItem::factory([
					'name' => 'download',
					'text' => elgg_echo('download'),
					'href' => elgg_get_download_url($entity),
					'section' => 'actions',
					'icon' => 'download',
				]);
			}
		}

		foreach ($return as $key => $item) {
			if (in_array($item->getName(), $remove)) {
				unset($return[$key]);
				continue;
			}

			$link_class = $item->getLinkClass();
			$link_classes = explode(' ', $link_class);
			$link_classes = array_diff($link_classes, ['elgg-button', 'elgg-button-action', 'elgg-button-submit']);
			$item->setLinkClass(implode(' ', $link_classes));

			switch ($item->getName()) {
				case 'edit' :
					$item->icon = 'pencil';
					$item->setText(elgg_echo('edit'));
					$item->setSection('actions');
					break;

				case 'delete' :
					$item->icon = 'trash';
					$item->setText(elgg_echo('delete'));
					$item->setSection('danger');
					break;

				case 'history' :
					$item->icon = 'history';
					break;

				case 'feature' :
					$item->icon = 'star';
					$item->setSection('admin');
					break;

				case 'unfeature' :
					$item->icon = 'star-o';
					$item->setSection('admin');
					break;

				case 'groups:edit' :
					$item->icon = 'pencil';
					$item->setSection('actions');
					break;

				case 'groups:invite' :
					$item->setSection('actions');
					$item->icon = 'user-plus';
					break;

				case 'groups:leave' :
					$item->icon = 'chain-broken';
					$item->setSection('danger');
					break;

				case 'groups:join' :
					$item->icon = 'link';
					$item->setSection('actions');
					break;

				case 'discovery:edit' :
					$item->icon = 'pencil';
					$item->setText($item->getTooltip());
					$item->setSection('admin');
					break;

				case 'discovery:share' :
					$item->icon = 'share';
					$item->setText($item->getTooltip());
					$item->setSection('actions');
					break;

				case 'quarantine_status' :
					$item->icon = 'archive';
					$item->setSection('admin');
					break;
			}
		}

		return $return;
	}

	/**
	 * Setup entity menu
	 *
	 * @param string         $hook   "register"
	 * @param string         $type   "menu:entity_social"
	 * @param ElggMenuItem[] $return Menu
	 * @param array          $params Hook params
	 *
	 * @return ElggMenuItem[]
	 */
	public static function setupEntitySocialMenu($hook, $type, $return, $params) {

		$entity = elgg_extract('entity', $params);

		if ($entity instanceof \ElggObject) {
			$comments = false;
			if ($entity->getSubtype() == 'discussion') {
				$comments = elgg_get_entities([
					'type' => 'object',
					'subtype' => 'discussion_reply',
					'container_guid' => $entity->guid,
					'count' => true,
					'distinct' => false,
				]);
				$fragment = 'group-replies';
			} else {
				$comments = $entity->countComments();
				$fragment = 'comments';
			}

			if ($comments) {
				$parts = parse_url($entity->getURL());
				$parts['fragment'] = $fragment;
				$url = elgg_http_build_url($parts, false);
				$return[] = ElggMenuItem::factory([
					'name' => 'comments',
					'text' => $comments,
					'icon' => 'comments-o',
					'href' => $url,
				]);
			}
		}

		if ($entity instanceof ElggGroup) {
			$count = $entity->getMembers(['count' => true]);
			if ($count) {
				$return[] = ElggMenuItem::factory([
					'name' => 'members',
					'text' => "$count",
					'href' => "groups/members/$entity->guid",
					'title' => $count . ' ' . elgg_echo('groups:member'),
					'icon' => 'users',
				]);
			}
		}

		return $return;
	}

	/**
	 * Setup widget menu
	 *
	 * @param string         $hook   "register"
	 * @param string         $type   "menu:widget"
	 * @param ElggMenuItem[] $return Menu
	 * @param array          $params Hook params
	 *
	 * @return ElggMenuItem[]
	 */
	public
	static function setupWidgetMenu($hook, $type, $return, $params) {

		$remove = ['collapse'];

		foreach ($return as $key => $item) {
			if (in_array($item->getName(), $remove)) {
				unset($return[$key]);
				continue;
			}
		}

		return $return;
	}

	/**
	 * Setup owner block menu
	 *
	 * @param string         $hook   "register"
	 * @param string         $type   "menu:owner_block"
	 * @param ElggMenuItem[] $return Menu
	 * @param array          $params Hook params
	 *
	 * @return ElggMenuItem[]
	 */
	public static function setupOwnerBlockMenu($hook, $type, $return, $params) {

		$entity = elgg_extract('entity', $params, elgg_get_page_owner_entity());
		if (!$entity) {
			return;
		}

		if ($entity instanceof ElggUser) {
			$return[] = ElggMenuItem::factory([
				'name' => 'activity',
				'text' => elgg_echo('activity'),
				'href' => "activity/owner/$entity->username",
				'priority' => 10,
			]);

			$return[] = ElggMenuItem::factory([
				'name' => 'friends',
				'text' => elgg_echo('friends'),
				'href' => "friends/$entity->username",
				'priority' => 20,
			]);
		}

		if ($entity instanceof ElggGroup) {
			if (elgg_group_gatekeeper(false, $entity->guid)) {
				$return[] = ElggMenuItem::factory([
					'name' => 'members',
					'text' => elgg_echo('groups:members'),
					'href' => "groups/members/$entity->guid",
					'priority' => 20,
				]);
			}
		}

		$remove = [];

		foreach ($return as $key => $item) {
			if (in_array($item->getName(), $remove)) {
				unset($return[$key]);
				continue;
			}

			switch ($item->getName()) {
				case 'activity' :
					$item->setPriority(10);
					break;
			}

			if ($entity->guid == elgg_get_page_owner_guid()) {
				$href = $item->getHref();
				if (strpos($href, elgg_get_site_url()) == 0) {

					$href = substr($href, strlen(elgg_get_site_url()));
					$href_parts = explode('/', parse_url($href, PHP_URL_PATH));

					$page_url = current_page_url();
					$page_url = substr($page_url, strlen(elgg_get_site_url()));
					$page_url_parts = explode('/', parse_url($page_url, PHP_URL_PATH));

					if (empty($href_parts)) {
						continue;
					}
					if (empty($page_url_parts)) {
						continue;
					}

					if ($href_parts[0] == 'groups') {
						array_shift($href_parts);
					}

					if ($page_url_parts[0] == 'groups') {
						array_shift($page_url_parts);
					}

					if (!empty($href_parts) && $href_parts[0] == $page_url_parts[0]) {
						$item->setSelected();
					}
				}
			}
		}

		return $return;
	}

	/**
	 * Setup user hover menu
	 *
	 * @param string         $hook   "register"
	 * @param string         $type   "menu:user_hover"
	 * @param ElggMenuItem[] $return Menu
	 * @param array          $params Hook params
	 *
	 * @return ElggMenuItem[]
	 */
	public
	static function setupUserHoverMenu($hook, $type, $return, $params) {

		$remove = ['activity:owner'];

		if (!elgg_is_admin_logged_in()) {
			$remove[] = 'logbrowser';
		}

		foreach ($return as $key => $item) {
			if (in_array($item->getName(), $remove)) {
				unset($return[$key]);
				continue;
			}

			switch ($item->getName()) {
				case 'add_friend' :
					$item->icon = 'user-plus';
					break;

				case 'remove_friend' :
					$item->icon = 'user-times';
					$item->setSection('danger');
					break;

				case 'reportuser' :
					$item->icon = 'bullhorn';
					$item->setSection('danger');
					break;

				case 'ban' :
					$item->icon = 'ban';
					break;

				case 'delete' :
					$item->icon = 'trash';
					break;

				case 'send' :
					$item->icon = 'paper-plane-o';
					break;

				case 'settings:edit' :
					$item->icon = 'cog';
					break;

				case 'profile:edit' :
					$item->icon = 'pencil';
					break;

				case 'avatar:edit' :
					$item->icon = 'user-circle';
					break;

				case 'resetpassword' :
					$item->icon = 'key';
					break;

				case 'logbrowser' :
					$item->icon = 'history';
					break;

				case 'makeadmin' :
					$item->icon = 'flag';
					break;

				case 'removeadmin' :
					$item->icon = 'flag-o';
					break;

				case 'login_as' :
					$item->icon = 'user-secret';
					break;

				case 'removeuser' :
					$item->icon = 'user-times';
					$item->setSection('danger');
					break;

			}
		}

		return $return;
	}

	/**
	 * Setup title menu
	 *
	 * @param string         $hook   "register"
	 * @param string         $type   "menu:title"
	 * @param ElggMenuItem[] $return Menu
	 * @param array          $params Hook params
	 *
	 * @return ElggMenuItem[]
	 */
	public
	static function setupTitleMenu($hook, $type, $return, $params) {

		$remove = [];

		foreach ($return as $key => $item) {
			if (in_array($item->getName(), $remove)) {
				unset($return[$key]);
				continue;
			}

			switch ($item->getName()) {
				case 'download' :
					$item->icon = 'download';
					break;

				case 'add' :
					$item->icon = 'plus';
					break;

				case 'delete' :
					$item->icon = 'trash';
					$item->setSection('danger');
					break;

				case 'edit' :
				case 'groups:edit' :
					$item->icon = 'pencil';
					break;

				case 'groups:invite' :
					$item->icon = 'user-plus';
					break;

				case 'groups:leave' :
					$item->icon = 'chain-broken';
					$item->setSection('danger');
					break;

				case 'groups:join' :
					$item->icon = 'link';
					break;
			}
		}

		return $return;
	}

	/**
	 * Setup extras menu
	 *
	 * @param string         $hook   "register"
	 * @param string         $type   "menu:extras"
	 * @param ElggMenuItem[] $return Menu
	 * @param array          $params Hook params
	 *
	 * @return ElggMenuItem[]
	 */
	public
	static function setupExtrasMenu($hook, $type, $return, $params) {

		$remove = [];

		foreach ($return as $key => $item) {
			if (in_array($item->getName(), $remove)) {
				unset($return[$key]);
				continue;
			}

			switch ($item->getName()) {
				case 'bookmark' :
					$item->icon = 'bookmark';
					$item->setText($item->getTooltip());
					break;

				case 'rss' :
					$item->icon = 'rss';
					$item->setText($item->getTooltip());
					break;

				case 'report_this' :
					$item->icon = 'bullhorn';
					$item->setText($item->getTooltip());
					break;

				case 'file_list' :
					$item->icon = $item->getText();
					$item->setText($item->getTooltip());
					break;

				case 'discovery:share' :
					$item->icon = 'share';
					$item->setText($item->getTooltip());
					break;
			}
		}

		return $return;
	}

	/**
	 * Setup page menu
	 *
	 * @param string         $hook   "register"
	 * @param string         $type   "menu:page"
	 * @param ElggMenuItem[] $return Menu
	 * @param array          $params Hook params
	 *
	 * @return ElggMenuItem[]
	 */
	public
	static function setupPageMenu($hook, $type, $return, $params) {

		$remove = [];

		$return[] = ElggMenuItem::factory([
			'name' => 'theme',
			'text' => elgg_echo('admin:theme'),
			'href' => '#',
			'section' => 'configure',
			'context' => ['admin'],
		]);

		$return[] = ElggMenuItem::factory([
			'name' => 'theme:assets',
			'text' => elgg_echo('admin:theme:assets'),
			'href' => 'admin/theme/assets',
			'section' => 'configure',
			'parent_name' => 'theme',
			'context' => ['admin'],
		]);

		$return[] = ElggMenuItem::factory([
			'name' => 'theme:layout',
			'text' => elgg_echo('admin:theme:layout'),
			'href' => 'admin/theme/layout',
			'section' => 'configure',
			'parent_name' => 'theme',
			'context' => ['admin'],
		]);

		foreach ($return as $key => $item) {
			if (in_array($item->getName(), $remove)) {
				unset($return[$key]);
				continue;
			}

			switch ($item->getName()) {
				case 'invite' :
					$item->icon = 'user-plus';
					$item->setSection('actions');
					break;

				case 'bookmarklet' :
					$item->icon = 'chrome';
					$item->setSection('extras');
					break;
			}
		}

		return $return;
	}

}