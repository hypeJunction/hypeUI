<?php

$assets = elgg_get_uploaded_files('assets');

if (empty($assets)) {
	return elgg_error_response(elgg_echo('admin:theme:assets:no_files'));
}

$success = $error = 0;

$dir = elgg_get_config('dataroot');

foreach ($assets as $name => $asset) {
	if (!$asset) {
		continue;
	}
	if (!$asset->isValid()) {
		$error++;
		continue;
	}

	$view = elgg_get_plugin_setting("asset:$name", 'hypeUI');
	if ($view && is_file("$dir$view")) {
		unlink("$dir$view");
		elgg_unset_plugin_setting("asset:$name", 'hypeUI');
	}

	$ext = $asset->getClientOriginalExtension();
	$filename = "$name.$ext";

	if ($asset->move($dir . 'theme', $filename)) {
		elgg_set_plugin_setting("asset:$name", "theme/$filename", 'hypeUI');
		$success++;
	} else {
		$error++;
	}
}

elgg_flush_caches();
_elgg_services()->autoloadManager->deleteCache();

return elgg_ok_response('', elgg_echo('admin:theme:assets:success', [$success, $success + $error]));

