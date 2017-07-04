<?php
/**
 * Short summary of the action that occurred
 *
 * @vars['item'] ElggRiverItem
 */

$item = elgg_extract('item', $vars);

$subject = $item->getSubjectEntity();
$object = $item->getObjectEntity();

$summary = elgg_extract('summary', $vars);

$prepare_summary_string = function() use ($item, $summary, $subject, $object) {
	if (!empty($summary)) {
		return $summary;
	}

	$subject_link = elgg_view('output/url', [
		'href' => $subject->getURL(),
		'text' => $subject->getDisplayName(),
		'class' => 'elgg-river-subject',
	]);

	$object_link = elgg_view('output/url', [
		'href' => $object->getURL(),
		'text' => elgg_get_excerpt($object->getDisplayName(), 100),
		'class' => 'elgg-river-object',
	]);

	$action = $item->action_type;
	$type = $item->type;
	$subtype = $item->subtype ? $item->subtype : 'default';

	$summary_keys = [
		"river:$action:$type:$subtype",
		"river:$action:$type:default",
		"river:$action:default",
	];

	foreach ($summary_keys as $key) {
		if (elgg_language_key_exists($key)) {
			return elgg_echo($key, [$subject_link, $object_link]);
		}
	}

	return $subject_link;
};

$summary = $prepare_summary_string();
if (!$summary) {
	return;
}

$group_string = '';
$container = $object->getContainerEntity();
if ($container instanceof ElggGroup && $container->guid != elgg_get_page_owner_guid()) {
	$group_link = elgg_view('output/url', [
		'href' => $container->getURL(),
		'text' => $container->getDisplayName(),
	]);
	$group_string = elgg_echo('river:ingroup', [$group_link]);
}

$timestamp = elgg_view('river/elements/timestamp', $vars);

echo elgg_format_element('div', [
	'class' => 'elgg-river-summary',
], "$summary $group_string $timestamp");
