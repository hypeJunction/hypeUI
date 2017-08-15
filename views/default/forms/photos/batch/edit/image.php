<?php
/**
 * Form component for editing a single image
 *
 * @uses $vars['entity']
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$image = elgg_extract('entity', $vars);
/* @var $image TidypicsImage */

$thumbnail = elgg_view_entity_icon($image, 'small', array('href' => false));

$fields= [];

$fields[] = [
	'#type' => 'text',
	'#label' => elgg_echo('title'),
	'name' => 'title[]',
	'value' => $entity->title,
];

$fields[] = [
	'#type' => 'longtext',
	'#label' => elgg_echo('caption'),
	'name' => 'caption[]',
	'value' => $entity->description,
];

$fields[] = [
	'#type' => 'tags',
	'#label' => elgg_echo('tags'),
	'name' => 'tags[]',
	'value' => $entity->tags,
];

$fields[] = [
	'#type' => 'hidden',
	'name' => 'guid[]',
	'value' => $image->guid,
];

$fieldset = elgg_view_field([
	'#type' => 'fieldset',
	'fields' => $fields,
]);

echo elgg_view_image_block($thumbnail, $fieldset);