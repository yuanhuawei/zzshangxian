<?php
defined('PHP168_PATH') or die();

/**
* ������������,ȷ����������ֶ���Ψһ��,���ҽ���Ϊ��������
* ���ļ��µı��ֶ��������Դ����߱����ٶ�,���������ݿⲻ�˽�,��Ҫ�Ҽ�,����ᵼ�±��ݲ�ȫ�ĺ��
* ��ʽ ���� => �����ֶ�,
**/

//��ǰ׺
$__T_ = $core->CONFIG['table_prefix'];

return array(
	
	$__T_ .'admin_log' => 'id',
	
	$__T_ .'member' => 'id',
	
	$__T_ .'cms_item' => 'id',
	
	//����CMSģ���Լ�д
	$__T_ .'cms_item_article_' => 'id',
	$__T_ .'cms_item_article_addon' => 'id',
	
	$__T_ .'cms_item_photo_' => 'id',
	$__T_ .'cms_item_photo_addon' => 'id',
	
	$__T_ .'cms_item_down_' => 'id',
	$__T_ .'cms_item_down_addon' => 'id',
	
	$__T_ .'cms_item_video_' => 'id',
	$__T_ .'cms_item_video_addon' => 'id',
	
	//�����
	'1p8_cms_category' => 'id',
	'1p8_cms_item' => 'id',
	'1p8_cms_item_article_' => 'id',
	'1p8_cms_item_article_addon' => 'id',
	'f' => 'id',
);