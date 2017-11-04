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
		if (!empty($search_word))
		{
			$str = trim(mb_convert_kana($search_word, 's', 'UTF-8')); // 全角-->半角スペース変換
			$words = explode(' ', $str); // スペースでの分割

			$this->_set_word_search_condition($words, $andor);
		}
		
		if (empty($category_code))
		{
			$this->db->where('racers.deleted', 0);
		}
		else
		{
			// とりあえずサブクエリで racer_code 取得
			$query = $this->db->select('code')
					->join('category_racers as cr', 'cr.racer_code = racers.code', 'INNER')
					->where('racers.deleted', 0)
					->where('cr.deleted', 0)
					->where('cr.category_code', $category_code)
					->where("cr.apply_date <= '" . date('Y-m-d') . "'")
					->group_start()
						->or_where('cr.cancel_date is null')
						->or_where("cr.cancel_date >= '" . date('Y-m-d') . "'")
					->group_end()
					->group_by('cr.racer_code')
					->order_by('code')
					->distinct();
			
			$subquery = $this->db->get_compiled_select('racers');
			
			$this->db->where('code in (' . $subquery . ')');
		}
		
		$query = $this->db->select('code, family_name, first_name, team, gender, nationality_code, jcf_number'
				. ", group_concat(distinct cr.category_code order by cr.category_code separator ',') as cats")
				->join('category_racers as cr', 'cr.racer_code = racers.code', 'INNER')
				->where('cr.deleted', 0)
				->where("cr.apply_date <= '" . date('Y-m-d') . "'")
				->group_start()
					->or_where('cr.cancel_date is null')
					->or_where("cr.cancel_date >= '" . date('Y-m-d') . "'")
				->group_end()
				// if $category_code is not empty, not need r.deleted
				->group_by('cr.racer_code')
				->order_by('code')
				->distinct()
				->get('racers');

		$racers = $query->result_array();
		
		foreach ($racers as &$racer)
		{
			$racer['gender_exp'] = Gender::genderAt($racer['gender'])->charExp();
		}

		return $racers;
	}
	
	/**
	 * $this->db->xx() を呼び、キーワード検索のための条件をセットする
	 * @param array(string) $words キーワードとなる文字列の配列
	 * @param string $andor 'and' もしくはそれ以外の文字列
	 */
	private function _set_word_search_condition($words, $andor)
	{
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
}
