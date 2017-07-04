<?php

$full = elgg_extract('full_view', $vars);
$entity = elgg_extract('entity', $vars);

if (!$entity instanceof ElggEntity) {
	return;
}

$vars['responses'] = function($entity, $full) {

	if ($full) {
		$content = elgg_view('discussion/replies', [
			'topic' => $entity,
			'show_add_form' => $entity->canWriteToContainer(0, 'object', 'discussion_reply') && $entity->status != 'closed',
		]);

		if ($entity->status == 'closed') {
			$content .= elgg_view('discussion/closed');
		}

		return $content;
	} else {
		$last_reply = elgg_get_entities([
			'type' => 'object',
			'subtype' => 'discussion_reply',
			'container_guid' => $entity->guid,
			'limit' => 1,
			'distinct' => false,
		]);

		if ($last_reply) {
			$last_reply = array_shift($last_reply);
			/* @var ElggDiscussionReply $last_reply */

			$poster = $last_reply->getOwnerEntity();
			$reply_time = elgg_view_friendly_time($last_reply->time_created);

			return elgg_view('output/url', [
				'text' => elgg_echo('discussion:updated', [$poster->name, $reply_time]),
				'href' => $last_reply->getURL(),
				'is_trusted' => true,
			]);
		}
	}
};

if ($entity->status == 'closed') {
	$vars['badges'] = elgg_format_element('span', [
		'class' => 'tag is-danger',
	], elgg_view_icon('lock'));
}

if ($full) {
	echo elgg_view('object/elements/full', $vars);
} elseif (elgg_in_context('gallery')) {
	echo elgg_view('object/elements/card', $vars);
} else {
	echo elgg_view('object/elements/summary', $vars);
}