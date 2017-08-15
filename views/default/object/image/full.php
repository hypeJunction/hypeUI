<?php
/**
 * Full view of an image
 *
 * @uses $vars['entity'] TidypicsImage
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$image = $photo = $vars['entity'];
$album = $image->getContainerEntity();

ob_start();

echo '<div class="tidypics-photo-wrapper center">';
if ($album->getSize() > 1) {
	echo elgg_view('object/image/navigation', $vars);
}
echo elgg_view('photos/tagging/help', $vars);
echo elgg_view('photos/tagging/select', $vars);
echo elgg_view_entity_icon($image, 'large', array(
	'href' => $image->getIconURL('master'),
	'img_class' => 'tidypics-photo',
	'link_class' => 'tidypics-lightbox',
));
echo elgg_view('photos/tagging/tags', $vars);
echo '</div>';

$vars['attachments'] = ob_get_clean();

echo elgg_view('object/elements/full', $vars);

