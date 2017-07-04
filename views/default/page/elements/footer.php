<?php
/**
 * Page footer
 */
?>
<footer class="elgg-page-footer footer">
    <div class="elgg-inner container">
        <div class="menu columns is-centered">
			<?php
			echo elgg_view_menu('footer', [
				'sort_by' => 'priority',
				'class' => 'elgg-menu-hz column is-one-third has-text-centered',
				'show_section_headers' => false,
			]);
			?>
        </div>
    </div>
</footer>