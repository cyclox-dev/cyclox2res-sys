<?php

require_once(APPPATH . 'etc/cyclox/Const/CategoryReason.php');

/**
 * Description of Categoryracer_model
 *
 * @author shun
 */
class Categoryracer_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * 指定大会での昇格者をかえす。カテゴリーコードを string 判断で並び替えた順でのリスト。
	 * @param string $meet_code 大会コード
	 * @return array カテゴリー昇格者
	 */
	public function get_rankuppers_of_meet($meet_code)
	{
		// 昇格者情報取得
		$cdt = array(
			'meet_code' => $meet_code,
			'reason_id' => CategoryReason::$RESULT_UP->ID(),
			'r.deleted' => 0,
			'cr.deleted' => 0,
			'rr.deleted' => 0,
			'er.deleted' => 0,
			'ec.deleted' => 0
		);
		
		$query = $this->db->select('*, cr.category_code as cr_cat_code, ec.name as ec_name')
				->join('racers as r', 'r.code = cr.racer_code', 'INNER')
				->join('racer_results as rr', 'rr.id = cr.racer_result_id', 'INNER')
				->join('entry_racers as er', 'rr.entry_racer_id = er.id', 'INNER')
				->join('entry_categories as ec', 'ec.id = er.entry_category_id', 'INNER')
				->get_where('category_racers as cr', $cdt);
		
		$rankups = $query->result_array();
		
		// 一応カテゴリーコードで並び替え
		uasort($rankups, function($a, $b)
		{
			return $a['category_code'] > $b['category_code'];
		});
		
		return $rankups;
	}
	
	/**
	 * 指定レースでの昇格者をかえす。
	 * @param string $ecat_id 出走カテゴリー ID
	 * @return array カテゴリー昇格者のマップ。キー値はリザルト ID(rr_id)
	 */
	public function get_rankuppers_of_ecat($ecat_id)
	{
		// 昇格者情報取得
		$cdt = array(
			'reason_id' => CategoryReason::$RESULT_UP->ID(),
			'r.deleted' => 0,
			'cr.deleted' => 0,
			'rr.deleted' => 0,
			'er.deleted' => 0,
			'ec.deleted' => 0,
			'ec.id' => $ecat_id
		);
		
		$query = $this->db->select('*, cr.category_code as cr_cat_code, ec.name as ec_name, rr.id as rr_id')
				->join('racers as r', 'r.code = cr.racer_code', 'INNER')
				->join('racer_results as rr', 'rr.id = cr.racer_result_id', 'INNER')
				->join('entry_racers as er', 'rr.entry_racer_id = er.id', 'INNER')
				->join('entry_categories as ec', 'ec.id = er.entry_category_id', 'INNER')
				->get_where('category_racers as cr', $cdt);
		
		$rankups = $query->result_array();
		
		$retMap = array();
		foreach ($rankups as $r)
		{
			$retMap[$r['rr_id']] = $r;
		}
		
		return $retMap;
	}
	
	/**
	 * 指定選手のカテゴリー所属をかえす
	 * @param string $racer_code 選手コード
	 * @return array カテゴリー所属
	 */
	public function get_catbinds($racer_code = NULL)
	{
		$cdt = array(
			'cr.racer_code' => $racer_code,
			//'r.deleted' => 0, <-- 削除済み選手も表示する。
			'cr.deleted' => 0,
		);
		
		$query = $this->db->select('*, mt.short_name as meet_name, ss.short_name as season_short_name')
				->join('meets as mt', 'mt.code = cr.meet_code', 'LEFT')
				->join('seasons as ss', 'ss.id = mt.season_id', 'LEFT')
				->order_by('cr.cancel_date DESC')
				->get_where('category_racers as cr', $cdt);
		
		$cats = $query->result_array();
		return $this->_arrange_cat_binds($cats);
	}
	
	/**
	 * カテゴリー所属を現在所属、過去の、未来の、に分別し、それぞれ並び替える。
	 * @param array $cats カテゴリー所属リスト
	 * @return array 並び替え結果。key: on, old, future に振り分けられる。
	 */
	private function _arrange_cat_binds($cats)
	{
		if (empty($cats))
		{
			return array();
		}
		
		$today = date('Y/m/d');
		
		$future = array();
		$old = array();
		$on = array();
		
		foreach ($cats as $c)
		{
			if (!empty($c['apply_date']))
			{
				$c['apply_date'] = date('Y/m/d', strtotime($c['apply_date']));
			}
			
			if (!empty($c['cancel_date']))
			{
				$c['cancel_date'] = date('Y/m/d', strtotime($c['cancel_date']));
			}
			
			$c['is_by_rankup'] = (!empty($c['racer_result_id']) && !empty($c['meet_code'])
					&& $c['at_date'] > date('2017-03-31')
					&& $c['reason_id'] == CategoryReason::$RESULT_UP->ID());
			
			if ($c['apply_date'] > $today)
			{
				$future[] = $c;
			}
			else if (empty($c['cancel_date']) || $c['cancel_date'] >= $today)
			{
				$on[] = $c;
			}
			else
			{
				$old[] = $c;
			}
		}
		
		// 過去所属はモデルの order by に依存
		
		// 未来所属は apply date 順
		if (sizeof($future) > 1)
		{
			usort($future, function($a, $b) {
				return $a['apply_date'] < $b['apply_date'];
			});
		}
		
		// 現在所属も apply date 順
		if (sizeof($on) > 1)
		{
			usort($on, function($a, $b) {
				return $a['apply_date'] < $b['apply_date'];
			});
		}
		
		$ret = array(
			'on' => $on,
			'old' => $old,
			'future' => $future,
		);
		
		return $ret;
	}
	
	public function get_seasonrankdown_num_at($dt = false)
	{
		if (! $dt) {
			$dt = date('Y-m-d');
		}
		
		$apply_date = (new DateTime($dt))->format('Y') . '-04-01';
		$cdt = [
			'deleted' => 0,
			'reason_id' => CategoryReason::$SEASON_DOWN->ID(),
			'apply_date' => $apply_date,
		];
		
		return $this->db->from('category_racers')->where($cdt)->count_all_results();
	}
}
