<?php

require_once(APPPATH . 'etc/cyclox/Const/RacerResultStatus.php');
require_once(APPPATH . 'etc/cyclox/Util/Util.php');
require_once(APPPATH . 'etc/util/Xsys_util.php');

/**
 * Description of Result_model
 *
 * @author shun
 */
class Result_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * 指定 entry category id のレースに属するリザルトをかえす
	 * @param int $ecat_id encty category id
	 * @return array リザルト配列
	 */
	public function get_results($ecat_id)
	{
		$cdt = array(
			'ec.deleted' => 0,
			'er.deleted' => 0,
			'rr.deleted' => 0,
			'ec.id' => $ecat_id,
		);
		
		$query = $this->db->select('*, rr.id as rr_id')
				->join('entry_racers as er', 'rr.entry_racer_id = er.id', 'INNER')
				->join('entry_categories as ec', 'er.entry_category_id = ec.id', 'INNER')
				->order_by('order_index ASC')
				->get_where('racer_results as rr', $cdt);
		
		$results = $query->result_array();
		
		$hp_map = $this->_get_holdpoints(array('entry_category_id' => $ecat_id));
		
		// result.status, result.time を表現に。
		foreach ($results as &$r)
		{
			$r['rank_exp'] = Xsys_util::rank_express($r['rank'], $r['status'], $r['entry_status']);
			
			if (!empty($hp_map[$r['rr_id']]))
			{
				$r['hps'] = $hp_map[$r['rr_id']];
			}
		}
		
		return $results;
	}
	
	/**
	 * 指定出走カテゴリーのリザルトのラップタイムをかえす
	 * @param int  $ecat_id 出走カテゴリー ID
	 * @return array ラップタイム配列
	 */
	public function get_laps_of_ecat($ecat_id)
	{
		$cdt = array(
			'ec.deleted' => 0,
			'er.deleted' => 0,
			'rr.deleted' => 0,
			'ec.id' => $ecat_id,
		);
		
		$query = $this->db->select('*, rr.id as rr_id')
				->join('entry_racers as er', 'rr.entry_racer_id = er.id', 'INNER')
				->join('entry_categories as ec', 'er.entry_category_id = ec.id', 'INNER')
				->join('time_records as tr', 'tr.racer_result_id = rr.id', 'INNER')
				->order_by('tr.lap ASC')
				->get_where('racer_results as rr', $cdt);
		$results = $query->result_array();
		
		$map = array();
		
		// result.status, result.time を表現に。
		foreach ($results as $r)
		{
			$rrid = $r['racer_result_id'];
			$time_list = empty($map[$rrid]) ? array() : $map[$rrid];
			
			$lap = $r['lap'];
			$time_list[$lap] = Util::milli2Time($r['time_milli'], false, 1);
			
			$map[$rrid] = $time_list;
		}
		
		return $map;
	}
	
	/**
	 * 指定の選手コードの選手のリザルトをかえす
	 * @param string $code 選手コード
	 * @return array リザルトの配列
	 */
	public function get_result_of_racer($code = NULL)
	{
		if (empty($code))
		{
			return array();
		}
		
		$cdt = array(
			'er.racer_code' => $code,
			'mt.at_date >' => '2017-03-31',
			'er.deleted' => 0,
			'ec.deleted' => 0,
			'eg.deleted' => 0,
			'mt.deleted' => 0,
			'rr.deleted' => 0,
		);
		
		$query = $this->db->select('*, mt.short_name as meet_name, ec.name as race_name'
				. ', ec.id as ec_id, rr.status as result_status, rr.id as rr_id')
				->join('entry_categories as ec', 'ec.id = er.entry_category_id', 'INNER')
				->join('entry_groups as eg', 'eg.id = ec.entry_group_id', 'INNER')
				->join('meets as mt', 'mt.code = eg.meet_code', 'INNER')
				->join('racer_results as rr', 'rr.entry_racer_id = er.id', 'INNER')
				->order_by('at_date', 'DESC')
				->get_where('entry_racers as er', $cdt);
		//var_dump(json_encode($query->result_array()));
		
		$result = $query->result_array();
		
		$hpmap = $this->_get_holdpoints(array('racer_code' => $code));
		
		foreach ($result as &$r)
		{
			$r['rank_exp'] = Xsys_util::rank_express($r['rank'], $r['result_status'], $r['entry_status']);
			
			// 18-19以前は ajocc point ゼロの場合に非表示
			if (is_null($r['ajocc_pt']) || ($r['at_date'] < '2019-04-01' && empty($r['ajocc_pt'])))
			{
				$r['ajocc_pt_exp'] = '';
			}
			else
			{
				$r['ajocc_pt_exp'] = $r['ajocc_pt'] . 'pt/' . $r['as_category'];
			}
			
			if (!empty($hpmap[$r['rr_id']]))
			{
				$r['hps'] = $hpmap[$r['rr_id']];
			}
		}
		
		return $result;
	}
	
	/**
	 * 指定条件の残留ポイントマップをかえす
	 * @param array $condition 追加の条件式
	 * @return array racer_result_id をキーとする残留ポイント表現文字列のマップ
	 */
	private function _get_holdpoints($condition)
	{
		$cdt = $condition;
		if (empty($cdt))
		{
			$cdt = array();
		}
		
		// 2017-18 までの残留ポイント
		$cdt['er.deleted'] = 0;
		$cdt['rr.deleted'] = 0;
		
		$query = $this->db->select('hp.racer_result_id, hp.point, hp.category_code')
				->join('racer_results as rr', 'hp.racer_result_id = rr.id', 'INNER')
				->join('entry_racers as er', 'rr.entry_racer_id = er.id', 'INNER')
				->get_where('hold_points as hp', $cdt); // order by はしない。昇格した場合に表記の順が崩れるので。
		
		$hps = $query->result_array();
		
		// racer result id でまとめる
		$hp_map = array();
		foreach ($hps as $hp)
		{
			$rrid = $hp['racer_result_id'];
			if (empty($hp_map[$rrid]))
			{
				$hp_map[$rrid] = array();
			}
			$hp_map[$rrid][] = array(
				'pt' => $hp['point'],
				'cat' => $hp['category_code'],
			);
		}
		
		return $hp_map;
	}
}
