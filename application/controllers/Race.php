<?php

/**
 * Description of Race
 *
 * @author shun
 */
class Race extends XSYS_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('race_model');
		$this->load->model('result_model');
		$this->load->model('categoryracer_model');
	}
	
	public function view($ecat_id = NULL)
	{
		$data = array();
		$data['ecat'] = $this->race_model->get_race_info($ecat_id);
		
		if (empty($data['ecat']))
		{
			show_404();
		}
		
		$data['results'] = $this->result_model->get_results($ecat_id);
		$data['rankuppers'] = $this->categoryracer_model->get_rankuppers_of_ecat($ecat_id);
		
		// 残留ポイント表記があるかチェック
		// 人数カウント
		$entried = 0;
		$started = 0;
		$fin = 0;
		$has_holdpoints = FALSE;
		foreach ($data['results'] as $r)
		{
			++$entried;
			if ($r['status'] != RacerResultStatus::$DNS->val())
			{
				++$started;
				if ($r['status'] == RacerResultStatus::$FIN->val())
				{
					++$fin;
				}
			}
			
			if (!empty($r['hold_points_exp']))
			{
				$has_holdpoints = TRUE;
			}
		}
		$data['entried'] = $entried;
		$data['started'] = $started;
		$data['fin'] = $fin;
		$data['has_holdpoints'] = $has_holdpoints;
		
		$this->_fmt_render('race/view', $data);
	}
}
