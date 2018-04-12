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
		//ע������������ʹ���ڳ���ִ�н���ʱִ��
		register_shutdown_function(array(&$this, '_IpLocation'));
	}
	
	$this->separator = $this->separate(500);
}

function getlong() {
	//����ȡ��little-endian�����4���ֽ�ת��Ϊ��������
	$result = unpack('Vlong', fread($this->fp, 4));
	return $result['long'];
}

function getlong3() {
	//����ȡ��little-endian�����3���ֽ�ת��Ϊ��������
	$result = unpack('Vlong', fread($this->fp, 3).chr(0));
	return $result['long'];
}

function packip($ip) {
	// ��IP��ַת��Ϊ���������������PHP5�У�IP��ַ�����򷵻�False��
	// ��ʱintval��Flaseת��Ϊ����-1��֮��ѹ����big-endian������ַ���
	return pack('N', intval($ip));
}

function getstring($data = '') {
	while (ord($char = fread($this->fp, 1)) > 0) {		// �ַ�������C��ʽ���棬�Խ���
		$data .= $char;			 // ����ȡ���ַ����ӵ������ַ���֮��
	}
	return $data;
}

function getarea() {
	$byte = fread($this->fp, 1);	// ��־�ֽ�
	switch (ord($byte)) {
		case 0:					 // û��������Ϣ
			$area = '';
			break;
		case 1:
		case 2:					 // ��־�ֽ�Ϊ1��2����ʾ������Ϣ���ض���
			fseek($this->fp, $this->getlong3());
			$area = $this->getstring();
			break;
		default:					// ���򣬱�ʾ������Ϣû�б��ض���
			$area = $this->getstring($byte);
			break;
	}
	return $area;
}

function separate($count){
	if (!$this->fp) return null;			// ��������ļ�û�б���ȷ�򿪣���ֱ�ӷ��ؿ�
	
	if($s = @include CACHE_PATH .'ips.php'){
		return $s;
	}
	
	$l = 0;						 // �������±߽�
	$u = $this->totalip;			// �������ϱ߽�
	$step = floor($u/$count);
	for($i=0; $i<$count; $i++){
		fseek($this->fp, $this->firstip + $i * $step * 7);
		$separator[$i] = strrev(fread($this->fp, 4));	 // ��ȡ�м��¼�Ŀ�ʼIP��ַ
		// strrev����������������ǽ�little-endian��ѹ��IP��ַת��Ϊbig-endian�ĸ�ʽ
	}
	write_file(CACHE_PATH .'ips.php', "<?php\r\nreturn ". var_export($separator, true) .';');
	return $separator;
}

	/**
 * �������� IP ��ַ�������������ڵ�����Ϣ
 *
 * @access public
 * @param string $ip, array $separator
 * @return array
 */
function get($ip, $separator = 0) {
	if (!$this->fp) return null;			// ��������ļ�û�б���ȷ�򿪣���ֱ�ӷ��ؿ�
	$location['ip'] = ip2long($ip);
	$ip = $this->packip($location['ip']);   // �������IP��ַת��Ϊ�ɱȽϵ�IP��ַ,���Ϸ���IP��ַ�ᱻת��Ϊ255.255.255.255


	$l = 0;							// �������±߽�
	$u = $this->totalip;			// �������ϱ߽�
	$findip = $this->lastip;		// ���û���ҵ��ͷ������һ��IP��¼��QQWry.Dat�İ汾��Ϣ��
	if($this->separator){
		$count = count($this->separator);
		$step = floor($u/$count);
		$j = 0;
		for($i=0; $i<$count-1; $j = floor(($count + $i) / 2)){//���ֲ�����������
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

	//��ȡ���ҵ���IP����λ����Ϣ
	fseek($this->fp, $findip);
	$location['beginip'] = long2ip($this->getlong());
	$offset = $this->getlong3();
	fseek($this->fp, $offset);
	$location['endip'] = long2ip($this->getlong());
	$byte = fread($this->fp, 1);	// ��־�ֽ�
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
				default:			// ���򣬱�ʾ������Ϣû�б��ض���
					$location['country'] = $this->getstring($byte);
					$location['area'] = $this->getarea();
					break;
			}
			break;
		case 2:					 // ��־�ֽ�Ϊ2����ʾ������Ϣ���ض���
			fseek($this->fp, $this->getlong3());
			$location['country'] = $this->getstring();
		   fseek($this->fp, $offset + 8);
		   $location['area'] = $this->getarea();
			break;
		default:					// ���򣬱�ʾ������Ϣû�б��ض���
			$location['country'] = $this->getstring($byte);
			$location['area'] = $this->getarea();
			break;
	}
	if ($location['country'] == '��������' || $location['country'] == ' CZ88.NET') {  // CZ88.NET��ʾû����Ч��Ϣ
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