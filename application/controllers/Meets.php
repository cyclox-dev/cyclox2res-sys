<?php

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
		
		$this->_fmtRender('meets/index', $data);
	}
	
	public function view($code = NULL)
	{
		$data['meet'] = $this->meet_model->get_meet($code);
		
		if (empty($data['meet']))
		{
			show_404();
		}
		
		$this->_fmtRender('meets/view', $data);
	}
}
