<?php

/**
 * Description of Meets
 *
 * @author shun
 */
class Meet extends XSYS_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('meet_model');
		$this->load->model('race_model');
		$this->load->model('categoryracer_model');
		$this->load->helper('url_helper');
	}
	
	public function index()
	{
		$data['meets'] = $this->meet_model->get_meet();
		
		$this->_fmtRender('meets/index', $data);
	}
	
	public function view($code = NULL)
	{
		$data = array();
		$data['meet'] = $this->meet_model->get_meet($code);
		$data['entries'] = $this->race_model->get_race_of_meet($code);
		$data['rank_ups'] = $this->categoryracer_model->get_rankuppers_of_meet($code);
		
		if (empty($data['meet']))
		{
			show_404();
		}
		
		$this->_fmtRender('meets/view', $data);
	}
}
