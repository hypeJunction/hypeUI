<?php

$entity = elgg_extract('entity', $vars);

if ($entity->isPublicMembership()) {
	$membership = elgg_echo("groups:open");
	$class = 'is-success';
} else {
	$membership = elgg_echo("groups:closed");
	$class = 'is-danger';
}

$vars['badges'] = elgg_format_element('span', [
	'class' => ['tag', $class],
], $membership);

echo elgg_view('page/components/list_item', $vars);