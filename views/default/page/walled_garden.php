<?php

if (elgg_is_sticky_form('register')) {
	// An error occurred while submitting the registration form in a lightbox
	forward('register');
}

echo elgg_view('page/default', $vars);


