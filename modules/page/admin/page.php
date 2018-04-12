<?php
defined('PHP168_PATH') or die();
 
GetGP(array('job','action','id','postdb','cid','aid'));

if($job=="add")
{
	$rsdb[filename]=$timestamp.'.htm';
	include template($this_module, 'edit', 'admin');
}
elseif($action=="add" )
{
	//对地址做处理
	//$postdb[content]=En_TruePath($postdb[content]);

	$DB_master->query("INSERT INTO `{$this_module->table_page}` ( `fid` , `name` ,`title` , `posttime` , `uid` , `username` , `style` , `tpl_head` , `tpl_foot` , `tpl_main` , `filename` , `filepath` , `keywords` , `content` ) VALUES ('$postdb[fid]','$postdb[name]','$postdb[title]','$timestamp','$postdb[uid]','$postdb[username]','$postdb[style]','$postdb[tpl_head]','$postdb[tpl_foot]','$postdb[tpl_main]','$postdb[filename]','$postdb[filepath]','$postdb[keywords]','$postdb[content]')");
	message('done');
}
elseif($job=="edit")
{

	$rsdb=$DB_master->fetch_one("SELECT * FROM `{$this_module->table_page}` WHERE id='$id'");
	//真实地址还原
	//$rsdb[content]=En_TruePath($rsdb[content],0);

	$rsdb[content]=str_replace("'","&#39;",$rsdb[content]);

	include template($this_module, 'edit', 'admin');
}
elseif($action=="edit" )
{
	$DB_master->query("UPDATE `{$this_module->table_page}` SET fid='$postdb[fid]',name='$postdb[name]',title='$postdb[title]',posttime='$timestamp',uid='$postdb[uid]',username='$postdb[username]',style='$postdb[style]',tpl_head='$postdb[tpl_head]',tpl_foot='$postdb[tpl_foot]',tpl_main='$postdb[tpl_main]',filename='$postdb[filename]',filepath='$postdb[filepath]',keywords='$postdb[keywords]',content='$postdb[content]' WHERE id='$id' ");
	message('done');
}
elseif($action=="delete" )
{
	$rs=$DB_master->fetch_one("SELECT * FROM `{$this_module->table_page}` WHERE id='$id'");
	//unlink(PHP168_PATH.$rs[filename]);
	$DB_master->query("DELETE FROM `{$this_module->table_page}` WHERE id='$id'");
	message('done');
}
else
{
	!$page && $page=1;
	$rows=50;
	$min=($page-1)*$rows;
	//$showpage=getpage("`{$pre}alonepage`","","index.php?lfj=alonepage&job=list",$rows);
	$query=$DB_master->query("SELECT * FROM `{$this_module->table_page}` ORDER BY id DESC LIMIT $min,$rows");
	while($rs=$DB_master->fetch_array($query)){
		$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
		$listdb[]=$rs;
	}

	include template($this_module, 'list', 'admin');
}

?>