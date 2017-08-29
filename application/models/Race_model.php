<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Race_model
 *
 * @author shun
 */
class Race_model  extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
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
		
		return $this->_convert_start_clock($entries);
	}
	
	/**
	 * 出走時間順に並び替える。時間表記は HH:mm に変更する。
	 * @param array $entries 
	 * @return array 並び替えられた配列
	 */
	private function _convert_start_clock($entries)
	{
		if (empty($entries))
		{
			return $entries;
		}
		
		// start delay を出走時間に適用
		foreach ($entries as &$e)
		{
			if (!empty($e['start_delay_sec']))
			{
				$min = $e['start_delay_sec'] / 60;
				$e['start_clock'] = date('H:i:s', strtotime($e['start_clock'] . ' +' . $min . ' min'));
			}
		}
		
		// 出走時間順に並び替え
		uasort($entries, function($a, $b) {
			if (empty($a['start_clock']))
			{
				return empty($b['start_clock']) ? 0 : -1;
			}
			if (empty($b['start_clock']))
			{
				return 1;
			}
			
			$timea = DateTime::createFromFormat('H:i:s', $a['start_clock']);
			$timeb = DateTime::createFromFormat('H:i:s', $b['start_clock']);
			
			return ($timea->format('G') * 60 + $timea->format('i')) - ($timeb->format('G') * 60 + $timeb->format('i'));
		});
		
		// 表記を HH:mm に変更。
		foreach ($entries as &$e)
		{
			$e['start_clock'] = date('H:i', strtotime($e['start_clock']));
		}
		
		return $entries;
	}
}
