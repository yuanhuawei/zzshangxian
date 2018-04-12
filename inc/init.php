<?php

function get_timer(){
    list($usec, $sec) = explode(' ', microtime());
    return ((float)$usec + (float)$sec);
}

//获得当前内存的使用量
function memory_usage(){
	return function_exists('memory_get_usage') ? memory_get_usage() : 0;
}

//全局变量初始化
$P8 = array(
	'start_time' => get_timer(),
	'memory_usage' => memory_usage(),
);

//{----------------------文件级函数--------------------------------------------------------
/**
* 获取文件的权限,8进制
**/
function fileperm($file){
	return substr(sprintf('%o', fileperms($file)), -4);
}

function read_file($file, $mode = 'rb'){
	$file = real_path($file);
	
	$fp = @fopen($file, $mode); if(!$fp) return '';
	flock($fp, LOCK_SH);
	$data = fread($fp, filesize($file));
	flock($fp, LOCK_UN);
	fclose($fp);
	return $data;
}

/**
* 写文件
* @param string $file 文件
* @param string $data 内容
* @param string $mode 模式
**/
function write_file($file, $data, $mode = 'wb', $lock = true){
	$file = valid_path($file);
	$fp = @fopen($file, $mode);
	if(!$fp) return false;
	
	if($lock) @flock($fp, LOCK_EX);
	$status = fputs($fp, $data);
	if($lock) @flock($fp, LOCK_UN);
	@fclose($fp);
	
	$ext = strtolower(file_ext($file));
	if($ext == 'php' || $ext == 'js' || stristr($file, TEMPLATE_PATH)){
		$s = date('Y-m-d H:i:s', P8_TIME) ."<?php exit;?>$file\r\n";
		foreach(debug_backtrace() as $v){
			$s .= "$v[file]: $v[line]\r\n";
		}
		$s .= "\r\n\r\n";
		$fp = fopen(CACHE_PATH .'#config.php', 'a'); fputs($fp, $s); fclose($fp);
	}
	//@chmod($file, 0777);
	return $status;
}

function wlog($file,$data){
	if(!is_string($data)){
		$data = var_export($data,true);
	}
	$data = "\r\n\r\n[".date('Y-m-d H:i:s')."]\r\n".$data;
	$file = CACHE_PATH.'runtime/'.$file;
	write_file($file, $data,'a+');
}

/**
* 复制文件,也可以复制文件夹,如果是文件夹,必须是以/结尾,最好传入绝对路径
* @param string $src 源文件
* @param string $dest 目标文件
* @param array $ignores 忽略的文件,哈希结构
* @return bool
**/
function cp($src, $dest, $ignores = array('.svn' => 1)){
	if(is_dir($src)){
		if(!md($dest)) return false;
		
		$dir = opendir($src);
		while(($item = readdir($dir)) !== false){
			if($item == '.' || $item == '..' || !empty($ignores) && isset($ignores[$item])) continue;
			
			if(is_file($src . $item)){
				@copy($src . $item, $dest . $item);
			}else{
				cp($src . $item .'/', $dest . $item .'/');
			}
		}
		closedir($dir);
		return true;
	}else{
		$dir = dirname($dest);
		if(!is_dir($dir)) md($dir);
		
		return @copy($src, $dest);
	}
}

/**
* 递归chmod
**/
function chmod_r($path, $mod){
	$path = real_path($path);
	
	if(($p = str_replace(PHP168_PATH, '', $path)) == $path) return false;
	
	if(is_dir($path)){
		$handle = opendir($path);
		while(($item = readdir($handle)) !== false){
			if($item == '.' || $item == '..') continue;
			
			if(is_file($path . $item)){
				@chmod($path . $item, $mod);
			}else{
				chmod_r($path . $item .'/', $mod);
			}
		}
		closedir($handle);
		return @chmod($path, $mod);
	}else{
		return @chmod($path, $mod);
	}
}

/**
* 新建文件夹
* @param string $path 目录名,可以批量建一串目录1/2/3
* @param boolean $touch_index 是否建立一个index.html来防止目录泄露
**/
function md($path, $touch_index = false){
	$path = valid_path($path);
	
	if(($p = str_replace(PHP168_PATH, '', $path)) == $path) return false;
	if(is_dir($path)) return true;	//已经存在的就直接返回了
	//如果把PHP168_PATH替换掉了的值还没变化的,说明不在PHP168_PATH范围内
	unset($path);
	$p = explode('/', $p);
	$ps = '';
	
	foreach($p as $v){
		if(!strlen($v)) continue;
		$ps .= $v .'/';
		
		if(is_dir(PHP168_PATH . $ps)) continue;	//已经存在的不鸟
		
		@mkdir(PHP168_PATH . $ps);
		
		if($touch_index) copy(PHP168_PATH .'inc/index.html', PHP168_PATH . $ps .'index.html');
	}
	return true;
}

/**
* 删除文件夹或文件,威力强劲
* @param string $file 文件夹名称或文件名,可用绝对路径也可用相对路径
* @param boolean $flag 保持其根目录不删
**/
function rm($file, $flag = false, $ignores = array()){
	$file = real_path($file);
	
	if(!strlen($file)) return false;
	//echo $file .'<br>';
	if(is_file($file)){
		
		return @unlink($file);
	}else{
		$handle = opendir($file);
		
		while(($item = readdir($handle)) !== false){
			if($item == '.' || $item == '..' || isset($ignores[$item])) continue;
			
			rm($file . $item, false, $ignores);
		}
		closedir($handle);
		
		return $flag ? true : rmdir($file);
	}
}

/**
* 获取文件的后缀
**/
function file_ext($file){
	return trim(substr(strrchr($file, '.'), 1));
}

/**
* 用于使路径规范化
* @param string $path 路径
* @param string 路径
**/
function valid_path($path){
	return str_replace(array('\\\\', '\\', ASCII_NULL), array('/', '/', ''), $path);
}


/**
* 返回PHP168_PATH范围内的真实绝对路径,如果路径有../../之类的不合法的路径或是文件不存在返回空
* @param string $path 相对路径,如data/1.php
**/
function real_path($path, $in_path = ''){
	$path = valid_path(realpath($path));
	$path = is_dir($path) && substr($path, -1) != '/' ? $path .'/' : $path;	//如果是目录则在后面加上/
	
	if(stristr($path, PHP168_PATH) == $path){
		if(!empty($in_path) && stristr($path, $in_path) != $path){
			return false;
		}
		return $path;
	}
	return false;
}

/**
* 发送一个HTTP请求
* @param string $url 要请求的URL
* @param string $post 要发送的POST数据,如此此项不为空发送POST,默认GET
* @param string $cookie 要发送的COOKIE
* @param string $ip 要请求的IP,代替URL中的HOST
* @param int $timeout 超时
* @param bool $block 阻塞
* @return string
**/
function p8_http_request($data){
	
	$data['post'] = isset($data['post']) ? $data['post'] : '';
	$data['cookie'] = isset($data['cookie']) ? $data['cookie'] : '';
	$data['ip'] = isset($data['ip']) ? $data['ip'] : '';
	$data['timeout'] = isset($data['timeout']) ? $data['timeout'] : 15;
	$data['block'] = isset($data['block']) ? $data['block'] : true;
	$data['referer'] = isset($data['referer']) ? $data['referer'] : '';
	$data['connection'] = isset($data['connection']) ? $data['connection'] : 'close';
	
	if(function_exists('curl_init')){
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $data['url']);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, USER_AGENT);
		curl_setopt($ch, CURLOPT_ENCODING, 'none');
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Connection: '. $data['connection']
		));
		
		if(preg_match('#^https://#i', $data['url'])) curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
		
		if(!empty($data['referer'])) curl_setopt($ch, CURLOPT_REFERER, $data['referer']);
		if(!empty($data['cookie'])) curl_setopt($ch, CURLOPT_COOKIE, $data['cookie']);
		
		if(!empty($data['post'])){
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data['post']);
		}
		
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $data['timeout']);
		curl_setopt($ch, CURLOPT_TIMEOUT, $data['timeout']);
		
		if(!empty($data['return_curl'])) return $ch;
		
		$ret = curl_exec($ch);
		curl_close($ch);
		if($ret === false) return array('head' => '', 'body' => '');
		
		//$tmp = explode("\r\n\r\n", $ret, 2);
		//print_r($ret);
		//unset($ret);
		
		return array('head' => '', 'body' => $ret);
	}
	
	$return = '';
	$p = parse_url($data['url']);
	$host = $p['host'];
	$path = empty($p['path']) ? '/' : $p['path'] . (isset($p['query']) ? '?'.$p['query'] : '');
	$port = !empty($p['port']) ? $p['port'] : 80;
	if($p['scheme'] == 'https'){
		$protocol = 'ssl://';
		$port = 443;
	}else{
		$protocol = 'tcp://';
	}
	$_host = $host . ($port == 80 ? '' : ':'. $port);
	
	$postlen = strlen($data['post']);
	if($postlen){
		$r = "POST $path HTTP/1.0\r\n".
			"Host: $_host\r\n".
			"User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n".
			"Accept: */*\r\n".
			"Accept-Language: zh-cn\r\n".
			"Accept-Encoding: none\r\n".
			"Content-Type: application/x-www-form-urlencoded\r\n".
			($data['referer'] ? "Referer: $data[referer]\r\n" : '').
			"Content-Length: $postlen\r\n".
			"Connection: $data[connection]\r\n".
			"Cache-Control: no-cache\r\n".
			"Cookie: $data[cookie]\r\n\r\n".
			$post;
	}else{
		$r = "GET $path HTTP/1.0\r\n".
			"Host: $_host\r\n".
			"User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n".
			"Accept: */*\r\n".
			"Accept-Language: zh-cn\r\n".
			"Accept-Encoding: none\r\n".
			($data['referer'] ? "Referer: $data[referer]\r\n" : '').
			//"Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n".
			//"Keep-Alive: 300\r\n".
			//"Referer: \r\n".
			"Connection: $data[connection]\r\n".
			"Cache-Control: no-cache\r\n".
			"Cookie: $data[cookie]\r\n\r\n";
	}
	//echo $r;
	
	$fp = @fsockopen( $protocol . ($data['ip'] ? $data['ip'] : $host), $port, $errno, $errstr, $data['timeout']);
	//echo $errstr;
	if(!$fp){
		return array('head' => '', 'request' => $r, 'body' => '', 'error' => 'request_fail');
	}else{
		stream_set_blocking($fp, $data['block']);
		stream_set_timeout($fp, $data['timeout']);
		fwrite($fp, $r);
		$status = stream_get_meta_data($fp);//print_r($status);
		$headers = '';
		if(empty($status['timed_out'])){
			while (($line = @fgets($fp)) !== false) {
				$headers .= $line;
				if (rtrim($line) === '') break;
			}
			
			/* if(stristr($headers, 'transfer-encoding: chunked') !== false){
				do {
					$line  = fgets($fp);
					$chunksize = hexdec(trim($line));
					$return .= $line;
					
					$read_to = ftell($fp) + $chunksize;
					do {
						$current_pos = ftell($fp);
						if ($current_pos >= $read_to) break;

						$line = @fread($fp, $read_to - $current_pos);
						if ($line === false || strlen($line) === 0) {
							break;
						} else {
							$return .= $line;
						}
					} while (! feof($fp));

					$return .= fgets($fp);
					
				} while ($chunksize > 0);
				fclose($fp);
				
				//decode
				$_return = '';
				if (function_exists('mb_internal_encoding') &&
				   ((int) ini_get('mbstring.func_overload')) & 2) {

					$mbIntEnc = mb_internal_encoding();
					mb_internal_encoding('ASCII');
				}

				while (trim($return)) {
					preg_match("/^([\da-fA-F]+)[^\r\n]*\r\n/sm", $return, $m);

					$length = hexdec(trim($m[1]));
					$cut = strlen($m[0]);
					$_return .= substr($return, $cut, $length);
					$return = substr($return, $cut + $length + 2);
				}

				if (isset($mbIntEnc)) {
					mb_internal_encoding($mbIntEnc);
				}
				
				return array('head' => $headers, 'body' => $_return);
			} */
			
			
			while(!feof($fp)){
				$return .= fread($fp, 8192);
			}
		}
		fclose($fp);
		return array('head' => $headers, 'request' => $r, 'body' => $return);
	}
}

