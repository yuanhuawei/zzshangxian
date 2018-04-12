<?php
class IpLocation {

var $fp;
var $firstip;
var $lastip;
var $totalip;
var $separator;

function IpLocation() {
	$this->fp = 0;
	if (($this->fp = @fopen(PHP168_PATH .'inc/QQWry.Dat', 'rb')) !== false) {
		$this->firstip = $this->getlong();
		$this->lastip = $this->getlong();
		$this->totalip = ($this->lastip - $this->firstip) / 7;
		//注册析构函数，使其在程序执行结束时执行
		register_shutdown_function(array(&$this, '_IpLocation'));
	}
	
	$this->separator = $this->separate(500);
}

function getlong() {
	//将读取的little-endian编码的4个字节转化为长整型数
	$result = unpack('Vlong', fread($this->fp, 4));
	return $result['long'];
}

function getlong3() {
	//将读取的little-endian编码的3个字节转化为长整型数
	$result = unpack('Vlong', fread($this->fp, 3).chr(0));
	return $result['long'];
}

function packip($ip) {
	// 将IP地址转化为长整型数，如果在PHP5中，IP地址错误，则返回False，
	// 这时intval将Flase转化为整数-1，之后压缩成big-endian编码的字符串
	return pack('N', intval($ip));
}

function getstring($data = '') {
	while (ord($char = fread($this->fp, 1)) > 0) {		// 字符串按照C格式保存，以结束
		$data .= $char;			 // 将读取的字符连接到给定字符串之后
	}
	return $data;
}

function getarea() {
	$byte = fread($this->fp, 1);	// 标志字节
	switch (ord($byte)) {
		case 0:					 // 没有区域信息
			$area = '';
			break;
		case 1:
		case 2:					 // 标志字节为1或2，表示区域信息被重定向
			fseek($this->fp, $this->getlong3());
			$area = $this->getstring();
			break;
		default:					// 否则，表示区域信息没有被重定向
			$area = $this->getstring($byte);
			break;
	}
	return $area;
}

function separate($count){
	if (!$this->fp) return null;			// 如果数据文件没有被正确打开，则直接返回空
	
	if($s = @include CACHE_PATH .'ips.php'){
		return $s;
	}
	
	$l = 0;						 // 搜索的下边界
	$u = $this->totalip;			// 搜索的上边界
	$step = floor($u/$count);
	for($i=0; $i<$count; $i++){
		fseek($this->fp, $this->firstip + $i * $step * 7);
		$separator[$i] = strrev(fread($this->fp, 4));	 // 获取中间记录的开始IP地址
		// strrev函数在这里的作用是将little-endian的压缩IP地址转化为big-endian的格式
	}
	write_file(CACHE_PATH .'ips.php', "<?php\r\nreturn ". var_export($separator, true) .';');
	return $separator;
}

	/**
 * 根据所给 IP 地址或域名返回所在地区信息
 *
 * @access public
 * @param string $ip, array $separator
 * @return array
 */
function get($ip, $separator = 0) {
	if (!$this->fp) return null;			// 如果数据文件没有被正确打开，则直接返回空
	$location['ip'] = ip2long($ip);
	$ip = $this->packip($location['ip']);   // 将输入的IP地址转化为可比较的IP地址,不合法的IP地址会被转化为255.255.255.255


	$l = 0;							// 搜索的下边界
	$u = $this->totalip;			// 搜索的上边界
	$findip = $this->lastip;		// 如果没有找到就返回最后一条IP记录（QQWry.Dat的版本信息）
	if($this->separator){
		$count = count($this->separator);
		$step = floor($u/$count);
		$j = 0;
		for($i=0; $i<$count-1; $j = floor(($count + $i) / 2)){//二分查找所在区间
			if($i>1000) break;
			
			if($ip<$this->separator[$j]){
				if($ip>$this->separator[$j-1]){
						$l = 1;
						$i = $j;
						$u = $j * $step;
						break;
				}else{
						$count = $j;
				}
			}else{
				$i = $j;
			}
		}
		if($l){
			$l = ($i-1)*$step;
		}else{
			$l = $i * $step;
		}
	}
	while ($l <= $u) {
		$i = floor(($l + $u) / 2);
		fseek($this->fp, $this->firstip + $i * 7);
		$beginip = strrev(fread($this->fp, 4));
		if ($ip < $beginip) {
			$u = $i - 1;
		}else{
			fseek($this->fp, $this->getlong3());
			$endip = strrev(fread($this->fp, 4));
			if ($ip > $endip) {
				$l = $i + 1;
			} else {
				$findip = $this->firstip + $i * 7;
				break;
			}
		}
	}

	//获取查找到的IP地理位置信息
	fseek($this->fp, $findip);
	$location['beginip'] = long2ip($this->getlong());
	$offset = $this->getlong3();
	fseek($this->fp, $offset);
	$location['endip'] = long2ip($this->getlong());
	$byte = fread($this->fp, 1);	// 标志字节
	switch (ord($byte)) {
		case 1:
			$countryOffset = $this->getlong3();
			fseek($this->fp, $countryOffset);
			$byte = fread($this->fp, 1);
			switch (ord($byte)) {
				case 2:
					fseek($this->fp, $this->getlong3());
					$location['country'] = $this->getstring();
					//fseek($this->fp, $countryOffset + 4);
					$location['area'] = $this->getarea();
					break;
				default:			// 否则，表示国家信息没有被重定向
					$location['country'] = $this->getstring($byte);
					$location['area'] = $this->getarea();
					break;
			}
			break;
		case 2:					 // 标志字节为2，表示国家信息被重定向
			fseek($this->fp, $this->getlong3());
			$location['country'] = $this->getstring();
		   fseek($this->fp, $offset + 8);
		   $location['area'] = $this->getarea();
			break;
		default:					// 否则，表示国家信息没有被重定向
			$location['country'] = $this->getstring($byte);
			$location['area'] = $this->getarea();
			break;
	}
	if ($location['country'] == '纯真网络' || $location['country'] == ' CZ88.NET') {  // CZ88.NET表示没有有效信息
		$location['country'] = 'Unknown';
	}
	
	global $core;
	if($core->CONFIG['page_charset'] != 'gbk'){
		$location = convert_encode('gbk', $core->CONFIG['page_charset'], $location);
	}
	
	return $location;
}

function _IpLocation() {
	if ($this->fp) {
		fclose($this->fp);
	}
	$this->fp = 0;
}

}