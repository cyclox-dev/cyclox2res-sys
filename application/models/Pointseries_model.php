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
			'ps.deleted' => 0,
			'ec.id' => $ecat_id,
			'ps.is_active' => 1,
			'ps.publishes_on_ressys' => 1,
		);
		
		$query = $this->db->select('*, rr.id as rr_id')
				->join('entry_racers as er', 'rr.entry_racer_id = er.id', 'INNER')
				->join('entry_categories as ec', 'er.entry_category_id = ec.id', 'INNER')
				->join('point_series_racers as psr', 'rr.id = psr.racer_result_id', 'INNER')
				->join('point_series as ps', 'psr.point_series_id = ps.id', 'INNER')
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
			'deleted' => 0,
			'is_active' => 1,
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
		
		$cdt = [
			'ps.deleted' => 0,
			'ss.deleted' => 0,
			'racer_code' => $code,
			'ps.is_active' => 1,
			'ps.publishes_on_ressys' => 1,
		];
		
		$query = $this->db->select('*, ps.name as ps_name')
				->join('point_series as ps', 'psr_set.point_series_id = ps.id and psr_set.set_group_id = ps.public_psrset_group_id', 'INNER')
				->join('seasons as ss', 'ss.id = ps.season_id', 'LEFT')
				->get_where('tmp_point_series_racer_sets as psr_set', $cdt);
		
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
	 * ポイントシリーズ一覧をかえす
	 * @param array $option キー 'before_only' === true ならば以前のシーズンのみをかえす
	 * @return array point series list
	 */
	public function get_ranking_list($option = array())
	{
		$cdt = array(
			'ps.deleted' => 0,
			'ps.is_active' => 1,
			'ps.publishes_on_ressys' => 1,
		);
		
		if (isset($option['before_only']))
		{
			$cdt['end_date <='] = $option['before_only'];
		}
		
		if (XSYS_const::NONVISIBLE_BEFORE1718)
		{
			$cdt['start_date >='] = '2017-04-01';
		}
		
		$query = $this->db->select('*, ps.name as ps_name, ps.id as ps_id, psg.name as psg_name, seasons.name as season_name')
				->join('seasons', 'seasons.id = ps.season_id', 'INNER')
				->join('point_series_groups as psg', 'psg.id = ps.point_series_group_id', 'LEFT')
				->order_by('start_date DESC')
				->order_by('point_series_group_id')
				->order_by('priority_value')
				->get_where('point_series as ps', $cdt);
		
		$ss = $query->result_array();
		
		return $this->_packByPsId($ss);
	}
	
	/**
	 * ポイントシリーズと3位までの情報をかえす
	 * @return array ポイントシリーズ情報
	 */
	public function get_rankings()
	{
		$cdt = array(
			'ps.deleted' => 0,
			'season_id' => NULL,
			'psrs.rank <=' => 3,
			'psrs.rank >' => 0, // タイトル行除去
			'ps.is_active' => 1,
			'ps.publishes_on_ressys' => 1,
		);
		
		$query = $this->db->select('*, ps.name as ps_name, ps.id as ps_id, psrs.name as psrs_name, psg.name as psg_name')
				->join('tmp_point_series_racer_sets as psrs', 'psrs.point_series_id = ps.id and psrs.set_group_id = ps.public_psrset_group_id', 'INNER')
				->join('point_series_groups as psg', 'psg.id = ps.point_series_group_id', 'LEFT')
				->order_by('psg.priority_value DESC, ps.point_series_group_id ASC, psrs.point_series_id ASC, psrs.rank ASC')
				->get_where('point_series as ps', $cdt);
		$noSsSeries = $query->result_array();
		$noSsSeries = $this->_packByPsId($noSsSeries);
		
		$cdt = array(
			'ps.deleted' => 0,
			'ss.deleted'=> 0,
			'season_id is not NULL',
			'psrs.rank <=' => 3,
			'psrs.rank >' => 0, // タイトル行除去
			'ps.is_active' => 1,
			'ps.publishes_on_ressys' => 1,
		);
		
		$query = $this->db->select('*, ps.name as ps_name, ps.id as ps_id, psrs.name as psrs_name, psg.name as psg_name'
				. ', ss.id as season_id, ss.name as season_name')
				->join('tmp_point_series_racer_sets as psrs', 'psrs.point_series_id = ps.id and psrs.set_group_id = ps.public_psrset_group_id', 'INNER')
				->join('point_series_groups as psg', 'psg.id = ps.point_series_group_id', 'LEFT')
				->join('seasons as ss', 'ss.id = ps.season_id', 'INNER')
				->order_by('ss.end_date DESC, psg.priority_value DESC, ps.point_series_group_id ASC, psrs.point_series_id ASC, psrs.rank ASC')
				->get_where('point_series as ps', $cdt);
		$ssSeries = $query->result_array();
		
		if (XSYS_const::NONVISIBLE_BEFORE1718)
		{
			$tmp = array();
			foreach ($ssSeries as $s)
			{
				if ($s['end_date'] > '2017-03-31')
				{
					$tmp[] = $s;
				}
			}
			$ssSeries = $tmp;
		}
		
		$ssSeries = $this->_packByPsId($ssSeries);
		
		return array_merge($noSsSeries, $ssSeries);
	}
	
	/**
	 * tmp_point_series_racer_sets データをまとめたシリーズをかえす
	 * @param array $series シリーズのデータの配列
	 */
	private function _packByPsId($series)
	{
		if (empty($series))
		{
			return array();
		}
		
		$ret = array();
		
		$psg_id = $series[0]['point_series_group_id'];
		$ps_id = $series[0]['ps_id'];
		$psg_pack = [
			'list' => array(),
			'psg_name' => $series[0]['psg_name'],
			'season_id' => $series[0]['season_id'],
		];
		$psg_pack['season_name'] = isset($series[0]['season_name']) ? $series[0]['season_name'] : '';
		$ps_pack = array();
		
		// psg_id --> ps_id ごとにまとめる
		foreach ($series as $s)
		{	
			if ($s['ps_id'] != $ps_id)
			{
				$psg_pack['list'][] = $ps_pack;
				$ps_pack = array();
				$ps_id = $s['ps_id'];
				
				if ($s['point_series_group_id'] != $psg_id)
				{
					if (!empty($psg_pack['list']))
					{
						$ret[] = $psg_pack;
					}

					$psg_pack = [
						'list' => array(),
						'psg_name' => $s['psg_name'],
						'season_id' => $s['season_id'],
					];
					$psg_pack['season_name'] = isset($s['season_name']) ? $s['season_name'] : '';
					$psg_id = $s['point_series_group_id'];
				}
			}
			
			$ps_pack[] = $s;
		}
		$psg_pack['list'][] = $ps_pack;
		$ret[] = $psg_pack;
		
		return $ret;
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
		$cdt = array(
			'ps.id' => $id,
			'ps.deleted' => 0,
			'ss.deleted' => 0,
			'ps.publishes_on_ressys' => 1,
		);
		
		$query = $this->db->select('*, ps.name as ps_name')
				->join('seasons as ss', 'ss.id = ps.season_id', 'LEFT')
				->get_where('point_series as ps', $cdt);
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
		
		$cdt = [
			'point_series_id' => $id,
			'set_group_id' => $series['public_psrset_group_id'],
		];
		
		$query = $this->db->select('*')
				->order_by('rank', 'ASC')
				->get_where('tmp_point_series_racer_sets as psr_set', $cdt);
		$result = $query->result_array();
		
		if (!empty($result))
		{
			$title_row = $result[0];

			$titles = json_decode($title_row['point_json'], TRUE);
			if (XSYS_const::NONVISIBLE_BEFORE1718)
			{
				foreach ($titles as &$t)
				{
					if ($t['at_date'] < '2017-04-01')
					{
						unset($t['code']);
						unset($t['entry_category_name']);
					}
				}
			}
			unset($t);

			$title_row['pt_titles'] = $titles;
			$title_row['sumup_titles'] = json_decode($title_row['sumup_json'], TRUE);
			$ret['title_row'] = $title_row;

			unset($result[0]);
			$result = array_values($result); // index を詰める

			$ret['ranking'] = $result;
		}
		
		return $ret;
	}
	
	/**
	 * 同じポイントシリーズに属するポイントシリーズの情報をかえす
	 * @param type $ps_group_id ポイントシリーズグループ ID
	 * @param type $season_id シーズン ID。未指定の場合はすべて。
	 * @return $array ポイントシリーズ情報。無効な指定の場合には空の配列をかえす。
	 */
	public function get_series_grouped($ps_group_id, $season_id = FALSE)
	{
		if (empty($ps_group_id)) return [];
		
		$cdt = array(
			'ps.point_series_group_id' => $ps_group_id,
			'ps.deleted' => 0,
			'ps.publishes_on_ressys' => 1,
		);
		
		if (!empty($season_id))
		{
			$this->db->join('seasons as ss', 'ss.id = ps.season_id', 'INNER');
			$cdt['ps.season_id'] = $season_id;
			$cdt['ss.deleted'] = 0;
			
			if (XSYS_const::NONVISIBLE_BEFORE1718)
			{
				$cdt['ss.start_date >'] = '2017-03-31';
			}
		}
		
		$query = $this->db->select('*, ps.short_name as ps_short_name, ps.id as ps_id')
				->get_where('point_series as ps', $cdt);
		$series_list = $query->result_array();
		
		return $series_list;
	}
}