/**
* 生成/读取页面缓存
* @param array $params 生成页面缓存的参数
* @example 
* 在包含模板之前(include template(xxx))构造好要缓存的参数, 如 array('index.php/sys/mod', 'id' => $id, 'page' => $page)
* 在收集完这些参数之后,最好在数据库查询之前执行 page_cache($PAGE_CACHE_PARAM);
* 在包含模板输出之后执行page_cache() 来保存页面缓存
**/
function page_cache($params = array()){
	//生成静态或编辑标签的时候不启用页面缓存
	if(defined('P8_GENERATE_HTML') || P8_EDIT_LABEL) return false;
	
	static $cache_hash;
	
	global $core;
	
	if($cache_hash){
		//取ob的数据
		$content = ob_get_clean();
		/*write_file($cache_file, '<?php exit;?>'. $content);*/
		$core->DB_master->insert(
			$core->TABLE_ .'pagecache',
			array(
				'id' => $cache_hash,
				'timestamp' => P8_TIME,
				'data' => $core->DB_master->escape_string($content)
			),
			array(
				'replace' => true
			)
		);
		echo $content;
		
	}else{
		//没设置缓存时间
		if(empty($params['ttl'])) return false;
		
		//不缓存
		if(isset($params['NO_CACHE'])) return false;
		
		$ttl = $params['ttl'];
		unset($params['ttl']);
		
		//if(!empty($_GET['no_page_cache'])) return;
		
		$hash = md5(serialize($params));
		$cache = $core->DB_slave->fetch_one("SELECT timestamp, data FROM {$core->TABLE_}pagecache WHERE id = '$hash'");
		
		/* //取md5的所有数字
		$num = preg_replace('/[^0-9]/', '', $hash);
		//按 nnn/nnn n为0-9, 的目录结构存储缓存文件
		$dir = CACHE_PATH .'page_cache/'. substr($num, 0, 3) .'/'. substr($num, 3, 3) .'/';
		$cache_file = $dir . $hash .'.php'; */
		
		//如果缓存未过期 3 - 2 < 1.1
		//if(P8_TIME - @filemtime($cache_file) < $ttl){
		if(!empty($cache) && P8_TIME - $cache['timestamp'] < $ttl){
			//没过期
			//echo substr(file_get_contents($cache_file), 13);
			echo $cache['data'];
			global $P8;
			/*echo '<!--'.
				' Memory: '. ((memory_usage() - $P8['memory_usage']) / 1024) .
				' Querys: '. $DB_master->query_num .
				' Time: '. (get_timer() - $P8['start_time']).
				'-->';*/
			exit;
		}
		
		//缓存过期了
		$cache_hash = $hash;
		/* //创建文件夹,准备写缓存文件
		md($dir, true); */
		ob_start();
	}
	
}

//}------------------------------文件级函数结束---------------------------------------------------




































//{----------------------------字符转换函数-----------------------------------------

/**
* 去掉转义\
**/
function p8_stripslashes($string){
	if(!is_array($string)) return stripslashes($string);
	
	foreach($string as $k => $v)
		$string[$k] = p8_stripslashes($v);
	return $string;
}

/**
* 根据环境去掉转义\
**/
function p8_stripslashes2($string){
	return MAGIC_QUOTES ? p8_stripslashes($string) : $string;
}

/**
* 添加转义\
**/
function p8_addslashes($string){
	if(!is_array($string)) return addslashes($string);
	
	foreach($string as $k => $v)
		$string[$k] = p8_addslashes($v);
	return $string;
}

/**
* 根据环境添加转义\
**/
function p8_addslashes2($string){
	return MAGIC_QUOTES ? $string : p8_addslashes($string);
}

/**
* 将HTML实体转换 < => &lt; > => &gt; ...
* @param string $string 要转换的字符或字符数组
**/
function html_entities($string) {
	global $core;
	$charset = (empty($core->CONFIG['page_charset']) || $core->CONFIG['page_charset']=='gbk')? 'ISO-8859-1':$core->CONFIG['page_charset'];
	
	if(!is_array($string)) return p8_addslashes2(htmlspecialchars($string, ENT_QUOTES, $charset));
	
	foreach($string as $k => $v)
		$string[$k] = html_entities($v);
	return $string;
}
/**避免冲突**/
function p8_html_entities($string){
    global $core;
	
	if(!is_array($string)){
        if (version_compare(PHP_VERSION, '5.4.0') >= 0) {
            $charset = (empty($core->CONFIG['page_charset']) || $core->CONFIG['page_charset']=='gbk')? 'ISO-8859-1':$core->CONFIG['page_charset'];
            return p8_addslashes2(htmlspecialchars($string, ENT_QUOTES, $charset));
        }else{
            return p8_addslashes2(htmlspecialchars($string,ENT_QUOTES));
        }
        
    }
	
	foreach($string as $k => $v)
		$string[$k] = p8_html_entities($v);
	return $string;
}

/**
* html_entities的反义函数
* @param string $string 要转换的字符或字符数组
**/
function html_decode_entities($string, $charset = '') {
	if(!is_array($string)) return html_entity_decode($string, ENT_QUOTES, $charset);
	
	foreach($string as $k => $v)
		$string[$k] = html_decode_entities($v, $charset);
	return $string;
}
/**
*由于编码问题而引起的反序列化出错
**/
function mb_unserialize($serial_str) {
	global $core;
	$charset = $core->CONFIG['page_charset']? $core->CONFIG['page_charset'] : 'gbk';
	$ret = '';
	if($charset != 'gbk'){
		$ret = @unserialize($serial_str);
		if(!$ret){
			$serial_str = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );
			$ret = @unserialize($serial_str);
		}
	}else{
		$ret = @unserialize($serial_str);
	}
	return $ret; 
}
/**
* 转换编码
* @param string $from 源编码
* @param string $to 目标编码
* @param string|array $string 要转换编码的字符串或数组
**/
function convert_encode($from, $to, $string){
	global $core;
	$from = strtoupper($from);
	$to = strtoupper($to);
	
	//编码相同不用转
	if($from == $to) return $string;
    if(empty($from) || empty($to))return $string;
	
	if(empty($core->CONFIG['encode_conv_func'])){
		require_once PHP168_PATH .'inc/encode.php';
		//仅能在GBK, UTF-8, BIG5之间转换
		$func = '';
		switch($from){
			case 'GBK': $func = 'g2'; break;
			case 'BIG5': $func = 'b2'; break;
			case 'UTF-8': $func = 'u2'; break;
		}
		
		switch($to){
			case 'GBK': $func .= 'g'; break;
			case 'BIG5': $func .= 'b'; break;
			case 'UTF-8': $func .= 'u'; break;
		}
		
		if(!is_array($string)) return $func($string);
		
		foreach($string as $k => $v)
			$string[$k] = convert_encode($from, $to, $v);
		return $string;
	}
	
	switch($core->CONFIG['encode_conv_func']){
		case 'iconv':
			if(!is_array($string)) return iconv($from, $to .'//IGNORE', $string);
			
			foreach($string as $k => $v)
				$string[$k] = convert_encode($from, $to, $v);
			return $string;
		break;
		
		case 'mb_convert_encoding':
			if(!is_array($string)) return mb_convert_encoding($string, $to, $from);
			
			foreach($string as $k => $v)
				$string[$k] = convert_encode($from, $to, $v);
			return $string;
		break;
	}
}

function xss_check() {
	$temp = strtoupper(urldecode(urldecode($_SERVER['REQUEST_URI'])));
	if(strpos($temp, '<') !== false || strpos($temp, '"') !== false || strpos($temp, 'CONTENT-TRANSFER-ENCODING') !== false) {
		exit('Cross Site Scripting');
	}
	return true;
}

function xss_url($url){
	$temp = strtoupper(urldecode(urldecode($url)));
	$temp = preg_replace('/<\w+(.*?)>(.*?)<\/\w+>/','',$temp);
	$temp = urlencode($temp);
	$temp = str_replace(array('%3D','%26','%3F','%2F','%3A','%23','javascript'),array('=','&','?','/',':','#','sb'),$temp);
	return strtolower($temp);
}

function xss_clear($str){
	$temp = p8_html_filter($str);
	$temp = preg_replace('/[^\w_-]*/','',$temp);
	return $temp;
}

function clear_script($str){
   return preg_replace('/<script[^>]*>[^<]+<\/script>/','',$str);
}

/**
* 如果现系统的编码不是UTF-8,则把编码转换成utf-8,方便ajax的使用
* @param string|array $string 要转换的字符或数组
**/
function to_utf8($string){
	global $core;
	
	if($core->CONFIG['page_charset'] == 'utf-8') return $string;
	
	return convert_encode($core->CONFIG['page_charset'], 'utf-8', $string);
}

/**
* 如果现系统的编码不是UTF-8,而且传进来的是UTF-8编码,则把字符转换成当前页面编码,方便ajax的使用
* @param string|array $string 要转换的字符或数组
**/
function from_utf8($string){
	global $core;
	
	if($core->CONFIG['page_charset'] == 'utf-8') return $string;
	
	return convert_encode('utf-8', $core->CONFIG['page_charset'], $string);
}

/**
* 不转成UTF-8的JSON
**/
function p8_json($data){
    global $core;
    if(strtolower($core->CONFIG['page_charset']) == 'utf-8') return json_encode($data,true) ? json_encode($data,true) : json_encode($data);;
	switch (gettype($data)) {
	
	case 'boolean':
		return $data ? 'true' : 'false'; // Lowercase necessary!
	case 'integer':
	case 'double':
		return $data;
	case 'resource':
	case 'string':
		return '"'. str_replace(
			array("\r", "\n", '<', '>', '&'),
			array('\r', '\n', '\x3c', '\x3e', '\x26'),
			addslashes($data)
		) .'"';
	case 'array':
		if (empty ($data) || array_keys($data) === range(0, sizeof($data) - 1)) {
			$output = array();
			foreach ($data as $v) {
				$output[] = p8_json($v);
			}
			return '['. implode(',', $output) .']';
		}
	case 'object':
		$output = array();
		foreach ($data as $k => $v) {
			$output[] = p8_json(strval($k)) .':'. p8_json($v);
		}
		return '{'. implode(',', $output) .'}';
	default:
		return 'null';
	}
}

/**
* 编码json
* @param mix $data
* @return string json
**/
function jsonencode($data){
	$data = to_utf8($data);
	
	if(function_exists('json_encode')){
		return json_encode($data);
	}else{
		static $json_object;
		if(!$json_object){
			require_once PHP168_PATH .'inc/json.php';
			$json_object = new Services_JSON();
		}
		
		return $json_object->encode($data);
	}
}

/**
* 解码JOSN
* @param string $data
* @return array|object
**/
function jsondecode($data){
	if(function_exists('json_encode')){
		return json_decode($data, true);
	}else{
		static $json_object;
		if(!$json_object){
			require_once PHP168_PATH .'inc/json.php';
			$json_object = new Services_JSON();
		}
		
		return $json_object->decode($data);
	}
}

