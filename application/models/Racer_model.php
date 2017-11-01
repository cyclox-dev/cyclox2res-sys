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
	
	/**
	 * 指定の選手配列をかえす
	 * @param string $search_word 検索ワード
	 * @param string $category_code カテゴリーコード
	 * @param boolean $eqafter156 15-16以降のデータに絞るか
	 * @param string andor 'and' もしくはそれ以外の文字列
	 * @return array 選手情報配列。
	 */
	public function get_racers($search_word, $category_code, $eqafter156, $andor)
	{
		
		
		return NULL;
	}
}
