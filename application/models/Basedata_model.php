<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Category_model
 *
 * @author shun
 */
class Basedata_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * カテゴリー情報の配列をかえす
	 * @return array
	 */
	public function get_categories()
	{
		$query = $this->db->select('*')
				->order_by('category_group_id', 'ASC')
				->order_by('short_name', 'ASC')
				->get_where('categories', array('deleted' => 0));
		$cats = $query->result_array();
		
		return $cats;
	}
}