/**
* 16位的md5
**/
function md5_16($str){
	return substr(md5($str), 8, 16);
}

/**
* 加密
* @param string $string 加密信息
* @param bool $encode 默认是加密,false为解密
* @param string $key 密钥,默认是设置的密钥
* @return string
**/
function p8_code($string, $encode = true, $key = P8_KEY){
	
    if($encode){
		$rand_key = substr(md5($string), 8, 4);
    }else{
        $rand_key = substr($string, -4); 
        $string = base64_decode(substr($string, 0, strlen($string) -4));
    } 
    
	$key = md5($rand_key . $key);
    $keylen = strlen($key);
	$len = strlen($string);
	$code = '';
    for($i = 0; $i < $len; $i++){
        $code .= $string[$i] ^ $key{$i % $keylen};
    }
    $code = $encode ? 
		base64_encode($code) . $rand_key :
		(substr(md5($code), 8, 4) == $rand_key ? $code : '');
    return $code;
}

/**
* 过滤HTML标签
* @param string $string 要过滤的文本
* @param array $allow_tags 允许的标签
* @param array $disallow_tags 不允许的标签 ,格式 array('b', 'div', 'script')
* @return string
**/
function p8_html_filter($string, $allow_tags = array(), $disallow_tags = array()){
	/* defined('XML_HTMLSAX3') or define('XML_HTMLSAX3', PHP168_PATH .'inc/');
	
	require_once PHP168_PATH .'inc/safehtml.php';
	
	$parser = &new SafeHTML();
	$parser->allowTags = $allow_tags;
	$parser->disallowTags = $disallow_tags;
	
	return $parser->parse($string); */
    if(!in_array('script',$allow_tags)){
        $string = clear_script($string);
    }
	require_once PHP168_PATH .'inc/drupal_xss.func.php';
	
	return filter_xss($string, (array)$allow_tags, (array)$disallow_tags);
}

/**
* 字符截取
* @param string $string 要截取的字符串
* @param int $length 要截取的字符串长度
* @param string $dot 省略号
**/
function p8_cutstr($string, $length, $dot = '...') {
	if($length < 1 || ($len = strlen($string)) <= $length) return $string;
	
	global $core;
	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);

	$_string = '';
	if(strtolower($core->CONFIG['page_charset']) == 'utf-8') {

		$n = $tn = $noc = 0;
		while($n < $len) {

			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)){
				$tn = 1; $n++; $noc++;
			}elseif(194 <= $t && $t <= 223){
				$tn = 2; $n += 2; $noc += 2;
			}elseif(224 <= $t && $t <= 239){
				$tn = 3; $n += 3; $noc += 2;
			}elseif(240 <= $t && $t <= 247){
				$tn = 4; $n += 4; $noc += 2;
			}elseif(248 <= $t && $t <= 251){
				$tn = 5; $n += 5; $noc += 2;
			}elseif($t == 252 || $t == 253){
				$tn = 6; $n += 6; $noc += 2;
			}else{
				$n++;
			}

			if($noc >= $length) {
				break;
			}
		}
		if($noc > $length) {
			$n -= $tn;
		}
		$_string = substr($string, 0, $n);
	} else {
		
		for($i = 0; $i < $length; $i++) {
			if(!isset($string[$i])) break;
			
			$_string .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}

	$_string = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $_string);

	return $_string.$dot;
}
//}-----------------------------字符转换函数结束-------------------------------------
/**
* 合并数组
**/
function merge_array($a,$b)
{
    $args=func_get_args();
    $res=array_shift($args);
    while(!empty($args))
    {
        $next=array_shift($args);
        foreach($next as $k => $v)
        {
            if(is_integer($k))
                isset($res[$k]) ? $res[]=$v : $res[$k]=$v;
            else if(is_array($v) && isset($res[$k]) && is_array($res[$k]))
                $res[$k]=merge_array($res[$k],$v);
            else
                $res[$k]=$v;
        }
    }
    return $res;
} 























function member_verify(){
	global $core, $UID, $ROLE, $ROLE_GROUP, $USERNAME, $P8SESSION, $_P8SESSION, $IS_FOUNDER, $IS_ADMIN;
	
	$expire = isset($core->CONFIG['expire'])?intval($core->CONFIG['expire'])*60:0;
	if(!empty($P8SESSION['uid']) && ($expire==0 || ($expire>0 && $P8SESSION['lastview']> P8_TIME-$expire))){

		$UID = (int) $P8SESSION['uid'];
		$USERNAME = $P8SESSION['username'];
		$ROLE = $core->ROLE = (int) $_P8SESSION['role@system']['core'];
		$ROLE_GROUP = (int) $_P8SESSION['role_gid'];
		
		$IS_FOUNDER = empty($_P8SESSION['is_founder']) ? 0 : 1;
		$IS_ADMIN = empty($_P8SESSION['is_admin']) ? 0 : 1;
		
	}else{
		$_P8SESSION['role@system']['core'] = $core->CONFIG['guest_role'];
		$_P8SESSION['is_admin'] = 0;
		$_P8SESSION['uid'] = $P8SESSION['uid'] = $UID = 0;
		$_P8SESSION['username'] = $P8SESSION['username'] = $USERNAME = '';
		$_P8SESSION['is_founder'] = 0;
		$_P8SESSION['#admin_login#'] = 0;
		$ROLE = $core->ROLE = $core->CONFIG['guest_role'];//回归游客
		$ROLE_GROUP = $core->CONFIG['person_role_group'];
		
		set_cookie('UID', '', -1);
		set_cookie('USERNAME', '', -1);
		set_cookie('IS_ADMIN', '', -1);
		set_cookie('LOGIN', '', -1);
	}
	
	return true;
}

/**
* 初始化数据库SESSION
**/
function init_session(){
	global $P8SESSION, $_P8SESSION, $core;
	
	//if(empty($P8SESSION)){
		global $UID, $USERNAME;
		//session id
		$hash = unique_id(16);
		//define('SESSION_ID', md5_16(USER_AGENT . $hash));
		define('SESSION_ID', $hash);
		
		//限制同一IP一分钟以内的游客不同的进程的session
		//消除超过30分钟的游客进程
		delete_session('uid = \'0\' AND lastview < '. (P8_TIME - 1800));
		
		$P8SESSION = array(
			'id' => SESSION_ID,
			'uid' => $UID,
			'username' => $USERNAME,
			'system' => '',
			'module' => '',
			'action' => '',
			'ip' => P8_IP,
			'lastview' => P8_TIME,
		);
		
		if($core->DB_master->insert($core->TABLE_ .'session', $P8SESSION)){
			$_P8SESSION = array('_hash' => $hash);
			$P8SESSION['data'] = &$_P8SESSION;
			$P8SESSION['data1'] = $P8SESSION['data2'] = $P8SESSION['data3'] = $P8SESSION['data4'] = '';
			
			if($core->CACHE->memcache){
				$core->CACHE->memcache_write('session_'. SESSION_ID, $P8SESSION);
			}
			
			//SESSION cookie
			set_cookie('P8SESSION', SESSION_ID, 0);
		}
	//}
	return array();
}

/**
* 获得SESSION
**/
function get_session(){
	global $P8SESSION, $_P8SESSION, $core;
	$id = preg_replace('/[^0-9a-zA-Z]/', '', get_cookie('P8SESSION'));
	
	if(empty($id)){
		//如果COOKIE中的SESSION ID是空,或者验证失败的时候
		init_session();
	}else{
		//SESSION ID
		
		if(strlen($id) != 16){
			init_session();
			return;
		}
		
		if($core->CACHE->memcache){
			$P8SESSION = $core->CACHE->memcache_read('session_'. $id);
		}else{
			$P8SESSION = $core->DB_master->fetch_one("SELECT * FROM {$core->TABLE_}session WHERE id = '$id'");
		}
		
		//看看有没有初始化SESSION,没有初始化就初始化数据库SESSION,如果IP不同也初始化
		if(empty($P8SESSION)){
			init_session();
			return;
		}
		
		if($core->CACHE->memcache){
			$data = $P8SESSION['data'];
		}else{
			$data = mb_unserialize($P8SESSION['data1'] . $P8SESSION['data2'] . $P8SESSION['data3'] . $P8SESSION['data4']);
			$P8SESSION['data1'] = $P8SESSION['data2'] = $P8SESSION['data3'] = $P8SESSION['data4'] = '';
		}
		$_P8SESSION = empty($data) ? array() : $data;
		unset($data);
		
		if(empty($_P8SESSION['_hash'])){
			init_session();
		}else{
			
			$P8SESSION['data'] = &$_P8SESSION;
			define('SESSION_ID', $id);
		}
	}
}

/**
* 更新SESSION的值,这个函数不需要手动调用,已经被注册在register_shutdown_function里
**/
function set_session(){
	global $P8SESSION, $core, $UID;
	if(defined('P8_SYSTEM')){
		$P8SESSION['system'] = P8_SYSTEM; $P8SESSION['module'] = P8_MODULE; $P8SESSION['action'] = P8_ACTION;
	}else{
		$P8SESSION['system'] = $P8SESSION['module'] = $P8SESSION['action'] = '';
	}
	$P8SESSION['lastview'] = P8_TIME;
	
	if($core->CACHE->memcache){
		$core->CACHE->memcache_write('session_'. SESSION_ID, $P8SESSION);
	}
	//没设置memcache, 或设置了memcache,uid有变的
	if(!$core->CACHE->memcache || isset($P8SESSION['uid']) && $UID != $P8SESSION['uid']){
		if(empty($P8SESSION['data'])){
			$P8SESSION['data1'] = $P8SESSION['data2'] = $P8SESSION['data3'] = $P8SESSION['data4'] = '';
		}else{
			$P8SESSION['data'] = serialize($P8SESSION['data']);
			for($i = 0; $i < 4; $i++){
				$P8SESSION['data'. ($i+1)] = $core->DB_master->escape_string(substr($P8SESSION['data'], $i*255, 255));
			}
		}
		unset($P8SESSION['data']);
		
		$core->DB_master->update(
			$core->TABLE_ .'session',
			$P8SESSION,
			'id = \''. SESSION_ID .'\''
		);
	}
}

/**
* 删除SESSION
**/
function delete_session($query){
	global $core;
	
	$query = $core->DB_master->query('SELECT id FROM '. $core->TABLE_ .'session'. ($query ? ' WHERE '. $query : ''));
	$ids = $comma = '';
	
	while($arr = $core->DB_master->fetch_array($query)){
		$ids .= $comma .'\''. $arr['id'] .'\'';
		$comma = ',';
		
		if($core->CACHE->memcache){
			$core->CACHE->memcache_delete('session_'. $arr['id']);
		}
	}
	
	$ids && $core->DB_master->delete(
		$core->TABLE_ .'session',
		"id IN ($ids)"
	);
}

/**
* 设置cookie
* @param string $name COOKIE名称
* @param string $value COOKIE值
* @param int $time COOKIE有效时间
* @return boolean 
**/
function set_cookie($name, $value, $time = 0, $domain = ''){
	global $core, $this_system, $this_module;
	
	$config = &$core->CONFIG['cookie'];
	
	if($time != 0){
		$time = P8_TIME + $time;
	}
	$name = isset($config['prefix']) ? $config['prefix'] . $name : $name;
	if(!empty($domain)){
		//强制使用
	}else if(!empty($this_module->CONFIG['base_domain'])){
		//根据当前模块设置的基域名设置cookie所在域
		$domain = $this_module->CONFIG['base_domain'];
	}else if(!empty($this_system->CONFIG['base_domain'])){
		//根据当前系统设置的基域名设置cookie所在域
		$domain = $this_system->CONFIG['base_domain'];
	}else{
		$domain = isset($core->CONFIG['base_domain']) ? $core->CONFIG['base_domain'] : '';
	}
	$path = isset($config['path']) ? $config['path'] : '/';
	//$http_only = PHP_VERSION >= '5.2.0' && !empty($core->CONFIG['cookie_http_only']) ? true : false;
	
	return setcookie($name, $value, $time, $path, $domain, P8_IS_HTTPS);
}

