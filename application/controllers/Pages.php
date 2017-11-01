<?php

class Pages extends XSYS_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('form');
		
		$this->load->model('basedata_model');
		$this->load->model('meet_model');
	}
	
	// use as top page.
	public function home()
	{
		$data = array();
		
		$data['cats'] = $this->basedata_model->get_categories();
		$data['meets'] = $this->meet_model->get_meets(FALSE, 15, TRUE);
		
		$data['eqafter156'] = 'on';
		$data['andor'] = 'and';
		
		$data['rider_search_div'] = $this->parser->parse('racer/sub/rider_search', $data, TRUE);
		$this->_fmt_render('pages/home', $data);
	}
	
	public function view($page = 'home')
	{
		if (!file_exists(APPPATH . 'views/pages/' . $page . '.php'))
		{
			// おっと、そのページはありません！
			show_404();
		}

		$data['title'] = ucfirst($page); // 頭文字を大文字に

		$this->_fmt_render('pages/' . $page, $data);
	}

}
