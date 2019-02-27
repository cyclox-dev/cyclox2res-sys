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
	protected $__KEY_BODY_ID= '__key_body_id'; // body 要素に与えるid名
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('parser');
		$this->load->library('session');
		$this->load->helper('html_escape');
		$this->load->helper('url_helper');
	}

	private function _startsWith($haystack, $needle)
	{
		return strpos($haystack, $needle) === 0;
	}
	/**
	 * 
	 * @param type $view
	 * @param type $data
	 * @param type $js_list view に必要な js ファイルのリスト。http から始まるリンクについては絶対、else 相対パスで。
	 * @param type $css_list view に必要な css ファイルのリスト。http から始まるリンクについては絶対、else 相対パスで。
	 * @param type $title
	 */
	protected function _fmt_render($view = NULL, $data = [], $js_list = [], $css_list = [], $title = '')
	{
		if (empty($view))
		{
			show_404();
		}
		
		$data['xsys_flash_error_list'] = $this->session->flashdata(XSYS_const::FLASH_KEY_ERROR);
		$data['xsys_flash_info_list'] = $this->session->flashdata(XSYS_const::FLASH_KEY_INFO);
		
		
		$jss = [];
		foreach ($js_list as $js)
		{
			if ($this->_startsWith($js, 'http'))
			{
				$jss[] = $js;
			}
			else
			{
				$jss[] = base_url('assets/js/' . $js);
			}
		}
		
		$data['xsys_header_js_files'] = $jss;
		
		$csss = [];
		foreach ($css_list as $css)
		{
			if ($this->_startsWith($css, 'http'))
			{
				$csss[] = $css;
			}
			else
			{
				$csss[] = base_url('assets/css/' . $css);
			}
		}
		
		$data['xsys_header_css_files'] = $csss;
		
		$data['xsys_page_title'] = $title;
		
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