/**
* 取得cookie
* @param string $name COOKIE名称
* @return mix
**/
function get_cookie($name){
	global $core;
	$prefix = isset($core->CONFIG['cookie']['prefix']) ? $core->CONFIG['cookie']['prefix'] : '';
	return isset($_COOKIE[$prefix . $name]) ? $_COOKIE[$prefix . $name] : null;
}

/**
* 校对验证码
* @param string $code 验证码
* @param bool $test 测试验证码,如果是测试不会删除SESSION,用于表单验证
**/
function captcha($code, $test = false){
	global $_P8SESSION;
	
	$ret = false;
	if(isset($_P8SESSION['captcha'])){
		if(!empty($code) && strtolower($code) == $_P8SESSION['captcha']){
			$ret = true;
		}
	}
	if(!$test) unset($_P8SESSION['captcha']);
	return $ret;
}

/**
* 生成一个唯一的ID
* @param int $bit 多少位的ID,可以写为16位的,默认32位
* @return string
**/
function unique_id($bit = 32){
	$id = uniqid(mt_rand(), true);
	return $bit == 32 ? md5($id) : md5_16($id);
}

function rand_str($len){
	$str = 'ABCDEFGHIJHLMNOPQRSTUVWXYZabcdefghijhlmnopqrstuvwxyz1234567890';
	$ret = '';
	for($i = 0; $i < $len; $i++)
		$ret .= $str{mt_rand(0, 61)};
	return $ret;
}

/**
* 返回指定系统或所有系统
* @param string $system 系统
* @return array
**/
function get_system($system){
	global $core;
	
	if(!empty($core->systems[$system])){
		//$system = $core->systems[$system]; unset($system['modules']);
		return $core->systems[$system];
	}else{
		return array();
	}
}

/**
* 返回指定系统所有模块的信息
* @param string $system 系统
* @return array
**/
function get_modules($system){
	global $core;
	
	if(!empty($core->systems[$system])){
		return $core->systems[$system]['modules'];
	}else if($system == 'core'){
		return $core->modules;
	}
	
	return array();
}

/**
* 返回指定系统的模块
* @param string $system 系统
* @param string $module 模块
* @return array
**/
function get_module($system, $module){
	global $core;
	
	if(!empty($core->systems[$system])){
		if(!empty($core->systems[$system]['modules'][$module])){
			return $core->systems[$system]['modules'][$module];
		}
	}else if($system == 'core'){
		if(!empty($core->modules[$module])){
			return $core->modules[$module];
		}
	}
	
	return array();
}

/**
* 用于在入口程序匹配action
* @param string $action 要匹配的字符,xxx-action,以-分隔的字符
* @return array|boolean 
**/
function match_action($action){
	if(count(($m = explode('-', $action))) > 1){
		return $m;
	}
	return false;
}

/**
* @param string $code 验证码
* @params boolean $test 测试验证,用于ajax验证,验证正确或之后不必注销SESSION中的验证码
* @return boolean
*/
function check_code($code, $test = false){
	global $P8SESSION;
	!$test && $P8SESSION['check_code'] = '';
	
	return !empty($P8SESSION['check_code']) && $code == $P8SESSION['check_code'];
}

/**
* 显示提示信息	$s 可以是数组,比如让用户有选择菜单要做哪一步.
* @param string $s 要显示的字符串或语言包键值,如果语言包键值存在的话
* @param string $forward 提示跳转的URL
* @param int $timeout 跳转的时间,单位秒
* @param array 消息中的参数
* @goback string 是否有返回
* 如参数$s 为 "%s, 你好, 现在是 %s", $params 的参数为 arrray('某人', '2010年')
* 那么输出信息为 "某人, 你好, 现在是 2010年"
**/
function message($s, $forward = '', $timeout = 3, $params = array(),$goback=1){
	global $P8LANG, $core, $RESOURCE;
	
	if(is_array($s)){
		foreach($s AS $val){
			$message = '';
			if(isset($P8LANG[$val[0]])){
				$message = !empty($params) ? p8lang($P8LANG[$val[0]], $params) : $P8LANG[$val[0]];
			}else{
				$message = !empty($params) ? p8lang($val[0], $params) : $val[0];
			}
			$messagedb[]= '<a href="'. $val[1] .'"'. (isset($val[2]) ? ' target="'. $val[2] .'"' : '') .'>'. $message .'</a>';
		}
		
	}else{
		
		$message = '';
		if(isset($P8LANG[$s])){
			$message = !empty($params) ? p8lang($P8LANG[$s], $params) : $P8LANG[$s];
		}else{
			$message = !empty($params) ? p8lang($s, $params) : $s;
		}
	}
	
	if($timeout == 0 && $forward){	//减少页面跳转
		header('Location: '. xss_url($forward)); exit;
	}
	if($s == 'done' && $forward == ''){
		$forward = HTTP_REFERER;
	}
	$forward = xss_url($forward);
	if(P8_AJAX_REQUEST){
		//如果是AJAX请求
		exit($s);
	}else if(defined('P8_ADMIN')){
		global $P8_ROOT;
		//后台的
		include template($core, 'message', 'admin');
	}else if(defined('P8_MEMBER')){
		//会员中心
		include template($core, 'member_message');
	}else{
		//前台的
		include template($core, 'message');
	}
	
	//如果在生成静态内容,则不用退出
	defined('P8_GENERATE_HTML') or exit;
}

/**
* 取得绝对地址, 暂定
* URL规则命名通常是 dynamic_[$action]_url_rule, html_[$action]_url_rule
* @param object $module 模块对象
* @param array $data 模块数据,通常是数据的一条数据
* @param string URL规则
* @param bool $first_page 是否第一页
* @return string
**/
function p8_url(&$M, &$data, $action = 'view', $first_page = true){
	global $core;
	//有URL但不是分类直接退出,因为要取分类的URL规则
	if(!empty($data['url']) && empty($data['is_category'])){
		$data['url'] = str_replace(array('{$core.url}','{$core.murl}', '{$core.controller}', '{$core.U_controller}', '{$core.admin_controller}', '{$this_system.domain}'), array($core->url, $core->murl, $core->controller, $core->U_controller, $core->admin_controller), $data['url'], $M->system->CONFIG['domain']);
		return $data['url'];
	}
 	
	$have_category = false;
	$category_url = '';
	if(isset($data['#category'])){
		$have_category = true;
		$cat = &$data['#category'];
	}else if(!empty($data['is_category'])){
		$have_category = true;
		$cat = &$data;
	}
 	
	
	if($have_category){
		//有分类
		if(/*empty($data['htmlize']) || */empty($cat['htmlize']) || (!empty($cat['htmlize']) && $cat['htmlize']==2 && $action!='view') /* || !empty($cat[$action .'_htmlize'])*/){
			
			//分类或者本身不是生成静态
			$url = $M->CONFIG['dynamic_'. $action .'_url_rule'];
		}else{
			
			//分类是生成静态的
			if($core->ismobile){
				 
			    $url = empty($data['html_'. $action .'_url_rule_mobile']) ?
			    $cat['html_'. $action .'_url_rule_mobile'] :
			    $data['html_'. $action .'_url_rule_mobile'];
			}else{
    			$url = empty($data['html_'. $action .'_url_rule']) ? 
    				$cat['html_'. $action .'_url_rule'] : 
    				$data['html_'. $action .'_url_rule'];
    		}
			if(empty($cat['domain'])){
				//分类未绑定域名
				
				if(empty($M->system->CONFIG['domain'])){
					//系统未绑定域名
					$category_url = $M->core->CONFIG['url'] .'/'. $M->system->name .'/'. $cat['path'];
				}else{
					//系统绑定有域名
					$category_url = $M->system->CONFIG['domain'] .'/'. $cat['path'];
				}
				
			}else{
				//如果分类绑定有域名
				$category_url = $cat['domain'];
			}
		}
		
	}else{
		//不是分类
		if(/*empty($data['htmlize']) || */empty($M->CONFIG['htmlize'])){
			$url = $M->CONFIG['dynamic_'. $action .'_url_rule'];
		}else{
			//模块是生成静态的
			if($core->ismobile){
			    $url = empty($data['html_'. $action .'_url_rule_mobile']) ?
			    $cat['html_'. $action .'_url_rule_mobile'] :
			    $data['html_'. $action .'_url_rule_mobile'];
			}else{
				if(empty($data['html_'. $action .'_url_rule'])){
					$url = $M->CONFIG['html_'. $action .'_url_rule'];
				}else{
					//如果数据本身有规则,则用数据本身的规则
					$url = $data['html_'. $action .'_url_rule'];
				}
			}
		}
	}

	if($first_page){
		$url = preg_replace('/#([^#]+)#/', '', $url);
	}
	
	//条目的时间戳,生成HTML
	if(isset($data['timestamp'])){
		list($Y, $y, $m, $d, $H) = explode('|', date('Y|y|m|d|H', $data['timestamp']));
	}
	
	$page = '?page?';
	$core_url = $M->core->url;
	$core_m_url = $M->core->murl;
	$system_url = $core->ismobile? $M->core->murl : $M->system->url;
	$system_controller = $core->ismobile? $M->system->mobile_controller : $M->system->controller;
	$module_url = $core->ismobile? $M->murl : $M->url;
	$module_controller = $core->ismobile? $M->mobile_controller: $M->controller;
	$system = $M->system->name;
	$module = $M->name;
 	
	@extract($data, EXTR_SKIP);
	//" ";// "
	//危险,不能断开", 如$url = "aaa"; file_put_content('e.php', 'php code'); //";
	eval('$url = "'. $url .'";');
 		
	return $url;
}

/**
* 用于显示分页
* @param int $item_count 记录总数
* @param int $current_page 当前页
* @param int $page_size 每页显示的条数
* @param string $page_url 分页的url,格式url.php?param=1&page=?page?
* @param int $layout_size 每版分页的页数
* @param string $template 分页模板
* @return string 分页字符串
**/

