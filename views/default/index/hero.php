<?php
$module = elgg_extract('hero_module', $vars);
if (!$module) {
	if (!elgg_is_logged_in()) {
		$title = elgg_extract('title', $vars, elgg_echo('login'));
		$body = elgg_view_form('login');
		$module = elgg_view_module('hero', $title, $body, [
			'class' => 'hero is-white',
		]);
	}
}
?>

<div class="hero is-primary is-fullheight elgg-hero-index">
    <div class="hero-body">
        <div class="container">
            <div class="columns is-vcentered">
                <div class="column is-6">
                    <h1 class="title"><span> Introducing a powerful open source social networking engine </span></h1>
                    <h2 class="subtitle"><span> Providing you with the core components needed to build a socially aware web application </span>
                    </h2>

                    <div class="elgg-hero-calls">
						<?php
						echo elgg_view('output/url', [
							'href' => 'about/download',
							'text' => "Get Elgg",
							'icon' => 'download',
							'class' => 'elgg-button is-dark',
						]);

						echo elgg_view('output/url', [
							'href' => 'http://learn.elgg.org',
							'text' => "Learn More",
							'icon' => 'info-circle',
							'class' => 'elgg-button is-dark',
							'target' => '_blank',
						]);

						echo elgg_view('output/url', [
							'href' => 'http://github.com/elgg/elgg',
							'text' => "Open Source",
							'icon' => 'github',
							'class' => 'elgg-button is-dark',
							'target' => '_blank',
						]);
						?>
                    </div>
                </div>
                <div class="column is-4 is-offset-2">
					<?php
					echo $module;
					?>
                </div>
            </div>
        </div>
    </div>
</div>