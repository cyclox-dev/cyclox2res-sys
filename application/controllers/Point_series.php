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
	}
	
	public function view($id = NULL)
	{
		$ranking = $this->pointseries_model->get_ranking($id);
		
		if (empty($ranking))
		{
			show_404();
		}
		
		$this->_fmt_render('point_series/view', $ranking);
	}
}
