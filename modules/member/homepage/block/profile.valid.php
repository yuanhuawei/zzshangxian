<?php
defined('PHP168_PATH') or die();

$item_count = isset($block['item_count']) ? $block['item_count'] : 5;

return array(
	'name' => $block['name'],
	'alias' => html_entities($block['alias'])
);