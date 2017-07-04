<?php
/**
 * Reply header
 */

$post = $vars['post'];
$poster = $post->getOwnerEntity();
$poster_details = [
	htmlspecialchars($poster->name, ENT_QUOTES, 'UTF-8'),
	htmlspecialchars($poster->username, ENT_QUOTES, 'UTF-8'),
];
?>
<div class="content">
    <b><?php echo elgg_echo('thewire:replying', $poster_details); ?>: </b>
</div>
<div class="content">
	<?= thewire_filter($post->description) ?>
</div>
