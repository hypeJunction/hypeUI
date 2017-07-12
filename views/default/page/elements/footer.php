<?php
/**
 * Page footer
 */

$footer = elgg_extract('footer', $vars);
if ($footer === false) {
	return;
}
?>
<footer class="elgg-page-footer footer">
    <div class="elgg-inner container">
        <div class="columns is-centered">
            <div class="column">
				<?php
				$info = elgg_get_plugin_setting('footer', 'hypeUI');
				if ($info) {
					$info = elgg_view('output/longtext', [
						'class' => 'content',
						'value' => $info,
					]);
				}
				?>
            </div>
        </div>
        <div class="columns is-centered is-multiline">
			<?php
			if ($footer) {
				echo $footer;
			}
			echo elgg_view('page/elements/footer/extend', $vars);
			?>
        </div>
        <div class="menu columns is-centered">
			<?php
			echo elgg_view_menu('footer', [
				'sort_by' => 'priority',
				'class' => 'elgg-menu-hz column is-one-third',
				'show_section_headers' => false,
			]);
			?>
        </div>
    </div>
</footer>