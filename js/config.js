var P8CONFIG = {
	url: 'http://localhost:8080/jt',
	RESOURCE: 'http://localhost:8080/jt',
	language: 'zh-cn',
	controller: 'http://localhost:8080/jt/index.php',
	U_controller: 'http://localhost:8080/jt/u.php',
	cookie_prefix: 'jebA_',
	cookie_path: '/',
	base_domain: '',
	mobile_status: 1,
	mobile_auto_jump: 1,
	mobile_url: 'http://localhost:8080/jt/m',
	
	URI: {
		'ask': {'': {url: 'http://localhost:8080/jt/ask',controller: 'http://localhost:8080/jt/index.php/ask',U_controller: 'http://localhost:8080/jt/u.php/ask'},
			'answer': {url: 'http://localhost:8080/jt/ask/modules/answer',controller: 'http://localhost:8080/jt/index.php/ask/answer',U_controller: 'http://localhost:8080/jt/u.php/ask/answer'},
			'category': {url: 'http://localhost:8080/jt/ask/modules/category',controller: 'http://localhost:8080/jt/index.php/ask/category',U_controller: 'http://localhost:8080/jt/u.php/ask/category'},
			'item': {url: 'http://localhost:8080/jt/ask/modules/item',controller: 'http://localhost:8080/jt/index.php/ask/item',U_controller: 'http://localhost:8080/jt/u.php/ask/item'},
			'member': {url: 'http://localhost:8080/jt/ask/modules/member',controller: 'http://localhost:8080/jt/index.php/ask/member',U_controller: 'http://localhost:8080/jt/u.php/ask/member'}
		},
		'cms': {'': {url: 'http://localhost:8080/jt/cms',controller: 'http://localhost:8080/jt/index.php/cms',U_controller: 'http://localhost:8080/jt/u.php/cms'},
			'assist_category': {url: 'http://localhost:8080/jt/cms/modules/assist_category',controller: 'http://localhost:8080/jt/index.php/cms/assist_category',U_controller: 'http://localhost:8080/jt/u.php/cms/assist_category'},
			'category': {url: 'http://localhost:8080/jt/cms/modules/category',controller: 'http://localhost:8080/jt/index.php/cms/category',U_controller: 'http://localhost:8080/jt/u.php/cms/category'},
			'item': {url: 'http://localhost:8080/jt/cms/modules/item',controller: 'http://localhost:8080/jt/index.php/cms/item',U_controller: 'http://localhost:8080/jt/u.php/cms/item'},
			'model': {url: 'http://localhost:8080/jt/cms/modules/model',controller: 'http://localhost:8080/jt/index.php/cms/model',U_controller: 'http://localhost:8080/jt/u.php/cms/model'},
			'statistic': {url: 'http://localhost:8080/jt/cms/modules/statistic',controller: 'http://localhost:8080/jt/index.php/cms/statistic',U_controller: 'http://localhost:8080/jt/u.php/cms/statistic'}
		},
		core: {'': {url: 'http://localhost:8080/jt',controller: 'http://localhost:8080/jt/index.php'},
			'46': {url: 'http://localhost:8080/jt/modules/46',controller: 'http://localhost:8080/jt/index.php/46',U_controller: 'http://localhost:8080/jt/u.php/46'},
			'credit': {url: 'http://localhost:8080/jt/modules/credit',controller: 'http://localhost:8080/jt/index.php/credit',U_controller: 'http://localhost:8080/jt/u.php/credit'},
			'crontab': {url: 'http://localhost:8080/jt/modules/crontab',controller: 'http://localhost:8080/jt/index.php/crontab',U_controller: 'http://localhost:8080/jt/u.php/crontab'},
			'cservice': {url: 'http://localhost:8080/jt/modules/cservice',controller: 'http://localhost:8080/jt/index.php/cservice',U_controller: 'http://localhost:8080/jt/u.php/cservice'},
			'dbm': {url: 'http://localhost:8080/jt/modules/dbm',controller: 'http://localhost:8080/jt/index.php/dbm',U_controller: 'http://localhost:8080/jt/u.php/dbm'},
			'discuzx': {url: 'http://www.xxx.com',controller: 'http://localhost:8080/jt/index.php/discuzx',U_controller: 'http://localhost:8080/jt/u.php/discuzx'},
			'forms': {url: 'http://localhost:8080/jt/modules/forms',controller: 'http://localhost:8080/jt/index.php/forms',U_controller: 'http://localhost:8080/jt/u.php/forms'},
			'friendlink': {url: 'http://localhost:8080/jt/modules/friendlink',controller: 'http://localhost:8080/jt/index.php/friendlink',U_controller: 'http://localhost:8080/jt/u.php/friendlink'},
			'guestbook': {url: 'http://localhost:8080/jt/modules/guestbook',controller: 'http://localhost:8080/jt/index.php/guestbook',U_controller: 'http://localhost:8080/jt/u.php/guestbook'},
			'interview': {url: 'http://localhost:8080/jt/modules/interview',controller: 'http://localhost:8080/jt/index.php/interview',U_controller: 'http://localhost:8080/jt/u.php/interview'},
			'label': {url: 'http://localhost:8080/jt/modules/label',controller: 'http://localhost:8080/jt/index.php/label',U_controller: 'http://localhost:8080/jt/u.php/label'},
			'letter': {url: 'http://localhost:8080/jt/modules/letter',controller: 'http://localhost:8080/jt/index.php/letter',U_controller: 'http://localhost:8080/jt/u.php/letter'},
			'mail': {url: 'http://localhost:8080/jt/modules/mail',controller: 'http://localhost:8080/jt/index.php/mail',U_controller: 'http://localhost:8080/jt/u.php/mail'},
			'member': {url: 'http://localhost:8080/jt/modules/member',controller: 'http://localhost:8080/jt/index.php/member',U_controller: 'http://localhost:8080/jt/u.php/member'},
			'message': {url: 'http://localhost:8080/jt/modules/message',controller: 'http://localhost:8080/jt/index.php/message',U_controller: 'http://localhost:8080/jt/u.php/message'},
			'notify': {url: 'http://localhost:8080/jt/modules/notify',controller: 'http://localhost:8080/jt/index.php/notify',U_controller: 'http://localhost:8080/jt/u.php/notify'},
			'opinion': {url: 'http://localhost:8080/jt/modules/opinion',controller: 'http://localhost:8080/jt/index.php/opinion',U_controller: 'http://localhost:8080/jt/u.php/opinion'},
			'page': {url: 'http://localhost:8080/jt/modules/page',controller: 'http://localhost:8080/jt/index.php/page',U_controller: 'http://localhost:8080/jt/u.php/page'},
			'pay': {url: 'http://localhost:8080/jt/modules/pay',controller: 'http://localhost:8080/jt/index.php/pay',U_controller: 'http://localhost:8080/jt/u.php/pay'},
			'role': {url: 'http://localhost:8080/jt/modules/role',controller: 'http://localhost:8080/jt/index.php/role',U_controller: 'http://localhost:8080/jt/u.php/role'},
			'shortcutsms': {url: 'http://localhost:8080/jt/modules/shortcutsms',controller: 'http://localhost:8080/jt/index.php/shortcutsms',U_controller: 'http://localhost:8080/jt/u.php/shortcutsms'},
			'sms': {url: 'http://localhost:8080/jt/modules/sms',controller: 'http://localhost:8080/jt/index.php/sms',U_controller: 'http://localhost:8080/jt/u.php/sms'},
			'special': {url: 'http://localhost:8080/jt/modules/special',controller: 'http://localhost:8080/jt/index.php/special',U_controller: 'http://localhost:8080/jt/u.php/special'},
			'spider': {url: 'http://localhost:8080/jt/modules/spider',controller: 'http://localhost:8080/jt/index.php/spider',U_controller: 'http://localhost:8080/jt/u.php/spider'},
			'survey': {url: 'http://localhost:8080/jt/modules/survey',controller: 'http://localhost:8080/jt/index.php/survey',U_controller: 'http://localhost:8080/jt/u.php/survey'},
			'uchome': {url: 'http://www.xxx.com',controller: 'http://localhost:8080/jt/index.php/uchome',U_controller: 'http://localhost:8080/jt/u.php/uchome'},
			'uploader': {url: 'http://localhost:8080/jt/modules/uploader',controller: 'http://localhost:8080/jt/index.php/uploader',U_controller: 'http://localhost:8080/jt/u.php/uploader'},
			'vote': {url: 'http://localhost:8080/jt/modules/vote',controller: 'http://localhost:8080/jt/index.php/vote',U_controller: 'http://localhost:8080/jt/u.php/vote'},
			'xspace': {url: 'http://www.xxx.com',controller: 'http://localhost:8080/jt/index.php/xspace',U_controller: 'http://localhost:8080/jt/u.php/xspace'}
		}
	}
};