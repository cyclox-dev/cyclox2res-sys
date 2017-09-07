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
	}
	
	public function view($code = NULL)
	{
		$racer = $this->racer_model->get_racer($code);
		
		if (empty($racer))
		{
			show_404();
		}
		
		$data = array('racer' => $racer);
		
		$this->_fmt_render('racer/view', $data);
	}
}
