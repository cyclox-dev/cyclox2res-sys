<?php

/**
 * Description of Racer
 *
 * @author shun
 */
class Racer extends XSYS_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('form');
		$this->load->helper('url');
		
		$this->load->model('racer_model');
		$this->load->model('basedata_model');
		$this->load->model('categoryracer_model');
		$this->load->model('result_model');
		$this->load->model('pointseries_model');
		$this->load->model('ajoccranking_model');
	}
	
	public function view($code = NULL)
	{
		$racer = $this->racer_model->get_racer($code);
		
		if (empty($racer))
		{
			show_404();
		}
		
		$data = array('racer' => $racer);
		
		$data['rankings'] = $this->pointseries_model->get_racers_ranks($code);
		$data['ajocc_rankings'] = $this->ajoccranking_model->get_racers_ranks($code);
		$data['cats'] = $this->categoryracer_model->get_catbinds($code);
		
		$results = $this->result_model->get_result_of_racer($code);
		
		$rankup_to = array();
		
		if (!empty($data['cats']['on']))
		{
			$rankup_to = $this->_pull_rankup_tos($data['cats']['on']);
		}
		
		if (!empty($data['cats']['old']))
		{
			$rankup_to += $this->_pull_rankup_tos($data['cats']['old']);
		}
		
		if (!empty($rankup_to))
		{
			foreach ($results as &$r)
			{
				if (!empty($rankup_to[$r['rr_id']]))
				{
					$r['rank_up_to'] = $rankup_to[$r['rr_id']];
				}
			}
		}
		
		$data['results'] = $results;
		$this->_fmt_render('racer/view', $data);
	}
	
	/**
	 * 昇格したリザルトマップをかえす
	 * @param array $catbinds カテゴリー所属配列
	 * @return array key:result_id, val:昇格先カテゴリーとするマップ
	 */
	private function _pull_rankup_tos($catbinds)
	{
		$ret = array();
		
		foreach ($catbinds as $bind)
		{
			if ($bind['is_by_rankup'])
			{
				$ret[$bind['racer_result_id']] = $bind['category_code'];
			}
		}
		
		return $ret;
	}
	
	public function index()
	{
		$cat = $this->input->get('category');
		$swords = $this->input->get('search_words');
		$andor = $this->input->get('andor');
		
		if (is_null($swords) && is_null($cat))
		{
			$data['searches'] = FALSE;
		}
		else
		{
			$data['searches'] = TRUE;
			
			if (empty($swords) && $cat === 'empty')
			{
				// 全データになってしまうため、無しとする。
				$data['racers'] = FALSE;
			}
			else
			{
				$cat_code = ($cat === 'empty') ? FALSE : $cat;
				$ret = $this->racer_model->get_racers($swords, $andor, $cat_code);
				
				$data['racers'] = $ret['racers'];
				$data['all_count'] = $ret['count_all'];
			}
		}
		
		$data['cat_code'] = $cat;
		$data['search_words'] = $swords;
		$data['andor'] = empty($andor) ? 'and' : $andor;

		$data['cats'] = $this->basedata_model->get_categories();
		
		$data['rider_search_div'] = $this->parser->parse('racer/sub/rider_search', $data, TRUE);
		$this->_fmt_render('racer/index', $data);
	}
}
