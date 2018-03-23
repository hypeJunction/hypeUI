<?php

if (!isset($vars['full_view'])) {
	$vars['full_view'] = true;
}

echo elgg_view('object/comment', $vars);