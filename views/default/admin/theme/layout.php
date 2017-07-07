<?php

echo elgg_view('admin/theme/filter', [
	'selected' => 'layout',
]);

echo elgg_view_form('theme/layout', [
	'enctype' => 'multipart/form-data',
], $vars);
