<?php
/**
 * Elgg login form
 *
 * @package    Elgg
 * @subpackage Core
 */

?>
    <div class="elgg-body">
		<?php
		echo elgg_view_menu('login', [
			'sort_by' => 'priority',
			'class' => 'elgg-menu-hz',
		]);

		echo elgg_view_field([
			'#type' => 'text',
			'name' => 'username',
			'required' => true,
			//'#label' => elgg_echo('loginusername'),
            'icon' => 'user',
			'tabindex' => 1,
            'class' => 'is-large',
		]);

		echo elgg_view_field([
			'#type' => 'password',
			'name' => 'password',
			'required' => true,
			//'#label' => elgg_echo('password'),
			'class' => 'is-large',
            'icon' => 'key',
			'tabindex' => 2,
		]);
		?>
        <div class="level">
            <div class="level-left">
                <div class="level-item">
					<?php
					echo elgg_view_field([
						'#type' => 'checkbox',
						'label' => elgg_echo('user:persistent'),
						'name' => 'persistent',
						'value' => true,
						'tabindex' => 3,
					]);
					?>
                </div>
            </div>
            <div class="level-right">
                <div class="level-item">
					<?php
					echo elgg_view('output/url', [
						'href' => 'forgotpassword',
						'text' => elgg_echo('user:password:lost'),
						'class' => 'forgot_link elgg-account-help-fortgot-password',
						'tabindex' => 5,
					]);
					?>
                </div>
            </div>
        </div>
		<?php
		echo elgg_view('login/extend', $vars);
		?>
    </div>

<?php
if (isset($vars['returntoreferer'])) {
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'returntoreferer',
		'value' => 'true'
	]);
}

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('login'),
	'tabindex' => 4,
]);

if (elgg_get_config('allow_registration')) {
	$register_link = elgg_view('output/url', [
		'href' => elgg_get_registration_url(),
		'text' => elgg_echo('register'),
		'class' => 'registration_link elgg-account-help-registration-link',
	]);
	$register = elgg_echo('core:account:help:register', [$register_link]);
	$footer .= elgg_format_element('div', [
		'class' => 'elgg-account-help-register',
	], $register);
}

$footer .= elgg_view('login/extend/footer', $vars);

elgg_set_form_footer($footer);
