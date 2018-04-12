<?php
defined('PHP168_PATH') or die();

/**
* rss
**/


$cid = 0;
foreach($URL_PARAMS as $k => $v){
	switch($v){
	
	case 'category':
		$cid = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 0;
		
	break;
	
	}
}

//ҳ�滺�����: cid
$PAGE_CACHE_PARAM['cid'] = $cid;

//ҳ�滺�����: ����ʱ��
$PAGE_CACHE_PARAM['ttl'] = empty($this_module->CONFIG['list_page_cache_ttl']) ? 0 : $this_module->CONFIG['list_page_cache_ttl'];

$CAT = &$this_system->fetch_category($cid);

//���಻����
if($cid && empty($CAT)){
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: '. $this_url);
	exit;
}

page_cache($PAGE_CACHE_PARAM);


//���ط���ģ�鲢ȡ�õ�ǰ����Ļ���
$category = &$this_system->load_module('category');

$select = select();
$select->from($this_module->main_table .' AS i', 'i.*');

$sphinx = $this_module->CONFIG['sphinx'];
$sphinx['index'] = $this_system->sphinx_indexes();


$category->get_cache();

if($cid){
	
	$CATEGORY = $category->get_children_ids($cid) + array($cid);
	$select->in('i.cid', $CATEGORY);
	$select->order('i.list_order DESC');
	
	$channel = '';
	
}else{
	$select->order('i.id DESC');
	
}

$count = 0;

$list = $core->list_item(
	$select,
	array(
		'count' => &$count,
		'page' => &$page,
		'page_size' => 40,
		'sphinx' => $sphinx
	)
);

$items = '';

foreach($list as $k => $v){
	$v['#category'] = &$category->categories[$v['cid']];
	$list[$k]['url'] = p8_url($this_module, $v, 'view');
	$list[$k]['frame'] = attachment_url($v['frame']);
	
	//��������
	$parents = $category->get_parents($v['cid']);
	$ps = '';
	foreach($parents as $p){
		$ps .= $p['name'] .' ';
	}
	$list[$k]['category_name'] = $ps . $v['#category']['name'];
	//����URL
	$list[$k]['category_url'] = $v['#category']['url'];
	
	$_r = date('r', $v['timestamp']);
	
	$items .= <<<EOT
<item>
<title><![CDATA[$v[title]]]></title>
<category><![CDATA[{$list[$k]['category_name']}]]></category> 
<description><![CDATA[$v[summary]]]></description>
<author><![CDATA[$v[username]]]></author>
<link>{$list[$k]['url']}</link>
<pubDate>$_r</pubDate>
</item>
EOT;

}

$charset = strtoupper($core->CONFIG['page_charset']);
$r = date('r', P8_TIME);


header('Content-type: application/xml; charset='. $charset);
echo <<<EOT
<?xml version="1.0" encoding="$charset" ?>
<rss version="2.0">
<channel>
	<title><![CDATA[{$core->CONFIG['site_name']}]]></title>
	<description><![CDATA[{$core->CONFIG['site_description']}]]></description>
	<link>{$core->url}</link>
	<lastBuildDate>$r</lastBuildDate>
	<generator><![CDATA[PHP168 Sharp]]></generator>
	<image>
		<url><![CDATA[images/rss.gif]]></url>
		<title><![CDATA[PHP168 Sharp]]></title>
		<link><![CDATA[{$core->url}]]></link>
		<description><![CDATA[{$core->CONFIG['site_name']}]]></description>
	</image>
	
	$items
	
</channel>
</rss>
EOT;


//--------------------------------------------------------------------------------

//����ҳ�滺��
page_cache();
exit;