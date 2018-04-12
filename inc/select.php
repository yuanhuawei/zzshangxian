<?php
defined('PHP168_PATH') or die();

class P8_DB_Select{

var $_distinct;
var $_from;			//表
var $_fields;		//字段
var $_where;		//条件
var $_where_conn;
var $_like;
var $_group;		//集合
var $_having;		//集合过滤
var $_order;		//排序
var $_range;
var $_filter;
var $_limit_count;	//限制
var $_limit_offset;
var $_searching_field;

function P8_DB_Select(){
	$this->_distinct = false;
	$this->_from = array();
	$this->_where = array();
	$this->_where_conn = ' AND ';
	
	//sphinx, 传递到sphinx参数
	$this->_range = array();
	$this->_filter = array();
	$this->_group = '';
	$this->_like = '';
	$this->_order = '';
	$this->_limit_count = 0;
	$this->_limit_offset = 0;
	$this->_keyword = array();
	//sphinx
	
	$this->_having = '';
	
}

/**
* 复制一个select对象
**/
function copy(&$obj){
	$obj = select();
	$obj->_distinct = $this->_distinct;
	$obj->_from = $this->_from;
	$obj->_where = $this->_where;
	
	//sphinx
	$obj->_range = $this->_range;
	$obj->_filter = $this->_filter;
	$obj->_group = $this->_group;
	$obj->_order = $this->_order;
	$obj->_like = $this->_like;
	$obj->_limit_count = $this->_limit_count;
	$obj->_limit_offset = $this->_limit_offset;
	$obj->_keyword = $this->_keyword;
	//sphinx
	
	$obj->_having = $this->_having;
}

function distinct($flag = true){
	$this->_distinct = (bool) $flag;
}

/**
* sql from部分
* @param string $table 表名称, 如 table, table AS t
* @param string $fields 字段, 如f1, f2 , t.f3 AS ff
* @param string $index 强制使用哪个索引, 如 primary
**/
function from($table, $fields = '*', $index = ''){
	
	$this->_join('INNER JOIN', $table, $fields, '', $index);
}

/**
* sql inner join 部分
* @param string $table 表名称, 如 table, table AS t
* @param string $fields 字段, 如f1, f2 , t.f3 AS ff
* @param string $join_cond 连接条件, 如a.id = b.id
* @param string $index 强制使用哪个索引, 如 primary
**/
function inner_join($table, $fields = '*', $join_cond = '', $index = ''){
	$this->_join('INNER JOIN', $table, $fields, $join_cond, $index);
}

/**
* sql inner join 部分
* @param string $table 表名称, 如 table, table AS t
* @param string $fields 字段, 如f1, f2 , t.f3 AS ff
* @param string $join_cond 连接条件, 如a.id = b.id
* @param string $index 强制使用哪个索引, 如 primary
**/
function left_join($table, $fields = '*', $join_cond = '', $index = ''){
	$this->_join('LEFT JOIN', $table, $fields, $join_cond, $index);
}

function _join($type, $table, $fields = '*', $join_cond = '', $index = ''){
	
	if(preg_match("/^(.+)\s+AS\s+(.+)$/i", $table, $m)){
		$alias = $m[2];
		if(preg_match("/^([^\.]+)\.(.+)/", $m[1], $mm)){
			$table = "`$mm[1]`.`$mm[2]` AS `$m[2]`";
		}else{
			$table = "`$m[1]` AS `$m[2]`";
		}
	}else{
		$alias = $table;
		if(preg_match("/^([^\.]+)\.(.+)/", $table, $m)){
			$table = "`$m[1]`.`$m[2]`";
		}else{
			$table = "`$table`";
		}
	}
	
	$this->_from[$alias] = array(
		'table' => $table,
		'join' => $type,
		'condition' => $join_cond,
		'fields' => $fields, 	//$this->_fields($fields, $alias)
		'index' => $index
	);
}

/* function _fields($fields, $alias){
	if(!is_array($fields)) return "`$alias`.`$fields`";
	
	$_fields = $comma = '';
	foreach($fields as $v){
		$n = $a = '';
		if(preg_match("/^(.+)\s+AS\s+(.+)$/i", $v, $m)){
			$a = $m[2];	//列表
			$n = $m[1];	//别名
			//$_fields .= $comma ."`$alias`.`$m[1]` AS `$m[2]`";
		}else{
			$n = $v;
			//
		}
		
		//检测到有函数
		if(preg_match("/^(.+)\((.+)\)/", $n, $m)){
			$n = strtoupper($m[1]) ."(`$alias`.`$m[2]`)";
		}else{
			$n = "`$alias`.`$n`";
		}
		$_fields .= $comma . (empty($a) ? $n : "$n AS `$a`");
		$comma = ',';
	}
	
	unset($fields);
	return $_fields;
} */

/**
* 改变条件连接符成 and
**/
function where_and(){
	$this->_where_conn = ' AND ';
}

/**
* 改变条件连接符成 OR
**/
function where_or(){
	$this->_where_conn = ' OR ';
}

/**
* 增加一个条件
* @param string $where 条件,如 field1 = value
**/
function where($where){
	$this->_where[] = count($this->_where) ? $this->_where_conn . $where : $where;
}

/**
* SQL条件过滤
* @param string $field 字段
* @param string|array $values 要过滤的值,可以是字符也可以是数组
* @param boolean $exclude 排除过滤的条件,即 1 = 2, $exclude = true, 1 != 2
**/
function in($field, $values, $exclude = false){
	//if(empty($values)) return false;
	
	if(is_array($values)){
		//如果是整数,放到sphinx的filter下
		if(empty($values)) return false;
		
		if(is_int(current($values)))
			$this->_filter[] = array('field' => $field, 'values' => $values, 'exclude' => $exclude);
		
		$s = $comma = '';
		foreach($values as $v){
			$s .= $comma ."'$v'";
			$comma = ',';
		}
		
		$this->where($field . ($exclude ? ' NOT IN ' : ' IN ') . '('. $s .')');
	}else{
		if(is_int($values))
			$this->_filter[] = array('field' => $field, 'values' => array($values), 'exclude' => $exclude);
			
		$this->where($field . ($exclude ? ' != ' : ' = ') . '\''. $values .'\'');
	}
}

/**
* 范围查询
* @param string $field 字段
* @param mix $min 左区间
* @param mix $max 右区间
* @param boolean $exclude 排除区间
* range('field', 100, 200)	相当于 field > 100 AND field < 200
* range('field', 100, 200, true)	相当于 field < 100 OR field > 200
**/
function range($field, $min = null, $max = null, $exclude = false, $eq = true){
	//无意义的范围,退出
	if($min === null && $max === null) return false;
	
	$lt = '';
	$gt = '';
	$s = '';
	
	if($exclude){
		$lt = $min === null ? '' : "$field ". ($eq ? '<=' : '<') ." '$min'";
		$gt = $max === null ? '' : "$field ". ($eq ? '>=' : '>') ." '$max'";
		$s = !empty($lt) && !empty($gt) ? "($lt OR $gt)" : $lt . $gt;
	}else{
		$lt = $min === null ? '' : "$field ". ($eq ? '>=' : '>') ." '$min'";
		$gt = $max === null ? '' : "$field ". ($eq ? '<=' : '<') ." '$max'";
		$s = !empty($lt) && !empty($gt) ? "($lt AND $gt)" : $lt . $gt;
	}
	
	!empty($s) && $this->where($s);
	
	$is_float = false;
	if(is_float($min) || is_float($max)){
		$is_float = true;
		$min = (float) $min;
		$max = (float) $max;
	}
	
	$this->_range[] = array('field' => $field, 'min' => $min, 'max' => $max, 'exclude' => $exclude, 'float' => $is_float);
	
	return true;
}

/**
* 搜索
* @param string $field 要搜索的字段
* @param string $keyword 要搜索的关键词
**/
function like($field, $keyword, $type = 'all', $exclude = false){
	$this->_keyword[] = $keyword;
	
	$not = $exclude ? 'NOT' : '';
	
	$keyword = str_replace(array('%', '_'), array('\\%', '\\_'), $keyword);
	switch($type){
	
	case 'left': $s = "$field $not LIKE '$keyword%'"; break;
	case 'right': $s = "$field $not LIKE '%$keyword'"; break;
	default: $s = "$field $not LIKE '%$keyword%'"; break;
	
	}
	
	$this->where($s);
	
	
}

function search($field, $keyword, $left_extend='', $right_extend=''){
	$this->_keyword[] = $keyword;
	
	$keyword = str_replace(array('%', '_'), array('\\%', '\\_'), $keyword);
	if(strlen($keyword) == 0) return;
	
	$this->_searching_field = $field;
	
	$keywords = preg_split('/\s+|,/', $keyword);
	$length = count($keywords);
	
	$ret = $field .' LIKE \'%'. array_shift($keywords) .'%\'';
	
	if($length > 1){
		$keywords = ' '.implode(' ', $keywords);
		$ret .= preg_replace_callback('/\s*(\+|\-|\||\s|&)+([^\+\-\|\s&]+)/s', array(&$this, '_search_reg'), $keywords);
	}
	
	$this->where($left_extend.'('. $ret .')'.$right_extend);
}

function _search_reg($m){
	switch($m[1]{0}){
		case '-':
			return ' AND '. $this->_searching_field .' NOT LIKE \'%'. $m[2] .'%\'';
		break;
		case '|':
			return ' OR '. $this->_searching_field .' LIKE \'%'. $m[2] .'%\'';
		break;
		default:
			return ' OR '. $this->_searching_field .' LIKE \'%'. $m[2] .'%\'';
	}
}

/**
* sql group by 部分
* @param string $fields 如field1, field2
**/
function group($fields){
	$this->_group = $fields;
}

/**
* sql having 部分
* @param string $cond 如field > value
**/
function having($cond){
	$this->_having = $cond;
}

/**
* sql order by 部分
* @param string $field_str 要排序的字段, 如 a DESC, b ASC, t.c DESC
**/
function order($field_str){
	$this->_order = $field_str;
}

/**
* sql union 部分
* @param array $unions 要连接的select对象数组, 如array($select1, $select2)
* @param string $type union类型, all为union all
**/
function union($unions, $type = ''){
	$union = ' UNION ' . ($type == 'all' ? 'ALL ' : '');
	
	$sql = $s = '';
	foreach($unions as $v){
		$sql .= $s . $v->build_sql();
		$s = $union;
	}
	return $sql;
}

/**
* 构造SQL语句
* @param bool 是否为统计条数构造SQL语句
**/
function build_select($for_count = false){
	$first = current($this->_from);
	
	$joins = '';
	$fields = ($this->_distinct ? 'DISTINCT ' : ''). $first['fields'];
	
	while($v = next($this->_from)){
		$fields .= empty($v['fields']) ? '' : ',' .$v['fields'];
		$v['table'] .= $v['index'] ? ' FORCE INDEX('. $v['index'] .')' : '';
		$joins .= " $v[join] $v[table] ON $v[condition]";
	}
	reset($this->_from);
	
	$fields = $for_count ? 'COUNT(*) AS num' : $fields;
	$first['table'] .= $first['index'] ? ' FORCE INDEX('. $first['index'] .')' : '';
	return "SELECT $fields FROM $first[table] $joins";
}

/**
* sphinx搜索过后,请除所有的条件,只取ID即可
**/
function sphinx_clear(){
	$this->_distinct = false;
	$this->_where = array();
	
	//sphinx, 传递到sphinx参数
	$this->_range = array();
	$this->_filter = array();
	$this->_group = '';
	$this->_like = '';
	$this->_order = '';
	$this->_limit_count = 0;
	$this->_limit_offset = 0;
	//sphinx
	
	$this->_having = '';
}

function build_where(){
	return count($this->_where) ? ' WHERE '. implode(' ', $this->_where) : '';
}

function build_group(){
	return empty($this->_group) ? '' : " GROUP BY $this->_group";
}

function build_having(){
	return empty($this->_having) ? '' : " HAVING $this->_having";
}

function build_order(){
	return empty($this->_order) ? '' : " ORDER BY $this->_order";
}

function limit($limit_offset = 0, $limit_count = 0){
	$this->_limit_count = max (0, $limit_count);
	$this->_limit_offset = max(0, $limit_offset);
}

function build_limit(){
	
	return $this->_limit_count ? " LIMIT $this->_limit_offset,$this->_limit_count" : '';
}

function build_for_update(){
	
}

function build_sql(){
	return 
	$this->build_select() .
	$this->build_where() .
	$this->build_group() .
	$this->build_having() .
	$this->build_order() .
	$this->build_limit() .
	$this->build_for_update();
}

function build_count_sql(){
	return 
	$this->build_select(true) .
	$this->build_where() .
	$this->build_group() .
	$this->build_having();
}

}