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
	 * @param string andor 'and' もしくはそれ以外の文字列
	 * @param string $category_code カテゴリーコード
	 * @return array 選手情報配列。
	 */
	public function get_racers($search_word, $andor = 'and', $category_code = FALSE)
	{
		$this->db->select('*')->from('racers')
				->where('racers.deleted', 0);
		
		if (!empty($search_word))
		{
			$str = trim(mb_convert_kana($search_word, 's', 'UTF-8')); // 全角-->半角スペース変換
			$words = explode(' ', $str); // スペースでの分割

			$COL_NAMES = array('code', 'family_name', 'family_name_kana', 'family_name_en'
				, 'first_name', 'first_name_kana', 'first_name_en', 'team');

			$with_and = (empty($andor) || $andor === 'and');
			$is_first = TRUE;

			foreach ($words as $word)
			{
				if ($is_first || $with_and)
				{
					$this->db->group_start();
					$is_first = FALSE;
				}
				else
				{
					$this->db->or_group_start();
				}

				$hanKw = mb_convert_kana($word, 'rn');
				$zenKw = mb_convert_kana($word, 'RN');

				$str = '';
				foreach ($COL_NAMES as $col_name)
				{
					$this->db->or_like($col_name, $word);

					if ($hanKw != $word)
					{
						$this->db->or_like($col_name, $hanKw);
					}

					if ($zenKw != $word)
					{
						$this->db->or_like($col_name, $zenKw);
					}
				}

				$this->db->group_end();
			}
		}
		
		if (!empty($category_code))
		{
			$this->db->join('category_racers as cr', 'cr.racer_code = racers.code', 'INNER')
					->where('cr.deleted', 0)
					->where('cr.category_code', $category_code);
		}
		
		$query = $this->db->get();
		return $query->result_array();
	}
}
