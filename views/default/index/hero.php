<?php
$module = elgg_extract('hero_module', $vars);
if (!$module) {
	$module = elgg_get_plugin_setting('landing:module', 'hypeUI');
	if ($module) {
		$module = elgg_view('output/longtext', [
			'value' => $module,
		]);
	} else if (!elgg_is_logged_in()) {
		$title = elgg_extract('title', $vars, elgg_echo('login'));
		$body = elgg_view_form('login');
		$module = elgg_view_module('hero', $title, $body, [
			'class' => 'hero is-white',
		]);
	}
}

$style = elgg_get_plugin_setting('style:landing_hero', 'hypeUI', 'primary');

$cover_url = false;
$cover_image_view = elgg_get_plugin_setting('asset:landing_hero', 'hypeUI');

if ($cover_image_view && elgg_view_exists($cover_image_view)) {
	$cover_url = elgg_get_simplecache_url($cover_image_view);
} else if (elgg_view_exists('index/hero.jpg')) {
	$cover_url = elgg_get_simplecache_url('index/hero.jpg');
}

$cover = '';
if ($cover_url) {
	$cover = elgg_format_element('div', [
		'class' => 'elgg-layout-cover',
		'style' => "background-image: url(" . $cover_url . ")"
	]);
}

$site = elgg_get_site_entity();

$title = elgg_get_plugin_setting('landing:title', 'hypeUI', $site->name);
if ($title) {
	$title = elgg_view('output/longtext', [
		'class' => 'title',
		'value' => $title,
	]);
}

$subtitle = elgg_get_plugin_setting('landing:subtitle', 'hypeUI');
if ($subtitle) {
	$subtitle = elgg_view('output/longtext', [
		'class' => 'subtitle',
		'value' => $subtitle,
	]);
}

$info = elgg_get_plugin_setting('landing:info', 'hypeUI');
if ($info) {
	$info = elgg_view('output/longtext', [
		'class' => 'content',
		'value' => $info,
	]);
}

$info .= elgg_view_menu('index', [
	'class' => 'elgg-menu-hz',
	'sort_by' => 'priority',
]);

$attrs = [
	'class' => ['hero', 'is-fullheight', 'elgg-hero-index'],
];

if ($style) {
	$attrs['class'][] = "is-$style";
}
if ($cover) {
	$attrs['class'][] = 'has-cover';
}

$attrs = elgg_format_attributes($attrs);
?>

<div <?= $attrs ?>>
	<?= $cover ?>
    <div class="hero-body">
        <div class="container">
            <div class="columns is-vcentered">
                <div class="column is-6">
					<?php
					echo $title;
					echo $subtitle;
					?>
                    <div class="elgg-hero-calls">
						<?= $info ?>
                    </div>
                </div>
                <div class="column is-4 is-offset-2">
					<?= $module ?>
                </div>
            </div>
        </div>
    </div>
</div>