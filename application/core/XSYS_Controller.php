<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of XSYS_Controller
 *
 * @author shun
 */
class XSYS_Controller extends CI_Controller {

	protected $twig;

	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('parser');
		$this->load->helper('html_escape');
	}

	protected function _fmtRender($view = NULL, $data = array())
	{
		if (empty($view))
		{
			show_404();
		}
		
		$hd = $this->parser->parse('templates/header', $data, TRUE);
		$this->output->set_output($hd);
		
		$body = $this->parser->parse($view, $data, TRUE);
		$this->output->append_output($body);
		
		$ft = $this->parser->parse('templates/footer', $data, TRUE);
		$this->output->append_output($ft);
	}
}
