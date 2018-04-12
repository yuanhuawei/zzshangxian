<?php
defined('PHP168_PATH') or die();

$this_system->set_config(to_installed_charset(array(
	'sitename' => 'PHP168问答系统',
	'sitetitle' => 'PHP168系集CMS、B2B为一集的开发软件公司',
	'meta_keywords' => '模块关键词',
	'meta_description' => '模块描述',
	'allow_anonymous_post' => 1,
	'allow_anonymous_reply' => 0,
	'post_credit' => 3,
	'expired_days' => 30,
	'delete_credit' => 5,
	'reply_credit' => "5\r\n10\r\n15\r\n20\r\n30\r\n40\r\n50",
	'urgent_credit' => 5,
	'best_reply_credit' => '',
	'title_length' => 5,
	'content_min_length' => 2,
	'content_max_length' => 200,
	'perpage' => 25,
	'layout_size' => 10,
	'confirm_number' => 25,
	'confirm_perpage' => 5,
	'confirm_layout_size' => 5,
	'verify' => 1,
	'allow_anonymous_answer' => 1,
	'answer_content_length' => 1000,
	'verify_answer' => 0,
	'allow_anonymous_vote' => 1,
	'search_perpage' => 15,
	'search_layout_size' => 10,
	'history_expired_days' => 2,
	'addition_length' => 150,
	'allow_anonymous_poller' => 1,
	'poller_length' => 100,
	'tags_number' => 500
)));