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
	
	/**
	 * 指定の ajocc point ranking を取得する
	 * @param type $season_id
	 * @param type $local_setting_id
	 * @param type $category_code
	 * @return array 対象の ajocc point set の配列
	 */
	public function get_ranking($season_id, $local_setting_id, $category_code)
	{
		$cdt = [
			'season_id' => $season_id,
			'category_code' => $category_code,
		];
		
		$lsid = empty($local_setting_id) ? NULL : $local_setting_id;
		$cdt['ajoccpt_local_setting_id'] = $lsid;
		
		$query = $this->db->select('*')
				->order_by('sets.rank', 'ASC')
				->get_where('tmp_ajoccpt_racer_sets as sets', $cdt);
		$sets = $query->result_array();
		
		$ret = [];
		$ret['title_row'] = $sets[0];
		$ret['ranking'] = array_slice($sets, 1);
		
		if (!empty($local_setting_id))
		{
			$query = $this->db->select('*')
					->get_where('ajoccpt_local_settings', ['id' => $local_setting_id]);
			$ret['local_setting'] = $query->row_array();
		}
		
		$query = $this->db->select('*')
				->get_where('seasons', ['id' => $season_id]);
		$ret['season'] = $query->row_array();
		
		return $ret;
	}
	
	/**
	 * 指定選手の ajocc ranking 情報を得る
	 * @param type $racer_code
	 * @return array ajocc ranking 情報
	 */
	public function get_racers_ranks($racer_code)
	{
		$cdt = [
			'racer_code' => $racer_code,
		];
		
		$query = $this->db->select('*, als.id as als_id, als.name as als_name, ss.id as ss_id, ss.name as season_name')
				->join('ajoccpt_local_settings as als', 'als.id = sets.ajoccpt_local_setting_id', 'LEFT')
				->join('seasons as ss', 'ss.id = sets.season_id', 'INNER')
				->order_by('sets.season_id DESC, category_code ASC, ajoccpt_local_setting_id ASC')
				->get_where('tmp_ajoccpt_racer_sets as sets', $cdt);
		return $query->result_array();
	}
}
