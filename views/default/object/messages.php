<?php

$full = elgg_extract('full_view', $vars);
$entity = elgg_extract('entity', $vars);

$bulk_actions = (bool)elgg_extract('bulk_actions', $vars, false);

if (!$entity instanceof ElggEntity) {
	return;
}

$class = [];

if ($entity->toId == elgg_get_page_owner_guid()) {
	// received
	$user = get_user($entity->fromId);
	if ($user) {
		$icon = elgg_view_entity_icon($user, 'small');
		$user_link = elgg_view('output/url', [
			'href' => "messages/compose?send_to=$user->guid",
			'text' => $user->name,
			'is_trusted' => true,
		]);
	} else {
		$icon = '';
		$user_link = elgg_echo('messages:deleted_sender');
	}

	if ($entity->readYet) {
		$class[] = 'is-read';
	} else {
		$vars['badges'] = elgg_format_element('span', [
			'class' => 'tag is-small is-warning',
		], elgg_echo('new'));

		$class[] = 'is-unread';
	}

} else {
	// sent
	$user = get_user($entity->toId);

	if ($user) {
		$icon = elgg_view_entity_icon($user, 'small');
		$user_link = elgg_view('output/url', [
			'href' => "messages/compose?send_to=$user->guid",
			'text' => elgg_echo('messages:to_user', [$user->name]),
			'is_trusted' => true,
		]);
	} else {
		$icon = '';
		$user_link = elgg_echo('messages:deleted_sender');
	}

	$class[] = 'is-read';
}

$vars['class'] = $class;
$vars['icon'] = $icon;
$vars['byline'] = $user_link;

if ($full) {
	$vars['responses'] = false;
	if (elgg_get_page_owner_guid() == $entity->toId) {
		$form_params = [
			'id' => 'messages-reply-form',
			'action' => 'action/messages/send',
		];
		$body_params = ['message' => $entity];
		$form = elgg_view_form('messages/reply', $form_params, $body_params);
		$vars['responses'] = elgg_view_module('info', elgg_echo('reply'), $form);
	}
	echo elgg_view('object/elements/full', $vars);
} else {
	$vars['content'] = false;
	$vars['inline_content'] = elgg_get_excerpt($entity->description, 100);

	$listing = elgg_view('object/elements/summary', $vars);
	if ($bulk_actions) {
		$checkbox = elgg_view('input/checkbox', [
			'name' => 'message_id[]',
			'value' => $entity->guid,
			'default' => false
		]);
		?>
        <div class="columns is-vcentered">
			<?= $checkbox ?>
            <div class="column">
				<?= $listing ?>
            </div>
        </div>
		<?php
	}
}
