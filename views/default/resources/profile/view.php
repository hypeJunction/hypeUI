<?php

$username = elgg_extract('username', $vars);
$user = get_user_by_username($username);

if (!$user) {
	forward('', '404');
}

elgg_set_page_owner_guid($user->guid);

$content = elgg_view('profile/layout', [
	'entity' => $user,
]);

$body = elgg_view_layout('default', array(
	'content' => $content,
	'title' => $user->getDisplayName(),
	'entity' => $user,
));

echo elgg_view_page($user->name, $body, 'default', [
	'entity' => $user,
]);
