-- <?php exit;?>

REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', '', 1, '', 'a:2:{s:13:"admin_actions";a:4:{s:10:"statistics";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:9:"cache_all";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'answer', 1, '', 'a:5:{s:13:"admin_actions";a:6:{s:6:"verify";b:0;s:4:"edit";b:0;s:6:"poller";b:0;s:6:"delete";b:0;s:4:"list";b:0;s:7:"against";b:0;}s:7:"actions";a:9:{s:4:"post";b:1;s:11:"post_follow";b:1;s:3:"fen";b:1;s:4:"vote";b:1;s:6:"poller";b:1;s:6:"verify";b:1;s:4:"edit";b:1;s:6:"delete";b:1;s:15:"set_best_answer";b:1;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:5:{s:4:"post";b:1;s:11:"post_follow";b:1;s:3:"fen";b:1;s:4:"vote";b:1;s:6:"poller";b:1;}}}s:21:"my_category_to_verify";a:0:{}s:19:"my_addible_category";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'category', 1, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"insert";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:7:"set_acl";b:0;s:5:"cache";b:0;}s:7:"actions";a:2:{s:4:"main";b:1;s:3:"get";b:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'item', 1, '', 'a:5:{s:13:"admin_actions";a:18:{s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"verify";b:0;s:9:"recommend";b:0;s:6:"closed";b:0;s:6:"answer";b:0;s:13:"answer_delete";b:0;s:12:"answer_audit";b:0;s:11:"answer_best";b:0;s:11:"answer_vote";b:0;s:14:"answer_content";b:0;s:12:"item_against";b:0;s:14:"answer_against";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:6:"sphinx";b:0;s:5:"label";b:0;}s:7:"actions";a:8:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"poller";b:1;s:6:"search";b:1;s:6:"verify";b:1;s:4:"edit";b:1;s:6:"delete";b:1;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:4:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"poller";b:1;}}}s:21:"my_category_to_verify";a:0:{}s:19:"my_addible_category";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'member', 1, '', 'a:2:{s:13:"admin_actions";a:5:{s:4:"list";b:0;s:8:"expertor";b:0;s:4:"star";b:0;s:5:"label";b:0;s:4:"post";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', '', 1, '', 'a:2:{s:13:"admin_actions";a:4:{s:4:"html";b:0;s:13:"index_to_html";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'assist_category', 1, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"list";b:0;s:12:"content_list";b:0;s:5:"label";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'category', 1, '', 'a:2:{s:13:"admin_actions";a:8:{s:4:"list";b:1;s:3:"add";b:1;s:6:"update";b:1;s:5:"cache";b:1;s:5:"merge";b:1;s:7:"set_acl";b:1;s:6:"delete";b:1;s:5:"clone";b:1;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'item', 1, '', 'a:5:{s:13:"admin_actions";a:23:{s:6:"config";b:1;s:3:"add";b:1;s:6:"verify";b:1;s:4:"move";b:1;s:4:"list";b:1;s:6:"update";b:1;s:6:"delete";b:1;s:7:"comment";b:1;s:14:"verify_comment";b:1;s:14:"delete_comment";b:1;s:12:"list_to_html";b:1;s:12:"view_to_html";b:1;s:9:"attribute";b:1;s:13:"attribute_acl";b:1;s:5:"label";b:1;s:10:"list_order";b:1;s:7:"set_acl";b:1;s:4:"mood";b:1;s:6:"spider";b:1;s:3:"tag";b:1;s:12:"cluster_push";b:1;s:5:"clone";b:1;s:11:"create_time";b:1;}s:7:"actions";a:11:{s:6:"search";b:1;s:4:"list";b:1;s:4:"view";b:1;s:7:"comment";b:1;s:3:"add";b:1;s:10:"autoverify";b:1;s:6:"update";b:1;s:6:"delete";b:1;s:6:"verify";b:1;s:9:"attribute";b:1;s:11:"create_time";b:1;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:3:"add";b:1;}}}s:19:"my_addible_category";a:1:{i:0;i:1;}s:21:"my_category_to_verify";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'model', 1, '', 'a:2:{s:13:"admin_actions";a:10:{s:3:"add";b:1;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"manage";b:0;s:6:"export";b:0;s:6:"import";b:0;s:9:"add_field";b:0;s:12:"update_field";b:0;s:12:"delete_field";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'statistic', 1, '', 'a:2:{s:13:"admin_actions";a:1:{s:4:"list";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', '', 1, '', 'a:4:{s:13:"admin_actions";a:33:{s:5:"login";b:1;s:3:"log";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:13:"set_admin_acl";b:0;s:8:"memcache";b:0;s:8:"db_slave";b:0;s:4:"menu";b:0;s:15:"navigation_menu";b:0;s:11:"member_menu";b:0;s:11:"system_list";b:0;s:11:"module_list";b:0;s:11:"plugin_list";b:0;s:6:"plugin";b:0;s:14:"install_system";b:0;s:16:"uninstall_system";b:0;s:14:"install_module";b:0;s:16:"uninstall_module";b:0;s:14:"install_plugin";b:0;s:16:"uninstall_plugin";b:0;s:5:"cache";b:1;s:7:"phpinfo";b:0;s:8:"template";b:0;s:11:"base_config";b:0;s:13:"global_config";b:0;s:10:"reg_config";b:0;s:15:"homepage_config";b:0;s:7:"stop_ip";b:0;s:8:"allow_ip";b:0;s:11:"word_filter";b:0;s:16:"connection_flood";b:0;s:9:"md5_files";b:0;s:4:"area";b:0;}s:7:"actions";a:0:{}s:10:"allow_tags";a:0:{}s:13:"disallow_tags";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', '46', 1, '', 'a:2:{s:13:"admin_actions";a:2:{s:2:"ad";b:0;s:3:"buy";b:0;}s:7:"actions";a:2:{s:4:"list";b:1;s:3:"buy";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'credit', 1, '', 'a:2:{s:13:"admin_actions";a:9:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:9:"list_rule";b:0;s:8:"add_rule";b:0;s:11:"update_rule";b:0;s:11:"delete_rule";b:0;s:5:"cache";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'crontab', 1, '', 'a:2:{s:13:"admin_actions";a:5:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:3:"run";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'cservice', 1, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:4:"list";b:0;}s:7:"actions";a:1:{s:12:"admin_replay";b:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'dbm', 1, '', 'a:2:{s:13:"admin_actions";a:1:{s:0:"";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'discuzx', 1, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'forms', 1, '', 'a:5:{s:13:"admin_actions";a:6:{s:6:"config";b:0;s:4:"list";b:0;s:5:"model";b:0;s:5:"field";b:0;s:5:"label";b:0;s:6:"import";b:0;}s:7:"actions";a:8:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;s:8:"download";b:0;s:11:"import_list";b:0;s:10:"authmanage";b:0;s:6:"manage";b:0;}s:12:"category_acl";a:55:{i:0;a:1:{s:7:"actions";a:2:{s:4:"post";b:1;s:6:"search";b:1;}}i:1;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:26;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:8;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:17;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:10;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:11;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:13;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:14;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:15;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:18;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:19;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:20;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:21;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:22;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:16;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:24;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:7;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:2;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:3;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:4;a:1:{s:7:"actions";a:1:{s:4:"view";b:1;}}i:39;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:5;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:6;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:9;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:23;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:25;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:27;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:28;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:29;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:30;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:32;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:33;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:34;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:37;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:38;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:40;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:41;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:42;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:43;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:44;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:45;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:46;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:47;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:48;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:49;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:50;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:51;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:52;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:65;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:66;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:70;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}i:71;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}i:72;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}i:76;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}}s:15:"my_forms_manage";a:0:{}s:13:"my_forms_post";a:1:{i:0;i:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'friendlink', 1, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"link";b:0;s:5:"label";b:0;s:4:"sort";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'guestbook', 1, '', 'a:2:{s:13:"admin_actions";a:4:{s:6:"config";b:0;s:4:"list";b:0;s:5:"label";b:0;s:8:"category";b:0;}s:7:"actions";a:7:{s:4:"view";b:1;s:4:"post";b:1;s:10:"autoverify";b:0;s:6:"verify";b:0;s:5:"reply";b:0;s:4:"edit";b:0;s:6:"delete";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'interview', 1, '', 'a:2:{s:13:"admin_actions";a:3:{s:6:"config";b:0;s:12:"list_subject";b:0;s:11:"add_subject";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'label', 1, '', 'a:3:{s:13:"admin_actions";a:6:{s:4:"list";b:1;s:3:"add";b:1;s:6:"update";b:1;s:5:"cache";b:1;s:6:"delete";b:1;s:7:"set_acl";b:1;}s:7:"actions";a:0:{}s:5:"scope";a:1:{s:5:"sites";a:1:{s:1:"*";a:1:{s:0:"";b:1;}}}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'letter', 1, '', 'a:4:{s:7:"actions";a:10:{s:4:"list";b:1;s:4:"post";b:1;s:4:"view";b:1;s:7:"manager";b:1;s:9:"delletter";b:0;s:4:"edit";b:0;s:8:"turnover";b:0;s:6:"vefify";b:0;s:7:"endtime";b:0;s:7:"display";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"post";b:1;s:4:"view";b:1;}}}s:16:"my_letter_manage";a:3:{s:4:"list";a:1:{i:0;i:0;}s:4:"post";a:1:{i:0;i:0;}s:4:"view";a:1:{i:0;i:0;}}s:13:"admin_actions";a:3:{s:6:"config";b:0;s:4:"list";b:0;s:10:"statistics";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'mail', 1, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:4:"test";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'member', 1, '', 'a:2:{s:13:"admin_actions";a:12:{s:6:"config";b:0;s:3:"add";b:0;s:8:"add_list";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:10:"batch_send";b:0;s:6:"credit";b:0;s:8:"recharge";b:0;s:8:"buy_role";b:0;s:9:"integrate";b:0;s:10:"transition";b:0;}s:7:"actions";a:1:{s:12:"address_list";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'message', 1, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:10:"batch_send";b:0;}s:7:"actions";a:1:{s:4:"send";b:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'notify', 1, '', 'a:2:{s:13:"admin_actions";a:2:{s:3:"add";b:0;s:4:"send";b:0;}s:7:"actions";a:6:{s:3:"add";b:0;s:4:"send";b:1;s:4:"show";b:1;s:4:"edit";b:0;s:6:"resend";b:0;s:7:"message";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'opinion', 1, '', 'a:2:{s:7:"actions";a:4:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"manage";b:0;}s:13:"admin_actions";a:3:{s:6:"config";b:0;s:4:"item";b:0;s:4:"list";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'page', 1, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"config";b:0;s:4:"list";b:0;s:3:"add";b:0;s:4:"edit";b:0;s:6:"delete";b:0;s:4:"html";b:0;}s:7:"actions";a:1:{s:10:"addcontent";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'pay', 1, '', 'a:2:{s:13:"admin_actions";a:5:{s:6:"config";b:0;s:9:"interface";b:0;s:5:"order";b:0;s:10:"view_order";b:0;s:19:"update_order_status";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'role', 1, '', 'a:2:{s:13:"admin_actions";a:11:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:10:"list_group";b:0;s:9:"add_group";b:0;s:12:"update_group";b:0;s:15:"add_group_field";b:0;s:18:"update_group_field";b:0;s:8:"copy_acl";b:0;s:5:"cache";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'shortcutsms', 1, '', 'a:2:{s:7:"actions";a:1:{s:6:"client";b:0;}s:13:"admin_actions";a:2:{s:6:"client";b:0;s:6:"config";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'sms', 1, '', 'a:2:{s:13:"admin_actions";a:2:{s:14:"list_interface";b:0;s:4:"test";b:1;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'special', 1, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"config";b:0;s:5:"label";b:0;s:3:"add";b:0;s:6:"delete";b:0;s:4:"edit";b:0;s:8:"category";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'spider', 1, '', 'a:2:{s:13:"admin_actions";a:4:{s:8:"category";b:0;s:4:"rule";b:0;s:4:"item";b:0;s:4:"walk";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'survey', 1, '', 'a:2:{s:7:"actions";a:4:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"manage";b:0;}s:13:"admin_actions";a:3:{s:6:"config";b:0;s:4:"item";b:0;s:4:"list";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'uchome', 1, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'uploader', 1, '', 'a:2:{s:13:"admin_actions";a:4:{s:6:"config";b:0;s:11:"role_filter";b:0;s:4:"list";b:0;s:6:"delete";b:0;}s:7:"actions";a:6:{s:4:"list";b:0;s:6:"upload";b:1;s:6:"mylist";b:1;s:7:"capture";b:1;s:9:"image_cut";b:1;s:6:"delete";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'vote', 1, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"vote";b:0;s:8:"truncate";b:0;s:6:"delete";b:0;}s:7:"actions";a:2:{s:11:"view_result";b:1;s:5:"voter";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'xspace', 1, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', '', 2, '', 'a:2:{s:13:"admin_actions";a:4:{s:10:"statistics";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:9:"cache_all";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'answer', 2, '', 'a:5:{s:13:"admin_actions";a:6:{s:6:"verify";b:0;s:4:"edit";b:0;s:6:"poller";b:0;s:6:"delete";b:0;s:4:"list";b:0;s:7:"against";b:0;}s:7:"actions";a:9:{s:4:"post";b:1;s:11:"post_follow";b:1;s:3:"fen";b:1;s:4:"vote";b:1;s:6:"poller";b:1;s:6:"verify";b:0;s:4:"edit";b:0;s:6:"delete";b:0;s:15:"set_best_answer";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:5:{s:4:"post";b:1;s:11:"post_follow";b:1;s:3:"fen";b:1;s:4:"vote";b:1;s:6:"poller";b:1;}}}s:21:"my_category_to_verify";a:0:{}s:19:"my_addible_category";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'category', 2, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"insert";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:7:"set_acl";b:0;s:5:"cache";b:0;}s:7:"actions";a:2:{s:4:"main";b:1;s:3:"get";b:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'item', 2, '', 'a:5:{s:13:"admin_actions";a:18:{s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"verify";b:0;s:9:"recommend";b:0;s:6:"closed";b:0;s:6:"answer";b:0;s:13:"answer_delete";b:0;s:12:"answer_audit";b:0;s:11:"answer_best";b:0;s:11:"answer_vote";b:0;s:14:"answer_content";b:0;s:12:"item_against";b:0;s:14:"answer_against";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:6:"sphinx";b:0;s:5:"label";b:0;}s:7:"actions";a:8:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"poller";b:1;s:6:"search";b:1;s:6:"verify";b:0;s:4:"edit";b:0;s:6:"delete";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:4:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"poller";b:1;}}}s:21:"my_category_to_verify";a:0:{}s:19:"my_addible_category";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'member', 2, '', 'a:2:{s:13:"admin_actions";a:5:{s:4:"list";b:0;s:8:"expertor";b:0;s:4:"star";b:0;s:5:"label";b:0;s:4:"post";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', '', 2, '', 'a:2:{s:13:"admin_actions";a:4:{s:4:"html";b:0;s:13:"index_to_html";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'assist_category', 2, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"list";b:0;s:12:"content_list";b:0;s:5:"label";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'category', 2, '', 'a:2:{s:13:"admin_actions";a:7:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:5:"cache";b:0;s:5:"merge";b:0;s:7:"set_acl";b:0;s:6:"delete";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'item', 2, '', 'a:5:{s:13:"admin_actions";a:21:{s:6:"config";b:0;s:3:"add";b:0;s:6:"verify";b:0;s:4:"move";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:7:"comment";b:0;s:14:"verify_comment";b:0;s:14:"delete_comment";b:0;s:12:"list_to_html";b:0;s:12:"view_to_html";b:0;s:9:"attribute";b:0;s:13:"attribute_acl";b:0;s:5:"label";b:0;s:10:"list_order";b:0;s:7:"set_acl";b:0;s:4:"mood";b:0;s:6:"spider";b:0;s:3:"tag";b:0;s:12:"cluster_push";b:0;}s:7:"actions";a:11:{s:6:"search";b:1;s:4:"list";b:1;s:4:"view";b:1;s:7:"comment";b:0;s:3:"add";b:0;s:10:"autoverify";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"verify";b:0;s:9:"attribute";b:0;s:11:"create_time";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}}s:19:"my_addible_category";a:0:{}s:21:"my_category_to_verify";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'model', 2, '', 'a:2:{s:13:"admin_actions";a:10:{s:3:"add";b:1;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"manage";b:0;s:6:"export";b:0;s:6:"import";b:0;s:9:"add_field";b:0;s:12:"update_field";b:0;s:12:"delete_field";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'statistic', 2, '', 'a:2:{s:13:"admin_actions";a:1:{s:4:"list";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', '', 2, '', 'a:4:{s:13:"admin_actions";a:33:{s:5:"login";b:0;s:3:"log";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:13:"set_admin_acl";b:0;s:8:"memcache";b:0;s:8:"db_slave";b:0;s:4:"menu";b:0;s:15:"navigation_menu";b:0;s:11:"member_menu";b:0;s:11:"system_list";b:0;s:11:"module_list";b:0;s:11:"plugin_list";b:0;s:6:"plugin";b:0;s:14:"install_system";b:0;s:16:"uninstall_system";b:0;s:14:"install_module";b:0;s:16:"uninstall_module";b:0;s:14:"install_plugin";b:0;s:16:"uninstall_plugin";b:0;s:5:"cache";b:0;s:7:"phpinfo";b:0;s:8:"template";b:0;s:11:"base_config";b:0;s:13:"global_config";b:0;s:10:"reg_config";b:0;s:15:"homepage_config";b:0;s:7:"stop_ip";b:0;s:8:"allow_ip";b:0;s:11:"word_filter";b:0;s:16:"connection_flood";b:0;s:9:"md5_files";b:0;s:4:"area";b:0;}s:7:"actions";a:0:{}s:10:"allow_tags";a:0:{}s:13:"disallow_tags";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', '46', 2, '', 'a:2:{s:13:"admin_actions";a:2:{s:2:"ad";b:0;s:3:"buy";b:0;}s:7:"actions";a:2:{s:4:"list";b:1;s:3:"buy";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'credit', 2, '', 'a:2:{s:13:"admin_actions";a:9:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:9:"list_rule";b:0;s:8:"add_rule";b:0;s:11:"update_rule";b:0;s:11:"delete_rule";b:0;s:5:"cache";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'crontab', 2, '', 'a:2:{s:13:"admin_actions";a:5:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:3:"run";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'cservice', 2, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:4:"list";b:0;}s:7:"actions";a:1:{s:12:"admin_replay";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'dbm', 2, '', 'a:2:{s:13:"admin_actions";a:1:{s:0:"";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'discuzx', 2, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'forms', 2, '', 'a:5:{s:13:"admin_actions";a:5:{s:6:"config";b:0;s:4:"list";b:0;s:5:"model";b:0;s:5:"field";b:0;s:5:"label";b:0;}s:7:"actions";a:8:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;s:8:"download";b:0;s:11:"import_list";b:0;s:10:"authmanage";b:0;s:6:"manage";b:0;}s:12:"category_acl";a:55:{i:0;a:1:{s:7:"actions";a:2:{s:4:"post";b:1;s:6:"search";b:1;}}i:1;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:26;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:8;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:17;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:10;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:11;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:13;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:14;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:15;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:18;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:19;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:20;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:21;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:22;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:16;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:24;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:7;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:2;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:3;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:4;a:1:{s:7:"actions";a:1:{s:4:"view";b:1;}}i:39;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:5;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:6;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:9;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:23;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:25;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:27;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:28;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:29;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:30;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:32;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:33;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:34;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:37;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:38;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:40;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:41;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:42;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:43;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:44;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:45;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:46;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:47;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:48;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:49;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:50;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:51;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:52;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:65;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:66;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:70;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}i:71;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}i:72;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}i:76;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}}s:15:"my_forms_manage";a:0:{}s:13:"my_forms_post";a:1:{i:0;i:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'friendlink', 2, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"link";b:0;s:5:"label";b:0;s:4:"sort";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'guestbook', 2, '', 'a:2:{s:13:"admin_actions";a:4:{s:6:"config";b:0;s:4:"list";b:0;s:5:"label";b:0;s:8:"category";b:0;}s:7:"actions";a:7:{s:4:"view";b:1;s:4:"post";b:1;s:10:"autoverify";b:0;s:6:"verify";b:0;s:5:"reply";b:0;s:4:"edit";b:0;s:6:"delete";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'interview', 2, '', 'a:2:{s:13:"admin_actions";a:3:{s:6:"config";b:0;s:12:"list_subject";b:0;s:11:"add_subject";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'label', 2, '', 'a:2:{s:13:"admin_actions";a:6:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:5:"cache";b:0;s:6:"delete";b:0;s:7:"set_acl";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'letter', 2, '', 'a:3:{s:7:"actions";a:11:{s:4:"list";b:1;s:4:"post";b:1;s:4:"view";b:1;s:7:"manager";b:1;s:9:"delletter";b:0;s:4:"edit";b:0;s:8:"turnover";b:0;s:6:"vefify";b:0;s:7:"endtime";b:0;s:7:"display";b:0;s:5:"reply";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"post";b:1;s:4:"view";b:1;}}}s:16:"my_letter_manage";a:3:{s:4:"list";a:1:{i:0;i:0;}s:4:"post";a:1:{i:0;i:0;}s:4:"view";a:1:{i:0;i:0;}}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'mail', 2, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:4:"test";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'member', 2, '', 'a:2:{s:13:"admin_actions";a:11:{s:6:"config";b:0;s:3:"add";b:0;s:8:"add_list";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:10:"batch_send";b:0;s:6:"credit";b:0;s:8:"recharge";b:0;s:8:"buy_role";b:0;s:9:"integrate";b:0;}s:7:"actions";a:1:{s:12:"address_list";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'message', 2, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:10:"batch_send";b:0;}s:7:"actions";a:1:{s:4:"send";b:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'notify', 2, '', 'a:2:{s:13:"admin_actions";a:2:{s:3:"add";b:0;s:4:"send";b:0;}s:7:"actions";a:6:{s:3:"add";b:0;s:4:"send";b:0;s:4:"show";b:0;s:4:"edit";b:0;s:6:"resend";b:0;s:7:"message";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'opinion', 2, '', 'a:1:{s:7:"actions";a:4:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"manage";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'page', 2, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"config";b:0;s:4:"list";b:0;s:3:"add";b:0;s:4:"edit";b:0;s:6:"delete";b:0;s:4:"html";b:0;}s:7:"actions";a:1:{s:10:"addcontent";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'pay', 2, '', 'a:2:{s:13:"admin_actions";a:5:{s:6:"config";b:0;s:9:"interface";b:0;s:5:"order";b:0;s:10:"view_order";b:0;s:19:"update_order_status";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'role', 2, '', 'a:2:{s:13:"admin_actions";a:11:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:10:"list_group";b:0;s:9:"add_group";b:0;s:12:"update_group";b:0;s:15:"add_group_field";b:0;s:18:"update_group_field";b:0;s:8:"copy_acl";b:0;s:5:"cache";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'shortcutsms', 2, '', 'a:1:{s:7:"actions";a:1:{s:6:"client";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'sms', 2, '', 'a:2:{s:13:"admin_actions";a:2:{s:14:"list_interface";b:0;s:4:"test";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'special', 2, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"config";b:0;s:5:"label";b:0;s:3:"add";b:0;s:6:"delete";b:0;s:4:"edit";b:0;s:8:"category";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'spider', 2, '', 'a:2:{s:13:"admin_actions";a:4:{s:8:"category";b:0;s:4:"rule";b:0;s:4:"item";b:0;s:4:"walk";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'survey', 2, '', 'a:1:{s:7:"actions";a:4:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"manage";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'uchome', 2, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'uploader', 2, '', 'a:2:{s:13:"admin_actions";a:4:{s:6:"config";b:0;s:11:"role_filter";b:0;s:4:"list";b:0;s:6:"delete";b:0;}s:7:"actions";a:6:{s:4:"list";b:1;s:6:"upload";b:1;s:6:"mylist";b:1;s:7:"capture";b:1;s:9:"image_cut";b:1;s:6:"delete";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'vote', 2, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"vote";b:0;s:8:"truncate";b:0;s:6:"delete";b:0;}s:7:"actions";a:2:{s:11:"view_result";b:1;s:5:"voter";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'xspace', 2, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', '', 3, '', 'a:2:{s:13:"admin_actions";a:4:{s:10:"statistics";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:9:"cache_all";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'answer', 3, '', 'a:5:{s:13:"admin_actions";a:6:{s:6:"verify";b:0;s:4:"edit";b:0;s:6:"poller";b:0;s:6:"delete";b:0;s:4:"list";b:0;s:7:"against";b:0;}s:7:"actions";a:9:{s:4:"post";b:1;s:11:"post_follow";b:1;s:3:"fen";b:1;s:4:"vote";b:1;s:6:"poller";b:1;s:6:"verify";b:0;s:4:"edit";b:0;s:6:"delete";b:0;s:15:"set_best_answer";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:5:{s:4:"post";b:1;s:11:"post_follow";b:1;s:3:"fen";b:1;s:4:"vote";b:1;s:6:"poller";b:1;}}}s:21:"my_category_to_verify";a:0:{}s:19:"my_addible_category";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'category', 3, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"insert";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:7:"set_acl";b:0;s:5:"cache";b:0;}s:7:"actions";a:2:{s:4:"main";b:1;s:3:"get";b:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'item', 3, '', 'a:5:{s:13:"admin_actions";a:18:{s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"verify";b:0;s:9:"recommend";b:0;s:6:"closed";b:0;s:6:"answer";b:0;s:13:"answer_delete";b:0;s:12:"answer_audit";b:0;s:11:"answer_best";b:0;s:11:"answer_vote";b:0;s:14:"answer_content";b:0;s:12:"item_against";b:0;s:14:"answer_against";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:6:"sphinx";b:0;s:5:"label";b:0;}s:7:"actions";a:8:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"poller";b:1;s:6:"search";b:1;s:6:"verify";b:0;s:4:"edit";b:0;s:6:"delete";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:4:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"poller";b:1;}}}s:21:"my_category_to_verify";a:0:{}s:19:"my_addible_category";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'member', 3, '', 'a:2:{s:13:"admin_actions";a:5:{s:4:"list";b:0;s:8:"expertor";b:0;s:4:"star";b:0;s:5:"label";b:0;s:4:"post";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', '', 3, '', 'a:2:{s:13:"admin_actions";a:4:{s:4:"html";b:0;s:13:"index_to_html";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'assist_category', 3, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"list";b:0;s:12:"content_list";b:0;s:5:"label";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'category', 3, '', 'a:2:{s:13:"admin_actions";a:7:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:5:"cache";b:0;s:5:"merge";b:0;s:7:"set_acl";b:0;s:6:"delete";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'item', 3, '', 'a:5:{s:13:"admin_actions";a:21:{s:6:"config";b:0;s:3:"add";b:0;s:6:"verify";b:0;s:4:"move";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:7:"comment";b:0;s:14:"verify_comment";b:0;s:14:"delete_comment";b:0;s:12:"list_to_html";b:0;s:12:"view_to_html";b:0;s:9:"attribute";b:0;s:13:"attribute_acl";b:0;s:5:"label";b:0;s:10:"list_order";b:0;s:7:"set_acl";b:0;s:4:"mood";b:0;s:6:"spider";b:0;s:3:"tag";b:0;s:12:"cluster_push";b:0;}s:7:"actions";a:11:{s:6:"search";b:1;s:4:"list";b:1;s:4:"view";b:1;s:7:"comment";b:0;s:3:"add";b:0;s:10:"autoverify";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"verify";b:0;s:9:"attribute";b:0;s:11:"create_time";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}}s:19:"my_addible_category";a:0:{}s:21:"my_category_to_verify";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'model', 3, '', 'a:2:{s:13:"admin_actions";a:10:{s:3:"add";b:1;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"manage";b:0;s:6:"export";b:0;s:6:"import";b:0;s:9:"add_field";b:0;s:12:"update_field";b:0;s:12:"delete_field";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'statistic', 3, '', 'a:2:{s:13:"admin_actions";a:1:{s:4:"list";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', '', 3, '', 'a:4:{s:13:"admin_actions";a:33:{s:5:"login";b:0;s:3:"log";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:13:"set_admin_acl";b:0;s:8:"memcache";b:0;s:8:"db_slave";b:0;s:4:"menu";b:0;s:15:"navigation_menu";b:0;s:11:"member_menu";b:0;s:11:"system_list";b:0;s:11:"module_list";b:0;s:11:"plugin_list";b:0;s:6:"plugin";b:0;s:14:"install_system";b:0;s:16:"uninstall_system";b:0;s:14:"install_module";b:0;s:16:"uninstall_module";b:0;s:14:"install_plugin";b:0;s:16:"uninstall_plugin";b:0;s:5:"cache";b:0;s:7:"phpinfo";b:0;s:8:"template";b:0;s:11:"base_config";b:0;s:13:"global_config";b:0;s:10:"reg_config";b:0;s:15:"homepage_config";b:0;s:7:"stop_ip";b:0;s:8:"allow_ip";b:0;s:11:"word_filter";b:0;s:16:"connection_flood";b:0;s:9:"md5_files";b:0;s:4:"area";b:0;}s:7:"actions";a:0:{}s:10:"allow_tags";a:0:{}s:13:"disallow_tags";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', '46', 3, '', 'a:2:{s:13:"admin_actions";a:2:{s:2:"ad";b:0;s:3:"buy";b:0;}s:7:"actions";a:2:{s:4:"list";b:1;s:3:"buy";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'credit', 3, '', 'a:2:{s:13:"admin_actions";a:9:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:9:"list_rule";b:0;s:8:"add_rule";b:0;s:11:"update_rule";b:0;s:11:"delete_rule";b:0;s:5:"cache";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'crontab', 3, '', 'a:2:{s:13:"admin_actions";a:5:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:3:"run";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'cservice', 3, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:4:"list";b:0;}s:7:"actions";a:1:{s:12:"admin_replay";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'dbm', 3, '', 'a:2:{s:13:"admin_actions";a:1:{s:0:"";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'discuzx', 3, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'forms', 3, '', 'a:5:{s:13:"admin_actions";a:5:{s:6:"config";b:0;s:4:"list";b:0;s:5:"model";b:0;s:5:"field";b:0;s:5:"label";b:0;}s:7:"actions";a:8:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;s:8:"download";b:0;s:11:"import_list";b:0;s:10:"authmanage";b:0;s:6:"manage";b:0;}s:12:"category_acl";a:55:{i:0;a:1:{s:7:"actions";a:2:{s:4:"post";b:1;s:6:"search";b:1;}}i:1;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:26;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:8;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:17;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:10;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:11;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:13;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:14;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:15;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:18;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:19;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:20;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:21;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:22;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:16;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:24;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:7;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:2;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:3;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:4;a:1:{s:7:"actions";a:1:{s:4:"view";b:1;}}i:39;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:5;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:6;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:9;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:23;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:25;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:27;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:28;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:29;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:30;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:32;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:33;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:34;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:37;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:38;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:40;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:41;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:42;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:43;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:44;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:45;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:46;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:47;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:48;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:49;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:50;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:51;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:52;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:65;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:66;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:70;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}i:71;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}i:72;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}i:76;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}}s:15:"my_forms_manage";a:0:{}s:13:"my_forms_post";a:1:{i:0;i:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'friendlink', 3, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"link";b:0;s:5:"label";b:0;s:4:"sort";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'guestbook', 3, '', 'a:2:{s:13:"admin_actions";a:4:{s:6:"config";b:0;s:4:"list";b:0;s:5:"label";b:0;s:8:"category";b:0;}s:7:"actions";a:7:{s:4:"view";b:1;s:4:"post";b:1;s:10:"autoverify";b:0;s:6:"verify";b:0;s:5:"reply";b:0;s:4:"edit";b:0;s:6:"delete";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'interview', 3, '', 'a:2:{s:13:"admin_actions";a:3:{s:6:"config";b:0;s:12:"list_subject";b:0;s:11:"add_subject";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'label', 3, '', 'a:2:{s:13:"admin_actions";a:6:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:5:"cache";b:0;s:6:"delete";b:0;s:7:"set_acl";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'letter', 3, '', 'a:3:{s:7:"actions";a:11:{s:4:"list";b:1;s:4:"post";b:1;s:4:"view";b:1;s:7:"manager";b:1;s:9:"delletter";b:0;s:4:"edit";b:0;s:8:"turnover";b:0;s:6:"vefify";b:0;s:7:"endtime";b:0;s:7:"display";b:0;s:5:"reply";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"post";b:1;s:4:"view";b:1;}}}s:16:"my_letter_manage";a:3:{s:4:"list";a:1:{i:0;i:0;}s:4:"post";a:1:{i:0;i:0;}s:4:"view";a:1:{i:0;i:0;}}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'mail', 3, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:4:"test";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'member', 3, '', 'a:2:{s:13:"admin_actions";a:11:{s:6:"config";b:0;s:3:"add";b:0;s:8:"add_list";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:10:"batch_send";b:0;s:6:"credit";b:0;s:8:"recharge";b:0;s:8:"buy_role";b:0;s:9:"integrate";b:0;}s:7:"actions";a:1:{s:12:"address_list";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'message', 3, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:10:"batch_send";b:0;}s:7:"actions";a:1:{s:4:"send";b:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'notify', 3, '', 'a:2:{s:13:"admin_actions";a:2:{s:3:"add";b:0;s:4:"send";b:0;}s:7:"actions";a:6:{s:3:"add";b:0;s:4:"send";b:0;s:4:"show";b:0;s:4:"edit";b:0;s:6:"resend";b:0;s:7:"message";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'opinion', 3, '', 'a:1:{s:7:"actions";a:4:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"manage";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'page', 3, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"config";b:0;s:4:"list";b:0;s:3:"add";b:0;s:4:"edit";b:0;s:6:"delete";b:0;s:4:"html";b:0;}s:7:"actions";a:1:{s:10:"addcontent";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'pay', 3, '', 'a:2:{s:13:"admin_actions";a:5:{s:6:"config";b:0;s:9:"interface";b:0;s:5:"order";b:0;s:10:"view_order";b:0;s:19:"update_order_status";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'role', 3, '', 'a:2:{s:13:"admin_actions";a:11:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:10:"list_group";b:0;s:9:"add_group";b:0;s:12:"update_group";b:0;s:15:"add_group_field";b:0;s:18:"update_group_field";b:0;s:8:"copy_acl";b:0;s:5:"cache";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'shortcutsms', 3, '', 'a:1:{s:7:"actions";a:1:{s:6:"client";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'sms', 3, '', 'a:2:{s:13:"admin_actions";a:2:{s:14:"list_interface";b:0;s:4:"test";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'special', 3, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"config";b:0;s:5:"label";b:0;s:3:"add";b:0;s:6:"delete";b:0;s:4:"edit";b:0;s:8:"category";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'spider', 3, '', 'a:2:{s:13:"admin_actions";a:4:{s:8:"category";b:0;s:4:"rule";b:0;s:4:"item";b:0;s:4:"walk";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'survey', 3, '', 'a:1:{s:7:"actions";a:4:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"manage";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', '', 4, '', 'a:2:{s:13:"admin_actions";a:4:{s:10:"statistics";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:9:"cache_all";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'uchome', 3, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'uploader', 3, '', 'a:2:{s:13:"admin_actions";a:4:{s:6:"config";b:0;s:11:"role_filter";b:0;s:4:"list";b:0;s:6:"delete";b:0;}s:7:"actions";a:6:{s:4:"list";b:0;s:6:"upload";b:0;s:6:"mylist";b:0;s:7:"capture";b:0;s:9:"image_cut";b:1;s:6:"delete";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'vote', 3, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"vote";b:0;s:8:"truncate";b:0;s:6:"delete";b:0;}s:7:"actions";a:2:{s:11:"view_result";b:1;s:5:"voter";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'xspace', 3, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', '', 0, '', 'a:2:{s:13:"admin_actions";a:4:{s:10:"statistics";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:9:"cache_all";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'answer', 0, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"verify";b:0;s:4:"edit";b:0;s:6:"poller";b:0;s:6:"delete";b:0;s:4:"list";b:0;s:7:"against";b:0;}s:7:"actions";a:9:{s:4:"post";b:0;s:11:"post_follow";b:0;s:3:"fen";b:0;s:4:"vote";b:0;s:6:"poller";b:0;s:6:"verify";b:0;s:4:"edit";b:0;s:6:"delete";b:0;s:15:"set_best_answer";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'category', 0, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"insert";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:7:"set_acl";b:0;s:5:"cache";b:0;}s:7:"actions";a:2:{s:4:"main";b:0;s:3:"get";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'item', 0, '', 'a:2:{s:13:"admin_actions";a:18:{s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"verify";b:0;s:9:"recommend";b:0;s:6:"closed";b:0;s:6:"answer";b:0;s:13:"answer_delete";b:0;s:12:"answer_audit";b:0;s:11:"answer_best";b:0;s:11:"answer_vote";b:0;s:14:"answer_content";b:0;s:12:"item_against";b:0;s:14:"answer_against";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:6:"sphinx";b:0;s:5:"label";b:0;}s:7:"actions";a:8:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"poller";b:0;s:6:"search";b:1;s:6:"verify";b:0;s:4:"edit";b:0;s:6:"delete";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'member', 0, '', 'a:2:{s:13:"admin_actions";a:5:{s:4:"list";b:0;s:8:"expertor";b:0;s:4:"star";b:0;s:5:"label";b:0;s:4:"post";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', '', 0, '', 'a:2:{s:13:"admin_actions";a:4:{s:4:"html";b:0;s:13:"index_to_html";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'assist_category', 0, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"list";b:0;s:12:"content_list";b:0;s:5:"label";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'category', 0, '', 'a:2:{s:13:"admin_actions";a:8:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:5:"cache";b:0;s:5:"merge";b:0;s:5:"clone";b:0;s:7:"set_acl";b:0;s:6:"delete";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'item', 0, '', 'a:4:{s:13:"admin_actions";a:23:{s:6:"config";b:0;s:3:"add";b:0;s:6:"verify";b:0;s:4:"move";b:0;s:5:"clone";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:7:"comment";b:0;s:14:"verify_comment";b:0;s:14:"delete_comment";b:0;s:12:"list_to_html";b:0;s:12:"view_to_html";b:0;s:9:"attribute";b:0;s:13:"attribute_acl";b:0;s:5:"label";b:0;s:10:"list_order";b:0;s:11:"create_time";b:0;s:7:"set_acl";b:0;s:4:"mood";b:0;s:6:"spider";b:0;s:3:"tag";b:0;s:12:"cluster_push";b:0;}s:7:"actions";a:11:{s:6:"search";b:1;s:4:"list";b:1;s:4:"view";b:1;s:7:"comment";b:1;s:3:"add";b:1;s:10:"autoverify";b:0;s:6:"update";b:1;s:6:"delete";b:1;s:6:"verify";b:0;s:9:"attribute";b:0;s:11:"create_time";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:3:"add";b:1;s:4:"view";b:1;}}}s:19:"my_addible_category";a:1:{i:0;i:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'model', 0, '', 'a:2:{s:13:"admin_actions";a:10:{s:3:"add";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"manage";b:0;s:6:"export";b:0;s:6:"import";b:0;s:9:"add_field";b:0;s:12:"update_field";b:0;s:12:"delete_field";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'statistic', 0, '', 'a:2:{s:13:"admin_actions";a:1:{s:4:"list";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', '', 0, '', 'a:2:{s:13:"admin_actions";a:33:{s:5:"login";b:0;s:3:"log";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:13:"set_admin_acl";b:0;s:8:"memcache";b:0;s:8:"db_slave";b:0;s:4:"menu";b:0;s:15:"navigation_menu";b:0;s:11:"member_menu";b:0;s:11:"system_list";b:0;s:11:"module_list";b:0;s:11:"plugin_list";b:0;s:6:"plugin";b:0;s:14:"install_system";b:0;s:16:"uninstall_system";b:0;s:14:"install_module";b:0;s:16:"uninstall_module";b:0;s:14:"install_plugin";b:0;s:16:"uninstall_plugin";b:0;s:5:"cache";b:0;s:7:"phpinfo";b:0;s:8:"template";b:0;s:11:"base_config";b:0;s:13:"global_config";b:0;s:10:"reg_config";b:0;s:15:"homepage_config";b:0;s:7:"stop_ip";b:0;s:8:"allow_ip";b:0;s:11:"word_filter";b:0;s:16:"connection_flood";b:0;s:9:"md5_files";b:0;s:4:"area";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', '46', 0, '', 'a:2:{s:13:"admin_actions";a:2:{s:2:"ad";b:0;s:3:"buy";b:0;}s:7:"actions";a:2:{s:4:"list";b:0;s:3:"buy";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'credit', 0, '', 'a:2:{s:13:"admin_actions";a:9:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:9:"list_rule";b:0;s:8:"add_rule";b:0;s:11:"update_rule";b:0;s:11:"delete_rule";b:0;s:5:"cache";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'crontab', 0, '', 'a:2:{s:13:"admin_actions";a:5:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:3:"run";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'cservice', 0, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:4:"list";b:0;}s:7:"actions";a:1:{s:12:"admin_replay";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'dbm', 0, '', 'a:2:{s:13:"admin_actions";a:1:{s:0:"";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'discuzx', 0, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'forms', 0, '', 'a:2:{s:13:"admin_actions";a:5:{s:6:"config";b:0;s:4:"list";b:0;s:5:"model";b:0;s:5:"field";b:0;s:5:"label";b:0;}s:7:"actions";a:8:{s:4:"post";b:0;s:4:"list";b:0;s:4:"view";b:0;s:6:"search";b:0;s:8:"download";b:0;s:11:"import_list";b:0;s:10:"authmanage";b:0;s:6:"manage";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'friendlink', 0, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"link";b:0;s:5:"label";b:0;s:4:"sort";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'guestbook', 0, '', 'a:2:{s:13:"admin_actions";a:4:{s:6:"config";b:0;s:4:"list";b:0;s:5:"label";b:0;s:8:"category";b:0;}s:7:"actions";a:7:{s:4:"view";b:1;s:4:"post";b:1;s:10:"autoverify";b:0;s:6:"verify";b:0;s:5:"reply";b:0;s:4:"edit";b:0;s:6:"delete";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'interview', 0, '', 'a:2:{s:13:"admin_actions";a:3:{s:6:"config";b:0;s:12:"list_subject";b:0;s:11:"add_subject";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'label', 0, '', 'a:2:{s:13:"admin_actions";a:6:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:5:"cache";b:0;s:6:"delete";b:0;s:7:"set_acl";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'letter', 0, '', 'a:2:{s:13:"admin_actions";a:3:{s:6:"config";b:0;s:4:"list";b:0;s:10:"statistics";b:0;}s:7:"actions";a:10:{s:4:"list";b:0;s:4:"post";b:0;s:4:"view";b:0;s:7:"manager";b:0;s:9:"delletter";b:0;s:4:"edit";b:0;s:8:"turnover";b:0;s:6:"vefify";b:0;s:7:"endtime";b:0;s:7:"display";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'mail', 0, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:4:"test";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'member', 0, '', 'a:2:{s:13:"admin_actions";a:12:{s:6:"config";b:0;s:3:"add";b:0;s:8:"add_list";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:10:"batch_send";b:0;s:6:"credit";b:0;s:8:"recharge";b:0;s:8:"buy_role";b:0;s:9:"integrate";b:0;s:10:"transition";b:0;}s:7:"actions";a:1:{s:12:"address_list";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'message', 0, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:10:"batch_send";b:0;}s:7:"actions";a:1:{s:4:"send";b:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'notify', 0, '', 'a:2:{s:13:"admin_actions";a:2:{s:3:"add";b:0;s:4:"send";b:0;}s:7:"actions";a:6:{s:3:"add";b:0;s:4:"send";b:0;s:4:"show";b:0;s:4:"edit";b:0;s:6:"resend";b:0;s:7:"message";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'opinion', 0, '', 'a:2:{s:13:"admin_actions";a:3:{s:6:"config";b:0;s:4:"item";b:0;s:4:"list";b:0;}s:7:"actions";a:4:{s:4:"post";b:0;s:4:"list";b:0;s:4:"view";b:0;s:6:"manage";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'page', 0, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"config";b:0;s:4:"list";b:0;s:3:"add";b:0;s:4:"edit";b:0;s:6:"delete";b:0;s:4:"html";b:0;}s:7:"actions";a:1:{s:10:"addcontent";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'pay', 0, '', 'a:2:{s:13:"admin_actions";a:5:{s:6:"config";b:0;s:9:"interface";b:0;s:5:"order";b:0;s:10:"view_order";b:0;s:19:"update_order_status";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'role', 0, '', 'a:2:{s:13:"admin_actions";a:11:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:10:"list_group";b:0;s:9:"add_group";b:0;s:12:"update_group";b:0;s:15:"add_group_field";b:0;s:18:"update_group_field";b:0;s:8:"copy_acl";b:0;s:5:"cache";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'shortcutsms', 0, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"client";b:0;s:6:"config";b:0;}s:7:"actions";a:1:{s:6:"client";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'sms', 0, '', 'a:2:{s:13:"admin_actions";a:2:{s:14:"list_interface";b:0;s:4:"test";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'special', 0, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"config";b:0;s:5:"label";b:0;s:3:"add";b:0;s:6:"delete";b:0;s:4:"edit";b:0;s:8:"category";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'spider', 0, '', 'a:2:{s:13:"admin_actions";a:4:{s:8:"category";b:0;s:4:"rule";b:0;s:4:"item";b:0;s:4:"walk";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'survey', 0, '', 'a:2:{s:13:"admin_actions";a:3:{s:6:"config";b:0;s:4:"item";b:0;s:4:"list";b:0;}s:7:"actions";a:4:{s:4:"post";b:0;s:4:"list";b:0;s:4:"view";b:0;s:6:"manage";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'uchome', 0, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'uploader', 0, '', 'a:2:{s:13:"admin_actions";a:4:{s:6:"config";b:0;s:11:"role_filter";b:0;s:4:"list";b:0;s:6:"delete";b:0;}s:7:"actions";a:6:{s:4:"list";b:1;s:6:"upload";b:1;s:6:"mylist";b:1;s:7:"capture";b:1;s:9:"image_cut";b:0;s:6:"delete";b:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'vote', 0, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"vote";b:0;s:8:"truncate";b:0;s:6:"delete";b:0;}s:7:"actions";a:2:{s:11:"view_result";b:0;s:5:"voter";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'xspace', 0, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'answer', 4, '', 'a:5:{s:13:"admin_actions";a:6:{s:6:"verify";b:0;s:4:"edit";b:0;s:6:"poller";b:0;s:6:"delete";b:0;s:4:"list";b:0;s:7:"against";b:0;}s:7:"actions";a:9:{s:4:"post";b:1;s:11:"post_follow";b:1;s:3:"fen";b:1;s:4:"vote";b:1;s:6:"poller";b:1;s:6:"verify";b:0;s:4:"edit";b:0;s:6:"delete";b:0;s:15:"set_best_answer";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:5:{s:4:"post";b:1;s:11:"post_follow";b:1;s:3:"fen";b:1;s:4:"vote";b:1;s:6:"poller";b:1;}}}s:21:"my_category_to_verify";a:0:{}s:19:"my_addible_category";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'category', 4, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"insert";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:7:"set_acl";b:0;s:5:"cache";b:0;}s:7:"actions";a:2:{s:4:"main";b:1;s:3:"get";b:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'item', 4, '', 'a:5:{s:13:"admin_actions";a:18:{s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"verify";b:0;s:9:"recommend";b:0;s:6:"closed";b:0;s:6:"answer";b:0;s:13:"answer_delete";b:0;s:12:"answer_audit";b:0;s:11:"answer_best";b:0;s:11:"answer_vote";b:0;s:14:"answer_content";b:0;s:12:"item_against";b:0;s:14:"answer_against";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:6:"sphinx";b:0;s:5:"label";b:0;}s:7:"actions";a:8:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"poller";b:1;s:6:"search";b:1;s:6:"verify";b:0;s:4:"edit";b:0;s:6:"delete";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:4:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"poller";b:1;}}}s:21:"my_category_to_verify";a:0:{}s:19:"my_addible_category";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'member', 4, '', 'a:2:{s:13:"admin_actions";a:5:{s:4:"list";b:0;s:8:"expertor";b:0;s:4:"star";b:0;s:5:"label";b:0;s:4:"post";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', '', 4, '', 'a:2:{s:13:"admin_actions";a:4:{s:4:"html";b:0;s:13:"index_to_html";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'assist_category', 4, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"list";b:0;s:12:"content_list";b:0;s:5:"label";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'category', 4, '', 'a:2:{s:13:"admin_actions";a:7:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:5:"cache";b:0;s:5:"merge";b:0;s:7:"set_acl";b:0;s:6:"delete";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'item', 4, '', 'a:5:{s:13:"admin_actions";a:21:{s:6:"config";b:0;s:3:"add";b:0;s:6:"verify";b:0;s:4:"move";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:7:"comment";b:0;s:14:"verify_comment";b:0;s:14:"delete_comment";b:0;s:12:"list_to_html";b:0;s:12:"view_to_html";b:0;s:9:"attribute";b:0;s:13:"attribute_acl";b:0;s:5:"label";b:0;s:10:"list_order";b:0;s:7:"set_acl";b:0;s:4:"mood";b:0;s:6:"spider";b:0;s:3:"tag";b:0;s:12:"cluster_push";b:0;}s:7:"actions";a:11:{s:6:"search";b:1;s:4:"list";b:1;s:4:"view";b:1;s:7:"comment";b:0;s:3:"add";b:0;s:10:"autoverify";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"verify";b:0;s:9:"attribute";b:0;s:11:"create_time";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:3:"add";b:1;}}}s:19:"my_addible_category";a:1:{i:0;i:1;}s:21:"my_category_to_verify";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'model', 4, '', 'a:2:{s:13:"admin_actions";a:10:{s:3:"add";b:1;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"manage";b:0;s:6:"export";b:0;s:6:"import";b:0;s:9:"add_field";b:0;s:12:"update_field";b:0;s:12:"delete_field";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'statistic', 4, '', 'a:2:{s:13:"admin_actions";a:1:{s:4:"list";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', '', 4, '', 'a:4:{s:13:"admin_actions";a:33:{s:5:"login";b:0;s:3:"log";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:13:"set_admin_acl";b:0;s:8:"memcache";b:0;s:8:"db_slave";b:0;s:4:"menu";b:0;s:15:"navigation_menu";b:0;s:11:"member_menu";b:0;s:11:"system_list";b:0;s:11:"module_list";b:0;s:11:"plugin_list";b:0;s:6:"plugin";b:0;s:14:"install_system";b:0;s:16:"uninstall_system";b:0;s:14:"install_module";b:0;s:16:"uninstall_module";b:0;s:14:"install_plugin";b:0;s:16:"uninstall_plugin";b:0;s:5:"cache";b:0;s:7:"phpinfo";b:0;s:8:"template";b:0;s:11:"base_config";b:0;s:13:"global_config";b:0;s:10:"reg_config";b:0;s:15:"homepage_config";b:0;s:7:"stop_ip";b:0;s:8:"allow_ip";b:0;s:11:"word_filter";b:0;s:16:"connection_flood";b:0;s:9:"md5_files";b:0;s:4:"area";b:0;}s:7:"actions";a:0:{}s:10:"allow_tags";a:0:{}s:13:"disallow_tags";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', '46', 4, '', 'a:2:{s:13:"admin_actions";a:2:{s:2:"ad";b:0;s:3:"buy";b:0;}s:7:"actions";a:2:{s:4:"list";b:1;s:3:"buy";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'credit', 4, '', 'a:2:{s:13:"admin_actions";a:9:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:9:"list_rule";b:0;s:8:"add_rule";b:0;s:11:"update_rule";b:0;s:11:"delete_rule";b:0;s:5:"cache";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'crontab', 4, '', 'a:2:{s:13:"admin_actions";a:5:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:3:"run";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'cservice', 4, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:4:"list";b:0;}s:7:"actions";a:1:{s:12:"admin_replay";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'dbm', 4, '', 'a:2:{s:13:"admin_actions";a:1:{s:0:"";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'discuzx', 4, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'forms', 4, '', 'a:5:{s:13:"admin_actions";a:5:{s:6:"config";b:0;s:4:"list";b:0;s:5:"model";b:0;s:5:"field";b:0;s:5:"label";b:0;}s:7:"actions";a:8:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;s:8:"download";b:0;s:11:"import_list";b:0;s:10:"authmanage";b:0;s:6:"manage";b:0;}s:12:"category_acl";a:55:{i:0;a:1:{s:7:"actions";a:2:{s:4:"post";b:1;s:6:"search";b:1;}}i:1;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:26;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:8;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:17;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:10;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:11;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:13;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:14;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:15;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:18;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:19;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:20;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:21;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:22;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:16;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:24;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:7;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:2;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:3;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:4;a:1:{s:7:"actions";a:1:{s:4:"view";b:1;}}i:39;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:5;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:6;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:9;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:23;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:25;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:27;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:28;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:29;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:30;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:32;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:33;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:34;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:37;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:38;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:40;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:41;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:42;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:43;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:44;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:45;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:46;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:47;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:48;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:49;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:50;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:51;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:52;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:65;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:66;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:70;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}i:71;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}i:72;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}i:76;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}}s:15:"my_forms_manage";a:0:{}s:13:"my_forms_post";a:1:{i:0;i:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'friendlink', 4, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"link";b:0;s:5:"label";b:0;s:4:"sort";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'guestbook', 4, '', 'a:2:{s:13:"admin_actions";a:4:{s:6:"config";b:0;s:4:"list";b:0;s:5:"label";b:0;s:8:"category";b:0;}s:7:"actions";a:7:{s:4:"view";b:1;s:4:"post";b:1;s:10:"autoverify";b:0;s:6:"verify";b:0;s:5:"reply";b:0;s:4:"edit";b:0;s:6:"delete";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'interview', 4, '', 'a:2:{s:13:"admin_actions";a:3:{s:6:"config";b:0;s:12:"list_subject";b:0;s:11:"add_subject";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'label', 4, '', 'a:2:{s:13:"admin_actions";a:6:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:5:"cache";b:0;s:6:"delete";b:0;s:7:"set_acl";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'letter', 4, '', 'a:3:{s:7:"actions";a:11:{s:4:"list";b:1;s:4:"post";b:1;s:4:"view";b:1;s:7:"manager";b:1;s:9:"delletter";b:0;s:4:"edit";b:0;s:8:"turnover";b:0;s:6:"vefify";b:0;s:7:"endtime";b:0;s:7:"display";b:0;s:5:"reply";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"post";b:1;s:4:"view";b:1;}}}s:16:"my_letter_manage";a:3:{s:4:"list";a:1:{i:0;i:0;}s:4:"post";a:1:{i:0;i:0;}s:4:"view";a:1:{i:0;i:0;}}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'mail', 4, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:4:"test";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'member', 4, '', 'a:2:{s:13:"admin_actions";a:11:{s:6:"config";b:0;s:3:"add";b:0;s:8:"add_list";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:10:"batch_send";b:0;s:6:"credit";b:0;s:8:"recharge";b:0;s:8:"buy_role";b:0;s:9:"integrate";b:0;}s:7:"actions";a:1:{s:12:"address_list";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'message', 4, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:10:"batch_send";b:0;}s:7:"actions";a:1:{s:4:"send";b:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'notify', 4, '', 'a:2:{s:13:"admin_actions";a:2:{s:3:"add";b:0;s:4:"send";b:0;}s:7:"actions";a:6:{s:3:"add";b:0;s:4:"send";b:0;s:4:"show";b:0;s:4:"edit";b:0;s:6:"resend";b:0;s:7:"message";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'opinion', 4, '', 'a:1:{s:7:"actions";a:4:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"manage";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'page', 4, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"config";b:0;s:4:"list";b:0;s:3:"add";b:0;s:4:"edit";b:0;s:6:"delete";b:0;s:4:"html";b:0;}s:7:"actions";a:1:{s:10:"addcontent";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'pay', 4, '', 'a:2:{s:13:"admin_actions";a:5:{s:6:"config";b:0;s:9:"interface";b:0;s:5:"order";b:0;s:10:"view_order";b:0;s:19:"update_order_status";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'role', 4, '', 'a:2:{s:13:"admin_actions";a:11:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:10:"list_group";b:0;s:9:"add_group";b:0;s:12:"update_group";b:0;s:15:"add_group_field";b:0;s:18:"update_group_field";b:0;s:8:"copy_acl";b:0;s:5:"cache";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'shortcutsms', 4, '', 'a:1:{s:7:"actions";a:1:{s:6:"client";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'sms', 4, '', 'a:2:{s:13:"admin_actions";a:2:{s:14:"list_interface";b:0;s:4:"test";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'special', 4, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"config";b:0;s:5:"label";b:0;s:3:"add";b:0;s:6:"delete";b:0;s:4:"edit";b:0;s:8:"category";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'spider', 4, '', 'a:2:{s:13:"admin_actions";a:4:{s:8:"category";b:0;s:4:"rule";b:0;s:4:"item";b:0;s:4:"walk";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'survey', 4, '', 'a:1:{s:7:"actions";a:4:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"manage";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'uchome', 4, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'uploader', 4, '', 'a:2:{s:13:"admin_actions";a:4:{s:6:"config";b:0;s:11:"role_filter";b:0;s:4:"list";b:0;s:6:"delete";b:0;}s:7:"actions";a:6:{s:4:"list";b:1;s:6:"upload";b:1;s:6:"mylist";b:1;s:7:"capture";b:1;s:9:"image_cut";b:1;s:6:"delete";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'vote', 4, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"vote";b:0;s:8:"truncate";b:0;s:6:"delete";b:0;}s:7:"actions";a:2:{s:11:"view_result";b:1;s:5:"voter";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'xspace', 4, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'cluster', 3, '', 'a:2:{s:13:"admin_actions";a:10:{s:5:"index";b:0;s:6:"config";b:0;s:6:"client";b:0;s:7:"service";b:0;s:3:"log";b:0;s:14:"client_console";b:0;s:14:"server_console";b:0;s:11:"client_call";b:0;s:11:"server_call";b:0;s:13:"set_admin_acl";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'homepage', 3, '', 'a:1:{s:7:"actions";a:16:{s:14:"member-profile";b:0;s:13:"cms/item-list";b:0;s:13:"ask/item-list";b:0;s:19:"core_member_profile";b:0;s:18:"core_member_friend";b:0;s:16:"core_member_view";b:0;s:15:"core_member_diy";b:0;s:16:"core_member_diy2";b:0;s:16:"core_member_diy3";b:0;s:13:"cms_item_list";b:0;s:13:"ask_item_list";b:0;s:19:"talent_company_list";b:0;s:19:"talent_student_list";b:0;s:19:"talent_teacher_list";b:0;s:15:"sites/item-list";b:0;s:15:"sites_item_list";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'client', 3, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"client";b:0;s:6:"config";b:0;}s:7:"actions";a:1:{s:6:"client";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'group', 3, '', 'a:2:{s:13:"admin_actions";a:0:{}s:7:"actions";a:1:{s:3:"add";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'client', 16, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"client";b:0;s:6:"config";b:0;}s:7:"actions";a:1:{s:6:"client";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'group', 16, '', 'a:2:{s:13:"admin_actions";a:0:{}s:7:"actions";a:1:{s:3:"add";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'group', 13, '', 'a:2:{s:13:"admin_actions";a:0:{}s:7:"actions";a:1:{s:3:"add";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'client', 13, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"client";b:0;s:6:"config";b:0;}s:7:"actions";a:1:{s:6:"client";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'homepage', 13, '', 'a:1:{s:7:"actions";a:16:{s:14:"member-profile";b:0;s:13:"cms/item-list";b:0;s:13:"ask/item-list";b:0;s:19:"core_member_profile";b:0;s:18:"core_member_friend";b:0;s:16:"core_member_view";b:0;s:15:"core_member_diy";b:0;s:16:"core_member_diy2";b:0;s:16:"core_member_diy3";b:0;s:13:"cms_item_list";b:0;s:13:"ask_item_list";b:0;s:19:"talent_company_list";b:0;s:19:"talent_student_list";b:0;s:19:"talent_teacher_list";b:0;s:15:"sites/item-list";b:0;s:15:"sites_item_list";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'special', 13, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"config";b:0;s:5:"label";b:0;s:3:"add";b:0;s:6:"delete";b:0;s:4:"edit";b:0;s:8:"category";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'spider', 13, '', 'a:2:{s:13:"admin_actions";a:4:{s:8:"category";b:0;s:4:"rule";b:0;s:4:"item";b:0;s:4:"walk";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'survey', 13, '', 'a:2:{s:7:"actions";a:4:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"manage";b:0;}s:13:"admin_actions";a:3:{s:6:"config";b:0;s:4:"item";b:0;s:4:"list";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'uchome', 13, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'uploader', 13, '', 'a:2:{s:13:"admin_actions";a:4:{s:6:"config";b:0;s:11:"role_filter";b:0;s:4:"list";b:0;s:6:"delete";b:0;}s:7:"actions";a:6:{s:4:"list";b:0;s:6:"upload";b:1;s:6:"mylist";b:1;s:7:"capture";b:1;s:9:"image_cut";b:1;s:6:"delete";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'vote', 13, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"vote";b:0;s:8:"truncate";b:0;s:6:"delete";b:0;}s:7:"actions";a:2:{s:11:"view_result";b:1;s:5:"voter";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'xspace', 13, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'cluster', 13, '', 'a:5:{s:13:"admin_actions";a:10:{s:5:"index";b:1;s:6:"config";b:1;s:6:"client";b:1;s:7:"service";b:1;s:3:"log";b:1;s:14:"client_console";b:1;s:14:"server_console";b:1;s:11:"client_call";b:1;s:11:"server_call";b:1;s:13:"set_admin_acl";b:1;}s:7:"actions";a:0:{}s:14:"server_service";a:3:{s:6:"client";b:0;s:8:"cms_item";b:1;s:4:"test";b:0;}s:14:"client_service";a:4:{s:5:"admin";b:0;s:6:"client";b:0;s:8:"cms_item";b:1;s:4:"test";b:0;}s:6:"client";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'sms', 13, '', 'a:2:{s:13:"admin_actions";a:2:{s:14:"list_interface";b:0;s:4:"test";b:1;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'shortcutsms', 13, '', 'a:2:{s:7:"actions";a:1:{s:6:"client";b:0;}s:13:"admin_actions";a:2:{s:6:"client";b:0;s:6:"config";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'role', 13, '', 'a:2:{s:13:"admin_actions";a:11:{s:4:"list";b:1;s:3:"add";b:1;s:6:"update";b:1;s:6:"delete";b:1;s:10:"list_group";b:1;s:9:"add_group";b:1;s:12:"update_group";b:1;s:15:"add_group_field";b:1;s:18:"update_group_field";b:1;s:8:"copy_acl";b:1;s:5:"cache";b:1;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'pay', 13, '', 'a:2:{s:13:"admin_actions";a:5:{s:6:"config";b:0;s:9:"interface";b:0;s:5:"order";b:0;s:10:"view_order";b:0;s:19:"update_order_status";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'page', 13, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"config";b:0;s:4:"list";b:0;s:3:"add";b:0;s:4:"edit";b:0;s:6:"delete";b:0;s:4:"html";b:0;}s:7:"actions";a:1:{s:10:"addcontent";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'opinion', 13, '', 'a:2:{s:7:"actions";a:4:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"manage";b:0;}s:13:"admin_actions";a:3:{s:6:"config";b:0;s:4:"item";b:0;s:4:"list";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'notify', 13, '', 'a:2:{s:13:"admin_actions";a:2:{s:3:"add";b:0;s:4:"send";b:0;}s:7:"actions";a:6:{s:3:"add";b:0;s:4:"send";b:1;s:4:"show";b:1;s:4:"edit";b:0;s:6:"resend";b:0;s:7:"message";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'message', 13, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:10:"batch_send";b:0;}s:7:"actions";a:1:{s:4:"send";b:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'member', 13, '', 'a:2:{s:13:"admin_actions";a:12:{s:6:"config";b:1;s:3:"add";b:1;s:8:"add_list";b:1;s:4:"list";b:1;s:6:"update";b:1;s:6:"delete";b:1;s:10:"batch_send";b:1;s:6:"credit";b:1;s:8:"recharge";b:1;s:8:"buy_role";b:1;s:9:"integrate";b:1;s:10:"transition";b:1;}s:7:"actions";a:1:{s:12:"address_list";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'mail', 13, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:4:"test";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'label', 13, '', 'a:3:{s:13:"admin_actions";a:6:{s:4:"list";b:1;s:3:"add";b:1;s:6:"update";b:1;s:5:"cache";b:1;s:6:"delete";b:1;s:7:"set_acl";b:1;}s:7:"actions";a:0:{}s:5:"scope";a:1:{s:5:"sites";a:1:{s:1:"*";a:1:{s:0:"";b:1;}}}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'letter', 13, '', 'a:4:{s:7:"actions";a:10:{s:4:"list";b:1;s:4:"post";b:1;s:4:"view";b:1;s:7:"manager";b:1;s:9:"delletter";b:0;s:4:"edit";b:0;s:8:"turnover";b:0;s:6:"vefify";b:0;s:7:"endtime";b:0;s:7:"display";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"post";b:1;s:4:"view";b:1;}}}s:16:"my_letter_manage";a:3:{s:4:"list";a:1:{i:0;i:0;}s:4:"post";a:1:{i:0;i:0;}s:4:"view";a:1:{i:0;i:0;}}s:13:"admin_actions";a:3:{s:6:"config";b:0;s:4:"list";b:0;s:10:"statistics";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'interview', 13, '', 'a:2:{s:13:"admin_actions";a:3:{s:6:"config";b:0;s:12:"list_subject";b:0;s:11:"add_subject";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'guestbook', 13, '', 'a:2:{s:13:"admin_actions";a:4:{s:6:"config";b:0;s:4:"list";b:0;s:5:"label";b:0;s:8:"category";b:0;}s:7:"actions";a:7:{s:4:"view";b:1;s:4:"post";b:1;s:10:"autoverify";b:0;s:6:"verify";b:0;s:5:"reply";b:0;s:4:"edit";b:0;s:6:"delete";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'friendlink', 13, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"link";b:0;s:5:"label";b:0;s:4:"sort";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'discuzx', 13, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'forms', 13, '', 'a:5:{s:13:"admin_actions";a:6:{s:6:"config";b:0;s:4:"list";b:0;s:5:"model";b:0;s:5:"field";b:0;s:5:"label";b:0;s:6:"import";b:0;}s:7:"actions";a:8:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;s:8:"download";b:0;s:11:"import_list";b:0;s:10:"authmanage";b:0;s:6:"manage";b:0;}s:12:"category_acl";a:55:{i:0;a:1:{s:7:"actions";a:2:{s:4:"post";b:1;s:6:"search";b:1;}}i:1;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:26;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:8;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:17;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:10;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:11;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:13;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:14;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:15;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:18;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:19;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:20;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:21;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:22;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:16;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:24;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:7;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:2;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:3;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:4;a:1:{s:7:"actions";a:1:{s:4:"view";b:1;}}i:39;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:5;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:6;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:9;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:23;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:25;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:27;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:28;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:29;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:30;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:32;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:33;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:34;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:37;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:38;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:40;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:41;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:42;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:43;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:44;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:45;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:46;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:47;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:48;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:49;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:50;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:51;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:52;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:65;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:66;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:70;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}i:71;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}i:72;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}i:76;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}}s:15:"my_forms_manage";a:0:{}s:13:"my_forms_post";a:1:{i:0;i:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'cservice', 13, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:4:"list";b:0;}s:7:"actions";a:1:{s:12:"admin_replay";b:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'dbm', 13, '', 'a:2:{s:13:"admin_actions";a:1:{s:0:"";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'crontab', 13, '', 'a:2:{s:13:"admin_actions";a:5:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:3:"run";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'credit', 13, '', 'a:2:{s:13:"admin_actions";a:9:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:9:"list_rule";b:0;s:8:"add_rule";b:0;s:11:"update_rule";b:0;s:11:"delete_rule";b:0;s:5:"cache";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', '46', 13, '', 'a:2:{s:13:"admin_actions";a:2:{s:2:"ad";b:0;s:3:"buy";b:0;}s:7:"actions";a:2:{s:4:"list";b:1;s:3:"buy";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', '', 13, '', 'a:4:{s:13:"admin_actions";a:33:{s:5:"login";b:1;s:3:"log";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:13:"set_admin_acl";b:0;s:8:"memcache";b:0;s:8:"db_slave";b:0;s:4:"menu";b:0;s:15:"navigation_menu";b:0;s:11:"member_menu";b:0;s:11:"system_list";b:0;s:11:"module_list";b:0;s:11:"plugin_list";b:0;s:6:"plugin";b:0;s:14:"install_system";b:0;s:16:"uninstall_system";b:0;s:14:"install_module";b:0;s:16:"uninstall_module";b:0;s:14:"install_plugin";b:0;s:16:"uninstall_plugin";b:0;s:5:"cache";b:1;s:7:"phpinfo";b:0;s:8:"template";b:0;s:11:"base_config";b:0;s:13:"global_config";b:0;s:10:"reg_config";b:0;s:15:"homepage_config";b:0;s:7:"stop_ip";b:0;s:8:"allow_ip";b:0;s:11:"word_filter";b:0;s:16:"connection_flood";b:0;s:9:"md5_files";b:0;s:4:"area";b:0;}s:7:"actions";a:0:{}s:10:"allow_tags";a:0:{}s:13:"disallow_tags";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'statistic', 13, '', 'a:2:{s:13:"admin_actions";a:1:{s:4:"list";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'model', 13, '', 'a:2:{s:13:"admin_actions";a:10:{s:3:"add";b:1;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"manage";b:0;s:6:"export";b:0;s:6:"import";b:0;s:9:"add_field";b:0;s:12:"update_field";b:0;s:12:"delete_field";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'item', 13, '', 'a:5:{s:13:"admin_actions";a:21:{s:6:"config";b:0;s:3:"add";b:0;s:6:"verify";b:0;s:4:"move";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:7:"comment";b:0;s:14:"verify_comment";b:0;s:14:"delete_comment";b:0;s:12:"list_to_html";b:0;s:12:"view_to_html";b:0;s:9:"attribute";b:0;s:13:"attribute_acl";b:0;s:5:"label";b:0;s:10:"list_order";b:0;s:7:"set_acl";b:0;s:4:"mood";b:0;s:6:"spider";b:0;s:3:"tag";b:0;s:12:"cluster_push";b:0;}s:7:"actions";a:11:{s:6:"search";b:1;s:4:"list";b:1;s:4:"view";b:1;s:7:"comment";b:1;s:3:"add";b:1;s:10:"autoverify";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"verify";b:0;s:9:"attribute";b:0;s:11:"create_time";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:3:"add";b:1;}}}s:19:"my_addible_category";a:1:{i:0;i:1;}s:21:"my_category_to_verify";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'category', 13, '', 'a:2:{s:13:"admin_actions";a:7:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:5:"cache";b:0;s:5:"merge";b:0;s:7:"set_acl";b:0;s:6:"delete";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', '', 13, '', 'a:2:{s:13:"admin_actions";a:4:{s:4:"html";b:0;s:13:"index_to_html";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'assist_category', 13, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"list";b:0;s:12:"content_list";b:0;s:5:"label";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'member', 13, '', 'a:2:{s:13:"admin_actions";a:5:{s:4:"list";b:0;s:8:"expertor";b:0;s:4:"star";b:0;s:5:"label";b:0;s:4:"post";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'item', 13, '', 'a:5:{s:13:"admin_actions";a:18:{s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"verify";b:0;s:9:"recommend";b:0;s:6:"closed";b:0;s:6:"answer";b:0;s:13:"answer_delete";b:0;s:12:"answer_audit";b:0;s:11:"answer_best";b:0;s:11:"answer_vote";b:0;s:14:"answer_content";b:0;s:12:"item_against";b:0;s:14:"answer_against";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:6:"sphinx";b:0;s:5:"label";b:0;}s:7:"actions";a:8:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"poller";b:1;s:6:"search";b:1;s:6:"verify";b:1;s:4:"edit";b:1;s:6:"delete";b:1;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:4:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"poller";b:1;}}}s:21:"my_category_to_verify";a:0:{}s:19:"my_addible_category";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'category', 13, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"insert";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:7:"set_acl";b:0;s:5:"cache";b:0;}s:7:"actions";a:2:{s:4:"main";b:1;s:3:"get";b:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', '', 13, '', 'a:2:{s:13:"admin_actions";a:4:{s:10:"statistics";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:9:"cache_all";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'answer', 13, '', 'a:5:{s:13:"admin_actions";a:6:{s:6:"verify";b:0;s:4:"edit";b:0;s:6:"poller";b:0;s:6:"delete";b:0;s:4:"list";b:0;s:7:"against";b:0;}s:7:"actions";a:9:{s:4:"post";b:1;s:11:"post_follow";b:1;s:3:"fen";b:1;s:4:"vote";b:1;s:6:"poller";b:1;s:6:"verify";b:1;s:4:"edit";b:1;s:6:"delete";b:1;s:15:"set_best_answer";b:1;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:5:{s:4:"post";b:1;s:11:"post_follow";b:1;s:3:"fen";b:1;s:4:"vote";b:1;s:6:"poller";b:1;}}}s:21:"my_category_to_verify";a:0:{}s:19:"my_addible_category";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'cluster', 1, '', 'a:5:{s:13:"admin_actions";a:10:{s:5:"index";b:1;s:6:"config";b:1;s:6:"client";b:1;s:7:"service";b:1;s:3:"log";b:1;s:14:"client_console";b:1;s:14:"server_console";b:1;s:11:"client_call";b:1;s:11:"server_call";b:1;s:13:"set_admin_acl";b:1;}s:7:"actions";a:0:{}s:14:"server_service";a:3:{s:6:"client";b:0;s:8:"cms_item";b:1;s:4:"test";b:0;}s:14:"client_service";a:4:{s:5:"admin";b:0;s:6:"client";b:0;s:8:"cms_item";b:1;s:4:"test";b:0;}s:6:"client";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'homepage', 1, '', 'a:1:{s:7:"actions";a:16:{s:14:"member-profile";b:0;s:13:"cms/item-list";b:0;s:13:"ask/item-list";b:0;s:19:"core_member_profile";b:0;s:18:"core_member_friend";b:0;s:16:"core_member_view";b:0;s:15:"core_member_diy";b:0;s:16:"core_member_diy2";b:0;s:16:"core_member_diy3";b:0;s:13:"cms_item_list";b:0;s:13:"ask_item_list";b:0;s:19:"talent_company_list";b:0;s:19:"talent_student_list";b:0;s:19:"talent_teacher_list";b:0;s:15:"sites/item-list";b:0;s:15:"sites_item_list";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'client', 1, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"client";b:0;s:6:"config";b:0;}s:7:"actions";a:1:{s:6:"client";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'group', 1, '', 'a:2:{s:13:"admin_actions";a:0:{}s:7:"actions";a:1:{s:3:"add";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'group', 2, '', 'a:2:{s:13:"admin_actions";a:0:{}s:7:"actions";a:1:{s:3:"add";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'client', 2, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"client";b:0;s:6:"config";b:0;}s:7:"actions";a:1:{s:6:"client";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'homepage', 2, '', 'a:1:{s:7:"actions";a:16:{s:14:"member-profile";b:0;s:13:"cms/item-list";b:0;s:13:"ask/item-list";b:0;s:19:"core_member_profile";b:0;s:18:"core_member_friend";b:0;s:16:"core_member_view";b:0;s:15:"core_member_diy";b:0;s:16:"core_member_diy2";b:0;s:16:"core_member_diy3";b:0;s:13:"cms_item_list";b:0;s:13:"ask_item_list";b:0;s:19:"talent_company_list";b:0;s:19:"talent_student_list";b:0;s:19:"talent_teacher_list";b:0;s:15:"sites/item-list";b:0;s:15:"sites_item_list";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'cluster', 2, '', 'a:2:{s:13:"admin_actions";a:10:{s:5:"index";b:0;s:6:"config";b:0;s:6:"client";b:0;s:7:"service";b:0;s:3:"log";b:0;s:14:"client_console";b:0;s:14:"server_console";b:0;s:11:"client_call";b:0;s:11:"server_call";b:0;s:13:"set_admin_acl";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'xspace', 16, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'vote', 16, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"vote";b:0;s:8:"truncate";b:0;s:6:"delete";b:0;}s:7:"actions";a:2:{s:11:"view_result";b:1;s:5:"voter";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'uploader', 16, '', 'a:2:{s:13:"admin_actions";a:4:{s:6:"config";b:0;s:11:"role_filter";b:0;s:4:"list";b:0;s:6:"delete";b:0;}s:7:"actions";a:6:{s:4:"list";b:1;s:6:"upload";b:1;s:6:"mylist";b:1;s:7:"capture";b:1;s:9:"image_cut";b:1;s:6:"delete";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'survey', 16, '', 'a:1:{s:7:"actions";a:4:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"manage";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'uchome', 16, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'spider', 16, '', 'a:2:{s:13:"admin_actions";a:4:{s:8:"category";b:0;s:4:"rule";b:0;s:4:"item";b:0;s:4:"walk";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'special', 16, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"config";b:0;s:5:"label";b:0;s:3:"add";b:0;s:6:"delete";b:0;s:4:"edit";b:0;s:8:"category";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'shortcutsms', 16, '', 'a:1:{s:7:"actions";a:1:{s:6:"client";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'sms', 16, '', 'a:2:{s:13:"admin_actions";a:2:{s:14:"list_interface";b:0;s:4:"test";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'role', 16, '', 'a:2:{s:13:"admin_actions";a:11:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:10:"list_group";b:0;s:9:"add_group";b:0;s:12:"update_group";b:0;s:15:"add_group_field";b:0;s:18:"update_group_field";b:0;s:8:"copy_acl";b:0;s:5:"cache";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'pay', 16, '', 'a:2:{s:13:"admin_actions";a:5:{s:6:"config";b:0;s:9:"interface";b:0;s:5:"order";b:0;s:10:"view_order";b:0;s:19:"update_order_status";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'opinion', 16, '', 'a:1:{s:7:"actions";a:4:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"manage";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'page', 16, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"config";b:0;s:4:"list";b:0;s:3:"add";b:0;s:4:"edit";b:0;s:6:"delete";b:0;s:4:"html";b:0;}s:7:"actions";a:1:{s:10:"addcontent";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'message', 16, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:10:"batch_send";b:0;}s:7:"actions";a:1:{s:4:"send";b:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'notify', 16, '', 'a:2:{s:13:"admin_actions";a:2:{s:3:"add";b:0;s:4:"send";b:0;}s:7:"actions";a:6:{s:3:"add";b:0;s:4:"send";b:0;s:4:"show";b:0;s:4:"edit";b:0;s:6:"resend";b:0;s:7:"message";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'member', 16, '', 'a:2:{s:13:"admin_actions";a:11:{s:6:"config";b:0;s:3:"add";b:0;s:8:"add_list";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:10:"batch_send";b:0;s:6:"credit";b:0;s:8:"recharge";b:0;s:8:"buy_role";b:0;s:9:"integrate";b:0;}s:7:"actions";a:1:{s:12:"address_list";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'mail', 16, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:4:"test";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'letter', 16, '', 'a:3:{s:7:"actions";a:11:{s:4:"list";b:1;s:4:"post";b:1;s:4:"view";b:1;s:7:"manager";b:1;s:9:"delletter";b:0;s:4:"edit";b:0;s:8:"turnover";b:0;s:6:"vefify";b:0;s:7:"endtime";b:0;s:7:"display";b:0;s:5:"reply";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"post";b:1;s:4:"view";b:1;}}}s:16:"my_letter_manage";a:3:{s:4:"list";a:1:{i:0;i:0;}s:4:"post";a:1:{i:0;i:0;}s:4:"view";a:1:{i:0;i:0;}}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'label', 16, '', 'a:2:{s:13:"admin_actions";a:6:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:5:"cache";b:0;s:6:"delete";b:0;s:7:"set_acl";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'interview', 16, '', 'a:2:{s:13:"admin_actions";a:3:{s:6:"config";b:0;s:12:"list_subject";b:0;s:11:"add_subject";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'guestbook', 16, '', 'a:2:{s:13:"admin_actions";a:4:{s:6:"config";b:0;s:4:"list";b:0;s:5:"label";b:0;s:8:"category";b:0;}s:7:"actions";a:7:{s:4:"view";b:1;s:4:"post";b:1;s:10:"autoverify";b:0;s:6:"verify";b:0;s:5:"reply";b:0;s:4:"edit";b:0;s:6:"delete";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'friendlink', 16, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"link";b:0;s:5:"label";b:0;s:4:"sort";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'cservice', 16, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:4:"list";b:0;}s:7:"actions";a:1:{s:12:"admin_replay";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'dbm', 16, '', 'a:2:{s:13:"admin_actions";a:1:{s:0:"";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'discuzx', 16, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'forms', 16, '', 'a:5:{s:13:"admin_actions";a:5:{s:6:"config";b:0;s:4:"list";b:0;s:5:"model";b:0;s:5:"field";b:0;s:5:"label";b:0;}s:7:"actions";a:8:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;s:8:"download";b:0;s:11:"import_list";b:0;s:10:"authmanage";b:0;s:6:"manage";b:0;}s:12:"category_acl";a:55:{i:0;a:1:{s:7:"actions";a:2:{s:4:"post";b:1;s:6:"search";b:1;}}i:1;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:26;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:8;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:17;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:10;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:11;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:13;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:14;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:15;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:18;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:19;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:20;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:21;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:22;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:16;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:24;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:7;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:2;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:3;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:4;a:1:{s:7:"actions";a:1:{s:4:"view";b:1;}}i:39;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:5;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:6;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:9;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:23;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:25;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:27;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:28;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:29;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:30;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:32;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:33;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:34;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:37;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:38;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:40;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:41;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:42;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:43;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:44;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:45;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:46;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:47;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:48;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:49;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:50;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:51;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:52;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:65;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:66;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:70;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}i:71;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}i:72;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}i:76;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}}s:15:"my_forms_manage";a:0:{}s:13:"my_forms_post";a:1:{i:0;i:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'crontab', 16, '', 'a:2:{s:13:"admin_actions";a:5:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:3:"run";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'credit', 16, '', 'a:2:{s:13:"admin_actions";a:9:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:9:"list_rule";b:0;s:8:"add_rule";b:0;s:11:"update_rule";b:0;s:11:"delete_rule";b:0;s:5:"cache";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', '46', 16, '', 'a:2:{s:13:"admin_actions";a:2:{s:2:"ad";b:0;s:3:"buy";b:0;}s:7:"actions";a:2:{s:4:"list";b:1;s:3:"buy";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', '', 16, '', 'a:4:{s:13:"admin_actions";a:33:{s:5:"login";b:0;s:3:"log";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:13:"set_admin_acl";b:0;s:8:"memcache";b:0;s:8:"db_slave";b:0;s:4:"menu";b:0;s:15:"navigation_menu";b:0;s:11:"member_menu";b:0;s:11:"system_list";b:0;s:11:"module_list";b:0;s:11:"plugin_list";b:0;s:6:"plugin";b:0;s:14:"install_system";b:0;s:16:"uninstall_system";b:0;s:14:"install_module";b:0;s:16:"uninstall_module";b:0;s:14:"install_plugin";b:0;s:16:"uninstall_plugin";b:0;s:5:"cache";b:0;s:7:"phpinfo";b:0;s:8:"template";b:0;s:11:"base_config";b:0;s:13:"global_config";b:0;s:10:"reg_config";b:0;s:15:"homepage_config";b:0;s:7:"stop_ip";b:0;s:8:"allow_ip";b:0;s:11:"word_filter";b:0;s:16:"connection_flood";b:0;s:9:"md5_files";b:0;s:4:"area";b:0;}s:7:"actions";a:0:{}s:10:"allow_tags";a:0:{}s:13:"disallow_tags";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'model', 16, '', 'a:2:{s:13:"admin_actions";a:10:{s:3:"add";b:1;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"manage";b:0;s:6:"export";b:0;s:6:"import";b:0;s:9:"add_field";b:0;s:12:"update_field";b:0;s:12:"delete_field";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'statistic', 16, '', 'a:2:{s:13:"admin_actions";a:1:{s:4:"list";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'item', 16, '', 'a:5:{s:13:"admin_actions";a:21:{s:6:"config";b:0;s:3:"add";b:0;s:6:"verify";b:0;s:4:"move";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:7:"comment";b:0;s:14:"verify_comment";b:0;s:14:"delete_comment";b:0;s:12:"list_to_html";b:0;s:12:"view_to_html";b:0;s:9:"attribute";b:0;s:13:"attribute_acl";b:0;s:5:"label";b:0;s:10:"list_order";b:0;s:7:"set_acl";b:0;s:4:"mood";b:0;s:6:"spider";b:0;s:3:"tag";b:0;s:12:"cluster_push";b:0;}s:7:"actions";a:11:{s:6:"search";b:1;s:4:"list";b:1;s:4:"view";b:1;s:7:"comment";b:0;s:3:"add";b:0;s:10:"autoverify";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"verify";b:0;s:9:"attribute";b:0;s:11:"create_time";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}}s:19:"my_addible_category";a:0:{}s:21:"my_category_to_verify";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'member', 16, '', 'a:2:{s:13:"admin_actions";a:5:{s:4:"list";b:0;s:8:"expertor";b:0;s:4:"star";b:0;s:5:"label";b:0;s:4:"post";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', '', 16, '', 'a:2:{s:13:"admin_actions";a:4:{s:4:"html";b:0;s:13:"index_to_html";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'assist_category', 16, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"list";b:0;s:12:"content_list";b:0;s:5:"label";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'group', 4, '', 'a:2:{s:13:"admin_actions";a:0:{}s:7:"actions";a:1:{s:3:"add";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'client', 4, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"client";b:0;s:6:"config";b:0;}s:7:"actions";a:1:{s:6:"client";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'homepage', 4, '', 'a:1:{s:7:"actions";a:16:{s:14:"member-profile";b:0;s:13:"cms/item-list";b:0;s:13:"ask/item-list";b:0;s:19:"core_member_profile";b:0;s:18:"core_member_friend";b:0;s:16:"core_member_view";b:0;s:15:"core_member_diy";b:0;s:16:"core_member_diy2";b:0;s:16:"core_member_diy3";b:0;s:13:"cms_item_list";b:0;s:13:"ask_item_list";b:0;s:19:"talent_company_list";b:0;s:19:"talent_student_list";b:0;s:19:"talent_teacher_list";b:0;s:15:"sites/item-list";b:0;s:15:"sites_item_list";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'cluster', 4, '', 'a:2:{s:13:"admin_actions";a:10:{s:5:"index";b:0;s:6:"config";b:0;s:6:"client";b:0;s:7:"service";b:0;s:3:"log";b:0;s:14:"client_console";b:0;s:14:"server_console";b:0;s:11:"client_call";b:0;s:11:"server_call";b:0;s:13:"set_admin_acl";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'category', 16, '', 'a:2:{s:13:"admin_actions";a:7:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:5:"cache";b:0;s:5:"merge";b:0;s:7:"set_acl";b:0;s:6:"delete";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'category', 16, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"insert";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:7:"set_acl";b:0;s:5:"cache";b:0;}s:7:"actions";a:2:{s:4:"main";b:1;s:3:"get";b:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'item', 16, '', 'a:5:{s:13:"admin_actions";a:18:{s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"verify";b:0;s:9:"recommend";b:0;s:6:"closed";b:0;s:6:"answer";b:0;s:13:"answer_delete";b:0;s:12:"answer_audit";b:0;s:11:"answer_best";b:0;s:11:"answer_vote";b:0;s:14:"answer_content";b:0;s:12:"item_against";b:0;s:14:"answer_against";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:6:"sphinx";b:0;s:5:"label";b:0;}s:7:"actions";a:8:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"poller";b:1;s:6:"search";b:1;s:6:"verify";b:0;s:4:"edit";b:0;s:6:"delete";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:4:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"poller";b:1;}}}s:21:"my_category_to_verify";a:0:{}s:19:"my_addible_category";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', '', 16, '', 'a:2:{s:13:"admin_actions";a:4:{s:10:"statistics";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:9:"cache_all";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'answer', 16, '', 'a:5:{s:13:"admin_actions";a:6:{s:6:"verify";b:0;s:4:"edit";b:0;s:6:"poller";b:0;s:6:"delete";b:0;s:4:"list";b:0;s:7:"against";b:0;}s:7:"actions";a:9:{s:4:"post";b:1;s:11:"post_follow";b:1;s:3:"fen";b:1;s:4:"vote";b:1;s:6:"poller";b:1;s:6:"verify";b:0;s:4:"edit";b:0;s:6:"delete";b:0;s:15:"set_best_answer";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:5:{s:4:"post";b:1;s:11:"post_follow";b:1;s:3:"fen";b:1;s:4:"vote";b:1;s:6:"poller";b:1;}}}s:21:"my_category_to_verify";a:0:{}s:19:"my_addible_category";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'group', 15, '', 'a:2:{s:13:"admin_actions";a:0:{}s:7:"actions";a:1:{s:3:"add";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'client', 15, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"client";b:0;s:6:"config";b:0;}s:7:"actions";a:1:{s:6:"client";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'homepage', 15, '', 'a:1:{s:7:"actions";a:16:{s:14:"member-profile";b:0;s:13:"cms/item-list";b:0;s:13:"ask/item-list";b:0;s:19:"core_member_profile";b:0;s:18:"core_member_friend";b:0;s:16:"core_member_view";b:0;s:15:"core_member_diy";b:0;s:16:"core_member_diy2";b:0;s:16:"core_member_diy3";b:0;s:13:"cms_item_list";b:0;s:13:"ask_item_list";b:0;s:19:"talent_company_list";b:0;s:19:"talent_student_list";b:0;s:19:"talent_teacher_list";b:0;s:15:"sites/item-list";b:0;s:15:"sites_item_list";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'cluster', 15, '', 'a:2:{s:13:"admin_actions";a:10:{s:5:"index";b:0;s:6:"config";b:0;s:6:"client";b:0;s:7:"service";b:0;s:3:"log";b:0;s:14:"client_console";b:0;s:14:"server_console";b:0;s:11:"client_call";b:0;s:11:"server_call";b:0;s:13:"set_admin_acl";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'vote', 15, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"vote";b:0;s:8:"truncate";b:0;s:6:"delete";b:0;}s:7:"actions";a:2:{s:11:"view_result";b:1;s:5:"voter";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'xspace', 15, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'uchome', 15, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'uploader', 15, '', 'a:2:{s:13:"admin_actions";a:4:{s:6:"config";b:0;s:11:"role_filter";b:0;s:4:"list";b:0;s:6:"delete";b:0;}s:7:"actions";a:6:{s:4:"list";b:1;s:6:"upload";b:1;s:6:"mylist";b:1;s:7:"capture";b:1;s:9:"image_cut";b:1;s:6:"delete";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'special', 15, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"config";b:0;s:5:"label";b:0;s:3:"add";b:0;s:6:"delete";b:0;s:4:"edit";b:0;s:8:"category";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'spider', 15, '', 'a:2:{s:13:"admin_actions";a:4:{s:8:"category";b:0;s:4:"rule";b:0;s:4:"item";b:0;s:4:"walk";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'survey', 15, '', 'a:1:{s:7:"actions";a:4:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"manage";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'shortcutsms', 15, '', 'a:1:{s:7:"actions";a:1:{s:6:"client";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'sms', 15, '', 'a:2:{s:13:"admin_actions";a:2:{s:14:"list_interface";b:0;s:4:"test";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'pay', 15, '', 'a:2:{s:13:"admin_actions";a:5:{s:6:"config";b:0;s:9:"interface";b:0;s:5:"order";b:0;s:10:"view_order";b:0;s:19:"update_order_status";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'role', 15, '', 'a:2:{s:13:"admin_actions";a:11:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:10:"list_group";b:0;s:9:"add_group";b:0;s:12:"update_group";b:0;s:15:"add_group_field";b:0;s:18:"update_group_field";b:0;s:8:"copy_acl";b:0;s:5:"cache";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'opinion', 15, '', 'a:1:{s:7:"actions";a:4:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"manage";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'page', 15, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"config";b:0;s:4:"list";b:0;s:3:"add";b:0;s:4:"edit";b:0;s:6:"delete";b:0;s:4:"html";b:0;}s:7:"actions";a:1:{s:10:"addcontent";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'message', 15, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:10:"batch_send";b:0;}s:7:"actions";a:1:{s:4:"send";b:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'notify', 15, '', 'a:2:{s:13:"admin_actions";a:2:{s:3:"add";b:0;s:4:"send";b:0;}s:7:"actions";a:6:{s:3:"add";b:0;s:4:"send";b:0;s:4:"show";b:0;s:4:"edit";b:0;s:6:"resend";b:0;s:7:"message";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'member', 15, '', 'a:2:{s:13:"admin_actions";a:11:{s:6:"config";b:0;s:3:"add";b:0;s:8:"add_list";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:10:"batch_send";b:0;s:6:"credit";b:0;s:8:"recharge";b:0;s:8:"buy_role";b:0;s:9:"integrate";b:0;}s:7:"actions";a:1:{s:12:"address_list";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'mail', 15, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:4:"test";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'label', 15, '', 'a:2:{s:13:"admin_actions";a:6:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:5:"cache";b:0;s:6:"delete";b:0;s:7:"set_acl";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'letter', 15, '', 'a:3:{s:7:"actions";a:11:{s:4:"list";b:1;s:4:"post";b:1;s:4:"view";b:1;s:7:"manager";b:1;s:9:"delletter";b:0;s:4:"edit";b:0;s:8:"turnover";b:0;s:6:"vefify";b:0;s:7:"endtime";b:0;s:7:"display";b:0;s:5:"reply";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"post";b:1;s:4:"view";b:1;}}}s:16:"my_letter_manage";a:3:{s:4:"list";a:1:{i:0;i:0;}s:4:"post";a:1:{i:0;i:0;}s:4:"view";a:1:{i:0;i:0;}}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'guestbook', 15, '', 'a:2:{s:13:"admin_actions";a:4:{s:6:"config";b:0;s:4:"list";b:0;s:5:"label";b:0;s:8:"category";b:0;}s:7:"actions";a:7:{s:4:"view";b:1;s:4:"post";b:1;s:10:"autoverify";b:0;s:6:"verify";b:0;s:5:"reply";b:0;s:4:"edit";b:0;s:6:"delete";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'interview', 15, '', 'a:2:{s:13:"admin_actions";a:3:{s:6:"config";b:0;s:12:"list_subject";b:0;s:11:"add_subject";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'friendlink', 15, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"link";b:0;s:5:"label";b:0;s:4:"sort";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'dbm', 15, '', 'a:2:{s:13:"admin_actions";a:1:{s:0:"";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'discuzx', 15, '', 'a:2:{s:13:"admin_actions";a:2:{s:5:"label";b:0;s:6:"config";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'forms', 15, '', 'a:5:{s:13:"admin_actions";a:5:{s:6:"config";b:0;s:4:"list";b:0;s:5:"model";b:0;s:5:"field";b:0;s:5:"label";b:0;}s:7:"actions";a:8:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;s:8:"download";b:0;s:11:"import_list";b:0;s:10:"authmanage";b:0;s:6:"manage";b:0;}s:12:"category_acl";a:55:{i:0;a:1:{s:7:"actions";a:2:{s:4:"post";b:1;s:6:"search";b:1;}}i:1;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:26;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:8;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:17;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:10;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:11;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:13;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:14;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:15;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:18;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:19;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:20;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:21;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:22;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:16;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:24;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:7;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:2;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:3;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:4;a:1:{s:7:"actions";a:1:{s:4:"view";b:1;}}i:39;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:5;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:6;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:9;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:23;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:25;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:27;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:28;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:29;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:30;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:32;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:33;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:34;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:37;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:38;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:40;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:41;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:42;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:43;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:44;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:45;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:46;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:47;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:48;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:49;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:50;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:51;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:52;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:65;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:66;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}i:70;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}i:71;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}i:72;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}i:76;a:1:{s:7:"actions";a:3:{s:4:"list";b:1;s:4:"view";b:1;s:6:"search";b:1;}}}s:15:"my_forms_manage";a:0:{}s:13:"my_forms_post";a:1:{i:0;i:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'crontab', 15, '', 'a:2:{s:13:"admin_actions";a:5:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:3:"run";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'cservice', 15, '', 'a:2:{s:13:"admin_actions";a:2:{s:6:"config";b:0;s:4:"list";b:0;}s:7:"actions";a:1:{s:12:"admin_replay";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', '46', 15, '', 'a:2:{s:13:"admin_actions";a:2:{s:2:"ad";b:0;s:3:"buy";b:0;}s:7:"actions";a:2:{s:4:"list";b:1;s:3:"buy";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'credit', 15, '', 'a:2:{s:13:"admin_actions";a:9:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:9:"list_rule";b:0;s:8:"add_rule";b:0;s:11:"update_rule";b:0;s:11:"delete_rule";b:0;s:5:"cache";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', '', 15, '', 'a:4:{s:13:"admin_actions";a:33:{s:5:"login";b:0;s:3:"log";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:13:"set_admin_acl";b:0;s:8:"memcache";b:0;s:8:"db_slave";b:0;s:4:"menu";b:0;s:15:"navigation_menu";b:0;s:11:"member_menu";b:0;s:11:"system_list";b:0;s:11:"module_list";b:0;s:11:"plugin_list";b:0;s:6:"plugin";b:0;s:14:"install_system";b:0;s:16:"uninstall_system";b:0;s:14:"install_module";b:0;s:16:"uninstall_module";b:0;s:14:"install_plugin";b:0;s:16:"uninstall_plugin";b:0;s:5:"cache";b:0;s:7:"phpinfo";b:0;s:8:"template";b:0;s:11:"base_config";b:0;s:13:"global_config";b:0;s:10:"reg_config";b:0;s:15:"homepage_config";b:0;s:7:"stop_ip";b:0;s:8:"allow_ip";b:0;s:11:"word_filter";b:0;s:16:"connection_flood";b:0;s:9:"md5_files";b:0;s:4:"area";b:0;}s:7:"actions";a:0:{}s:10:"allow_tags";a:0:{}s:13:"disallow_tags";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'statistic', 15, '', 'a:2:{s:13:"admin_actions";a:1:{s:4:"list";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'model', 15, '', 'a:2:{s:13:"admin_actions";a:10:{s:3:"add";b:1;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"manage";b:0;s:6:"export";b:0;s:6:"import";b:0;s:9:"add_field";b:0;s:12:"update_field";b:0;s:12:"delete_field";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'category', 15, '', 'a:2:{s:13:"admin_actions";a:7:{s:4:"list";b:0;s:3:"add";b:0;s:6:"update";b:0;s:5:"cache";b:0;s:5:"merge";b:0;s:7:"set_acl";b:0;s:6:"delete";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'item', 15, '', 'a:5:{s:13:"admin_actions";a:21:{s:6:"config";b:0;s:3:"add";b:0;s:6:"verify";b:0;s:4:"move";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:7:"comment";b:0;s:14:"verify_comment";b:0;s:14:"delete_comment";b:0;s:12:"list_to_html";b:0;s:12:"view_to_html";b:0;s:9:"attribute";b:0;s:13:"attribute_acl";b:0;s:5:"label";b:0;s:10:"list_order";b:0;s:7:"set_acl";b:0;s:4:"mood";b:0;s:6:"spider";b:0;s:3:"tag";b:0;s:12:"cluster_push";b:0;}s:7:"actions";a:11:{s:6:"search";b:1;s:4:"list";b:1;s:4:"view";b:1;s:7:"comment";b:0;s:3:"add";b:0;s:10:"autoverify";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"verify";b:0;s:9:"attribute";b:0;s:11:"create_time";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:2:{s:4:"list";b:1;s:4:"view";b:1;}}}s:19:"my_addible_category";a:0:{}s:21:"my_category_to_verify";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', '', 15, '', 'a:2:{s:13:"admin_actions";a:4:{s:4:"html";b:0;s:13:"index_to_html";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('cms', 'assist_category', 15, '', 'a:2:{s:13:"admin_actions";a:3:{s:4:"list";b:0;s:12:"content_list";b:0;s:5:"label";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'member', 15, '', 'a:2:{s:13:"admin_actions";a:5:{s:4:"list";b:0;s:8:"expertor";b:0;s:4:"star";b:0;s:5:"label";b:0;s:4:"post";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'category', 15, '', 'a:2:{s:13:"admin_actions";a:6:{s:6:"insert";b:0;s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:7:"set_acl";b:0;s:5:"cache";b:0;}s:7:"actions";a:2:{s:4:"main";b:1;s:3:"get";b:1;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'item', 15, '', 'a:5:{s:13:"admin_actions";a:18:{s:4:"list";b:0;s:6:"update";b:0;s:6:"delete";b:0;s:6:"verify";b:0;s:9:"recommend";b:0;s:6:"closed";b:0;s:6:"answer";b:0;s:13:"answer_delete";b:0;s:12:"answer_audit";b:0;s:11:"answer_best";b:0;s:11:"answer_vote";b:0;s:14:"answer_content";b:0;s:12:"item_against";b:0;s:14:"answer_against";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:6:"sphinx";b:0;s:5:"label";b:0;}s:7:"actions";a:8:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"poller";b:1;s:6:"search";b:1;s:6:"verify";b:0;s:4:"edit";b:0;s:6:"delete";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:4:{s:4:"post";b:1;s:4:"list";b:1;s:4:"view";b:1;s:6:"poller";b:1;}}}s:21:"my_category_to_verify";a:0:{}s:19:"my_addible_category";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', '', 15, '', 'a:2:{s:13:"admin_actions";a:4:{s:10:"statistics";b:0;s:6:"config";b:0;s:7:"set_acl";b:0;s:9:"cache_all";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('ask', 'answer', 15, '', 'a:5:{s:13:"admin_actions";a:6:{s:6:"verify";b:0;s:4:"edit";b:0;s:6:"poller";b:0;s:6:"delete";b:0;s:4:"list";b:0;s:7:"against";b:0;}s:7:"actions";a:9:{s:4:"post";b:1;s:11:"post_follow";b:1;s:3:"fen";b:1;s:4:"vote";b:1;s:6:"poller";b:1;s:6:"verify";b:0;s:4:"edit";b:0;s:6:"delete";b:0;s:15:"set_best_answer";b:0;}s:12:"category_acl";a:1:{i:0;a:1:{s:7:"actions";a:5:{s:4:"post";b:1;s:11:"post_follow";b:1;s:3:"fen";b:1;s:4:"vote";b:1;s:6:"poller";b:1;}}}s:21:"my_category_to_verify";a:0:{}s:19:"my_addible_category";a:0:{}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'homepage', 16, '', 'a:1:{s:7:"actions";a:16:{s:14:"member-profile";b:0;s:13:"cms/item-list";b:0;s:13:"ask/item-list";b:0;s:19:"core_member_profile";b:0;s:18:"core_member_friend";b:0;s:16:"core_member_view";b:0;s:15:"core_member_diy";b:0;s:16:"core_member_diy2";b:0;s:16:"core_member_diy3";b:0;s:13:"cms_item_list";b:0;s:13:"ask_item_list";b:0;s:19:"talent_company_list";b:0;s:19:"talent_student_list";b:0;s:19:"talent_teacher_list";b:0;s:15:"sites/item-list";b:0;s:15:"sites_item_list";b:0;}}');
REPLACE INTO `p8_acl` (`system`, `module`, `role_id`, `postfix`, `v`) VALUES 
('core', 'cluster', 16, '', 'a:2:{s:13:"admin_actions";a:10:{s:5:"index";b:0;s:6:"config";b:0;s:6:"client";b:0;s:7:"service";b:0;s:3:"log";b:0;s:14:"client_console";b:0;s:14:"server_console";b:0;s:11:"client_call";b:0;s:11:"server_call";b:0;s:13:"set_admin_acl";b:0;}s:7:"actions";a:0:{}}');
REPLACE INTO `p8_role` VALUES ('1','core','system','1','管理员','','0','0','0');
REPLACE INTO `p8_role` VALUES ('2','core','normal','2','普通会员','','15','0','0');
REPLACE INTO `p8_role` VALUES ('3','core','system','2','游客','','0','0','0');
REPLACE INTO `p8_role` VALUES ('4','core','normal','1','新闻主编','','8','0','0');
REPLACE INTO `p8_role` VALUES ('16','core','normal','4','企业会员','','0','0','0');
REPLACE INTO `p8_role_group` VALUES ('1','管理员组','0','1','','0');
REPLACE INTO `p8_role_group` VALUES ('2','个人','1','2','','0');
REPLACE INTO `p8_role_group` VALUES ('4','企业','1','12','','0');
REPLACE INTO `p8_role_group_1_data` VALUES ('1');
REPLACE INTO `p8_role_group_1_data` VALUES ('2');
REPLACE INTO `p8_role_group_1_data` VALUES ('3');
REPLACE INTO `p8_role_group_1_data` VALUES ('4');
REPLACE INTO `p8_role_group_1_data` VALUES ('5');
REPLACE INTO `p8_role_group_1_data` VALUES ('8');
REPLACE INTO `p8_role_group_1_data` VALUES ('15');
REPLACE INTO `p8_role_group_1_data` VALUES ('287');
REPLACE INTO `p8_role_group_1_data` VALUES ('288');
REPLACE INTO `p8_role_group_1_data` VALUES ('289');
REPLACE INTO `p8_role_group_1_data` VALUES ('290');
REPLACE INTO `p8_role_group_1_data` VALUES ('291');
REPLACE INTO `p8_role_group_1_data` VALUES ('293');
REPLACE INTO `p8_role_group_1_data` VALUES ('300');
REPLACE INTO `p8_role_group_2_data` VALUES ('2');
REPLACE INTO `p8_role_group_2_data` VALUES ('3');
REPLACE INTO `p8_role_group_2_data` VALUES ('4');
REPLACE INTO `p8_role_group_2_data` VALUES ('6');
REPLACE INTO `p8_role_group_2_data` VALUES ('7');
REPLACE INTO `p8_role_group_2_data` VALUES ('8');
REPLACE INTO `p8_role_group_2_data` VALUES ('9');
REPLACE INTO `p8_role_group_2_data` VALUES ('10');
REPLACE INTO `p8_role_group_2_data` VALUES ('11');
REPLACE INTO `p8_role_group_2_data` VALUES ('12');
REPLACE INTO `p8_role_group_2_data` VALUES ('13');
REPLACE INTO `p8_role_group_2_data` VALUES ('14');
REPLACE INTO `p8_role_group_2_data` VALUES ('15');
REPLACE INTO `p8_role_group_2_data` VALUES ('16');
REPLACE INTO `p8_role_group_2_data` VALUES ('17');
REPLACE INTO `p8_role_group_2_data` VALUES ('18');
REPLACE INTO `p8_role_group_2_data` VALUES ('19');
REPLACE INTO `p8_role_group_2_data` VALUES ('20');
REPLACE INTO `p8_role_group_2_data` VALUES ('21');
REPLACE INTO `p8_role_group_2_data` VALUES ('22');
REPLACE INTO `p8_role_group_2_data` VALUES ('23');
REPLACE INTO `p8_role_group_2_data` VALUES ('24');
REPLACE INTO `p8_role_group_2_data` VALUES ('25');
REPLACE INTO `p8_role_group_2_data` VALUES ('26');
REPLACE INTO `p8_role_group_2_data` VALUES ('27');
REPLACE INTO `p8_role_group_2_data` VALUES ('28');
REPLACE INTO `p8_role_group_2_data` VALUES ('29');
REPLACE INTO `p8_role_group_2_data` VALUES ('30');
REPLACE INTO `p8_role_group_2_data` VALUES ('31');
REPLACE INTO `p8_role_group_2_data` VALUES ('32');
REPLACE INTO `p8_role_group_2_data` VALUES ('33');
REPLACE INTO `p8_role_group_2_data` VALUES ('34');
REPLACE INTO `p8_role_group_2_data` VALUES ('35');
REPLACE INTO `p8_role_group_2_data` VALUES ('36');
REPLACE INTO `p8_role_group_2_data` VALUES ('37');
REPLACE INTO `p8_role_group_2_data` VALUES ('38');
REPLACE INTO `p8_role_group_2_data` VALUES ('39');
REPLACE INTO `p8_role_group_2_data` VALUES ('40');
REPLACE INTO `p8_role_group_2_data` VALUES ('41');
REPLACE INTO `p8_role_group_2_data` VALUES ('42');
REPLACE INTO `p8_role_group_2_data` VALUES ('43');
REPLACE INTO `p8_role_group_2_data` VALUES ('44');
REPLACE INTO `p8_role_group_2_data` VALUES ('45');
REPLACE INTO `p8_role_group_2_data` VALUES ('46');
REPLACE INTO `p8_role_group_2_data` VALUES ('47');
REPLACE INTO `p8_role_group_2_data` VALUES ('48');
REPLACE INTO `p8_role_group_2_data` VALUES ('49');
REPLACE INTO `p8_role_group_2_data` VALUES ('50');
REPLACE INTO `p8_role_group_2_data` VALUES ('51');
REPLACE INTO `p8_role_group_2_data` VALUES ('52');
REPLACE INTO `p8_role_group_2_data` VALUES ('53');
REPLACE INTO `p8_role_group_2_data` VALUES ('54');
REPLACE INTO `p8_role_group_2_data` VALUES ('55');
REPLACE INTO `p8_role_group_2_data` VALUES ('56');
REPLACE INTO `p8_role_group_2_data` VALUES ('57');
REPLACE INTO `p8_role_group_2_data` VALUES ('58');
REPLACE INTO `p8_role_group_2_data` VALUES ('59');
REPLACE INTO `p8_role_group_2_data` VALUES ('60');
REPLACE INTO `p8_role_group_2_data` VALUES ('61');
REPLACE INTO `p8_role_group_2_data` VALUES ('62');
REPLACE INTO `p8_role_group_2_data` VALUES ('63');
REPLACE INTO `p8_role_group_2_data` VALUES ('64');
REPLACE INTO `p8_role_group_2_data` VALUES ('65');
REPLACE INTO `p8_role_group_2_data` VALUES ('66');
REPLACE INTO `p8_role_group_2_data` VALUES ('67');
REPLACE INTO `p8_role_group_2_data` VALUES ('68');
REPLACE INTO `p8_role_group_2_data` VALUES ('69');
REPLACE INTO `p8_role_group_2_data` VALUES ('70');
REPLACE INTO `p8_role_group_2_data` VALUES ('71');
REPLACE INTO `p8_role_group_2_data` VALUES ('72');
REPLACE INTO `p8_role_group_2_data` VALUES ('73');
REPLACE INTO `p8_role_group_2_data` VALUES ('74');
REPLACE INTO `p8_role_group_2_data` VALUES ('75');
REPLACE INTO `p8_role_group_2_data` VALUES ('76');
REPLACE INTO `p8_role_group_2_data` VALUES ('77');
REPLACE INTO `p8_role_group_2_data` VALUES ('78');
REPLACE INTO `p8_role_group_2_data` VALUES ('79');
REPLACE INTO `p8_role_group_2_data` VALUES ('80');
REPLACE INTO `p8_role_group_2_data` VALUES ('81');
REPLACE INTO `p8_role_group_2_data` VALUES ('82');
REPLACE INTO `p8_role_group_2_data` VALUES ('83');
REPLACE INTO `p8_role_group_2_data` VALUES ('84');
REPLACE INTO `p8_role_group_2_data` VALUES ('85');
REPLACE INTO `p8_role_group_2_data` VALUES ('86');
REPLACE INTO `p8_role_group_2_data` VALUES ('87');
REPLACE INTO `p8_role_group_2_data` VALUES ('88');
REPLACE INTO `p8_role_group_2_data` VALUES ('89');
REPLACE INTO `p8_role_group_2_data` VALUES ('90');
REPLACE INTO `p8_role_group_2_data` VALUES ('91');
REPLACE INTO `p8_role_group_2_data` VALUES ('92');
REPLACE INTO `p8_role_group_2_data` VALUES ('93');
REPLACE INTO `p8_role_group_2_data` VALUES ('94');
REPLACE INTO `p8_role_group_2_data` VALUES ('95');
REPLACE INTO `p8_role_group_2_data` VALUES ('96');
REPLACE INTO `p8_role_group_2_data` VALUES ('97');
REPLACE INTO `p8_role_group_2_data` VALUES ('98');
REPLACE INTO `p8_role_group_2_data` VALUES ('99');
REPLACE INTO `p8_role_group_2_data` VALUES ('100');
REPLACE INTO `p8_role_group_2_data` VALUES ('101');
REPLACE INTO `p8_role_group_2_data` VALUES ('102');
REPLACE INTO `p8_role_group_2_data` VALUES ('103');
REPLACE INTO `p8_role_group_2_data` VALUES ('104');
REPLACE INTO `p8_role_group_2_data` VALUES ('105');
REPLACE INTO `p8_role_group_2_data` VALUES ('106');
REPLACE INTO `p8_role_group_2_data` VALUES ('107');
REPLACE INTO `p8_role_group_2_data` VALUES ('108');
REPLACE INTO `p8_role_group_2_data` VALUES ('109');
REPLACE INTO `p8_role_group_2_data` VALUES ('110');
REPLACE INTO `p8_role_group_2_data` VALUES ('111');
REPLACE INTO `p8_role_group_2_data` VALUES ('112');
REPLACE INTO `p8_role_group_2_data` VALUES ('113');
REPLACE INTO `p8_role_group_2_data` VALUES ('114');
REPLACE INTO `p8_role_group_2_data` VALUES ('115');
REPLACE INTO `p8_role_group_2_data` VALUES ('116');
REPLACE INTO `p8_role_group_2_data` VALUES ('117');
REPLACE INTO `p8_role_group_2_data` VALUES ('118');
REPLACE INTO `p8_role_group_2_data` VALUES ('119');
REPLACE INTO `p8_role_group_2_data` VALUES ('120');
REPLACE INTO `p8_role_group_2_data` VALUES ('121');
REPLACE INTO `p8_role_group_2_data` VALUES ('122');
REPLACE INTO `p8_role_group_2_data` VALUES ('123');
REPLACE INTO `p8_role_group_2_data` VALUES ('124');
REPLACE INTO `p8_role_group_2_data` VALUES ('125');
REPLACE INTO `p8_role_group_2_data` VALUES ('126');
REPLACE INTO `p8_role_group_2_data` VALUES ('127');
REPLACE INTO `p8_role_group_2_data` VALUES ('128');
REPLACE INTO `p8_role_group_2_data` VALUES ('129');
REPLACE INTO `p8_role_group_2_data` VALUES ('130');
REPLACE INTO `p8_role_group_2_data` VALUES ('131');
REPLACE INTO `p8_role_group_2_data` VALUES ('132');
REPLACE INTO `p8_role_group_2_data` VALUES ('133');
REPLACE INTO `p8_role_group_2_data` VALUES ('134');
REPLACE INTO `p8_role_group_2_data` VALUES ('135');
REPLACE INTO `p8_role_group_2_data` VALUES ('136');
REPLACE INTO `p8_role_group_2_data` VALUES ('137');
REPLACE INTO `p8_role_group_2_data` VALUES ('138');
REPLACE INTO `p8_role_group_2_data` VALUES ('139');
REPLACE INTO `p8_role_group_2_data` VALUES ('140');
REPLACE INTO `p8_role_group_2_data` VALUES ('141');
REPLACE INTO `p8_role_group_2_data` VALUES ('142');
REPLACE INTO `p8_role_group_2_data` VALUES ('143');
REPLACE INTO `p8_role_group_2_data` VALUES ('144');
REPLACE INTO `p8_role_group_2_data` VALUES ('145');
REPLACE INTO `p8_role_group_2_data` VALUES ('146');
REPLACE INTO `p8_role_group_2_data` VALUES ('147');
REPLACE INTO `p8_role_group_2_data` VALUES ('148');
REPLACE INTO `p8_role_group_2_data` VALUES ('149');
REPLACE INTO `p8_role_group_2_data` VALUES ('150');
REPLACE INTO `p8_role_group_2_data` VALUES ('151');
REPLACE INTO `p8_role_group_2_data` VALUES ('152');
REPLACE INTO `p8_role_group_2_data` VALUES ('153');
REPLACE INTO `p8_role_group_2_data` VALUES ('154');
REPLACE INTO `p8_role_group_2_data` VALUES ('155');
REPLACE INTO `p8_role_group_2_data` VALUES ('156');
REPLACE INTO `p8_role_group_2_data` VALUES ('157');
REPLACE INTO `p8_role_group_2_data` VALUES ('158');
REPLACE INTO `p8_role_group_2_data` VALUES ('159');
REPLACE INTO `p8_role_group_2_data` VALUES ('160');
REPLACE INTO `p8_role_group_2_data` VALUES ('161');
REPLACE INTO `p8_role_group_2_data` VALUES ('162');
REPLACE INTO `p8_role_group_2_data` VALUES ('163');
REPLACE INTO `p8_role_group_2_data` VALUES ('164');
REPLACE INTO `p8_role_group_2_data` VALUES ('165');
REPLACE INTO `p8_role_group_2_data` VALUES ('166');
REPLACE INTO `p8_role_group_2_data` VALUES ('167');
REPLACE INTO `p8_role_group_2_data` VALUES ('168');
REPLACE INTO `p8_role_group_2_data` VALUES ('169');
REPLACE INTO `p8_role_group_2_data` VALUES ('170');
REPLACE INTO `p8_role_group_2_data` VALUES ('171');
REPLACE INTO `p8_role_group_2_data` VALUES ('172');
REPLACE INTO `p8_role_group_2_data` VALUES ('173');
REPLACE INTO `p8_role_group_2_data` VALUES ('174');
REPLACE INTO `p8_role_group_2_data` VALUES ('175');
REPLACE INTO `p8_role_group_2_data` VALUES ('176');
REPLACE INTO `p8_role_group_2_data` VALUES ('177');
REPLACE INTO `p8_role_group_2_data` VALUES ('178');
REPLACE INTO `p8_role_group_2_data` VALUES ('179');
REPLACE INTO `p8_role_group_2_data` VALUES ('180');
REPLACE INTO `p8_role_group_2_data` VALUES ('181');
REPLACE INTO `p8_role_group_2_data` VALUES ('182');
REPLACE INTO `p8_role_group_2_data` VALUES ('183');
REPLACE INTO `p8_role_group_2_data` VALUES ('184');
REPLACE INTO `p8_role_group_2_data` VALUES ('185');
REPLACE INTO `p8_role_group_2_data` VALUES ('186');
REPLACE INTO `p8_role_group_2_data` VALUES ('187');
REPLACE INTO `p8_role_group_2_data` VALUES ('188');
REPLACE INTO `p8_role_group_2_data` VALUES ('189');
REPLACE INTO `p8_role_group_2_data` VALUES ('190');
REPLACE INTO `p8_role_group_2_data` VALUES ('191');
REPLACE INTO `p8_role_group_2_data` VALUES ('192');
REPLACE INTO `p8_role_group_2_data` VALUES ('193');
REPLACE INTO `p8_role_group_2_data` VALUES ('194');
REPLACE INTO `p8_role_group_2_data` VALUES ('195');
REPLACE INTO `p8_role_group_2_data` VALUES ('196');
REPLACE INTO `p8_role_group_2_data` VALUES ('197');
REPLACE INTO `p8_role_group_2_data` VALUES ('198');
REPLACE INTO `p8_role_group_2_data` VALUES ('199');
REPLACE INTO `p8_role_group_2_data` VALUES ('200');
REPLACE INTO `p8_role_group_2_data` VALUES ('201');
REPLACE INTO `p8_role_group_2_data` VALUES ('202');
REPLACE INTO `p8_role_group_2_data` VALUES ('203');
REPLACE INTO `p8_role_group_2_data` VALUES ('204');
REPLACE INTO `p8_role_group_2_data` VALUES ('205');
REPLACE INTO `p8_role_group_2_data` VALUES ('206');
REPLACE INTO `p8_role_group_2_data` VALUES ('207');
REPLACE INTO `p8_role_group_2_data` VALUES ('208');
REPLACE INTO `p8_role_group_2_data` VALUES ('209');
REPLACE INTO `p8_role_group_2_data` VALUES ('210');
REPLACE INTO `p8_role_group_2_data` VALUES ('211');
REPLACE INTO `p8_role_group_2_data` VALUES ('212');
REPLACE INTO `p8_role_group_2_data` VALUES ('213');
REPLACE INTO `p8_role_group_2_data` VALUES ('214');
REPLACE INTO `p8_role_group_2_data` VALUES ('215');
REPLACE INTO `p8_role_group_2_data` VALUES ('216');
REPLACE INTO `p8_role_group_2_data` VALUES ('217');
REPLACE INTO `p8_role_group_2_data` VALUES ('218');
REPLACE INTO `p8_role_group_2_data` VALUES ('219');
REPLACE INTO `p8_role_group_2_data` VALUES ('220');
REPLACE INTO `p8_role_group_2_data` VALUES ('221');
REPLACE INTO `p8_role_group_2_data` VALUES ('222');
REPLACE INTO `p8_role_group_2_data` VALUES ('223');
REPLACE INTO `p8_role_group_2_data` VALUES ('224');
REPLACE INTO `p8_role_group_2_data` VALUES ('225');
REPLACE INTO `p8_role_group_2_data` VALUES ('226');
REPLACE INTO `p8_role_group_2_data` VALUES ('227');
REPLACE INTO `p8_role_group_2_data` VALUES ('228');
REPLACE INTO `p8_role_group_2_data` VALUES ('229');
REPLACE INTO `p8_role_group_2_data` VALUES ('230');
REPLACE INTO `p8_role_group_2_data` VALUES ('231');
REPLACE INTO `p8_role_group_2_data` VALUES ('232');
REPLACE INTO `p8_role_group_2_data` VALUES ('233');
REPLACE INTO `p8_role_group_2_data` VALUES ('234');
REPLACE INTO `p8_role_group_2_data` VALUES ('235');
REPLACE INTO `p8_role_group_2_data` VALUES ('236');
REPLACE INTO `p8_role_group_2_data` VALUES ('237');
REPLACE INTO `p8_role_group_2_data` VALUES ('238');
REPLACE INTO `p8_role_group_2_data` VALUES ('239');
REPLACE INTO `p8_role_group_2_data` VALUES ('240');
REPLACE INTO `p8_role_group_2_data` VALUES ('241');
REPLACE INTO `p8_role_group_2_data` VALUES ('242');
REPLACE INTO `p8_role_group_2_data` VALUES ('243');
REPLACE INTO `p8_role_group_2_data` VALUES ('244');
REPLACE INTO `p8_role_group_2_data` VALUES ('245');
REPLACE INTO `p8_role_group_2_data` VALUES ('246');
REPLACE INTO `p8_role_group_2_data` VALUES ('247');
REPLACE INTO `p8_role_group_2_data` VALUES ('248');
REPLACE INTO `p8_role_group_2_data` VALUES ('249');
REPLACE INTO `p8_role_group_2_data` VALUES ('250');
REPLACE INTO `p8_role_group_2_data` VALUES ('251');
REPLACE INTO `p8_role_group_2_data` VALUES ('252');
REPLACE INTO `p8_role_group_2_data` VALUES ('253');
REPLACE INTO `p8_role_group_2_data` VALUES ('254');
REPLACE INTO `p8_role_group_2_data` VALUES ('255');
REPLACE INTO `p8_role_group_2_data` VALUES ('256');
REPLACE INTO `p8_role_group_2_data` VALUES ('257');
REPLACE INTO `p8_role_group_2_data` VALUES ('258');
REPLACE INTO `p8_role_group_2_data` VALUES ('259');
REPLACE INTO `p8_role_group_2_data` VALUES ('260');
REPLACE INTO `p8_role_group_2_data` VALUES ('261');
REPLACE INTO `p8_role_group_2_data` VALUES ('262');
REPLACE INTO `p8_role_group_2_data` VALUES ('263');
REPLACE INTO `p8_role_group_2_data` VALUES ('264');
REPLACE INTO `p8_role_group_2_data` VALUES ('265');
REPLACE INTO `p8_role_group_2_data` VALUES ('266');
REPLACE INTO `p8_role_group_2_data` VALUES ('267');
REPLACE INTO `p8_role_group_2_data` VALUES ('268');
REPLACE INTO `p8_role_group_2_data` VALUES ('269');
REPLACE INTO `p8_role_group_2_data` VALUES ('270');
REPLACE INTO `p8_role_group_2_data` VALUES ('271');
REPLACE INTO `p8_role_group_2_data` VALUES ('272');
REPLACE INTO `p8_role_group_2_data` VALUES ('273');
REPLACE INTO `p8_role_group_2_data` VALUES ('274');
REPLACE INTO `p8_role_group_2_data` VALUES ('275');
REPLACE INTO `p8_role_group_2_data` VALUES ('276');
REPLACE INTO `p8_role_group_2_data` VALUES ('277');
REPLACE INTO `p8_role_group_2_data` VALUES ('278');
REPLACE INTO `p8_role_group_2_data` VALUES ('279');
REPLACE INTO `p8_role_group_2_data` VALUES ('280');
REPLACE INTO `p8_role_group_2_data` VALUES ('281');
REPLACE INTO `p8_role_group_2_data` VALUES ('282');
REPLACE INTO `p8_role_group_2_data` VALUES ('283');
REPLACE INTO `p8_role_group_2_data` VALUES ('284');
REPLACE INTO `p8_role_group_2_data` VALUES ('285');
REPLACE INTO `p8_role_group_2_data` VALUES ('286');
REPLACE INTO `p8_role_group_2_data` VALUES ('292');
REPLACE INTO `p8_role_group_2_data` VALUES ('294');
REPLACE INTO `p8_role_group_2_data` VALUES ('296');
REPLACE INTO `p8_role_group_2_data` VALUES ('297');
REPLACE INTO `p8_role_group_4_data` VALUES ('3');
REPLACE INTO `p8_role_group_4_data` VALUES ('4');
REPLACE INTO `p8_role_group_4_data` VALUES ('5');
REPLACE INTO `p8_role_group_4_data` VALUES ('6');
REPLACE INTO `p8_role_group_4_data` VALUES ('7');
REPLACE INTO `p8_role_group_4_data` VALUES ('8');
REPLACE INTO `p8_role_group_4_data` VALUES ('9');
REPLACE INTO `p8_role_group_4_data` VALUES ('295');
REPLACE INTO `p8_role_group_4_data` VALUES ('298');
REPLACE INTO `p8_role_group_4_data` VALUES ('299');