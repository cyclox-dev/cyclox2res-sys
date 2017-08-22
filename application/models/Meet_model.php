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
		$this->load->database();
	}
	
	public function get_meet($code = FALSE)
	{
		if ($code === FALSE)
		{
			$query = $this->db->get('meets');
			return $query->result_array();
		}
		
		$query = $this->db->get_where('meets', array('code' => $code));
		return $query->row_array();
	}
}
