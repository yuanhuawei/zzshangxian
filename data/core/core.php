<?php
return array (
  'encode_conv_functions' => 
  array (
    'default' => '',
    'mb_convert_encoding' => 'mb_convert_encoding',
    'iconv' => 'iconv',
  ),
  'mysql_connect_types' => 
  array (
    'mysql' => 'P8_mysql',
    'mysqli' => 'P8_mysqli',
  ),
  'next_crontab' => '1651385100',
  '2dimensional' => '',
  'administrator_role' => '1',
  'administrator_role_group' => '1',
  'admin_controller' => 'admin.php',
  'admin_email' => '',
  'admin_login_code' => '',
  'admin_login_with_captcha' => '0',
  'attachment' => 
  array (
    'confuse' => '1',
    'path' => 'attachment',
    'remote' => 
    array (
      'server' => 
      array (
        1 => 'http://jt.php168.net/attachment',
      ),
    ),
  ),
  'base_domain' => '',
  'build' => '20170610',
  'cc_num' => '20',
  'cc_time' => '30',
  'cookie' => 
  array (
    'prefix' => 'jebA_',
    'path' => '/',
    'domain' => '',
  ),
  'copyright' => '联系方式: MSN: 88888@hotmail.com 邮箱:setpoterheight QQ：888888888 电话：020-8888888 传真：020-88888888',
  'copyright_domain' => '粤ICP备05011111号 ',
  'CoreMenu' => '1',
  'core_table_prefix' => '',
  'credit' => '1',
  'credits' => 
  array (
    1 => 
    array (
      'name' => '积分',
      'unit' => '个',
      'is_unsigned' => '0',
      'float_bit' => '0',
      'roe' => 
      array (
      ),
    ),
    2 => 
    array (
      'name' => '金币',
      'unit' => '枚',
      'is_unsigned' => '0',
      'float_bit' => '0',
      'roe' => 
      array (
      ),
    ),
  ),
  'credit_common' => '1',
  'credit_gold' => '2',
  'debug' => '0',
  'enable_mobile' => '1',
  'encode_conv_func' => 'iconv',
  'expire' => '0',
  'guest_role' => '3',
  'gzip' => '0',
  'hash_name' => '',
  'homepage_template' => 'homepage/default',
  'homepage_templates' => '',
  'hook_modules' => 
  array (
    'member' => 
    array (
      'core' => 
      array (
        'uploader' => 'uid',
        'message' => 'sendee_uid',
        'pay' => 'buyer_uid',
      ),
      'ask' => 
      array (
        'item' => 'uid',
        'answer' => 'uid',
      ),
      'cms' => 
      array (
        'item' => 'uid',
      ),
    ),
    'label' => 
    array (
      'core' => 
      array (
        'uploader' => 'item_id',
      ),
    ),
    'message' => 
    array (
      'core' => 
      array (
        'uploader' => 'item_id',
      ),
    ),
    46 => 
    array (
      'core' => 
      array (
        'uploader' => 'item_id',
      ),
    ),
    'forms' => 
    array (
      'core' => 
      array (
        'uploader' => 'form_id',
      ),
    ),
    'notify' => 
    array (
      'core' => 
      array (
        'uploader' => 'item_id',
      ),
    ),
    'special' => 
    array (
      'core' => 
      array (
        'uploader' => 'item_id',
      ),
    ),
    'spider' => 
    array (
      'core' => 
      array (
        'uploader' => 'item_id',
      ),
    ),
    'vote' => 
    array (
      'core' => 
      array (
        'uploader' => 'item_id',
      ),
    ),
  ),
  'index_system' => 'cms',
  'lang' => 'zh-cn',
  'language' => 
  array (
    'zh-cn' => '中文',
  ),
  'last_acl_cache' => '1585720620',
  'last_credit_cache' => '1585720575',
  'last_label_cache' => '1585720592',
  'last_last_label_cache' => '1585720015',
  'last_user_acl_cache' => '1585720602',
  'logo' => '',
  'member_role' => '2',
  'member_template' => 'member/default',
  'member_templates' => 
  array (
    'default' => '默认风格',
  ),
  'memcache' => 
  array (
    'enabled' => 0,
    'host' => 'localhost',
    'port' => '11211',
    'pconnect' => 1,
    'prefix' => 'Udzj_',
    'server' => 
    array (
      'localhost:11211' => 
      array (
        'host' => 'localhost',
        'port' => 11211,
      ),
    ),
  ),
  'mobile_auto_jump' => '1',
  'mobile_logo' => '',
  'mobile_template' => 'mobile/group',
  'mobile_templates' => 
  array (
    'default' => '默认风格',
    'group' => '集团风格',
  ),
  'modules' => 
  array (
    46 => 
    array (
      'name' => '46',
      'url' => 'http://localhost:8080/jt/modules/46',
      'controller' => 'http://localhost:8080/jt/index.php/46',
      'U_controller' => 'http://localhost:8080/jt/u.php/46',
      'alias' => '广告系统',
      'class' => 'P8_46',
      'controller_class' => 'P8_46_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'credit' => 
    array (
      'name' => 'credit',
      'url' => 'http://localhost:8080/jt/modules/credit',
      'controller' => 'http://localhost:8080/jt/index.php/credit',
      'U_controller' => 'http://localhost:8080/jt/u.php/credit',
      'alias' => '积分模块',
      'class' => 'P8_Credit',
      'controller_class' => 'P8_Credit_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'crontab' => 
    array (
      'name' => 'crontab',
      'url' => 'http://localhost:8080/jt/modules/crontab',
      'controller' => 'http://localhost:8080/jt/index.php/crontab',
      'U_controller' => 'http://localhost:8080/jt/u.php/crontab',
      'alias' => '计划任务',
      'class' => 'P8_Crontab',
      'controller_class' => 'P8_Crontab_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'cservice' => 
    array (
      'name' => 'cservice',
      'url' => 'http://localhost:8080/jt/modules/cservice',
      'controller' => 'http://localhost:8080/jt/index.php/cservice',
      'U_controller' => 'http://localhost:8080/jt/u.php/cservice',
      'alias' => '投诉建议',
      'class' => 'P8_CService',
      'controller_class' => 'P8_CService_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'dbm' => 
    array (
      'name' => 'dbm',
      'url' => 'http://localhost:8080/jt/modules/dbm',
      'controller' => 'http://localhost:8080/jt/index.php/dbm',
      'U_controller' => 'http://localhost:8080/jt/u.php/dbm',
      'alias' => '数据库管理',
      'class' => 'P8_DBM',
      'controller_class' => 'P8_DBM_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'discuzx' => 
    array (
      'name' => 'discuzx',
      'url' => 'http://www.xxx.com',
      'controller' => 'http://localhost:8080/jt/index.php/discuzx',
      'U_controller' => 'http://localhost:8080/jt/u.php/discuzx',
      'alias' => 'discuzX数据调用',
      'class' => 'P8_DiscuzX',
      'controller_class' => 'P8_DiscuzX_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'forms' => 
    array (
      'name' => 'forms',
      'url' => 'http://localhost:8080/jt/modules/forms',
      'controller' => 'http://localhost:8080/jt/index.php/forms',
      'U_controller' => 'http://localhost:8080/jt/u.php/forms',
      'alias' => '万能表单',
      'class' => 'P8_forms',
      'controller_class' => 'P8_Forms_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'friendlink' => 
    array (
      'name' => 'friendlink',
      'url' => 'http://localhost:8080/jt/modules/friendlink',
      'controller' => 'http://localhost:8080/jt/index.php/friendlink',
      'U_controller' => 'http://localhost:8080/jt/u.php/friendlink',
      'alias' => '友情链接',
      'class' => 'P8_Friendlink',
      'controller_class' => 'P8_Friendlink_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'guestbook' => 
    array (
      'name' => 'guestbook',
      'url' => 'http://localhost:8080/jt/modules/guestbook',
      'controller' => 'http://localhost:8080/jt/index.php/guestbook',
      'U_controller' => 'http://localhost:8080/jt/u.php/guestbook',
      'alias' => '留言本',
      'class' => 'P8_Guestbook',
      'controller_class' => 'P8_Guestbook_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'interview' => 
    array (
      'name' => 'interview',
      'url' => 'http://localhost:8080/jt/modules/interview',
      'controller' => 'http://localhost:8080/jt/index.php/interview',
      'U_controller' => 'http://localhost:8080/jt/u.php/interview',
      'alias' => '在线访谈',
      'class' => 'P8_Interview',
      'controller_class' => 'P8_Interview_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'label' => 
    array (
      'name' => 'label',
      'url' => 'http://localhost:8080/jt/modules/label',
      'controller' => 'http://localhost:8080/jt/index.php/label',
      'U_controller' => 'http://localhost:8080/jt/u.php/label',
      'alias' => '标签模块',
      'class' => 'P8_Label',
      'controller_class' => 'P8_Label_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'letter' => 
    array (
      'name' => 'letter',
      'url' => 'http://localhost:8080/jt/modules/letter',
      'controller' => 'http://localhost:8080/jt/index.php/letter',
      'U_controller' => 'http://localhost:8080/jt/u.php/letter',
      'alias' => '领导信箱',
      'class' => 'P8_Letter',
      'controller_class' => 'P8_Letter_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'mail' => 
    array (
      'name' => 'mail',
      'url' => 'http://localhost:8080/jt/modules/mail',
      'controller' => 'http://localhost:8080/jt/index.php/mail',
      'U_controller' => 'http://localhost:8080/jt/u.php/mail',
      'alias' => '邮件模块',
      'class' => 'P8_Mail',
      'controller_class' => 'P8_Mail_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'member' => 
    array (
      'name' => 'member',
      'url' => 'http://localhost:8080/jt/modules/member',
      'controller' => 'http://localhost:8080/jt/index.php/member',
      'U_controller' => 'http://localhost:8080/jt/u.php/member',
      'alias' => '会员模块',
      'class' => 'P8_Member',
      'controller_class' => 'P8_Member_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'message' => 
    array (
      'name' => 'message',
      'url' => 'http://localhost:8080/jt/modules/message',
      'controller' => 'http://localhost:8080/jt/index.php/message',
      'U_controller' => 'http://localhost:8080/jt/u.php/message',
      'alias' => '短消息模块',
      'class' => 'P8_Message',
      'controller_class' => 'P8_Message_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'notify' => 
    array (
      'name' => 'notify',
      'url' => 'http://localhost:8080/jt/modules/notify',
      'controller' => 'http://localhost:8080/jt/index.php/notify',
      'U_controller' => 'http://localhost:8080/jt/u.php/notify',
      'alias' => '通知',
      'class' => 'P8_Notify',
      'controller_class' => 'P8_Notify_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'opinion' => 
    array (
      'name' => 'opinion',
      'url' => 'http://localhost:8080/jt/modules/opinion',
      'controller' => 'http://localhost:8080/jt/index.php/opinion',
      'U_controller' => 'http://localhost:8080/jt/u.php/opinion',
      'alias' => '意见征集',
      'class' => 'P8_Opinion',
      'controller_class' => 'P8_Opinion_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'page' => 
    array (
      'name' => 'page',
      'url' => 'http://localhost:8080/jt/modules/page',
      'controller' => 'http://localhost:8080/jt/index.php/page',
      'U_controller' => 'http://localhost:8080/jt/u.php/page',
      'alias' => '独立页',
      'class' => 'P8_Page',
      'controller_class' => 'P8_Page_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'pay' => 
    array (
      'name' => 'pay',
      'url' => 'http://localhost:8080/jt/modules/pay',
      'controller' => 'http://localhost:8080/jt/index.php/pay',
      'U_controller' => 'http://localhost:8080/jt/u.php/pay',
      'alias' => '支付模块',
      'class' => 'P8_Pay',
      'controller_class' => 'P8_Pay_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'role' => 
    array (
      'name' => 'role',
      'url' => 'http://localhost:8080/jt/modules/role',
      'controller' => 'http://localhost:8080/jt/index.php/role',
      'U_controller' => 'http://localhost:8080/jt/u.php/role',
      'alias' => '角色模块',
      'class' => 'P8_Role',
      'controller_class' => 'P8_Role_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'shortcutsms' => 
    array (
      'name' => 'shortcutsms',
      'url' => 'http://localhost:8080/jt/modules/shortcutsms',
      'controller' => 'http://localhost:8080/jt/index.php/shortcutsms',
      'U_controller' => 'http://localhost:8080/jt/u.php/shortcutsms',
      'alias' => '快捷短信管理',
      'class' => 'P8_ShortcutSms',
      'controller_class' => 'P8_ShortcutSms_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'sms' => 
    array (
      'name' => 'sms',
      'url' => 'http://localhost:8080/jt/modules/sms',
      'controller' => 'http://localhost:8080/jt/index.php/sms',
      'U_controller' => 'http://localhost:8080/jt/u.php/sms',
      'alias' => '手机短信模块',
      'class' => 'P8_SMS',
      'controller_class' => 'P8_SMS_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'special' => 
    array (
      'name' => 'special',
      'url' => 'http://localhost:8080/jt/modules/special',
      'controller' => 'http://localhost:8080/jt/index.php/special',
      'U_controller' => 'http://localhost:8080/jt/u.php/special',
      'alias' => '专题',
      'class' => 'P8_Special',
      'controller_class' => 'P8_Special_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'spider' => 
    array (
      'name' => 'spider',
      'url' => 'http://localhost:8080/jt/modules/spider',
      'controller' => 'http://localhost:8080/jt/index.php/spider',
      'U_controller' => 'http://localhost:8080/jt/u.php/spider',
      'alias' => '采集',
      'class' => 'P8_Spider',
      'controller_class' => 'P8_Spider_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'survey' => 
    array (
      'name' => 'survey',
      'url' => 'http://localhost:8080/jt/modules/survey',
      'controller' => 'http://localhost:8080/jt/index.php/survey',
      'U_controller' => 'http://localhost:8080/jt/u.php/survey',
      'alias' => '问卷调查',
      'class' => 'P8_Survey',
      'controller_class' => 'P8_Survey_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'uchome' => 
    array (
      'name' => 'uchome',
      'url' => 'http://www.xxx.com',
      'controller' => 'http://localhost:8080/jt/index.php/uchome',
      'U_controller' => 'http://localhost:8080/jt/u.php/uchome',
      'alias' => 'Uchome数据调用',
      'class' => 'P8_Uchome',
      'controller_class' => 'P8_Uchome_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'uploader' => 
    array (
      'name' => 'uploader',
      'url' => 'http://localhost:8080/jt/modules/uploader',
      'controller' => 'http://localhost:8080/jt/index.php/uploader',
      'U_controller' => 'http://localhost:8080/jt/u.php/uploader',
      'alias' => '上传模块',
      'class' => 'P8_Uploader',
      'controller_class' => 'P8_Uploader_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'vote' => 
    array (
      'name' => 'vote',
      'url' => 'http://localhost:8080/jt/modules/vote',
      'controller' => 'http://localhost:8080/jt/index.php/vote',
      'U_controller' => 'http://localhost:8080/jt/u.php/vote',
      'alias' => '投票',
      'class' => 'P8_Vote',
      'controller_class' => 'P8_Vote_Controller',
      'installed' => true,
      'enabled' => true,
    ),
    'xspace' => 
    array (
      'name' => 'xspace',
      'url' => 'http://www.xxx.com',
      'controller' => 'http://localhost:8080/jt/index.php/xspace',
      'U_controller' => 'http://localhost:8080/jt/u.php/xspace',
      'alias' => 'xspace数据调用',
      'class' => 'P8_Xspace',
      'controller_class' => 'P8_Xspace_Controller',
      'installed' => true,
      'enabled' => true,
    ),
  ),
  'murl' => 'http://localhost:8080/jt/m',
  'mysql_charset' => 'utf8',
  'mysql_connect_type' => 'mysql',
  'p8_key' => 'eae383d01305296c716c4a16b54bc5ed',
  'page_charset' => 'utf-8',
  'person_role_group' => '2',
  'plugins' => 
  array (
    'anv' => 
    array (
      'alias' => '亚洲网视可视化售后',
      'class' => 'P8_Plugin_Anv',
      'installed' => true,
      'enabled' => true,
    ),
    'qqconnect' => 
    array (
      'alias' => 'QQ登录',
      'class' => 'P8_Plugin_Qqconnect',
      'installed' => true,
      'enabled' => true,
    ),
    'schedul' => 
    array (
      'alias' => '排班',
      'class' => 'P8_Plugin_Schedul',
      'installed' => true,
      'enabled' => true,
    ),
  ),
  'resource_url' => '',
  'robot_log' => '0',
  'serial_number' => 'ET47A-TN003-PO3DH-BYH7P-79E11',
  'session_cross_domains' => 
  array (
  ),
  'ShowMenu' => '1',
  'site_close_reason' => '网站正在维护中...',
  'site_description' => '国微企业级CMS为中国领先的开源CMS平台，专注提供媒学校、企业、局级政府、站群系统等中高端平台',
  'site_key_word' => '国微CMS,政府方案,站群方案,学校方案',
  'site_name' => '国微集团方案----领先的集团站群系统',
  'site_open' => '1',
  'sphinx_prefix' => '',
  'ssi' => '',
  'statistics' => '',
  'system&module' => 
  array (
    'ask' => 
    array (
      'name' => 'ask',
      'url' => 'http://localhost:8080/jt/ask',
      'controller' => 'http://localhost:8080/jt/index.php/ask',
      'U_controller' => 'http://localhost:8080/jt/u.php/ask',
      'alias' => '问答系统',
      'class' => 'P8_Ask',
      'table_prefix' => 'p8_ask_',
      'controller_class' => 'P8_Ask_Controller',
      'installed' => true,
      'enabled' => true,
      'modules' => 
      array (
        'answer' => 
        array (
          'name' => 'answer',
          'url' => 'http://localhost:8080/jt/ask/modules/answer',
          'controller' => 'http://localhost:8080/jt/index.php/ask/answer',
          'U_controller' => 'http://localhost:8080/jt/u.php/ask/answer',
          'alias' => '答案模块',
          'class' => 'P8_Ask_answer',
          'controller_class' => 'P8_Ask_answer_Controller',
          'installed' => true,
          'enabled' => true,
        ),
        'category' => 
        array (
          'name' => 'category',
          'url' => 'http://localhost:8080/jt/ask/modules/category',
          'controller' => 'http://localhost:8080/jt/index.php/ask/category',
          'U_controller' => 'http://localhost:8080/jt/u.php/ask/category',
          'alias' => '问答分类模块',
          'class' => 'P8_Ask_Category',
          'controller_class' => 'P8_Ask_Category_Controller',
          'installed' => true,
          'enabled' => true,
        ),
        'item' => 
        array (
          'name' => 'item',
          'url' => 'http://localhost:8080/jt/ask/modules/item',
          'controller' => 'http://localhost:8080/jt/index.php/ask/item',
          'U_controller' => 'http://localhost:8080/jt/u.php/ask/item',
          'alias' => '问题模块',
          'class' => 'P8_Ask_item',
          'controller_class' => 'P8_Ask_item_Controller',
          'installed' => true,
          'enabled' => true,
        ),
        'member' => 
        array (
          'name' => 'member',
          'url' => 'http://localhost:8080/jt/ask/modules/member',
          'controller' => 'http://localhost:8080/jt/index.php/ask/member',
          'U_controller' => 'http://localhost:8080/jt/u.php/ask/member',
          'alias' => '问答会员模块',
          'class' => 'P8_Ask_Member',
          'controller_class' => 'P8_Ask_Member_Controller',
          'installed' => true,
          'enabled' => true,
        ),
      ),
    ),
    'cms' => 
    array (
      'name' => 'cms',
      'url' => 'http://localhost:8080/jt/cms',
      'controller' => 'http://localhost:8080/jt/index.php/cms',
      'U_controller' => 'http://localhost:8080/jt/u.php/cms',
      'alias' => 'CMS系统',
      'class' => 'P8_CMS',
      'table_prefix' => 'p8_cms_',
      'controller_class' => 'P8_CMS_Controller',
      'installed' => true,
      'enabled' => true,
      'modules' => 
      array (
        'assist_category' => 
        array (
          'name' => 'assist_category',
          'url' => 'http://localhost:8080/jt/cms/modules/assist_category',
          'controller' => 'http://localhost:8080/jt/index.php/cms/assist_category',
          'U_controller' => 'http://localhost:8080/jt/u.php/cms/assist_category',
          'alias' => 'CMS副栏目',
          'class' => 'P8_CMS_Assist_category',
          'controller_class' => 'P8_CMS_Assist_category_Controller',
          'installed' => true,
          'enabled' => true,
        ),
        'category' => 
        array (
          'name' => 'category',
          'url' => 'http://localhost:8080/jt/cms/modules/category',
          'controller' => 'http://localhost:8080/jt/index.php/cms/category',
          'U_controller' => 'http://localhost:8080/jt/u.php/cms/category',
          'alias' => 'CMS分类模块',
          'class' => 'P8_CMS_Category',
          'controller_class' => 'P8_CMS_Category_Controller',
          'installed' => true,
          'enabled' => true,
        ),
        'item' => 
        array (
          'name' => 'item',
          'url' => 'http://localhost:8080/jt/cms/modules/item',
          'controller' => 'http://localhost:8080/jt/index.php/cms/item',
          'U_controller' => 'http://localhost:8080/jt/u.php/cms/item',
          'alias' => 'CMS内容模块',
          'class' => 'P8_CMS_Item',
          'controller_class' => 'P8_CMS_Item_Controller',
          'installed' => true,
          'enabled' => true,
        ),
        'model' => 
        array (
          'name' => 'model',
          'url' => 'http://localhost:8080/jt/cms/modules/model',
          'controller' => 'http://localhost:8080/jt/index.php/cms/model',
          'U_controller' => 'http://localhost:8080/jt/u.php/cms/model',
          'alias' => 'CMS模型模块',
          'class' => 'P8_CMS_Model',
          'controller_class' => 'P8_CMS_Model_Controller',
          'installed' => true,
          'enabled' => true,
        ),
        'statistic' => 
        array (
          'name' => 'statistic',
          'url' => 'http://localhost:8080/jt/cms/modules/statistic',
          'controller' => 'http://localhost:8080/jt/index.php/cms/statistic',
          'U_controller' => 'http://localhost:8080/jt/u.php/cms/statistic',
          'alias' => '统计',
          'class' => 'P8_CMS_Statistic',
          'controller_class' => 'P8_CMS_Statistic_Controller',
          'installed' => true,
          'enabled' => true,
        ),
      ),
    ),
  ),
  'template' => 'group5',
  'templatecache' => '0',
  'templates' => 
  array (
    'default' => '默认风格',
    'group5' => 'group05',
  ),
  'template_dir' => 'template/',
  'url' => 'http://localhost:8080/jt',
  'url_rewrite_enabled' => '0',
  'use_core_roles_only' => '1',
  'version' => 'school707',
  '_hook_modules' => 
  array (
    'uploader' => 
    array (
      'core' => 
      array (
        'member' => 'uid',
        'label' => 'item_id',
        'message' => 'item_id',
        46 => 'item_id',
        'forms' => 'form_id',
        'notify' => 'item_id',
        'special' => 'item_id',
        'spider' => 'item_id',
        'vote' => 'item_id',
      ),
      'ask' => 
      array (
        'item' => 'item_id',
        'answer' => 'answer_id',
      ),
      'cms' => 
      array (
        'item' => 'item_id',
      ),
    ),
    'message' => 
    array (
      'core' => 
      array (
        'member' => 'sendee_uid',
      ),
    ),
    'pay' => 
    array (
      'core' => 
      array (
        'member' => 'buyer_uid',
      ),
    ),
  ),
);