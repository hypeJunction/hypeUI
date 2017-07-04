<?php
/**
 * Main layout content
 */
?>
<div class="elgg-layout-main elgg-main column">
	<div class="elgg-inner">
		<?php
		echo $vars['content'];

		if (isset($vars['area1'])) {
			echo $vars['area1'];
		}
		?>
	</div>
</div>