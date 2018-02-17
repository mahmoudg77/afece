<?php
namespace Framework\Addons;


use Framework\Database;
use Framework\Addons\Comprosser;

class PivotTable
{
	protected $db;
	protected $sql;

	function __construct($sql){
		$this->db=new Database();

		$this->sql=$sql;
	}

	function render(){

		$result=$this->db->query($this->sql);
		//$result=$this->db->result;

		Compressor::compressMySql($result);
		mysql_free_result($result);
	}

}


?>
