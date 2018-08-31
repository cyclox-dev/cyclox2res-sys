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
		
		$this->load->helper('date');
	}
	
	public function index()
	{
		$rankings = $this->pointseries_model->get_rankings();
		$this->_fmt_render('point_series/index', array('rankings' => $rankings));
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
		
		$this->_fmt_render('point_series/view', $data, ['results.js'], ['rankings_data.css'], 'ランキング');
	}
	
	public function view__($id = NULL)
	{
		$ranking = $this->pointseries_model->get_ranking($id);
		
		$this->_fmt_render('point_series/__view', $ranking);
	}
}
