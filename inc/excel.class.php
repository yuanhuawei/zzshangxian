<?php

class excel
{
	var $fileDir='';		//�ļ�����Ŀ¼
	var $fileName='';							//�ļ���
	var $zipName='';							//ѹ�����ļ���
	var $timeOutLimit=86400;					//�ļ�����ʱ����
	var $code='gzsharp';						//�����ַ���
	var $lockFile='';							//���ļ�����ֹ�û�ûִ�����ʱ�ٴβ���
	var $fileContent='';						//�ļ�����
	var $fileArr=array();						//�ļ�����
	var $cover=0;								//�Ƿ񸲸��½��ļ�
	/**
	 * ���캯��
	 * @param int $cover �Ƿ��½�
	 */
	 function __construct($cover=0)
	{
		$this->fileDir=CACHE_PATH.'Excel/';
		$this->cover=$cover;		

	}
	/**
	 * ����Ƿ��в������Ƿ����½��ļ�
	 * @param string $act ����
	 * @param string $user �����û�
	 * @return 1 ��ִ��  -1������������ -2�������ļ�
	 */
	 function checkFile($act,$user)
	{
		$this->lockFile=$this->fileDir.$act.'_'.$user.'.lock';
		if(is_file($this->lockFile))
		{
			return -1;
		}else{
			$zipFile=$this->fileDir.$this->zipName;
			if(is_file($zipFile))					//�������ļ�
			{
				if(!$this->cover)
				{
					$now=time();
					$lastMT=filemtime($zipFile);
					if(($now-$lastMT)>$this->timeOutLimit)		//�ļ�����ʱ���⣬��д
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
	 * �����ļ���
	 * @param string $file_name
	 * @param string $act ����
	 * @param string $user �����û�
	 * @param int $cover �Ƿ��½�
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
	 * ����ļ�
	 * @return string -1:excel�ļ�����ʧ�� -2:zip�ļ�����ʧ��  �ɹ�����zip�ļ�
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
	 * �ļ�ͷ
	 * @param array $dataHeader �ļ�ͷ˵������
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
	 * �ļ�β
	 */
	 function fileFooter()
	{
		$this->fileContent='</table></html>';
		$this->saveFile();
	}
	/**
	 * �ļ���������
	 * @param array $data ����(��ά����)
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
	 * �����ļ�
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
	 * ѹ���ļ�
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
			if(is_file($file)) unlink($file);		//ɾ��Դ�ļ�
		}
		if(is_file($this->lockFile)) unlink($this->lockFile);
		return true;
	}
}