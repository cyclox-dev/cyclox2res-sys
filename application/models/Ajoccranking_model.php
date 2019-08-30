<?php

require_once(APPPATH . 'etc/cyclox/Const/CategoryReason.php');

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
	
	public function get_rankings($opt = FALSE)
	{
		$this->db->select('sets.season_id, ajoccpt_local_setting_id, category_code'
				. ', cat.short_name as cat_name, ss.name as season_name'
				. ', locals.id as locals_id, locals.name as locals_name', 'start_date')
				->distinct()
				->join('seasons as ss', 'ss.id = sets.season_id', 'INNER')
				->join('categories as cat', 'cat.code = sets.category_code', 'INNER')
				->join('category_groups as cg', 'cg.id = cat.category_group_id', 'INNER')
				->join('ajoccpt_local_settings as locals', 'locals.id = sets.ajoccpt_local_setting_id', 'LEFT')
				->order_by('ss.start_date', 'DESC')
				->order_by('locals.id', 'ASC')
				->order_by('cg.display_rank', 'ASC')
				->order_by('cat.rank', 'ASC')
				->where('ss.deleted', 0)
				->where('cat.deleted', 0);
		
		if (XSYS_const::NONVISIBLE_BEFORE1718)
		{
			$this->db->where('ss.start_date >', '2017-04-01');
		}
		
		if (isset($opt['before_only']))
		{
			$this->db->where('end_date <=', $opt['before_only']);
		}
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
		
		if (!empty($sets))
		{
			$ret['title_row'] = $sets[0];
			$ret['ranking'] = array_slice($sets, 1);
		}
		
		// 同じシーズン、ローカル設定の他カテゴリーランキングを取得
		$cdt = [
			'season_id' => $season_id,
			'ajoccpt_local_setting_id' => $lsid,
			'cat.deleted' => 0,
			'grp.deleted' => 0,
		];
		$query = $this->db->select('category_code, display_rank, cat.rank as cat_rank')
				->distinct()
				->join('categories as cat', 'cat.code = sets.category_code', 'INNER')
				->join('category_groups as grp', 'grp.id = cat.category_group_id', 'INNER')
				->order_by('grp.display_rank', 'ASC')
				->order_by('cat.rank', 'ASC')
				->get_where('tmp_ajoccpt_racer_sets as sets', $cdt);
		$cat_codes = $query->result_array();
		log_message('debug', print_r($cat_codes, TRUE));
		$codes = [];
		foreach ($cat_codes as $code)
		{
			$codes[] = $code['category_code'];
		}
		$ret['cat_codes'] = $codes;
		
		// 地域設定取得
		if (!empty($local_setting_id))
		{
			$query = $this->db->select('*')
					->get_where('ajoccpt_local_settings', ['id' => $local_setting_id]);
			$ret['local_setting'] = $query->row_array();
		}
		
		// シーズン情報
		$query = $this->db->select('*')
				->get_where('seasons', ['id' => $season_id, 'deleted' => 0]);
		$ret['season'] = $query->row_array();
		
		// 昇格者情報
		$cdt = [
			'category_code' => $category_code,
			'deleted' => 0,
			'apply_date >=' => $ret['season']['start_date'],
			'apply_date <=' => $ret['season']['end_date'],
			'reason_id' => CategoryReason::$RESULT_UP->ID(),
			'deleted' => 0,
		];
		$query = $this->db->select('racer_code')
				->get_where('category_racers', $cdt);
		$rankupper = $query->result_array();
		$codes = [];
		foreach($rankupper as $ru)
		{
			$codes[] = $ru['racer_code'];
		}
		$ret['rankupper'] = $codes;
		//log_message('debug', print_r($codes, true));
		
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
			'ss.deleted' => 0,
		];
		
		$query = $this->db->select('*, als.id as als_id, als.name as als_name, ss.id as ss_id, ss.name as season_name')
				->join('ajoccpt_local_settings as als', 'als.id = sets.ajoccpt_local_setting_id', 'LEFT')
				->join('seasons as ss', 'ss.id = sets.season_id', 'INNER')
				->order_by('sets.season_id DESC, category_code ASC, ajoccpt_local_setting_id ASC')
				->get_where('tmp_ajoccpt_racer_sets as sets', $cdt);
		return $query->result_array();
	}
}
