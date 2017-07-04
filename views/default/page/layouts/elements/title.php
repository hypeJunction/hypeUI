<?php
/**
 * Layout title
 */
$header = elgg_extract('header', $vars);

if (isset($header)) {
	echo $header;
}

$owner = elgg_get_page_owner_entity();
if (!elgg_in_context('admin') && $owner) {
	$icon = elgg_view_entity_icon($owner, 'medium');
	$title = elgg_format_element('div', [
		'class' => 'elgg-heading-main title is-1',
	], $owner->getDisplayName());
	$subtitle = '';
	if ($owner->briefdescription) {
		$subtitle = elgg_format_element('div', [
			'class' => 'subtitle is-4',
		], $owner->briefdescription);
	}
	$title = elgg_view_image_block($icon, $title . $subtitle, [
		'class' => 'is-vcentered',
	]);

} else {
	$title = elgg_extract('title', $vars, '');
	if ($title) {
		$title = elgg_view_title($title, [
			'class' => 'elgg-heading-main title is-1',
		]);
	}
	$subtitle = elgg_extract('subtitle', $vars);
	if ($subtitle) {
		$subtitle = elgg_format_element('div', [
			'class' => 'subtitle is-4',
		], $subtitle);
	}

	$title = elgg_format_element('div', [], $title . $subtitle);
}

?>
<div class="elgg-layout-title">
    <div class="elgg-inner container">
		<?= $title ?>
    </div>
</div>
