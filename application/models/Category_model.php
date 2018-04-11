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
class Category_model  extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * races category に属するカテゴリーをかえす
	 * @param string $races_category_code レースカテゴリーコード
	 * @return array カテゴリー情報の配列
	 */
	public function get_categories_of_rcat($races_category_code)
	{
		$cdt = [
			'crc.races_category_code' => $races_category_code,
			'cat.deleted' => 0,
			'crc.deleted' => 0,
		];
		
		$query = $this->db->select('*')
				->join('categories as cat', 'cat.code = crc.category_code', 'INNER')
				->get_where('category_races_categories as crc', $cdt);
		
		$cats = $query->result_array();
		
		return $cats;
	}
}
