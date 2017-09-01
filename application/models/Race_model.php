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
	public function get_race_info($ecat_id)
	{
		$cdt = array(
			'ec.deleted' => 0,
			'eg.deleted' => 0,
			'ec.id' => $ecat_id,
		);
		
		$query = $this->db->select('*, ec.name as ec_name, mt.name as meet_name, mg.name as meet_group_name')
				->join('entry_groups as eg', 'eg.id = ec.entry_group_id', 'INNER')
				->join('meets as mt', 'mt.code = eg.meet_code', 'INNER')
				->join('meet_groups as mg', 'mg.code = mt.meet_group_code', 'INNER')
				->get_where('entry_categories as ec', $cdt);
		
		$ecat = $query->row_array();
		
		$ecat['prepared_start_clock'] = date('H:i'
				, strtotime($this->_convert_start_clock($ecat['start_clock'], $ecat['start_delay_sec'])));
		
		return $ecat;
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
		$query = $this->db->select('*, count(*), ec.name as ec_name, ec.id as ec_id')
				->join('entry_categories as ec', 'ec.entry_group_id = eg.id', 'INNER')
				->join('entry_racers as er', 'er.entry_category_id = ec.id', 'INNER')
				->join('racer_results as rr', 'rr.entry_racer_id = er.id', 'INNER')
				->group_by('entry_category_id')
				->get_where('entry_groups as eg', $cdt);
		
		// result_array() で取ること。meets. の情報は単一の select で良いかも（meet_group, season と一緒にでも）。
		
		$entries = $query->result_array();
		
		return $this->_prepare_start_clock($entries);
	}
	
	/**
	 * 出走時間順に並び替える。時間表記は HH:mm に変更する。
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
		
		// 出走時間順に並び替え
		uasort($entries, function($a, $b) {
			if (empty($a['prepared_start_clock']))
			{
				return empty($b['prepared_start_clock']) ? 0 : -1;
			}
			if (empty($b['prepared_start_clock']))
			{
				return 1;
			}
			
			$timea = DateTime::createFromFormat('H:i:s', $a['prepared_start_clock']);
			$timeb = DateTime::createFromFormat('H:i:s', $b['prepared_start_clock']);
			
			return ($timea->format('G') * 60 + $timea->format('i')) - ($timeb->format('G') * 60 + $timeb->format('i'));
		});
		
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
