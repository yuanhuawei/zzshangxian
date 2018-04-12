<?php
defined('PHP168_PATH') or die();

$acl = $core->load_acl('core', '', $core->ROLE);
$content = isset($block['content']) ? p8_html_filter($block['content'], $acl['allow_tags'], $acl['disallow_tags']) : '';

return array(
	'name' => $block['name'],
	'alias' => html_entities($block['alias']),
	'content' => $content
);