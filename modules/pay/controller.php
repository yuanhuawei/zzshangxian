<?php
defined('PHP168_PATH') or die();

class P8_Pay_Controller extends P8_Controller{

function __construct(&$obj){
	parent::__construct($obj);
}

function P8_Pay_Controller(&$obj){
	$this->__construct($obj);
}

function valid_NO($NO){
	return preg_replace('/[^0-9a-zA-Z]/', '', $NO);
}

}