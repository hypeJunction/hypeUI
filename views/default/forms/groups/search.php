<?php
/**
 * Group search form
 *
 * @uses $vars['entity'] ElggGroup
 */

echo elgg_view('input/hidden', [
	'name' => 'container_guid',
	'value' => $vars['entity']->getGUID(),
]);

?>
<div class="field has-addons">
	<p class="control">
		<?php
		$params = [
			'name' => 'q',
			'class' => 'elgg-input-search mbm',
		];
		echo elgg_view('input/text', $params);
		?>
	</p>
	<p class="control">
		<?php
		echo elgg_view('input/submit', ['value' => elgg_echo('search:go')]);
		?>
	</p>
</div>
