<?php

$notices = elgg_get_admin_notices();
if ($notices) {
	foreach ($notices as $notice) {
		$notices_html .= elgg_view_entity($notice);
	}

	$notices_html = "<div class=\"elgg-admin-notices\">$notices_html</div>";
	$content = elgg_extract('content', $vars);
	$vars['content'] = $notices_html . $content;
}

echo elgg_view('page/layouts/default', $vars);