<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class employee_model extends CI_Model {

	var $table = 'employee';
	var $column = array('name','parent');
	var $order = array('id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	
	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}



}
