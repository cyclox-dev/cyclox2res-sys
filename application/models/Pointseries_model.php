<?php

/**
 * Description of Pointseries_model
 *
 * @author shun
 */
class Pointseries_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * 指定出走カテゴリーのポイントシリーズ取得ポイントをかえす。
	 * @param int $ecat_id 出走カテゴリー ID
	 * @return array racer_result_id(key:rr_id) をキーとするマップ。value は array。
	 *		$cat_id が無効な場合、NULL をかえす。
	 */
	public function get_psrmap_of_ecat($ecat_id = NULL)
	{
		if (empty($ecat_id))
		{
			return NULL;
		}
		
		$cdt = array(
			'ec.deleted' => 0,
			'er.deleted' => 0,
			'rr.deleted' => 0,
			'ec.id' => $ecat_id,
		);
		
		$query = $this->db->select('*, rr.id as rr_id')
				->join('entry_racers as er', 'rr.entry_racer_id = er.id', 'INNER')
				->join('entry_categories as ec', 'er.entry_category_id = ec.id', 'INNER')
				->join('point_series_racers as psr', 'rr.id = psr.racer_result_id', 'INNER')
				->get_where('racer_results as rr', $cdt);
		
		$points = $query->result_array();
		
		$rmap = array();
		
		foreach ($points as $pt)
		{
			$rid = $pt['rr_id'];
			if (empty($rmap[$rid]))
			{
				$rmap[$rid] = array();
			}
			
			$rmap[$rid][] = $pt;
		}
		
		return $rmap;
	}
	
	/**
	 * 指定 ID のポイントシリーズ設定情報をかえす
	 * @param int $series_id シリーズ ID
	 * @return array ポイントシリーズ情報
	 */
	public function get_series_info($series_id)
	{
		$cdt = array(
			'id' => $series_id,
			'deleted' => 0
		);
		
		$query = $this->db->select('*')
				->get_where('point_series', $cdt);
		
		return $query->row_array();
	}
	
	/**
	 * 指定選手のポイントシリーズ順位データをかえす
	 * @param string $code 選手コード
	 * @return array 順位データ
	 */
	public function get_racers_ranks($code)
	{
		if (empty($code))
		{
			return array();
		}
		
		$query = $this->db->select('*, ps.name as ps_name')
				->join('point_series as ps', 'ps.id = psr_set.point_series_id', 'INNER')
				->join('seasons as ss', 'ss.id = ps.season_id', 'LEFT')
				->get_where('tmp_point_series_racer_sets as psr_set', array('racer_code' => $code));
		
		$points = $query->result_array();
		//var_dump(json_encode($points));
		
		if (XSYS_const::NONVISIBLE_BEFORE1718)
		{
			$limited = array();

			foreach ($points as $p)
			{
				if (empty($p['season_id']) || $p['start_date'] >= '2017-04-01')
				{
					$limited[] = $p;
				}
			}

			$points = $limited;
		}
		
		return $points;
	}
	
	/**
	 * 指定ポイントシリーズの最新のランキングデータをかえす
	 * @param int $id ポイントシリーズ ID
	 * @return array ranking, series の2つのキーを持つ配列
	 */
	public function get_ranking($id)
	{
		if (empty($id))
		{
			return array();
		}
		
		$ret = array();
		
		$query = $this->db->select('*, ps.name as ps_name')
				->join('seasons as ss', 'ss.id = ps.season_id', 'LEFT')
				->get_where('point_series as ps', array('ps.id' => $id, 'ps.deleted' => 0));
		$series = $query->row_array();
		//var_dump(json_encode($series, JSON_UNESCAPED_UNICODE));
		
		if (XSYS_const::NONVISIBLE_BEFORE1718)
		{
			if (!empty($series['season_id']) && $series['start_date'] < '2017-04-01')
			{
				return array();
			}
		}
		
		$ret['series'] = $series;
		
		$query = $this->db->select('*')
				->order_by('rank', 'ASC')
				->get_where('tmp_point_series_racer_sets as psr_set', array('point_series_id' => $id));
		$ret['ranking'] = $query->result_array();
		
		return $ret;
	}
}
