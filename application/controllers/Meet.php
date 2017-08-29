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
	}
	
	public function index()
	{
		$data['meets'] = $this->meet_model->get_meet();
		
		$this->_fmt_render('meets/index', $data);
	}
	
	public function view($code = NULL)
	{
		$data = array();
		$data['meet'] = $this->meet_model->get_meet($code);
		$data['ecats'] = $this->race_model->get_race_of_meet($code);
		$data['rank_ups'] = $this->categoryracer_model->get_rankuppers_of_meet($code);
		
		if (empty($data['meet']))
		{
			show_404();
		}
		
		$this->_fmt_render('meets/view', $data);
	}
}
