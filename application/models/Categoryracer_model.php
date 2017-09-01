<?php

require_once(APPPATH . 'etc/cyclox/const/CategoryReason.php');

/**
 * Description of Categoryracer_model
 *
 * @author shun
 */
class Categoryracer_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * 指定大会での昇格者をかえす。カテゴリーコードを string 判断で並び替えた順でのリスト。
	 * @param string $meet_code 大会コード
	 * @return array カテゴリー昇格者
	 */
	public function get_rankuppers_of_meet($meet_code)
	{
		// 昇格者情報取得
		$cdt = array(
			'meet_code' => $meet_code,
			'reason_id' => CategoryReason::$RESULT_UP->ID(),
			'r.deleted' => 0,
			'cr.deleted' => 0,
			'rr.deleted' => 0,
			'er.deleted' => 0,
			'ec.deleted' => 0
		);
		
		$query = $this->db->select('*, cr.category_code as cr_cat_code, ec.name as ec_name')
				->join('racers as r', 'r.code = cr.racer_code', 'INNER')
				->join('racer_results as rr', 'rr.id = cr.racer_result_id', 'INNER')
				->join('entry_racers as er', 'rr.entry_racer_id = er.id', 'INNER')
				->join('entry_categories as ec', 'ec.id = er.entry_category_id', 'INNER')
				->get_where('category_racers as cr', $cdt);
		
		$rankups = $query->result_array();
		
		// 一応カテゴリーコードで並び替え
		uasort($rankups, function($a, $b)
		{
			return $a['category_code'] > $b['category_code'];
		});
		
		return $rankups;
	}
	
	/**
	 * 指定レースでの昇格者をかえす。
	 * @param string $ecat_id 出走カテゴリー ID
	 * @return array カテゴリー昇格者のマップ。キー値はリザルト ID(rr_id)
	 */
	public function get_rankuppers_of_ecat($ecat_id)
	{
		// 昇格者情報取得
		$cdt = array(
			'reason_id' => CategoryReason::$RESULT_UP->ID(),
			'r.deleted' => 0,
			'cr.deleted' => 0,
			'rr.deleted' => 0,
			'er.deleted' => 0,
			'ec.deleted' => 0,
			'ec.id' => $ecat_id
		);
		
		$query = $this->db->select('*, cr.category_code as cr_cat_code, ec.name as ec_name, rr.id as rr_id')
				->join('racers as r', 'r.code = cr.racer_code', 'INNER')
				->join('racer_results as rr', 'rr.id = cr.racer_result_id', 'INNER')
				->join('entry_racers as er', 'rr.entry_racer_id = er.id', 'INNER')
				->join('entry_categories as ec', 'ec.id = er.entry_category_id', 'INNER')
				->get_where('category_racers as cr', $cdt);
		
		$rankups = $query->result_array();
		
		$retMap = array();
		foreach ($rankups as $r)
		{
			$retMap[$r['rr_id']] = $r;
		}
		
		return $retMap;
	}
}
