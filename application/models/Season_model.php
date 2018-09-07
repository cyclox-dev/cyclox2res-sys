<?php

/**
 * Description of Season_model
 *
 * @author shun
 */
class Season_model  extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * シーズンをかえす
	 */
	public function get_seasons()
	{
		if (XSYS_const::NONVISIBLE_BEFORE1718)
		{
			 $this->db->where('start_date >', '2017-03-31');
		}
		
		$query = $this->db->select('*')
				->where('start_date <=', date('Y-m-d'))
				->get_where('seasons', ['deleted' => 0]);
		
		return $query->result_array();
	}
}
