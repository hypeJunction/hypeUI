<?php
/**
 * Summary of an image for lists/galleries
 *
 * @uses $vars['entity'] TidypicsImage
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$entity = elgg_extract('entity', $vars);
$vars['media'] = elgg_view_entity_icon($entity, 'large');

echo elgg_view('object/elements/card', $vars);