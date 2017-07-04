<?php
/**
 * Body of river item
 *
 * @uses $vars['item']        ElggRiverItem
 * @uses $vars['summary']     Alternate summary (the short text summary of action)
 * @uses $vars['message']     Optional message (usually excerpt of text)
 * @uses $vars['attachments'] Optional attachments (displaying icons or other non-text data)
 * @uses $vars['responses']   Alternate respones (comments, replies, etc.)
 */


$message = elgg_view('river/elements/message', $vars);
$attachments = elgg_view('river/elements/attachments', $vars);

if (!$message && !$attachments) {
	return;
}
?>

<div class="elgg-river-item-body"><?= $message . $attachments ?></div>
