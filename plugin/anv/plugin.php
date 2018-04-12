<?php
defined('PHP168_PATH') or die();

class P8_Plugin_Anv extends P8_Plugin{

function __construct($core, $name){
	$this->core = &$core;
	parent::__construct($name);

}

function P8_Plugin_Anv(&$core, $name){
	$this->__construct($core, $name);
}

/**
* ��ȡҪ��ʾ������
* @param array $v ���ڻ�ȡҳ���ϱ���������
*/
function _display($v = null){
	
	$this_plugin = &$this;
	global $P8LANG, $RESOURCE, $SKIN;
	$config = &$this_plugin->CONFIG;
	
	//���� <IFRAME src="http://ipoffice.cn/anvtv/?card_id=15144" frameBorder=0 width=406 scrolling=no height=306></IFRAME>
	//��ҵ�� <IFRAME src="http://ipoffice.cn/anvtv/?card_id=10004" frameBorder=0 width=497 scrolling=no height=275></IFRAME>
	//���� <iframe scrolling="no" height="275" frameborder="0" width="497" src="http://ipoffice.cn/anvtv/?card_id=10020"></iframe>
	//���� <iframe scrolling="no" height="279" frameborder="0" width="497" src="http://ipoffice.cn/anvtv/?card_id=39888"></iframe>
	//���� <iframe scrolling="no" height="352" frameborder="0" width="406" src="http://tv1998.cn/anvtv/?card_id=10002"></iframe>
	
	if(isset($v['width']) && isset($v['height'])){
		$width = $v['width'];
		$height = $v['height'];
	}else{
		$width = $config['width'];
		$height = $config['height'];
	}
	
	echo '<iframe src="http://tv1998.cn/anvtv/?card_id='. $config['id'] .'" width="'. $width .'" height="'. $height .'" frameborder="0" scrolling="no"></iframe>';
}

}