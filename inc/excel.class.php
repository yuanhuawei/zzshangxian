<?php

class excel
{
	var $fileDir='';		//文件保存目录
	var $fileName='';							//文件名
	var $zipName='';							//压缩包文件名
	var $timeOutLimit=86400;					//文件储存时间间隔
	var $code='gzsharp';						//加密字符串
	var $lockFile='';							//锁文件，防止用户没执行完成时再次操作
	var $fileContent='';						//文件内容
	var $fileArr=array();						//文件集合
	var $cover=0;								//是否覆盖新建文件
	/**
	 * 构造函数
	 * @param int $cover 是否新建
	 */
	 function __construct($cover=0)
	{
		$this->fileDir=CACHE_PATH.'Excel/';
		$this->cover=$cover;		

	}
	/**
	 * 检测是否并行操作或是否需新建文件
	 * @param string $act 功能
	 * @param string $user 操作用户
	 * @return 1 可执行  -1：正在生成中 -2：已有文件
	 */
	 function checkFile($act,$user)
	{
		$this->lockFile=$this->fileDir.$act.'_'.$user.'.lock';
		if(is_file($this->lockFile))
		{
			return -1;
		}else{
			$zipFile=$this->fileDir.$this->zipName;
			if(is_file($zipFile))					//若存在文件
			{
				if(!$this->cover)
				{
					$now=time();
					$lastMT=filemtime($zipFile);
					if(($now-$lastMT)>$this->timeOutLimit)		//文件保留时间外，重写
					{
						file_put_contents($this->lockFile, '');
						return 1;
					}else{
						return -2;
					}
				}else{
					file_put_contents($this->lockFile, '');
					return 1;
				}
			}else{
				file_put_contents($this->lockFile, '');
				return 1;
			}			
		}
		
	}
	/**
	 * 设置文件名
	 * @param string $file_name
	 * @param string $act 功能
	 * @param string $user 操作用户
	 * @param int $cover 是否新建
	 */
	 function setFileName($file_name,$act,$user,$cover=0)
	{
		if($file_name)
		{
			$md5Str=md5($user.$this->code);
			$this->fileName=$file_name.'_'.$user.'.xls';
			$this->zipName=$act.'_'.$user.'_'.$md5Str.'.zip';
			$this->fileArr[]=$this->fileName;
		}else{
			echo 'file can no empty';
			die;
		}
	}
	 function  getFileName($zip=false)
	{
		if($zip){
			$file=$this->fileDir.$this->zipName;
		}else{
			$file=$this->fileDir.$this->fileName;
		}
		if(is_file($file))
			return $file;
		else
			return;
	}

	/**
	 * 汇出文件
	 * @return string -1:excel文件生成失败 -2:zip文件生成失败  成功返回zip文件
	 */
	 function exportFile($zip=false)
	{
		$file  = $this->getFileName($zip);
		header('Last-Modified: '. gmdate('D, d M Y H:i:s', P8_TIME) .' GMT');
		header('Pragma: no-cache');
		header('Content-type: text/xls');
		header('Content-Encoding: none');
		header('Content-Disposition: attachment; filename='. $this->fileName);
		header('Content-type: xls');
		header('Content-Length: '.filesize($file));
		readfile($file);
		exit;	
	}
	/**
	 * 文件头
	 * @param array $dataHeader 文件头说明标题
	 */
	 function fileHeader(array $dataHeader=array())
	{
		global $core;
		$locale = 'gbk';
		if($core->CONFIG['page_charset'] == 'utf-8') $locale = 'UTF-8';
		$string = '<html xmlns:o="urn:schemas-microsoft-com:office:office"
		xmlns:x="urn:schemas-microsoft-com:office:excel"
		xmlns=" http://www.w3.org/TR/REC-html40">
		<meta http-equiv="expires" content="Mon, 06 Jan 1999 00:00:01 GMT">
		<meta http-equiv=Content-Type content="text/html; charset='.$locale.'">
		<!--[if gte mso 9]><xml>
		<x:ExcelWorkbook>
		<x:ExcelWorksheets>
		<x:ExcelWorksheet>
		<x:Name></x:Name>
		<x:WorksheetOptions>
		<x:DisplayGridlines/>
		</x:WorksheetOptions>
		</x:ExcelWorksheet>
		</x:ExcelWorksheets>
		</x:ExcelWorkbook>
		</xml><![endif]-->';
		$string.='<table border="1" cellspacing="0" cellpadding="0">';		
		$string.='<tr>';
		foreach($dataHeader as $val)
		{
			$string.='<td>'.$val.'</td>';
		}
		$string.='</tr>';		
		$this->fileContent=$string;
		$this->saveFile();
	}
	/**
	 * 文件尾
	 */
	 function fileFooter()
	{
		$this->fileContent='</table></html>';
		$this->saveFile();
	}
	/**
	 * 文件正文内容
	 * @param array $data 数据(二维数组)
	 */
	 function fileData(array $data=array())
	{
		if(empty($data)) return;
		$string='';
		foreach ($data as $rows)
		{
			$string.='<tr>';
			foreach($rows as $val)
			{
				$string.='<td>'.$val.'</td>';
			}	
			$string.='</tr>';
		}
		$this->fileContent=$string;
		$this->saveFile();
	}
	/**
	 * 保存文件
	 */
	private function saveFile()
	{
		if(!file_exists($this->fileDir)) mkdir($this->fileDir , 0777);
		$file=$this->fileDir.$this->fileName;
		if($this->fileContent)
		{
			if (file_put_contents($file , $this->fileContent,FILE_APPEND))
			{
				return true;
			}else{
				return false;
			}	
		}else{
			return false;
		}	
	}
	/**
	 * 压缩文件
	 */
	function zipFile()
	{
		if(!$this->fileName) return;
		if (!class_exists('ZipArchive'))
		{
			echo 'the server can`t zip .';
			exit;
		}
		$zipFile=$this->fileDir.$this->zipName;
		if($this->cover)
		{
			if(is_file($zipFile)) unlink($zipFile);
		}
		$zip = new ZipArchive();
		if($zip->open($zipFile , ZIPARCHIVE::CREATE) !== true)
			return false;
	
		foreach ($this->fileArr as $file_name)
		{
			$file=$this->fileDir.$file_name;
			$zip->addFile($file,substr(strrchr($file , '/') , 1));
		}
		$zip->close();
		foreach ($this->fileArr as $file_name)
		{
			$file=$this->fileDir.$file_name;
			if(is_file($file)) unlink($file);		//删除源文件
		}
		if(is_file($this->lockFile)) unlink($this->lockFile);
		return true;
	}
}