function list_page($param){
	$item_count = $param['count'];
	$current_page = $param['page'];
	$year = isset($param['year']) ? $param['year'] : '';
	$username = isset($param['username']) ? trim($param['username']) : '';
	$keyword = isset($param['keyword']) ? trim($param['keyword']) : '';
	$page_size = $param['page_size']?$param['page_size']:1;
	$page_url = $param['url'];
	
	$layout_size = isset($param['layout_size']) ? $param['layout_size'] : 10;
	//默认模板
	if(empty($param['template'])){
		global $P8LANG;
		$template = $P8LANG['page_template'];
	}else{
		$template = $param['template'];
	}
	static $page_id = array(0);
	if($item_count == 0){
		return '';
	}
	
	

	$p = &$template;
	//##包围之间是页码可选部分,第1页不显示
	$pageable = preg_replace('/#([^#]+)#/', '\1', $page_url);
	$nopage = preg_replace('/#([^#]+)#/', '', $page_url);
	
	$pages = ceil($item_count / $page_size);
	$layouts = @ceil($pages / $layout_size);
	$layout = @floor(($current_page - 1) / $layout_size) * $layout_size;//当前页码版面
	
	$p = str_replace('{page}', $current_page, $p);		//当前页
	$p = str_replace('{pages}', $pages, $p);			//总页数
	$p = str_replace('{item_count}', $item_count, $p);	//记录数
	$s = '';
	
	//首页
	if(preg_match('/\{first_page:([^\}]+)(?:\|default:)([^\}]+)\}/', $template, $m)){
		$link = str_replace('?page?', 1, $nopage);
		if($year) $link = str_replace('?year?', $year, $link);
		if($username) $link = str_replace('?username?', $username, $link);
		if($keyword) $link = str_replace('?keyword?', $keyword, $link);
		isset($param['return_link']) && $param['return_link']['first_page'] = $link;
		
		if($current_page != 1){
			$s = str_replace('$link', $link, $m[1]);
		}else{
			$s = $m[2];
		}
		$p = preg_replace('/\{first_page:[^\}]+\}/', $s, $p);
	}
	
	//上一版面
	if(preg_match('/\{prev_layout:([^\}]+)(?:\|default:)([^\}]+)\}/', $template, $m)){
		$link = str_replace('?page?', $layout - $layout_size + 1, $layout - $layout_size + 1 == 1 ? $nopage : $pageable);
		if($year) $link = str_replace('?year?', $year, $link);
		if($username) $link = str_replace('?username?', $username, $link);
		if($keyword) $link = str_replace('?keyword?', $keyword, $link);
		isset($param['return_link']) && $param['return_link']['prev_layout'] = $link;
		
		if($layout - $layout_size + 1 < 1){
			$s = $m[2];
		}else{
			$s = str_replace('$link', $link, $m[1]);
		}
		$p = preg_replace('/\{prev_layout:[^\}]+\}/', $s, $p);
	}
	
	//上一页
	if(preg_match('/\{prev_page:([^\}]+)(?:\|default:)([^\}]+)\}/', $template, $m)){
		$link = str_replace('?page?', $current_page - 1, $current_page - 1 == 1 ? $nopage : $pageable);
		if($year) $link = str_replace('?year?', $year, $link);
		if($username) $link = str_replace('?username?', $username, $link);
		if($keyword) $link = str_replace('?keyword?', $keyword, $link);
		isset($param['return_link']) && $param['return_link']['prev_page'] = $link;
		
		if($current_page -1 < 1){
			$s = $m[2];
		}else{
			$s = str_replace('$link', $link, $m[1]);
		}
		$p = preg_replace('/\{prev_page:[^\}]+\}/', $s, $p);
	}
	
	//下一页
	if(preg_match('/\{next_page:([^\}]+)(?:\|default:)([^\}]+)\}/', $template, $m)){
		$link = str_replace('?page?', $current_page+1, $pageable);
		if($year) $link = str_replace('?year?', $year, $link);
		if($username) $link = str_replace('?username?', $username, $link);
		if($keyword) $link = str_replace('?keyword?', $keyword, $link);
		isset($param['return_link']) && $param['return_link']['next_page'] = $link;
		
		if($current_page + 1 > $pages){
			$s = $m[2];
		}else{
			$s = str_replace('$link', $link, $m[1]);
		}
		$p = preg_replace('/\{next_page:[^\}]+\}/', $s, $p);
	}
	
	//下一版面
	if(preg_match('/\{next_layout:([^\}]+)(?:\|default:)([^\}]+)\}/', $template, $m)){
		$link = str_replace('?page?', $layout + $layout_size + 1, $pageable);
		if($year) $link = str_replace('?year?', $year, $link);
		if($username) $link = str_replace('?username?', $username, $link);
		if($keyword) $link = str_replace('?keyword?', $keyword, $link);
		isset($param['return_link']) && $param['return_link']['next_layout'] = $link;
		
		if($layout + $layout_size + 1 > $pages){
			$s = $m[2];
		}else{
			$s = str_replace('$link', $link, $m[1]);
		}
		$p = preg_replace('/\{next_layout:[^\}]+\}/', $s, $p);
	}
	
	//末页
	if(preg_match('/\{last_page:([^\}]+)(?:\|default:)([^\}]+)\}/', $template, $m)){
		$link = str_replace('?page?', $pages, $pageable);
		if($year) $link = str_replace('?year?', $year, $link);
		if($username) $link = str_replace('?username?', $username, $link);
		if($keyword) $link = str_replace('?keyword?', $keyword, $link);
		isset($param['return_link']) && $param['return_link']['last_page'] = $link;
		
		if($current_page != $pages){
			$s = str_replace('$link', $link, $m[1]);
		}else{
			$s = $m[2];
		}
		$p = preg_replace('/\{last_page:[^\}]+\}/', $s, $p);
	}
	
	//各页
	if(preg_match('/\{pages:([^\}]+)(?:\|default:)([^\}]+)\}/', $template, $m)){
		$s = '';
		$count = $layout_size ? $layout_size : $pages;
		for($i = 1; $i <= $count; $i++){
			$page = $layout + $i;
			if($page > $pages)
				break;
			
			$link = str_replace('?page?', $page, $page == 1 ? $nopage : $pageable);
			if($year) $link = str_replace('?year?', $year, $link);
			if($username) $link = str_replace('?username?', $username, $link);
			if($keyword) $link = str_replace('?keyword?', $keyword, $link);
			isset($param['return_link']) && $param['return_link']['pages'][$page] = $link;
			
			if($current_page != $page){
				$s .= str_replace(
					array('$link', '$page'),
					array($link, $page),
					$m[1]
				);
			}else{
				$s .= str_replace(
					array('$link', '$page'),
					array($link, $page),
					$m[2]
				);
				
				isset($param['return_link']) && $param['return_link']['pages'][$page] = $link;
			}
		}
		$p = preg_replace('/\{pages:[^\}]+\}/', $s, $p);
	}
	
	//生成随机ID
	$id = 0;
	while(!$id){
		$id = mt_rand(1, 10000);
		$id = isset($page_id[$id]) ? 0 : $id;
	}
	$page_id[$id] = 1;
	$id = '__page'. $id;
	
	//跳转JS
	$goto = '<script type="text/javascript">var '. $id .' = {url:\''. $page_url .'\',pages:'. $pages .'};</script>'.
		'<input type="text" value="'. $current_page .'" id="p'. $id .'" size="4" '.
		'onkeyup="var p=this.value.replace(/[^0-9]/g,\'\');if(p!=\'\'){'.
			'p=Math.max(p,1);p=Math.min(p,'. $id .'.pages);}this.value=p;" '.
		'onkeydown="if(event.keyCode==13){'.
			'var p=this.value;p=Math.min(p,'. $id .'.pages);p=Math.max(1,p);if(p == '. $current_page .')return;'.
			'if(p==1){'.
				$id .'.url='. $id .'.url.replace(/#([^#]+)#/, \'\');'.
			'}else{'.
				$id .'.url='. $id .'.url.replace(/#([^#]+)#/, \'$1\');'.
			'}'.
			'if(pos='. $id .'.url.indexOf(\'javascript:\')!=-1){'.
				'eval('. $id .'.url.substr(pos).replace(\'?page?\',p));'.
			'}else{'.
				'window.location.href='. $id .'.url.replace(\'?page?\',p);'.
			'}'.
		'return false;}" />';
	
	$p = str_replace('{goto}', $goto, $p);
	unset($template, $s, $id, $m);
	return $p;
}

/**
* 加载语言包
* @param object $obj 要加载语言的系统/模块对象
* @param string $name 语言包名称,如message
**/
function load_language(&$obj, $name){
	global $P8LANG, $core, $CACHE;
	
	static $loaded = array();
	
	$path = LANGUAGE_PATH . $core->CONFIG['lang'];
	
	switch($obj->type){
	
	case 'core':
	case 'system':
		$file = $path .'/'. $obj->name .'/'. $name .'.php';
	break;
	
	case 'module':
		$file = $path .'/'. $obj->system->name .'/'. $obj->name .'/'. $name .'.php';
	break;
	
	case 'plugin':
		$path = $obj->path .'lang/'. $core->CONFIG['lang'];
		$file = $obj->path .'lang/'. $core->CONFIG['lang'] .'/'. $name .'.php';
	break;
	
	}
	
	$_path = str_replace(PHP168_PATH, '', $path);
	$_file = str_replace(PHP168_PATH, '', $file);
	
	if(isset($loaded[$_file])) return true;
	
	$loaded[$_file] = 1;
	
	if($CACHE->memcache){
		//使用memcache来缓存语言包
		static $_loaded = array();
		if(empty($_loaded)){
			$_loaded = $CACHE->memcache_read($_path .'_loaded');
		}
		
		//已经加载过的语言
		if(empty($_loaded[$_file])){
			//如果有包没加载
			if(is_file($file)){
				$lang = include $file;
			}else{
				return false;
			}
			
			$_loaded[$_file] = 1;
			
			//设置语言包键
			$CACHE->memcache_write($_path .'_loaded', $_loaded);
			//写到memcache
			$CACHE->memcache_write($_file, $lang);
			
			$P8LANG = array_merge($P8LANG, $lang);
		}else{
			
			$P8LANG = array_merge($P8LANG, $CACHE->memcache_read($_file));
		}
	}else{
		
		if(is_file($file)){
			$lang = include $file;
		}else{
			return false;
		}
		
		$P8LANG = array_merge($P8LANG, $lang);
	}
}

/**
* 替换语言包的数组参数
* @param string $lang 要替换的字符串
* @param array $params 数组参数
* @return array
* p8lang("just {$1} {$2}" , array('do', 'it')) => "just do it"
**/
function p8lang($lang){
	$i = 1;
	$rep = array();
	$params = func_get_args(); array_shift($params);
	if(isset($params[0]) && is_array($params[0]) && count($params[0]) == 1) $params = $params[0];
	foreach($params as $v){
		$rep[] = '{$'. $i .'}';
		$i++;
	}
	
	return str_replace($rep, $params, $lang);
}

