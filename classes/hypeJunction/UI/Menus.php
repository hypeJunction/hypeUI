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

		$remove = ['friends'];

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
				'priority' => 500,
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

			$remove[] = 'dashboard';

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
	 * Set up the site menu
	 *
	 * Handles default, featured, and custom menu items
	 *
	 * @access private
	 */
	public static function prepareSiteMenu($hook, $type, $return, $params) {

		$featured_menu_names = elgg_get_config('site_featured_menu_names');
		$custom_menu_items = elgg_get_config('site_custom_menu_items');

		$more_children = [];

		if ($featured_menu_names || $custom_menu_items) {
			// we have featured or custom menu items

			$registered = $return['default'];
			/* @var ElggMenuItem[] $registered */

			// set up featured menu items
			$featured = [];
			foreach ($featured_menu_names as $name) {
				foreach ($registered as $index => $item) {
					if ($item->getName() == $name) {
						$featured[] = $item;
						unset($registered[$index]);
					}
				}
			}

			// add custom menu items
			$n = 1;
			foreach ($custom_menu_items as $title => $url) {
				$item = new ElggMenuItem("custom$n", $title, $url);
				$featured[] = $item;
				$n++;
			}


			if (count($registered) > 0) {

				foreach ($registered as $item) {
					$item->setParentName('more');
					$more_children[] = $item;
				}
			}

		} else {
			// no featured menu items set
			$max_display_items = 5;

			// the first n are shown, rest added to more list
			// if only one item on more menu, stick it with the rest
			$num_menu_items = count($return['default']);
			if ($num_menu_items > ($max_display_items + 1)) {
				$registered = array_splice($return['default'], $max_display_items);
				foreach ($registered as $item) {
					$item->setParentName('more');
					$more_children[] = $item;
				}
			}
		}

		if (!empty($more_children)) {
			$more = ElggMenuItem::factory([
				'name' => 'more',
				'href' => 'javascript:void(0);',
				'text' => elgg_echo('more') . elgg_view_icon('caret-down', ['class' => 'elgg-menu-icon-after']),
				'priority' => 999,
			]);

			$more->setChildren($more_children);

			$return['default'][] = $more;
		}

		// check if we have anything selected
		$selected = false;
		foreach ($return as $section) {
			/* @var ElggMenuItem[] $section */

			foreach ($section as $item) {
				if ($item->getSelected()) {
					$selected = true;
					break 2;
				}
			}
		}

		if (!$selected) {
			// nothing selected, match name to context or match url
			$current_url = current_page_url();
			foreach ($return as $section_name => $section) {
				foreach ($section as $key => $item) {
					// only highlight internal links
					if (strpos($item->getHref(), elgg_get_site_url()) === 0) {
						if ($item->getName() == elgg_get_context()) {
							$return[$section_name][$key]->setSelected(true);
							break 2;
						}
						if ($item->getHref() == $current_url) {
							$return[$section_name][$key]->setSelected(true);
							break 2;
						}
					}
				}
			}
		}

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

			if (elgg_is_active_plugin('notifications')) {
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
	public static function setupWidgetMenu($hook, $type, $return, $params) {

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
	public static function setupUserHoverMenu($hook, $type, $return, $params) {

		$remove = ['activity:owner'];

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
	public static function setupTitleMenu($hook, $type, $return, $params) {

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
	public static function setupExtrasMenu($hook, $type, $return, $params) {

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
	public static function setupPageMenu($hook, $type, $return, $params) {

		$remove = [];

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