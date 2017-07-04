<?php
/**
 * Topic is closed
 */
echo "<div class=\"message is-danger\">";
	echo "<h3 class='message-header'>" . elgg_echo("discussion:topic:closed:title") . "</h3>";
	echo "<p class='message-body'>" . elgg_echo("discussion:topic:closed:desc") . "</p>";
echo "</div>";