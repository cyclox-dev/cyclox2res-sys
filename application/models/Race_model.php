<?php

/**
 * Description of Race_model
 *
 * @author shun
 */
class Race_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * 指定 entry category id のレース情報をかえす
	 * @param int $ecat_id entry category id
	 * @return array レース情報
	 */
	public function get_race_info($ecat_id = NULL)
	{
		if (empty($ecat_id))
		{
			return null;
		}
		
		$cdt = array(
			'ec.deleted' => 0,
			'eg.deleted' => 0,
			'mt.deleted' => 0,
			'mg.deleted' => 0,
			'ec.id' => $ecat_id,
		);
		if (XSYS_const::NONVISIBLE_BEFORE1718)
		{
			$cdt['at_date >'] = '2017-03-31';
		}
		
		$query = $this->db->select('*, ec.name as ec_name, mt.name as meet_name'
				. ', mg.name as meet_group_name, mg.code as meet_group_code'
				. ', mt.code as meet_code, mt.start_frac_distance as meet_sfd, eg.start_frac_distance as eg_sfd'
				. ', mt.lap_distance as meet_ld, eg.lap_distance as eg_ld')
				->join('entry_groups as eg', 'eg.id = ec.entry_group_id', 'INNER')
				->join('meets as mt', 'mt.code = eg.meet_code', 'INNER')
				->join('meet_groups as mg', 'mg.code = mt.meet_group_code', 'INNER')
				->get_where('entry_categories as ec', $cdt);
		
		$ecat = $query->row_array();
		if (empty($ecat))
		{
			return null;
		}
		
		$ecat['prepared_start_clock'] = date('H:i'
				, strtotime($this->_convert_start_clock($ecat['start_clock'], $ecat['start_delay_sec'])));
		
		$ecat['sf_dist'] = is_null($ecat['eg_sfd']) ? $ecat['meet_sfd'] : $ecat['eg_sfd'];
		if (empty($ecat['sf_dist'])) {
			$ecat['sf_dist'] = 0.0;
		}
		$ecat['lap_dist'] = is_null($ecat['eg_ld']) ? $ecat['meet_ld'] : $ecat['eg_ld'];
		
		return $ecat;
	}
	
	/**
	 * 出走カテゴリー ID をかえす
	 * @param string $meet_code 大会
	 * @param string $ecat_name 出走カテゴリー名
	 * @return int id。見つからない場合などは null をかえす。
	 */
	public function get_race_id($meet_code, $ecat_name)
	{
		if (empty($meet_code) || empty($ecat_name))
		{
			return null;
		}
		
		$cdt = array(
			'mt.deleted' => 0,
			'ec.deleted' => 0,
			'eg.deleted' => 0,
			'mt.code' => $meet_code,
			'ec.name' => $ecat_name,
		);
		if (XSYS_const::NONVISIBLE_BEFORE1718)
		{
			$cdt['at_date >'] = '2017-03-31';
		}
		
		$query = $this->db->select('*, ec.id as ec_id')
				->join('entry_groups as eg', 'eg.id = ec.entry_group_id', 'INNER')
				->join('meets as mt', 'mt.code = eg.meet_code', 'INNER')
				->order_by('ec.modified', 'DESC') // もっとも新しい ecat を取得する
				->get_where('entry_categories as ec', $cdt);
		
		$ecat = $query->first_row('array');
		
		return empty($ecat['ec_id']) ? null : $ecat['ec_id'];
	}
	
	public function get_first_race_id($meet_code)
	{
		if (empty($meet_code))
		{
			return NULL;
		}
		
		// レース情報取得
		$cdt = array(
			'meet_code' => $meet_code,
			'eg.deleted' => 0,
			'ec.deleted' => 0,
			'er.deleted' => 0,
			'rr.deleted' => 0,
		);
		$query = $this->db->select('ec.id as ec_id')
				->join('entry_categories as ec', 'ec.entry_group_id = eg.id', 'INNER')
				->join('entry_racers as er', 'er.entry_category_id = ec.id', 'INNER')
				->join('racer_results as rr', 'rr.entry_racer_id = er.id', 'INNER') // result があること。カウントに必要。
				->join('races_categories as rc', 'rc.code = ec.races_category_code', 'INNER')
				->group_by('entry_category_id')
				->order_by('rc.display_rank')
				->get_where('entry_groups as eg', $cdt);
		$entry = $query->row_array();
		
		return $entry['ec_id'];
	}
	
	/**
	 * 指定大会のレース情報をかえす。
	 * @param type $meet_code
	 * @return array レース情報。
	 */
	public function get_race_of_meet($meet_code)
	{
		if (empty($meet_code))
		{
			return NULL;
		}
		
		// レース情報取得
		$cdt = array(
			'meet_code' => $meet_code,
			'eg.deleted' => 0,
			'ec.deleted' => 0,
			'er.deleted' => 0,
			'rr.deleted' => 0,
		);
		$query = $this->db->select('start_clock, start_delay_sec'
				.', count(*), ec.name as ec_name, ec.id as ec_id')
				->join('entry_categories as ec', 'ec.entry_group_id = eg.id', 'INNER')
				->join('entry_racers as er', 'er.entry_category_id = ec.id', 'INNER')
				->join('racer_results as rr', 'rr.entry_racer_id = er.id', 'INNER') // result があること。カウントに必要。
				->join('races_categories as rc', 'rc.code = ec.races_category_code', 'INNER')
				->group_by('entry_category_id')
				->order_by('rc.display_rank')
				->order_by('ec.name')
				->get_where('entry_groups as eg', $cdt);
		$entries = $query->result_array();
		
		// 優勝者を取得 MEMO: 上記の処理で同時に取得しようとすると rank=1 がいない場合に取得できなくなる。
		$cdt['rr.rank'] = 1;
		$query = $this->db->select('ec.id as ec_id, racer_code, er.name_at_race, er.team_name')
				->join('entry_categories as ec', 'ec.entry_group_id = eg.id', 'INNER')
				->join('entry_racers as er', 'er.entry_category_id = ec.id', 'INNER')
				->join('racer_results as rr', 'rr.entry_racer_id = er.id', 'INNER')
				->get_where('entry_groups as eg', $cdt);
		$tops = $query->result_array();
		
		foreach ($entries as &$e)
		{
			foreach ($tops as $t)
			{
				if ($t['ec_id'] == $e['ec_id'])
				{
					$e['top'] = array(
						'racer_code' => $t['racer_code'],
						'name' => $t['name_at_race'],
						'team' => $t['team_name']
					);
					break;
				}
			}
		}
		
		return $this->_prepare_start_clock($entries);
	}
	
	/**
	 * 実際の出走時間を設定する。時間表記は HH:mm に変更する。
	 * @param array $entries 
	 * @return array 並び替えられた配列
	 */
	private function _prepare_start_clock($entries)
	{
		if (empty($entries))
		{
			return $entries;
		}
		
		// start delay を出走時間に適用
		foreach ($entries as &$e)
		{
			if (!empty($e['start_clock']))
			{
				$e['prepared_start_clock'] = $this->_convert_start_clock($e['start_clock'], $e['start_delay_sec']);
			}
		}
		
		// 表記を HH:mm に変更。
		foreach ($entries as &$e)
		{
			$e['prepared_start_clock'] = date('H:i', strtotime($e['prepared_start_clock']));
		}
		
		return $entries;
	}
	
	/**
	 * スタート時刻にスタート遅延秒を加算した、実際のスタート時刻を H:i:s の形式でかえす。
	 * @param strint(datetime) $start_clock スタート時刻
	 * @param int $delay_sec 遅延秒
	 * @return string(datetime) H:i:s 形式の時間文字列
	 */
	private function _convert_start_clock($start_clock, $delay_sec)
	{
		$min = $delay_sec / 60;
		return date('H:i:s', strtotime($start_clock . ' +' . $min . ' min'));
	}
}
