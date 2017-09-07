<?php

require_once(APPPATH . 'etc/cyclox/Const/Gender.php');


/**
 * Description of Racer_model
 *
 * @author shun
 */
class Racer_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_racer($code = NULL)
	{
		if (empty($code))
		{
			return NULL;
		}
		
		$cdt = array(
			//'r.deleted' => 0,
			'code' => $code,
		);
		
		$query = $this->db->select('*')
				->get_where('racers', $cdt);
		
		$racer = $query->row_array();
		
		if (!empty($racer))
		{
			$racer['gender_exp'] = Gender::genderAt($racer['gender']);
		}
		
		return $racer;
	}
}
