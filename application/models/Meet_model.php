<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Meet_model
 *
 * @author shun
 */
class Meet_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * 大会を取得する。deleted は含まない。
	 * @param string $code 大会コード。指定しない場合はすべての大会を取得する。
	 * @return type 大会データ。$code を指定しない場合は大会データの配列。
	 */
	public function get_meet($code = FALSE)
	{
		if ($code === FALSE)
		{
			$this->db->order_by('at_date', 'DESC');
			$query = $this->db->get_where('meets', array('deleted' => 0));
			return $query->result_array();
		}
		
		$query = $this->db->get_where('meets', array('code' => $code, 'deleted' => 0));
		return $query->row_array();
	}
}
