<?php

echo elgg_view('admin/theme/filter', [
	'selected' => 'assets',
]);

echo elgg_view_form('theme/assets', [
	'enctype' => 'multipart/form-data',
], $vars);
