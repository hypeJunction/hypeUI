<?php
/**
 * ElggUpgrade view
 *
 * @package Elgg
 * @subpackage Core
 */

$entity = elgg_extract('entity', $vars);
/* @var $entity ElggUpgrade */

$vars['subtitle'] = false;
$vars['icon'] = false;
$vars['metadata'] = false;

echo elgg_view('object/elements/summary', $vars);
