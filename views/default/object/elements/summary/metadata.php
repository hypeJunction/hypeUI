<?php

/**
 * Outputs object metadata
 * @uses $vars['metadata'] Metadata/menu
 */


$social = elgg_extract('social', $vars);
$tags = elgg_view('object/elements/summary/badges', $vars);
$tags .= elgg_extract('tags', $vars);
$categories = elgg_view('output/categories', $vars);

if ($tags || $social || $categories) { ?>
	<div class="elgg-listing-summary-metadata level">
		<div class="level-left">
			<?php if ($tags || $categories) { ?>
				<div class="level-item">
					<?= $tags ?>
					<?= $categories ?>
				</div>
			<?php } ?>
		</div>
		<div class="level-right">
			<?php if ($social) { ?>
				<div class="level-item">
					<?= $social ?>
				</div>
			<?php } ?>
		</div>
	</div>

<?php } ?>