<?php
/**
 * Message for non-members on closed membership group profile pages.
 *
 * @package ElggGroups
 */

?>
<div class="message is-danger">
    <div class="message-body">
        <p>
			<?php
			echo elgg_echo('groups:closedgroup');
			if (elgg_is_logged_in()) {
				echo ' ' . elgg_echo('groups:closedgroup:request');
			}
			?>
        </p>
    </div>
</div>
