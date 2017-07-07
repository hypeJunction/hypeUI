<?php
/**
 * Layout header
 */

$header = elgg_extract('header', $vars);
if ($header === false) {
	return;
}

$attrs = [
	'class' => ['elgg-layout-header', 'hero'],
];

$cover = '';
$has_cover_class = '';
$cover_url = elgg_extract('cover_url', $vars);

if (!$cover_url) {
	$owner = elgg_get_page_owner_entity();
	if ($owner && $owner->hasIcon('large', 'cover')) {
		$cover_url = $owner->getIconURL([
			'size' => 'large',
			'type' => 'cover',
		]);
	}
}

if ($cover_url) {
	$cover = elgg_format_element('div', [
		'class' => 'elgg-layout-cover',
		'style' => "background-image:url($cover_url);"
	]);
	$attrs['class'][] = 'is-dark';
	$attrs['class'][] = 'has-cover';
} else {
	$style = elgg_get_plugin_setting('style:header', 'hypeUI', 'light');
	$attrs['class'][] = "is-$style";
}

$attrs = elgg_format_attributes($attrs);
?>
<div <?= $attrs ?>>
	<?= $cover ?>
    <div class="hero-body">
        <div class="elgg-inner container">
			<?php
			echo elgg_view('page/layouts/elements/title', $vars);
			?>
        </div>
    </div>
    <div class="hero-foot">
		<?= elgg_view('page/layouts/elements/owner_block', $vars) ?>
    </div>
</div>
