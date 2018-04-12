<?php
/**
* 还原
**/
//exit('deny'); 

header('Content-type: text/html; charset=utf-8');
defined('CACHE__PATH') or define('CACHE__PATH','./data/');
defined('P8__TIME') or define('P8__TIME',time());
if($_SERVER['REQUEST_METHOD'] == 'GET'){

	$list = array();
	$handle = opendir(CACHE__PATH.'db_backup/');
	$option = '';
	while(($item = readdir($handle)) !== false){
		if($item == '.' || $item == '..' || !is_dir(CACHE__PATH.'db_backup/'. $item)) continue;
		
		$option .= '<option value="'.$item.'">'.$item.'</option>';
	}
	echo <<<EOT
<form action="" method="post">
    <fieldset style=" width:400px;padding:20px;margin:100px auto">
        <legend>还原数据</legend>
				<table class="formtable" style="line-height:25px ;">
				
                    <tr>
                        <td width="50">数据</td><td>
                        <select name="name">
								$option
							</select>
                        </td>
                    </tr>
                    <tr>
                        <td>编码</td><td>
                            <input type="radio" name="charset" value="utf8" checked/> UTF8
                            <input type="radio" name="charset" value="gbk"/> GBK
                        </td>
                    </tr>
                    <tr>
						<td></td>
                        <td>
							<input type="submit" value="确定" onclick="return confirm('确定还原么');" />
							
						</td>
					</tr>
				</table>
        </fieldset>        
</form>
EOT;
	
}else if($_SERVER['REQUEST_METHOD'] == 'POST'){

	@set_time_limit(0);
	
	$name = isset($_POST['name']) ? basename($_POST['name']) : '*';
	$charset = isset($_POST['charset']) ? basename($_POST['charset']) : 'utf8';
	$name or mymessage('access_denied');
	is_dir(CACHE__PATH .'db_backup/'. $name) or mymessage('access_denied');
	
	
	function _poster($msg = ''){
		global $this_url;
		
		$fields = '';
		foreach($_POST as $k => $v){
			$fields .= '<input type="hidden" name="'. $k .'" value="'. $v .'" />';
		}
		
	$form = <<<EOT
$msg
<form action="$this_url" method="post" id="form">
$fields
</form>
<script type="text/javascript">
setTimeout(function(){ document.getElementById('form').submit(); }, 1);
</script>
EOT;
		echo($form);exit;
}
	
	if(empty($_POST['start'])){
		//初始化
		$files = glob(CACHE__PATH .'db_backup/'. $name .'/data_*.php');
		
		$_POST['start'] = 1;
		$_POST['offset'] = 0;
		$_POST['start_time'] = P8__TIME;
		$_POST['total'] = count($files);
		
		_poster('正在初始化');
	}
	
	
	
	$offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
	if($offset >= $_POST['total']){
		//it's done
        @unlink('./implodesql.php');
		exit( '<script>alert("还原完成");</script>');
        
	}
	
    if($charset == 'utf8'){
        require_once './inc/init.php';
        require_once './install/install.func.php';
        
        $sql = get_install_sql(
            $core->DB_master,
            @file_get_contents(CACHE__PATH .'db_backup/'. $name .'/data_'. $offset .'.php'),
            $core->TABLE_,
            false
        );
    
        foreach($sql as $v){
            $core->DB_master->query($v);
        }
        if($offset == $_POST['total']-1){
            $sql =array("update {$core->TABLE_}config SET v='utf8' where k='mysql_charset'",
                        "update {$core->TABLE_}config SET v='utf-8' where k='page_charset'");
            foreach($sql as $v){
                $core->DB_master->query($v);
            }
        }
    }else{
        define('NO_ADMIN_LOG', true);
        $DB_master = initmysql();
        if($offset == 0){
            //struct
            $content = file_get_contents(CACHE__PATH .'db_backup/'. $name .'/data_'. $offset .'.php');
            $content = str_replace(";\r", ';', $content);
            foreach(explode(";\n", $content) as $v){
                $DB_master->query($v);
            }
        }else{
           
            foreach(file(CACHE__PATH .'db_backup/'. $name .'/data_'. $offset .'.php') as $v){
                $DB_master->query($v);
            }
        }
    }
	
	$_POST['offset']++;
	
	_poster('共 '.$_POST['total'].' 个文件，正在还原第 '.$_POST['offset'].' 个文件');
}

function mymessage($msg){
    echo $msg;
    exit;
}
function initmysql(){
    require_once './inc/mysql.class.php';
    $CONFIG = include CACHE__PATH .'config.php';
	return new P8_mysql(
		$CONFIG['DB_master']['host'],
		$CONFIG['DB_master']['user'],
		$CONFIG['DB_master']['password'],
		$CONFIG['DB_master']['db'],
		'gbk',
		$CONFIG['DB_master']['port'],
		$CONFIG['DB_master']['pconnect']
	);
		
}