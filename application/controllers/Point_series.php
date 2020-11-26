<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Point_series
 *
 * @author shun
 */
class Point_series extends XSYS_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('pointseries_model');
		$this->load->model('ajoccranking_model');
		
		$this->load->helper('date');
	}
	
	/**
	 * 一覧を表示する
	 * @param any $opt string'before' ならば昨シーズンのシリーズだけを表示する（表示の切替は8/1である。）
	 */
	public function index($opt = FALSE)
	{
		$arg = array();
		if ($opt === 'before')
		{
			$y = date('Y');
			if (date('n') < 8) --$y; // BETAG: 8月には昨シーズンのを point_series/index/before に表示
			
			$arg['before_only'] = '' . $y . '-04-01';
		}
		
		$data = [];
		$data['rankings'] = $this->pointseries_model->get_ranking_list($arg);
		$data['ajocc_rankings'] = $this->ajoccranking_model->get_rankings($arg);
		$data['is_before'] = ($opt === 'before');
		
		$this->_fmt_render('point_series/index', $data, [], ['https://www.cyclocross.jp/css/rankings_data.css'], 'ランキング');
	}
	
	public function view($id = NULL)
	{
		$data['ps_id'] = $id;
		
		$ranking = $this->pointseries_model->get_ranking($id);
		if (!empty($ranking['ranking'])) $data['ranking'] = $ranking['ranking'];
		if (!empty($ranking['series'])) $data['series'] = $ranking['series'];
		if (!empty($ranking['title_row'])) $data['title_row'] = $ranking['title_row'];
		
		//log_message('debug', print_r($data, TRUE));
		
		$data['ps_grouped'] = $this->pointseries_model->get_series_grouped(
				$ranking['series']['point_series_group_id'], $ranking['series']['season_id']);
		
		//log_message('debug', print_r($data['ps_grouped'], TRUE));
		
		$this->_fmt_render('point_series/view', $data, ['https://www.cyclocross.jp/js/results.js'], ['https://www.cyclocross.jp/css/rankings_data.css'], 'ランキング');
	}
	
	public function view__($id = NULL)
	{
		$ranking = $this->pointseries_model->get_ranking($id);
		
		$this->_fmt_render('point_series/__view', $ranking);
	}
}
