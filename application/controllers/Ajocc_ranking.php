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
	
	public function view($category_code, $local_setting_id)
	{
		
	}
}
