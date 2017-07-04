<?php
/**
 * Group tag-based search form body
 */

?>
<div class="field has-addons">
	<p class="control">
		<?php
		$tag_string = elgg_echo('groups:search:tags');

		$params = [
			'name' => 'tag',
			'class' => 'elgg-input-search mbm',
			'value' => $tag_string,
			'onclick' => "if (this.value=='$tag_string') { this.value='' }",
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
