<?php
defined('PHP168_PATH') or die();

/**
* ר��ҳ���ɾ�̬
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');
if(REQUEST_METHOD != 'POST') exit;
require PHP168_PATH .'inc/html.func.php';
$__view_uri__ = '/index.php/'. $SYSTEM .'/special-view-id-{$id}';


//##��ʼ������ʼ{ step: 1
if(empty($_POST['task'])){

	@set_time_limit(0);

	//����
	$cids = isset($_POST['cids']) ? array_unique(filter_int($_POST['cids'])) : array();
	$ids = isset($_POST['ids']) ? array_unique(filter_int($_POST['ids'])) : array();
	$items = isset($_POST['items']) ? $_POST['items'] : 0;

	$cond = ' WHERE 1 ';
	
	//����
	if(!empty($cids) && current($cids) != 0){
		$cond .= ' AND cid IN ('. implode(',', $cids) .')';
	}else if(!empty($ids) && current($ids) != 0){
		$cond .= ' AND id IN ('. implode(',', $ids) .')';
	
	}

	//echo "SELECT COUNT(*) AS num FROM $this_module->table $cond";exit;
	$count = $DB_master->fetch_one("SELECT COUNT(*) AS num FROM $this_module->table $cond");
	$count = $count['num'];
	
	//û��Ҫ���ɵ��ļ�
	if(!$count){
		message('no_item');exit;
	}
	
	$perpage = isset($_POST['perpage']) ? intval($_POST['perpage']) : 50;
	$perpage = max($perpage, 1);
	

	$task_name = 'view_to_html_task_'. unique_id(16);
	
	//����
	$data = array(
		'time' => get_timer(),				//��ʼʱ��
		'count' =>$count,
		'page' => 0,				//��ǰ�Ĵ���
		'perpage' => $perpage,			//ÿ�����ɵ��ļ���
		'where' => $cond			//��ѯ����
	);
	
	_poster($task_name, $data, $msg = '');
	exit;
}
//##��ʼ���������}

//��������־
define('NO_ADMIN_LOG', true);


//##�߳̿�ʼ{ step: 2
$__task_name__ = $_POST['task'];
//��������
$__task__ = $_POST['taskd'];
//���߳�id��������
if(!$__task__['count'])exit('thread id required');

$__perpage__ = $__task__['perpage'];

//ȡҳ���ƫ����
$__page__ = $__task__['page'];
$offset = ($__page__ -1) * $__perpage__;
$offset =max($offset,0);
//############## ���Ĵ��� ###############
//ȡ����,�����￪ʼ����Ҫ�����ܹ���,��ֹ��ҳ��ı�����ͻ
$sql = "SELECT * FROM $this_module->table $__task__[where] LIMIT $offset, $__perpage__";
//echo $sql;exit;
$query = $DB_master->query($sql);

//############## ���Ĵ��� ###############}

while($__arr__ = $DB_master->fetch_array($query)){
		//��������ת������
		
		$file = p8_html_url($this_module, $__arr__, 'view', false);
		$tourl = p8_url($this_module, $__arr__, 'view');
		if($file){
			$id=$__arr__['id'];
			$basename = basename($file);
			//ȡ·��
			$path = str_replace($basename, '', $file);
			
			$page_file = preg_replace('/#([^#]+)#/', '\1', $file);
			$no_page = preg_replace('/#([^#]+)#/', '', $file);
			$__file__ = $no_page;
			
			
			eval('$_SERVER[\'_REQUEST_URI\'] = "'. $__view_uri__ .'";');
			
			ob_start();
			require PHP168_PATH .'index.php';
			$__content__ = ob_get_clean();
			
			md($path);
			write_file($__file__, $__content__);
		}
	}
	
	$__task__['page']+=$__task__['perpage'];
	if($__task__['page']>=$__task__['count']){
		message('done',$tourl);
	}
	echo $P8LANG['html'].'-'.$__task__['page'];
	_poster($__task_name__, $__task__, $msg = '');

function _poster($task, $data, $msg = ''){
	global $this_url;
	$inputs='';
	foreach($data as $name=>$value){
		$inputs .='<input type="hidden" name="taskd['.$name.']" value="'.$value.'">';
	}
	echo '<html>
<body>
'. $msg .'
<form action="'. $this_url .'" id="form" method="post">
<input type="hidden" name="task" value="'. $task .'" />
'.$inputs.'
</form>
<script type="text/javascript">
document.getElementById("form").submit();
</script>
</body>
</html>';
	exit;
}
