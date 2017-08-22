<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Meets
 *
 * @author shun
 */
class Meets extends XSYS_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('meet_model');
		$this->load->helper('url_helper');
	}
	
	public function index()
	{
		$data['meets'] = $this->meet_model->get_meet();
		$data['title'] = '大会リスト';
		
		$this->_fmtRender('meets/index', $data);
	}
	
	public function view($code = NULL)
	{
		$data['meet'] = $this->meet_model->get_meet($code);
		
		if (empty($data['meet']))
		{
			show_404();
		}
		
		$data['title'] = $data['meet']['name'];
		
		$this->_fmtRender('meets/view', $data);
	}
}
