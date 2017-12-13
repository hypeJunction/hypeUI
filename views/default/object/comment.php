<?php

/**
 * Elgg comment view
 *
 * @uses $vars['entity']    ElggComment
 * @uses $vars['full_view'] Display full view or brief view
 */

$full_view = elgg_extract('full_view', $vars, true);

$comment = $vars['entity'];
/* @var ElggComment $comment */

$entity = get_entity($comment->container_guid);
$commenter = get_user($comment->owner_guid);
if (!$entity || !$commenter) {
	return;
}

$commenter_icon = elgg_view_entity_icon($commenter, 'small');

if ($full_view) {
	$vars['title'] = false;

	$comment_text = elgg_view('output/longtext', [
		'value' => $comment->description,
		'class' => 'elgg-inner',
		'data-role' => $comment instanceof ElggDiscussionReply ? 'discussion-reply-text' : 'comment-text',
	]);

	if (elgg_extract('show_attachments', $vars, true)) {
		if (elgg_is_active_plugin('hypeScraper')) {
			$tokens = hypeapps_extract_tokens($comment->description);
			$urls = elgg_extract('urls', $tokens, []);
			if (!empty($urls)) {
				$urls = array_values($urls);
				$comment_text .= elgg_view('output/player', [
					'href' => $urls[0],
					'fallback' => true,
				]);
			}
		}
	}

	$comment_text .= elgg_view_menu('entity_social', [
		'entity' => $comment,
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	]);

	echo elgg_view('object/elements/summary', array_merge($vars, [
		'entity' => $comment,
		'icon' => $commenter_icon,
		'access' => false,
		'content' => false,
		'inline_content' => $comment_text,
		'social' => false,
		'class' => 'elgg-comment',
	]));
} else {

	$friendlytime = elgg_view_friendly_time($comment->time_created);

	$entity_title = $entity->title ? $entity->title : elgg_echo('untitled');
	$entity_link = elgg_view('output/url', [
		'href' => $entity->getURL(),
		'text' => $entity->getDisplayName() ? : elgg_echo('untitled'),
	]);

	$commenter_link = elgg_view('output/url', [
		'text' => $commenter->getDisplayName(),
		'href' => $commenter->getURL(),
	]);

	$excerpt = elgg_get_excerpt($comment->description, 80);
	$posted = elgg_echo('generic_comment:on', [$commenter_link, $entity_link]);

	$body = elgg_format_element('div', [
		'class' => 'elgg-subtext',
	], "$posted ($friendlytime) $excerpt");

	echo elgg_view_image_block($commenter_icon, $body);
}
