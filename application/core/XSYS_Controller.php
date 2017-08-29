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
		$this->load->library('session');
		$this->load->helper('html_escape');
	}

	protected function _fmt_render($view = NULL, $data = array())
	{
		if (empty($view))
		{
			show_404();
		}
		
		$data['xsys_flash_error_list'] = $this->session->flashdata(XSYS_const::FLASH_KEY_ERROR);
		$data['xsys_flash_info_list'] = $this->session->flashdata(XSYS_const::FLASH_KEY_INFO);
		
		$hd = $this->parser->parse('templates/header', $data, TRUE);
		$this->output->set_output($hd);
		
		$body = $this->parser->parse($view, $data, TRUE);
		$this->output->append_output($body);
		
		$ft = $this->parser->parse('templates/footer', $data, TRUE);
		$this->output->append_output($ft);
	}
	
	/**
	 * フラッシュメッセージ Lv.Error を追加する。
	 * @param String $msg メッセージ内容
	 */
	protected function _add_flash_error($msg)
	{
		$this->_add_flash_msg(XSYS_const::FLASH_KEY_ERROR, $msg);
	}
	
	/**
	 * フラッシュメッセージ Lv.Info を追加する。
	 * @param String $msg メッセージ内容
	 */
	protected function _add_flash_info($msg)
	{
		$this->_add_flash_msg(XSYS_const::FLASH_KEY_INFO, $msg);
	}
	
	private function _add_flash_msg($key, $msg)
	{
		$msgs = $this->session->flashdata($key);
		if (empty($msgs))
		{
			$msgs = array();
		}
		$msgs[] = $msg;
		
		$this->session->set_flashdata($key, $msgs);
	}
}
