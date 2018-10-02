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
	
	public function index()
	{
		$data['rankings'] = $this->ajoccranking_model->get_rankings();
		
		$this->_fmt_render('ajocc_ranking/index', $data);
	}
	
	public function view($season_id, $local_setting_id, $category_code)
	{
		$data = $this->ajoccranking_model->get_ranking($season_id, $local_setting_id, $category_code);
		$data['season_id'] = $season_id;
		$data['local_setting_id'] = $local_setting_id;
		$data['category_code'] = $category_code;
		
		$this->_fmt_render('ajocc_ranking/view', $data, ['https://www.cyclocross.jp/js/results.js'], ['https://www.cyclocross.jp/css/rankings_data.css'], 'ランキング');
	}
	
	public function view__($season_id, $local_setting_id, $category_code)
	{
		$data = $this->ajoccranking_model->get_ranking($season_id, $local_setting_id, $category_code);
		
		$this->_fmt_render('ajocc_ranking/__view', $data);
	}
}
