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
		$this->load->model('season_model');
	}
	
	public function index()
	{
		$meet_group_code = $this->input->get('meet_group');
		$season_id = $this->input->get('season');
		
		$cuts_futures = empty($meet_group_code);
		
		$data['meets'] = $this->meet_model->get_meets($meet_group_code, $season_id, FALSE, $cuts_futures);
		$data['meet_groups'] = $this->meet_model->get_meet_groups();
		$data['seasons'] = $this->season_model->get_seasons();
		
		//log_message('debug', print_r($data['meet_groups'], TRUE));
		if (!empty($meet_group_code))
		{
			$data['meet_group_code'] = $meet_group_code;
			
			foreach ($data['meet_groups'] as $mg)
			{
				if ($mg['code'] == $meet_group_code)
				{
					$data['meet_group'] = $mg;
					break;
				}
			}
		}
		
		$data['selected_season_id'] = $season_id;
		$this->_fmt_render('meet/index', $data, ['https://www.cyclocross.jp/js/results.js'], ['https://www.cyclocross.jp/css/results_data.css'], 'リザルト');
	}
	
	public function index__($meet_group_code = null)
	{
		$cuts_futures = empty($meet_group_code);
		
		$data['meets'] = $this->meet_model->get_meets($meet_group_code, FALSE, FALSE, $cuts_futures);
		
		if (!empty($meet_group_code))
		{
			$data['meet_group'] = $this->meet_model->get_meet_group($meet_group_code);
		}
		
		$this->_fmt_render('meet/__index', $data);
	}
	
	public function view($code = NULL)
	{
		$data = array();
		$data['meet'] = $this->meet_model->get_meet($code);
		
		if (empty($data['meet']))
		{
			show_404();
		}
		
		$ecat_id = $this->race_model->get_first_race_id($code);
		
		if (empty($ecat_id))
		{
			$this->_add_flash_error('指定した大会のリザルトデータがみつかりません。');
			redirect('meet');
			return;
		}
		
		redirect('race/' . $ecat_id);
	}
	
	public function view__($code = NULL)
	{
		$data = array();
		$data['meet'] = $this->meet_model->get_meet($code);
		
		if (empty($data['meet']))
		{
			show_404();
		}
		
		$data['ecats'] = $this->race_model->get_race_of_meet($code);
		$data['rank_ups'] = $this->categoryracer_model->get_rankuppers_of_meet($code);
		
		$this->_fmt_render('meet/__view', $data);
	}
}
