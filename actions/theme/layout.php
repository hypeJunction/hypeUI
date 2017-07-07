<?php

$params = get_input('params');

foreach ($params as $name => $value) {
	elgg_set_plugin_setting($name, $value, 'hypeUI');
}

return elgg_ok_response('', elgg_echo('admin:theme:settings_saved'));