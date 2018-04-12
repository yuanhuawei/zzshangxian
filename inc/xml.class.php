<?php
/*
array(
	'root' => array(
		'name' => 'root',
		'data' => 'data',
		
		'children' => array(
			'node1' => array(
				0 => array(
					'name' => 'node1',
					'data' => 'data1',
					
					'children' => array(...)
				)
			),
			
			'node2' => array(...)
		)
	)
);
*/

function xml2array($xml){
	$x = new P8_XML();
	return $x->parse($xml);
}

class P8_XML{

var $parser;
var $last_tag;
var $data = array();
var $count = 0;
var $root = array();

function __construct(){
	
}

function P8_XML(){
	$this->__construct();
}

function parse($s){
	
	$this->parser = xml_parser_create();
	xml_set_object($this->parser, $this);
	xml_set_element_handler($this->parser, 'open', 'close');
	xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, false);
	xml_set_character_data_handler($this->parser, 'data');

	$this->strXmlData = xml_parse($this->parser, $s);
	
	if(!$this->strXmlData) return null;
	
	xml_parser_free($this->parser);
	
	return $this->root;
}

function open($parser, $name, $attrs) {
	array_push($this->data, array('name' => $name, 'attrs' => $attrs, 'data' => ''));
	
	if($this->count == 0) $this->root[$name] = &$this->data[0];
	
	$this->count++;
}

function close($parser, $name) {
	$this->data[$this->count -2]['children'][$name][] = $this->data[--$this->count];
	array_pop($this->data);
}

function data($parser, $data){
	if(trim($data)){
		$this->data[$this->count -1]['data'] .= $data;
	}
}

}