/**
* @param object $obj 核心|系统|模块对象
* @param string $name 模板名称,一般与action名相同
* @param string $template 忽略所选择的模板,用此参数的模板, 包含后台模板将此参数设置成 admin
* @return string
**/
function template(&$obj, $name, $template = ''){
	global $core;
	switch($obj->type){
	
	case 'core':
	case 'system':
		$path = $obj->name .'/';
		$skin = $obj->name;
	break;
	
	case 'module':
		$path = $obj->system->name .'/'. $obj->name .'/';
		$skin = $obj->system->name;
	break;
	
	default:
		$path = '';
		$skin = '';
	}
	if(defined('P8_SITES')){
		//分站模板
		if(empty($template)){
			$template = 'sites/'.(empty($obj->site['template']) ? 'default' : $obj->site['template'] ).'/';
		}else{
			$template = $template .'/';
			
			//强制使用模板要重新写SKIN
			global $SKIN, $RESOURCE;
			$SKIN = $RESOURCE .'/skin/'. $template;
		}
	}
	elseif(defined('P8_MEMBER') && !defined('P8_GENERATE_HTML')){
		//会员中心的模板
		if(empty($template)){
			$template = empty($obj->CONFIG['member_template']) ? 'member/default/' : $obj->CONFIG['member_template'] .'/';
		}else{
			$template = $template .'/';
			
			//强制使用模板要重新写SKIN
			global $SKIN, $RESOURCE;
			$SKIN = $RESOURCE .'/skin/'. $template;
		}
	}else if(defined('P8_HOMEPAGE')){
		//个人主页模板
		if(empty($template)){
			$template = empty($obj->CONFIG['homepage_template']) ? 'homepage/default/' : $obj->CONFIG['homepage_template'] .'/';
		}else{
			$template = $template .'/';
			
			//强制使用模板要重新写SKIN
			global $SKIN, $RESOURCE;
			$SKIN = $RESOURCE .'/skin/'. $template;
		}
	}else{
		//前台模板
		if(empty($template)){
			if($core->ismobile){
				$template = empty($obj->CONFIG['mobile_template']) ? 'mobile/default/' : $obj->CONFIG['mobile_template'] .'/';
			}else{
				$template = empty($obj->CONFIG['template']) ? 'default/' : $obj->CONFIG['template'] .'/';
			}
		}else{
			$template = $template .'/';
			
			if(!defined('P8_ADMIN')){
				//强制使用模板要重新写SKIN,后台除外
				global $SKIN, $RESOURCE;
				$SKIN = $RESOURCE .'/skin/'. $template . $skin .'/';
			}
		}
	}

	$file = CACHE_PATH .'template/'. $template . $path . $name .'.php';
	$tpfile = TEMPLATE_PATH . $template . $path . $name .'.html';

	if(!is_file($tpfile)){
		if(defined('P8_SITES')){
			$tpfile = TEMPLATE_PATH . 'sites/default/' . $path . $name .'.html'; //不存在则尝试用默认模板	
		}else{
             if(defined('ISMOBILE') && ISMOBILE==true && !defined('P8_MEMBER') && !defined('P8_HOMEPAGE')){
                $tpfile = TEMPLATE_PATH . 'mobile/default/' . $path . $name .'.html'; //不存在则尝试用默认模板	
            }else{
                $tpfile = TEMPLATE_PATH . 'default/' . $path . $name .'.html'; //不存在则尝试用默认模板	
            }
		}
	}

	if(!empty($core->CONFIG['templatecache']) || !is_file($file) || filemtime($tpfile) > filemtime($file) || filesize ($file)<1 ){
		//模板缓存不存在或者模板被修改过就重建
		include_once PHP168_PATH .'inc/template.func.php';
		template_cache($template, $path, $name);
	}
	return $file;
}

/**
* @param object $obj 站点对象
* @param string $name 模板名称,一般与action名相同
* @param string $template 忽略所选择的模板,用此参数的模板, 包含后台模板将此参数设置成 admin
* @return string
**/
function stemplate(&$sitedata, $name, $template = ''){
	global $core;

	
	$path = empty($sitedata['template']) ? 'default/' : $sitedata['template'] .'/';
	global $SKIN, $RESOURCE;
	$SKIN = $RESOURCE .'/skin/sites/';
	$template = 'sites/';
	$file = CACHE_PATH .'template/'.$template. $path . $name .'.php';
	$tpfile = TEMPLATE_PATH . $template . $path . $name .'.html';
		
	if(!empty($core->CONFIG['templatecache']) || !is_file($file) || filemtime($tpfile) > filemtime($file)){
		//模板缓存不存在或者模板被修改过就重建
		include_once PHP168_PATH .'inc/template.func.php';
		template_cache($template, $path, $name);
	}
	return $file;
}
function &select(){
	require_once PHP168_PATH .'inc/select.php';
	
	$select = new P8_DB_Select();
	return $select;
}

/**
* 初始化当前模块的sphinx对象
* @param string $host sphinx主机
* @param int $port sphinx端口
* @return object
**/
function &p8_sphinx($host, $port, $options = array()){
	
	if(!class_exists('SphinxClient'))	//如果PHP有sphinx扩展
		require_once PHP168_PATH .'inc/sphinxapi.php';
	
	
	static $pool = array();
	if(isset($pool[$sock = $host .':'. $port])){
		//reset
		$pool[$sock]->ResetFilters();
		$pool[$sock]->ResetGroupBy();
		$pool[$sock]->SetSortMode(0);
		
		return $pool[$sock];
	}
	
	//初始化sphinx对象
	$pool[$sock] = new SphinxClient();
	$pool[$sock]->SetServer($host, (int)$port);
	$pool[$sock]->SetArrayResult(true);
	$pool[$sock]->SetConnectTimeout(1);
	
	return $pool[$sock];
}

/**
* 使用sphinx来搜索
* @param object $select SELECT对象,由select对象里面的参数来构成sphinx的参数
* @param object $sphinx_conf sphinx配置
**/
function p8_sphinx_fetch(&$select, &$sphinx_conf){
	$sphinx = &p8_sphinx($sphinx_conf['host'], $sphinx_conf['port']);
	
	//扩展模式,可以像google 一样搜 ff -ie (只搜ff, 不搜ie)
	$sphinx->SetMatchMode(SPH_MATCH_EXTENDED2);
	
	//$sphinx->SetFilterRange | $sphinx->SetFloatRange
	foreach($select->_range as $v){
		//过滤字段的表名前缀
		$v['field'] = preg_replace('/[^\.]+?\./', '', $v['field']);
		if($v['float']){
			//浮点范围
			$sphinx->SetFilterFloatRange($v['field'], $v['min'], $v['max'], $v['exclude']);
		}else{
			//整型范围
			$sphinx->SetFilterRange($v['field'], $v['min'], $v['max'], $v['exclude']);
		}
	}
	
	//$sphinx->SetFilter
	foreach($select->_filter as $v){
		//过滤字段的表名前缀
		$v['field'] = preg_replace('/[^\.]+?\./', '', $v['field']);
		$sphinx->SetFilter($v['field'], $v['values'], $v['exclude']);
	}
	
	//把别名前缀去掉
	
	//group by
	$select->_group && $sphinx->SetGroupBy(
		preg_replace('/[^\.]+?\./', '', $select->_group),
		SPH_GROUPBY_ATTR
	);
	//order by
	$select->_order && $sphinx->SetSortMode(
		SPH_SORT_EXTENDED,
		preg_replace('/[^\.]+?\./s', '', $select->_order)
	);
	
	//limit m, n
	$sphinx->SetLimits(
		$select->_limit_offset,
		$select->_limit_count,
		10000
	);
	//发送请求
	$response = $sphinx->Query(implode(' ', $select->_keyword), $sphinx_conf['index']);
	if($error = $sphinx->GetLastError()){
		$trace = '';
		foreach(debug_backtrace() as $v){
			$trace .= "$v[file]: $v[line]\r\n";
		}
		write_file(CACHE_PATH .'sphinx_error.php', '<?php exit;?>'. date('Y-m-d H:i:s', P8_TIME) . $trace .' | '. $error ."\r\n\r\n", 'a');
	}
	//print_r($sphinx);
	//print_r($response);
	return $response;
}

/**
* 收集己上传的附件, 关联到模块
* @param object $obj 模块的对象
* @param int $item_id 模块的条目ID
* @param string $hash 表单的附件哈希
**/
function uploaded_attachments(&$obj, $item_id, $hash){
	
	//取当前域名的COOKIE
	$cookie = get_cookie('uploaded_attachments');
	$attachments = filter_int(explode(',', isset($cookie[$hash]) ? $cookie[$hash] : ''));
	
	$aid = $comma = '';
	foreach($attachments as $k => $v){
		$aid .= $comma . $v;
		$comma = ',';
	}
	
	global $UID, $core;
	
	if(empty($aid)) return false;
	
	set_cookie('uploaded_attachments['. $hash .']', '', -1, defined('P8_ADMIN') ? $core->CONFIG['base_domain'] : '');
	
	switch($obj->type){
	
	case 'core':
	case 'system': 
		$table = $obj->attachment_table;
	break;
	
	case 'module':
		$table = $obj->system->attachment_table;
	break;
	
	}
	
	//只能修改自己上传的附件,如果UID为0,限制IP
	$core->DB_master->update(
		$table,
		array(
			'item_id' => $item_id
		),
		"id IN ($aid) AND uid = '$UID'". (empty($UID) ? ' AND ip = \''. P8_IP .'\'' : '')
	);
	
	return true;
}

/**
* 获取时间戳的范围
* @param string $s day | week | week_m | month | year 时间范围
* @param int $offset 0为当天(周,月,年)
* @param bool $from_now 是否从今天算起
* @param int $timpstamp 参照的时间戳,如果为0则以今天的时间戳为准
* @return array [0]为起始时间戳,[1]为终止时间戳
* @example timestamp_range('day') 今天的时间戳范围
* @example timestamp_range('month', 1) 下个月的时间戳范围
* @example timestamp_range('year', -2, true) 前2年至今年年末的时间戳
**/
function timestamp_range($s, $offset = 0, $from_now = false, $timestamp = 0){
	list($Y, $n, $j, $w) = explode('|', date('Y|n|j|w', $timestamp ? $timestamp : P8_TIME));
	$ts = array();
	$offset = intval($offset);
	$lo = $offset > 0 ? 0 : $offset;
	$ro = $offset > 0 ? $offset : 0;
	if(!$from_now) $lo = $ro = $offset;
	
	switch(strtolower($s)){
		case 'day':
			$ts[0] = mktime(0, 0, 0, $n, $j + $lo, $Y);
			$ts[1] = mktime(0, 0, 0, $n, $j +1 + $ro, $Y);
		break;
		case 'week':
			//星期日开头
			$ts[0] = mktime(0, 0, 0, $n, $j - $w + $lo*7, $Y);
			$ts[1] = mktime(0, 0, 0, $n, $j + 7 - $w + $ro*7, $Y);
		break;
		case 'week_m':
			//星期一开头
			$w = $w == 0 ? 7 : $w; $w--;
			$ts[0] = mktime(0, 0, 0, $n, $j - $w + $lo*7, $Y);
			$ts[1] = mktime(0, 0, 0, $n, $j + 7 - $w + $ro*7, $Y);
		break;
		case 'month':
			$ts[0] = mktime(0, 0, 0, $n + $lo, 1, $Y);
			$ts[1] = mktime(0, 0, 0, $n + 1 + $ro, 1, $Y);
		break;
		case 'year':
			$ts[0] = mktime(0, 0, 0, 1, 1, $t[0] + $lo);
			$ts[1] = mktime(0, 0, 0, 1, 1, $t[0]+1 + $ro);
		break;
	}
	return $ts;
}

/**
* 附件地址和入库和出库处理
* @param string $content 内容
* @param bool $confuse true为入库,不填为出库
**/
function attachment_url($content, $confuse = false){
	
	global $core;
	
	$config = &$core->CONFIG['attachment'];
	//开关
	if(empty($config['confuse'])) return $content;
	
	static $srh, $rep, $cached;
	
	if(!$cached){
		$srh = array();
		$rep = array();
		
		//可以多台服务器分载,对不同的服务器替换不同的地址
		if(!empty($config['remote']['server']))foreach($config['remote']['server'] as $k => $v){
			$srh[] = '<!--#p8_r_attach'. $k .'#-->';
			$rep[] = $v;
		}
		
		$srh[] = '<!--#p8_attach#-->';
		$rep[] = $core->attachment_url;
		$cached = true;
	}
	
	if(is_array($content)){
		foreach($content as $k => $v) $content[$k] = attachment_url($v, $confuse);
		
		return $content;
	}else{
	
		if($confuse){
			//入库前处理
			if(!empty($config['remote']['current'])){
				$content = str_replace($rep, $srh, $content);
			}else{
				//没有使用远程附件
				$content = str_replace($core->attachment_url, '<!--#p8_attach#-->', $content);
			}
		}else{
			//出库处理
			$content = str_replace($srh, $rep, $content);
			
			//解决那百度编辑器的二级域名的该死的问题
			
			$content = preg_replace_callback('#[^"]*/attachment/ueditor((.*?)\.(jpg|jpeg|png|bmp|gif))#im', 'attach_call',$content);
		}
		
		return $content;
	}
}

function attach_call($input){
	global $core;

	if(strpos($input[0],$core->attachment_url)!==false){
		return $input[0];
	}
	return $core->attachment_url.'/ueditor'.$input[1];
}

