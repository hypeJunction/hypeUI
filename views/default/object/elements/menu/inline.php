<?php

$toggle = elgg_view('output/url', [
	'href' => 'javascript:void(0);',
	'icon' => 'chevron-down',
	'text' => '',
	'class' => 'elgg-object-menu-toggle',
]);

$entity = elgg_extract('entity', $vars);

$guid = (int)$entity->guid;
$page_owner_guid = (int)elgg_get_page_owner_guid();
$contexts = elgg_get_context_stack();
$input = (array)elgg_get_config("input");

// generate MAC so we don't have to trust the client's choice of contexts
$data = serialize([$guid, $page_owner_guid, $contexts, $input]);
$mac = elgg_build_hmac($data)->getToken();

$attrs = [
	"rel" => $mac,
	'class' => 'elgg-module-popup elgg-object-menu-popup hidden',
];

$menu = elgg_extract('menu', $vars);
$placeholder = elgg_format_element('div', $attrs, $menu);

echo elgg_format_element('div', [
	'class' => 'elgg-object-menu',
], $toggle . $placeholder);

?>
<script>
    require(['object/elements/menu/placeholder']);
</script>