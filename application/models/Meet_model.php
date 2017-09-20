<?php

/**
 * Description of Meet_model
 *
 * @author shun
 */
class Meet_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * 大会を取得する。deleted は含まない。
	 * @param string $code 大会コード。
	 * @return array 大会データ
	 */
	public function get_meet($code = FALSE)
	{
		if ($code === FALSE)
		{
			return array();
		}
		
		$cdt = array(
			'mt.code' => $code,
			'mt.deleted' => 0
		);
		
		$query = $this->db->select('*, mg.code as mg_code, mt.name as meet_name, mt.homepage as meet_hp'
				. ', mg.name as mg_name, ss.name as ss_name')
				->join('meet_groups as mg', 'mt.meet_group_code = mg.code', 'INNER')
				->join('seasons as ss', 'mt.season_id = ss.id', 'INNER')
				->get_where('meets as mt', $cdt);
		return $query->row_array();
	}
	
	/**
	 * 大会を取得する。deleted は含まない。
	 * @param string $code 大会グループコード。指定しない場合はすべての大会を取得する。
	 * @return array 大会データの配列。$code を指定しない場合は大会データの配列。
	 */
	public function get_meets($code = FALSE)
	{
		$cdt = array(
			'meets.deleted' => 0,
		);

		if (XSYS_const::NONVISIBLE_BEFORE1718)
		{
			$cdt['at_date >'] = '2017-03-31';
		}
		
		$query = $this->db->order_by('at_date', 'DESC');
		
		if (!empty($code))
		{
			$cdt['meet_group_code'] = $code;
		}
		
		$query = $query->select('*, meets.name as mt_name, meets.code as mt_code'
				. ', mg.name as mg_name, mg.short_name as mg_short_name')
				->join('meet_groups as mg', 'mg.code = meets.meet_group_code', 'INNER');
	
		$query = $query->get_where('meets', $cdt);
		
		return $query->result_array();
	}
}
