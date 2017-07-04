<div class="field has-addons">
    <p class="control">
		<?php
		$params = [
			'name' => 'member_query',
			'class' => 'mbm',
			'required' => true,
		];
		echo elgg_view('input/text', $params);
		?>
    </p>
    <p class="control">
		<?php
		echo elgg_view('input/submit', ['value' => elgg_echo('search')]);
		?>
    </p>
</div>
<?php
echo "<p class='mtl elgg-text-help'>" . elgg_echo('members:total', [get_number_users()]) . "</p>";