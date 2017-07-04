<?php

$groups = elgg_list_entities_from_metadata([
	'types' => 'group',
	'metadata_name_value_pairs' => [
		'featured_group' => 'yes',
	],
	'limit' => 4,
	'list_type' => 'gallery',
	'item_class' => 'is-one-quarter',
	'gallery_class' => 'elgg-cards',
	'order_by' => 'RAND()',
	'card' => true,
	'pagination' => false,
]);

if ($groups) {
	echo elgg_view_module('aside', elgg_echo('groups:featured'), $groups);
}

$blogs = elgg_list_entities_from_annotation_calculation([
	'calculation' => 'sum',
	'annotation_names' => 'likes',
	'types' => 'object',
	'subtypes' => 'blog',
	'limit' => 10,
	'list_type' => 'gallery',
	'gallery_class' => 'elgg-cards',
	'item_class' => 'is-half',
	'pagination' => false,
]);

if ($blogs) {
	echo elgg_view_module('aside', elgg_echo('blogs:popular'), $blogs);
}
