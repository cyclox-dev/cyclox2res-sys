<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AjoccRanking
 *
 * @author shun
 */
class Ajocc_ranking extends XSYS_Controller {
	
	public function __construct()
	{
		parent::__construct();
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
		
		$data['rankings'] = $this->ajoccranking_model->get_rankings($arg);
		
		$this->_fmt_render('ajocc_ranking/index', $data);
	}
	
	public function view($season_id, $local_setting_id, $category_code)
	{
		$data = $this->ajoccranking_model->get_ranking($season_id, $local_setting_id, $category_code);
		$data['season_id'] = $season_id;
		$data['local_setting_id'] = $local_setting_id;
		$data['category_code'] = $category_code;
		
		$data['red_line_rank'] = $this->ajoccranking_model->get_redline_rank($season_id, $category_code);
		//log_message('debug', print_r($data['red_line_rank'], true));
		
		$this->_fmt_render('ajocc_ranking/view', $data, ['https://www.cyclocross.jp/js/results.js'], ['https://www.cyclocross.jp/css/rankings_data.css'], 'ランキング');
	}
	
	public function view__($season_id, $local_setting_id, $category_code)
	{
		$data = $this->ajoccranking_model->get_ranking($season_id, $local_setting_id, $category_code);
		
		$this->_fmt_render('ajocc_ranking/__view', $data);
	}
}
