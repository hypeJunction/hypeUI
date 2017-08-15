<?php
/**
 * Display an album in a gallery
 *
 * @uses $vars['entity'] TidypicsAlbum
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$album = elgg_extract('entity', $vars);
/* @var $album TidypicsAlbum */

$cover = $album->getCoverImage();

$vars['media'] = elgg_view_entity_icon($cover, 'large');

echo elgg_view('object/elements/card', $vars);