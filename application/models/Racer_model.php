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
	 * @param int $offset 取得オフセット
	 * @param int $limit データ取得件数
	 * @return array 選手情報配列。
	 */
	public function get_racers($search_word, $andor = 'and', $category_code = FALSE, $offset = 0, $limit = 20)
	{
		// for category racer sub query
		// 単純に join category_racers だとカテゴリーを持たない選手が表示されない。
		$query = $this->db->select("racer_code, GROUP_CONCAT(category_code order by category_code separator ',') as cats")
				->where('deleted', 0)
				->where("apply_date <= '" . date('Y-m-d') . "'")
				->where("(cancel_date is null OR cancel_date >= '" . date('Y-m-d') . "')") // <-- group_start(),_end だとうまくいかないことがあったのでべた書き
				->group_by('racer_code');
		$cat_subquery = $this->db->get_compiled_select('category_racers', TRUE);
		
		// 途中でカウントを取りたいのでキャッシュ機能を使用する。 TODO: catch Exceptoin?
		// >>> CACHE
		$this->db->start_cache();

		if (!empty($search_word))
		{
			$str = trim(mb_convert_kana($search_word, 's', 'UTF-8')); // 全角-->半角スペース変換
			$words = explode(' ', $str); // スペースでの分割

			$this->_set_word_search_condition($words, $andor);
		}
		
		if (empty($category_code))
		{
			$this->db->where('racers.deleted', 0);
			$this->db->stop_cache();
			
			$total_count = $this->db->from('racers')->count_all_results();
		}
		else
		{
			// とりあえずサブクエリで racer_code 取得
			$this->db->join('category_racers as cr', 'cr.racer_code = racers.code', 'INNER')
					->where('racers.deleted', 0)
					->where('cr.deleted', 0)
					->where('cr.category_code', $category_code)
					->where("cr.apply_date <= '" . date('Y-m-d') . "'")
					->where("(cancel_date is null OR cancel_date >= '" . date('Y-m-d') . "')") // <-- group_start(),_end だとうまくいかないことがあったのでべた書き
					->group_by('racers.code')
					->order_by('code');
			
			$this->db->stop_cache();
			
			$subquery = $this->db->select('code')->distinct()->get_compiled_select('racers', TRUE);
			$total_count = $this->db->select('code')->distinct()->get('racers')->num_rows();
			// 上記はパフォーマンス悪いと思われるが、他だと distinct が使えない可能性があるので num_rows() で。
			
			$this->db->flush_cache();
			
			$this->db->where("code IN ($subquery)");
		}
		
		$query = $this->db->select('code, family_name, first_name, team, gender,'
				. 'nationality_code, jcf_number, cats')
				->join("($cat_subquery) as cr", 'cr.racer_code = racers.code', 'LEFT')
						// ref: https://stackoverflow.com/questions/4455958/mysql-group-concat-with-left-join
						// 選手に対応する category 所属が無しでも大丈夫。
				->limit($limit, $offset)
				->order_by('code')
				->get('racers');
		
		$racers = $query->result_array();
		//log_message('debug', 'last select:' . $this->db->last_query());
		
		$this->db->flush_cache();
		// <<< CACHE

		//log_message('debug', 'all:' . print_r($total_count, TRUE) . ' with:' . count($racers));
		foreach ($racers as &$racer)
		{
			$racer['gender_obj'] = Gender::genderAt($racer['gender']);
		}

		return ['racers' => $racers, 'total_count' => $total_count];
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
