<?php

$topbar = elgg_extract('topbar', $vars);
if ($topbar === false) {
	return;
}

$walled = elgg_get_config('walled_garden') && !elgg_is_logged_in();
$position = elgg_get_plugin_setting('site_menu_position', 'hypeUI', 'topbar');
$style = elgg_get_plugin_setting('style:topbar', 'hypeUI', 'primary');

$class = elgg_in_context('admin') ? 'is-dark' : "is-$style";
?>
    <div class="elgg-page-nav hero <?= $class ?>">
        <div class="elgg-page-topbar">
            <div class="nav has-shadow">
                <div class="container">
                    <div class="nav-item">
						<?= elgg_view('page/elements/topbar_logo') ?>
                    </div>

                    <div class="nav-left">
						<?php
						if (!$walled && $position == 'topbar') {
							echo elgg_view_menu('site', [
								'sort_by' => 'priority',
								'class' => 'is-hidden-mobile',
								'item_class' => 'nav-item',
								'menu_view' => 'navigation/menu/topbar',
							]);
						}
						?>
                    </div>

                    <div class="nav-right">
						<?php
						echo elgg_view_menu('topbar', [
							'sort_by' => 'priority',
							'class' => 'is-hidden-mobile',
							'item_class' => 'nav-item',
						]);
						?>
                    </div>

                    <span class="nav-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
                </div>
            </div>
        </div>

        <div class="elgg-page-navbar is-hidden-tablet">
            <div class="container">
				<?php
				$extras = [];
				if (!$walled) {
					$site_items = elgg()->menus->getUnpreparedMenu('site')->getItems();
				} else {
					$site_items = [];
				}
				$topbar_items = elgg()->menus->getUnpreparedMenu('topbar')->getItems();
				$items = array_merge($site_items, $topbar_items);

				foreach ($items as $item) {
					/* @var $item ElggMenuItem */
					if ($item->getChildren()) {
						continue;
					}
					$item->setParentName(false);
					$item->setSection('default');
					$extras[] = $item;
				}

				echo elgg_view_menu('mobile', [
					'items' => $extras,
					'sort_by' => 'priority',
					'item_class' => 'nav-item',
					'menu_view' => 'navigation/menu/topbar',
				]);

				?>
            </div>
        </div>
		<?php
		if (!elgg_is_logged_in()) {
			$box = elgg_format_element('div', [
				'id' => 'login-box',
			], elgg_view('core/account/login_box'));
			echo elgg_format_element('div', [
				'class' => 'is-hidden',
			], $box);
		}
		?>
    </div>
<?php
if (!$walled && $position == 'navbar') {
	$style = elgg_get_plugin_setting('style:navbar', 'hypeUI', 'primary');
	$class = elgg_in_context('admin') ? 'is-dark' : "is-$style";
	?>
    <div class="elgg-page-nav hero is-alternate <?= $class ?> is-hidden-mobile">
        <div class="elgg-page-topbar">
            <div class="nav has-shadow">
                <div class="container">
                    <div class="nav-left">
						<?php
						echo elgg_view_menu('site', [
							'sort_by' => 'priority',
							'item_class' => 'nav-item',
							'menu_view' => 'navigation/menu/topbar',
						]);
						?>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php
}


