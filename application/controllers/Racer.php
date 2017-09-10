<?php

/**
 * Description of Racer
 *
 * @author shun
 */
class Racer  extends XSYS_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('racer_model');
		$this->load->model('categoryracer_model');
	}
	
	public function view($code = NULL)
	{
		$racer = $this->racer_model->get_racer($code);
		
		if (empty($racer))
		{
			show_404();
		}
		
		$data = array('racer' => $racer);
		
		$data['cats'] = $this->categoryracer_model->get_catbinds($code);
		
		$this->_fmt_render('racer/view', $data);
	}
}
