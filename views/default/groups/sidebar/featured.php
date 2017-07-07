<?php
/**
 * Featured groups
 *
 * @package ElggGroups
 */

$featured_groups = elgg_list_entities_from_metadata(array(
	'metadata_name' => 'featured_group',
	'metadata_value' => 'yes',
	'type' => 'group',
	'item_view' => 'object/elements/primer',
));

if ($featured_groups) {
	echo elgg_view_module('aside', elgg_echo("groups:featured"), $featured_groups);
}
