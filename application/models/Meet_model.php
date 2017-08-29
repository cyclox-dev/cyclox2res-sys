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
	 * @param string $code 大会コード。指定しない場合はすべての大会を取得する。
	 * @return type 大会データ。$code を指定しない場合は大会データの配列。
	 */
	public function get_meet($code = FALSE)
	{
		if ($code === FALSE)
		{
			$this->db->order_by('at_date', 'DESC');
			$query = $this->db->get_where('meets', array('deleted' => 0));
			return $query->result_array();
		}
		
		$cdt = array(
			'mt.code' => $code,
			'mt.deleted' => 0
		);
		
		$query = $this->db->select('*, mg.code as mg_code, mt.name as meet_name'
				. ', mg.name as mg_name, ss.name as ss_name')
				->join('meet_groups as mg', 'mt.meet_group_code = mg.code', 'INNER')
				->join('seasons as ss', 'mt.season_id = ss.id', 'INNER')
				->get_where('meets as mt', $cdt);
		return $query->row_array();
	}
}