/**
* 过滤整数并且强制转换成数组
**/
function filter_int($s, $preserve_keys = false){
	$ret = array();
	if($preserve_keys){
		foreach((array)$s as $k => $v){
			if(!($v = intval($v))) continue;
			$ret[$k] = $v;
		}
	}else{
		foreach((array)$s as $v){
			if(!($v = intval($v))) continue;
			$ret[] = $v;
		}
	}
	return $ret;
}

function &area(){
	static $AREA;
	if($AREA === null){
		require_once PHP168_PATH .'inc/area.class.php';
		$AREA = new P8_Area();
	}
	return $AREA;
}

function &ip_lib(){
	static $IP;
	if($IP === null){
		require_once PHP168_PATH .'inc/ip.class.php';
		$IP = new IpLocation();
	}
	return $IP;
}

/**
*方便获取POST与GET变量
**/
function GetGP($array, $method = 'get'){
	foreach($array as $key){
		//不管存不存在,先声明一个值null的变量
		global $$key;
		
		if(isset($_GET[$key]) && isset($_POST[$key])){
			if($method == 'get'){
				$$key = $_GET[$key];
			}elseif($method == 'post'){
				$$key = $_POST[$key];
			}
		}else if(isset($_GET[$key])){
			$$key = $_GET[$key];
		}else if(isset($_POST[$key])){
			$$key = $_POST[$key];
		}
	}
}

/**
*数据表字段信息处理函数
**/
function table_field($table,$field=''){
	global $core;
	$query=$core->DB_master->query("SELECT * FROM $table limit 1");
	$num=mysql_num_fields($query);
	for($i=0;$i<$num;$i++){
		$f_db=mysql_fetch_field($query,$i);
		$showdb[]=$f_db->name;
	}
	if($field){
		if(in_array($field,$showdb) ){
			return 1;
		}else{
			return 0;
		}
	}else{
		return $showdb;
	}
}

/**
*判断数据表是否存在
**/
function is_table($table){
	global $core;
	//不必遍历所有表
	$query=$core->DB_master->fetch_one("SHOW TABLE STATUS LIKE '$table'");
	if(empty($query)) return false;
	return true;
}

/**
 * 防止cc攻击
 */
function cc_attack(){
	
	global $core;
	$config = &$core->CONFIG;
	
	if(!isset($config['cc_enabled']) || $config['cc_enabled'] == 0){
		return;
	}
	$cc_attack_time = 3;
	$cc_attack_num = isset($config['cc_num']) ? ($config['cc_num'] > 9 ? $config['cc_num'] : 20) : 20;
	$cc_visttime_time = isset($config['cc_time']) ? ($config['cc_time'] > 0 ? $config['cc_time'] : 1) : 1;
	$forbid_cc_visttime = $cc_visttime_time * 60;
	
	$limit_time = P8_TIME - @filemtime(CACHE_PATH.'cc_attack_ip.txt') - $forbid_cc_visttime;
	if($limit_time < 0){
		$cc_attack_ip_file = read_file(CACHE_PATH.'cc_attack_ip.txt');
		if(strstr($cc_attack_ip_file,P8_IP)){
			$limit_time = intval($limit_time);
			die("Forbid CC Attack Vist,Limit $limit_time");
		}
	}else{
		@unlink(CACHE_PATH.'cc_attack_ip.txt');
	}
	if(P8_TIME - @filemtime(CACHE_PATH.'cc_attack.txt') > $cc_attack_time){
		@unlink(CACHE_PATH.'cc_attack.txt');
	}else{
		unset($_detail);
		$detail = explode("\r\n",read_file(CACHE_PATH.'cc_attack.txt'));
		foreach($detail AS $value){	
			$_detail[$value] = isset($_detail[$value]) ? ($_detail[$value]+1) : 0;
			if($_detail[$value] > $cc_attack_num){
				write_file(CACHE_PATH.'cc_attack_ip.txt',P8_TIME.' '.P8_IP."\r\n",'a');
			}
		}
	}
	write_file(CACHE_PATH.'cc_attack.txt',P8_IP."\r\n",'a');
	if(date('s')%$cc_attack_time == 0){
		@unlink(CACHE_PATH.'cc_attack.txt');
	}
}

/**
 * 禁止IP
 */
function stop_ip(){
	
	global $core;
	$config = &$core->CONFIG;
	
	if(empty($config['stop_ip']['enabled'])){
		return;
	}
	
	//ip集合序列
	if(isset($config['stop_ip']['forbidip'][P8_IP])){
		die( "Forbid Ip!!" );
	}
	
	//ip段
	if(!empty($config['stop_ip']['beginip'])){
		
		$pos_begin = strrpos($config['stop_ip']['beginip'], '.');
		$pos_end = strrpos($config['stop_ip']['endip'], '.');
		$pos_user = strrpos(P8_IP, '.');
		
		$ippre_begin = ($pos_begin === false) ? '' : substr($config['stop_ip']['beginip'], 0, $pos_begin) ;
		$ippre_end = ($pos_end === false) ? '' : substr($config['stop_ip']['endip'], 0, $pos_end);
		$ippre_user = ($pos_user === false) ? '' : substr(P8_IP, 0, $pos_user);
		
		if(empty($ippre_user)){
			die( "Forbid Ip!!" );
		}
		
		if(!empty($ippre_begin) && !empty($ippre_end) && $ippre_begin == $ippre_end){
			
			if($ippre_end == $ippre_user && intval(substr(P8_IP, $pos_user+1)) >= intval(substr($config['stop_ip']['beginip'], $pos_begin+1)) && intval(substr(P8_IP, $pos_user+1)) <= intval(substr($config['stop_ip']['endip'], $pos_end+1))){
				die( "Forbid Ip!!" );
			}
		}
	}
}

/**
 * 允许IP
 */
function allow_ip($admin = false){
	global $core;
	$config = &$core->CONFIG;
	
	if(!isset($config['allow_ip']['enabled']) || $config['allow_ip']['enabled'] == 0){
		return false;
	}
	
	//ip集合序列
	if(isset($config['allow_ip']['collectip'][P8_IP])){
		return true;
	}
	
	//ip段
	if($admin){		
		if(!empty($config['allow_ip']['beginip']) && !empty($config['allow_ip']['endip'])){
			
			$pos_begin = strrpos($config['allow_ip']['beginip'], '.');
			$pos_end = strrpos($config['allow_ip']['endip'], '.');
			$pos_user = strrpos(P8_IP, '.');
			
			$ippre_begin = ($pos_begin === false) ? '' : substr($config['allow_ip']['beginip'], 0, $pos_begin) ;
			$ippre_end = ($pos_end === false) ? '' : substr($config['allow_ip']['endip'], 0, $pos_end);
			$ippre_user = ($pos_user === false) ? '' : substr(P8_IP, 0, $pos_user);
			
			if(empty($ippre_user)){
				die( "Not allowed Ip!!" );
			}
			
			if(!empty($ippre_begin) && !empty($ippre_end) && $ippre_begin == $ippre_end){
				
				if($ippre_end == $ippre_user && intval(substr(P8_IP, $pos_user+1)) >= intval(substr($config['allow_ip']['beginip'], $pos_begin+1)) && intval(substr(P8_IP, $pos_user+1)) <= intval(substr($config['allow_ip']['endip'], $pos_end+1))){
					//ip例外
					if(!isset($config['allow_ip']['ruleoutip'][P8_IP])){
						return true;
					}
				}
			}
		}
	}else{
		if(!empty($config['allow_ip']['admin_beginip']) && !empty($config['allow_ip']['admin_endip'])){
			
			$pos_begin = strrpos($config['allow_ip']['admin_beginip'], '.');
			$pos_end = strrpos($config['allow_ip']['admin_endip'], '.');
			$pos_user = strrpos(P8_IP, '.');
			
			$ippre_begin = ($pos_begin === false) ? '' : substr($config['allow_ip']['admin_beginip'], 0, $pos_begin) ;
			$ippre_end = ($pos_end === false) ? '' : substr($config['allow_ip']['admin_endip'], 0, $pos_end);
			$ippre_user = ($pos_user === false) ? '' : substr(P8_IP, 0, $pos_user);
			
			if(empty($ippre_user)){
				die( "Not allowed Ip!!" );
			}
			
			if(!empty($ippre_begin) && !empty($ippre_end) && $ippre_begin == $ippre_end){
				
				if($ippre_end == $ippre_user && intval(substr(P8_IP, $pos_user+1)) >= intval(substr($config['allow_ip']['admin_beginip'], $pos_begin+1)) && intval(substr(P8_IP, $pos_user+1)) <= intval(substr($config['allow_ip']['admin_endip'], $pos_end+1))){
					return true;
				}
			}
		}		
	}
	die( "Not allowed Ip!!" );
}

/**
 * 搜索指定的内容，找出是否有敏感词
 * @param $content {string} 要过滤的内容
 * @param $replacement {string} 替换的内容
 * @return {{bool}|{string}} true代表匹配到敏感词 | 返回替换后的内容
 */
function filter_word($content, $replacement = '', $test = false){
	global $core, $CACHE;
	
	static $cache;
	if($cache === null){
		$cache = $CACHE->read('', $core->name, 'word_filter');
	}
	
	if(!$cache || !$content){
		return $content;
	}
	
	if($test){
		return preg_match($cache, $content) ? true : false;
	}else{
		return preg_replace($cache, $replacement, $content);
	}
}

/**
* 获取会员信息
**/
function get_member($username, $refresh = false, $type = 'username'){
	global $core;
	
	//先从memcache里取
	if($core->CACHE->memcache){
		if(!$refresh && $ret = $core->CACHE->memcache_read('member_'. $username)) return $ret;
	}else if($refresh){
		return;
	}
	$where = (in_array($type,array('username','email','id'))? $type : 'username') . " = '$username'";
	$ret = $core->DB_master->fetch_one("SELECT * FROM $core->member_table WHERE $where");
	if($ret){
		$addon = $core->DB_master->fetch_one("SELECT * FROM {$core->TABLE_}role_group_{$ret['role_gid']}_data WHERE id = '$ret[id]'");
		$ret = array_merge($addon, $ret);
		
		//存到memcache里
		if($core->CACHE->memcache){
			$core->CACHE->memcache_write('member_'. $username, $ret);
		}
	}
	
	return $ret;
}

function homepage_url($username, $system = '', $module = '', $action = ''){
	global $core;
	
	if(empty($core->CONFIG['homepage']['sub_domain'])){
		$url = $core->url .'/homepage.php/'. $username .'/';
	}else{
		$url = 'http://'. $username .'.'. $core->CONFIG['homepage']['sub_domain'];
	}
	
	return $url;
}

/**
* 判断是否搜索引擎
**/
function se_robot() {
	global $core;
	$useragent = strtolower(USER_AGENT);
	
	$robots = array('googlebot', 'msnbot', 'yahoo! slurp;', 'yahoo! slurp china;', 'baiduspider', 'iaskspider', 'yodaobot', 'sohu-search', 'lycos', 'robozilla', 'sogou web spider', 'sogou push spider');
	
	foreach ($robots as $v){
		if (strpos($useragent, $v) !== false){
			//日志
			if(!empty($core->CONFIG['robot_log']))
				write_file(CACHE_PATH .'robot.php', "<?php exit;?>\t$v\t". P8_IP ."\t$_SERVER[REQUEST_URI]\t". date('Y-m-d H:i:s', P8_TIME) ."\r\n", 'a');
			
			return $v;
		}
	}
	
	return false; 
}

