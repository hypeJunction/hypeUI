<?php
/**
 * Full view of an album
 *
 * @uses    $vars['entity'] TidypicsAlbum
 *
 * @author  Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$album = elgg_extract('entity', $vars);
/* @var $album TidypicsAlbum */

$images = $album->getImageList();
$vars['attachments'] = elgg_list_entities([
	'guids' => $images ? : [0],
	'limit' => (int) get_input('limit', 16),
	'offset' => (int) get_input('offset', 0),
	'full_view' => false,
	'list_type' => 'gallery',
	'list_type_toggle' => false,
	'pagination' => true,
	'pagination_type' => 'infinite',
	'gallery_class' => 'elgg-cards',
]);

echo elgg_view('object/elements/full', $vars);
