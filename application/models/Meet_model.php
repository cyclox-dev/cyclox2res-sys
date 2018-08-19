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
	 * 指定の大会グループをかえす
	 * @param string $code 大会グループコード
	 * @return array 大会グループ
	 */
	public function get_meet_group($code = FALSE)
	{
		if (empty($code))
		{
			return array();
		}
		
		$cdt = array(
			'code' => $code,
			'deleted' => 0
		);
		
		$query = $this->db->select('*')
				->get_where('meet_groups', $cdt);
		
		return $query->row_array();
	}
	
	/**
	 * 大会グループの配列をかえす
	 * @return array 大会グループの配列
	 */
	public function get_meet_groups()
	{
		$query = $this->db->select('*')
				->get_where('meet_groups', ['deleted' => 0]);
		
		return $query->result_array();
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
		if (XSYS_const::NONVISIBLE_BEFORE1718)
		{
			$cdt['at_date >'] = '2017-03-31';
		}
		
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
	 * @param int $limit 取得件数上限値
	 * @param bool $cuts_futures 未来に開催されるレースを含ませるか
	 * @return array 大会データの配列。$code を指定しない場合は大会データの配列。
	 */
	public function get_meets($code = FALSE, $limit = FALSE, $cuts_futures = FALSE)
	{
		$cdt = array(
			'meets.deleted' => 0,
		);
		
		if ($cuts_futures)
		{
			$cdt['at_date <'] = date('Y-m-d');
		}

		if (XSYS_const::NONVISIBLE_BEFORE1718)
		{
			$cdt['at_date >'] = '2017-03-31';
		}
		
		$this->db->order_by('season_id', 'DESC');
		$this->db->order_by('at_date', 'DESC');
		
		if (!empty($code))
		{
			$cdt['meet_group_code'] = $code;
		}
		
		$this->db->select('*, meets.name as mt_name, meets.code as mt_code'
				. ', mg.name as mg_name, mg.short_name as mg_short_name, ss.name as season_name')
				->join('meet_groups as mg', 'mg.code = meets.meet_group_code', 'INNER')
				->join('seasons as ss', 'ss.id = meets.season_id', 'INNER');
	
		if (!empty($limit) && is_int($limit))
		{
			$this->db->limit($limit, 0);
		}
		
		$query = $this->db->get_where('meets', $cdt);
		
		return $query->result_array();
	}
}