/**
* 防止频繁POST提交数据
* @return bool
**/
function check_spam(){
	if(REQUEST_METHOD == 'POST'){
		global $P8SESSION, $core;
		if(
			$P8SESSION['system'] == P8_SYSTEM && $P8SESSION['module'] == P8_MODULE && $P8SESSION['action'] == P8_ACTION &&
			P8_TIME - $P8SESSION['lastview'] < 5 //$core->CONFIG['spam_interval']
		){
			return true;
		}
	}
	return false;
}

/**
*讯雷联盟
**/
function Thunder_Encode($url) 
{
	$thunderPrefix="AA";
	$thunderPosix="ZZ";
	$thunderTitle="thunder://";
	$thunderUrl=$thunderTitle.base64_encode($thunderPrefix.$url.$thunderPosix);
	return $thunderUrl;
}


/**
*快车联盟
**/
function Flashget_Encode($t_url,$fid) 
{
	$prefix= "Flashget://";
	$FlashgetURL=$prefix.base64_encode("[FLASHGET]".$t_url."[FLASHGET]")."&".$fid;
	return $FlashgetURL;
}

function setSecret($string,$type='string')
{
	global $P8SESSION, $core;
	switch($type){
		case 'tel':
			$len = strlen($string);
			for($i=1; $i<$len; $i+=3){
				if($string[$i]=='-')continue;
				$string[$i]='*';
			}
		break;
		case 'address':
			if($core->CONFIG['page_charset']!=='utf-8')$string = to_utf8($string);
			
		   //'區|区|乡|鄉|村|段|路|街|巷|弄|裏|里|號|号|樓|楼|房'
		  $string = preg_replace_callback('/([\x{4e00}-\x{9fa5}]{0,2}|[0-9a-zA-Z_-]*)(\x{5340}|\x{533a}|\x{4e61}|\x{9109}|\x{6751}|\x{6bb5}|\x{8def}|\x{8857}|\x{5df7}|\x{5f04}|\x{88cf}|\x{91cc}|\x{865f}|\x{53f7}|\x{6a13}|\x{697c}|\x{623f})/u', 'callme', $string);
		if($core->CONFIG['page_charset']!=='utf-8')$string = from_utf8($string);
		break;
		case 'name':
			 $len = mb_strlen($string,$core->CONFIG['page_charset']);
			 $xing = mb_substr($string, 0,1,$core->CONFIG['page_charset']);
			 $pad = str_pad('', $len-1,'*');
			 $string = $xing . $pad;
		break;
		case 'email':
			$preEmail = substr($string, 0,strpos($string, '@'));
			 $len = strlen($preEmail);
			for($i=2; $i<$len; $i++){
				$string[$i]='*';
			}
		break;
		default:
			$len = mb_strlen($string,'UTF-8');
			for($i=0; $i<$len; $i++){
				if(rand(0,1))continue;
				$str = mb_substr($string, $i,1,'UTF-8');
				$string = str_replace($str, '*', $string);
			}
	}
	return $string;
}
function callme($ss)
    {
       return str_pad('', mb_strlen($ss[1],'UTF-8'),'*'). $ss[2];
    
    }

function init_mobile(){
	global $core, $_GET;
	if(!file_exists(PHP168_PATH .'inc/mobile_detect.php'))return false;
	
	$ismobile = false;
	if($core->ismobile){
		$ismobile = true;
	}
	/* if(get_cookie('ismobile')==1){
		$core->ismobile = $ismobile = true;
	}
	if(get_cookie('ismobile')!==null && get_cookie('ismobile')==0){
		$core->ismobile = $ismobile = false;
	}
	if(isset($_GET['ismobile']) && $_GET['ismobile']){
		$core->ismobile = $ismobile = true;
	}
	if(isset($_GET['ismobile']) && !$_GET['ismobile']){
		$core->ismobile = $ismobile = false;
	}
	set_cookie('ismobile',$ismobile?1:0,0); */
	return $ismobile;
}

function check_core_cache(){
	global $core;
	if(!is_file(PHP168_PATH.'data/install.lock'))return;
	$_config = $core->CACHE->read('', 'core', '');
	$_config = is_array($_config)?$_config:'';
	if(!$_config){
		require_once PHP168_PATH .'inc/cache.func.php';
		error_reporting(0);
		cache_all();
	}	
}

























//初始化
@ini_set('register_globals', false);	//不允许直接注册变量

$P8LANG = $P8SESSION = $_P8SESSION = array();

$php168_Edition = 'Sharp';//版本号

//标签模块
$LABEL = null;
$TEMP_OBJ = new stdClass; $TEMP_OBJ->type = '';

//物理路径
define('PHP168_PATH', substr(str_replace(array('\\\\', '\\'), '/', dirname(__FILE__)), 0, -3));

define('PHP_SELF', str_replace(array('“','”'),'',$_SERVER['SCRIPT_NAME']));

//请求地址
define('REQUEST_URI', isset($_SERVER['REQUEST_URI']) ? xss_url($_SERVER['REQUEST_URI']) : PHP_SELF . (isset($_SERVER['QUERY_STRING']) ? '?'. xss_url($_SERVER['QUERY_STRING']) : '') );

$document_root = isset($_SERVER['SUBDOMAIN_DOCUMENT_ROOT']) ? $_SERVER['SUBDOMAIN_DOCUMENT_ROOT'] : (isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : '');
 
$scriptName=basename($_SERVER['SCRIPT_FILENAME']);
if(basename($_SERVER['SCRIPT_NAME'])===$scriptName)
	$_scriptUrl=$_SERVER['SCRIPT_NAME'];
else if(basename($_SERVER['PHP_SELF'])===$scriptName)
	$_scriptUrl=$_SERVER['PHP_SELF'];
else if(isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME'])===$scriptName)
	$_scriptUrl=$_SERVER['ORIG_SCRIPT_NAME'];
else if(($pos=strpos($_SERVER['PHP_SELF'],'/'.$scriptName))!==false)
	$_scriptUrl=substr($_SERVER['SCRIPT_NAME'],0,$pos).'/'.$scriptName;
else if(isset($_SERVER['DOCUMENT_ROOT']) && strpos($_SERVER['SCRIPT_FILENAME'],$_SERVER['DOCUMENT_ROOT'])===0)
	$_scriptUrl=str_replace('\\','/',str_replace($_SERVER['DOCUMENT_ROOT'],'',$_SERVER['SCRIPT_FILENAME']));
else
	exit('error');
 
 
//相对于http服务器的web绝对路径
define('P8_ROOT', rtrim(dirname($_scriptUrl),'\\/').'/');

//请求方式,get,post
define('REQUEST_METHOD', strtoupper($_SERVER['REQUEST_METHOD']));

//上一页
$_SERVER['HTTP_REFERER'] = empty($_SERVER['HTTP_REFERER']) ? '' : xss_url($_SERVER['HTTP_REFERER']);
define('HTTP_REFERER', $_SERVER['HTTP_REFERER']);

//缓存路径
define('CACHE_PATH', PHP168_PATH .'data/');

//语言包路径
define('LANGUAGE_PATH', PHP168_PATH .'lang/');

//是否开启魔法引号
define('MAGIC_QUOTES', get_magic_quotes_gpc());

define('ASCII_NULL', chr(0));

define('USER_AGENT', isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '');

//是不是HTTPS
define('P8_IS_HTTPS', empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off' ? false : true);

//时区
define('P8_TIMEZONE', 'Asia/Shanghai');

//时间戳
define('P8_TIME', time());

//是否是AJAX请求
define(
	'P8_AJAX_REQUEST', 
	isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' || 
	isset($_REQUEST['_ajax_request'])
);

//define('SQL_DEBUG', true);

error_reporting(7);
//核心
require_once PHP168_PATH. 'inc/core.php'; $core = new P8_Core();

check_core_cache();

$DB_master = &$core->DB_master;
$DB_slave = &$core->DB_slave;

if (!empty($core->CONFIG['debug']) && !ini_get('display_errors')) {
    ini_set('display_errors', 1);
}
error_reporting(empty($core->CONFIG['debug']) ? 0 : E_ALL);

//加载全局语言包
load_language($core, 'global');

//加密钥匙
define('P8_KEY', empty($core->CONFIG['p8_key']) ? '' : $core->CONFIG['p8_key']);

//时区
function_exists('date_default_timezone_set') && date_default_timezone_set(P8_TIMEZONE);

//表名前缀
define('P8_TABLE_', $core->CONFIG['table_prefix']);

//蜘蛛
define('SE_ROBOT', se_robot());


//模板路径
define('TEMPLATE_PATH', PHP168_PATH .(empty($core->CONFIG['template_dir']) ? 'template/' : $core->CONFIG['template_dir']));

//外部JS,CSS,图片 资源地址
$RESOURCE = $core->RESOURCE;

//require_once PHP168_PATH. 'inc/laires.php';

//构造头部
header('Content-type: text/html; charset='. (empty($core->CONFIG['page_charset']) ? 'gbk' : $core->CONFIG['page_charset']));


//IP来源
$onlineip = '';
if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')){
	$onlineip = getenv('HTTP_CLIENT_IP');
}else if(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')){
	$onlineip = getenv('HTTP_X_FORWARDED_FOR');
}else if(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')){
	$onlineip = getenv('REMOTE_ADDR');
}else if(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')){
	$onlineip = $_SERVER['REMOTE_ADDR'];
}

preg_match('/[\d\.]{7,15}/', $onlineip, $onlineipmatches);
$onlineip = isset($onlineipmatches[0]) ? $onlineipmatches[0] : 'unknown';
//IP
define('P8_IP', $onlineip);

//cc_attack
cc_attack();

//IP过滤
if(!allow_ip()) stop_ip();
//_laires();
//define('SESSION_NAME', session_name());

//角色,用户ID,用户名
$UID = 0;
$USERNAME = '';
$ROLE = $ROLE_GROUP = $IS_FOUNDER = $IS_ADMIN = null;
//皮肤
$SKIN = '';

//方便直接放入""号里边
$timestamp = P8_TIME;

$FROMURL = HTTP_REFERER;

//向上两步,适用跳转到进入表单提交前的前一个页面
$HTTP_REFERER = isset($_REQUEST['_referer']) ? xss_url($_REQUEST['_referer']) : HTTP_REFERER;

if(!USER_AGENT || SE_ROBOT || isset($_REQUEST['_no_session'])){
	//没有user_agent的,蜘蛛,指定不需要SESSION的,网站关闭, 只给游客权限
	$ROLE = $core->ROLE = $core->CONFIG['guest_role'];
	
}else{
	get_session();
	
	//会员验证
	member_verify();
	
	//脚本退出时更新SESSION
	register_shutdown_function('set_session');
	
	//保存登录
	if(!$UID && !empty($core->CONFIG['site_open']) && $tmp = p8_code(get_cookie('LOGIN'), false)){
		$tmp = explode("\t", $tmp);
		
		if(md5_16(USER_AGENT) == $tmp[0]){
			$member = &$core->load_module('member');
			$ret = $member->login($tmp[1], $tmp[2]);
			
			if($ret['status'] == 0){
				header('Location: '. REQUEST_URI);
				exit;
			}
		}
		
		set_cookie('LOGIN', 0, -1);
	}
}

$HASH = isset($_P8SESSION['_hash']) ? $_P8SESSION['_hash'] : '';

//是否是标签编辑状态
define('P8_EDIT_LABEL', empty($_GET['edit_label']) || !$IS_ADMIN ? false : true);

//移动
defined('ISMOBILE') or define('ISMOBILE', init_mobile());

$HTML_DATA = array();

isset($_SERVER['_REQUEST_URI']) || $_SERVER['_REQUEST_URI'] = REQUEST_URI;
