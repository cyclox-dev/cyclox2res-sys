<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ajoccranking_model
 *
 * @author shun
 */
class Ajoccranking_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * AJOCC ランキングを取得する
	 * @param type $seasonIds シーズン ID の配列。FALSE 指定で現在シーズン。
	 */
	public function get_rankings($seasonIds = FALSE)
	{
		$this->db->select('sets.season_id, ajoccpt_local_setting_id, category_code'
				. ', cat.short_name as cat_name, ss.name as season_name'
				. ', locals.id as locals_id, locals.name as locals_name')
				->distinct()
				->join('seasons as ss', 'ss.id = sets.season_id', 'INNER')
				->join('categories as cat', 'cat.code = sets.category_code', 'INNER')
				->join('ajoccpt_local_settings as locals', 'locals.id = sets.ajoccpt_local_setting_id', 'LEFT')
				->order_by('category_code', 'ASC')
				->order_by('locals.id', 'ASC');
		$query = $this->db->get('tmp_ajoccpt_racer_sets as sets');
		$tmpr = $query->result_array();
		
		// season -> local_setting -> category の順に配列にまとめる。
		$rankings = [];
		foreach ($tmpr as $r)
		{
			$skey = $r['season_id'];
			if (empty($rankings[$skey]))
			{
				$rankings[$skey] = ['__name__' => $r['season_name']];
			}
			
			$set = $r['locals_id'];
			if (empty($set))
			{
				$set = 0;
			}
			if (empty($rankings[$skey][$set]))
			{
				$rankings[$skey][$set] = ['__name__' => $r['locals_name']];
			}
			
			$rankings[$skey][$set][] = [
				'code' => $r['category_code'],
				'name' => $r['cat_name'],
			];
		}
		
		return $rankings;
	}
	
}
