<?php

require_once(APPPATH . 'etc/cyclox/Const/RacerResultStatus.php');

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
		$this->load->model('pointseries_model');
	}
	
	public function view($ecat_id = NULL)
	{
		$data = array();
		$data['ecat'] = $this->race_model->get_race_info($ecat_id);
		
		if (empty($data['ecat']))
		{
			show_404();
		}
		if (XSYS_const::NONVISIBLE_BEFORE1718 && $data['ecat']['at_date'] < '2017-04-01')
		{
			show_404();
		}
		
		$results = $this->result_model->get_results($ecat_id);
		$data['rankuppers'] = $this->categoryracer_model->get_rankuppers_of_ecat($ecat_id);
		
		// 残留ポイント表記があるかチェック
		// 人数カウント
		$entried = 0;
		$started = 0;
		$fin = 0;
		$has_holdpoints = FALSE;
		foreach ($results as $r)
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
			
			if (!empty($r['hps']))
			{
				$has_holdpoints = TRUE;
			}
			
			if ($r['rank'] == 1)
			{
				$data['ecat']['race_lap'] = $r['lap'];
				$top_milli = $r['goal_milli_sec'];
				$top_lap = $r['lap'];
			}
		}
		$data['entried'] = $entried;
		$data['started'] = $started;
		$data['fin'] = $fin;
		$data['has_holdpoints'] = $has_holdpoints;
		
		// time/gap の設定
		if (!empty($top_milli))
		{
			foreach ($results as &$r)
			{
				$r['time_gap'] = $this->_get_result_timegaps($r, $top_lap, $top_milli);
			}
		}
		
		// シリーズポイント取得状況について取得
		$psrs_map = $this->pointseries_model->get_psrmap_of_ecat($ecat_id);
		
		$ps_titles = array();
		foreach ($results as &$result)
		{
			$rid = $result['rr_id'];
			if (empty($psrs_map[$rid])) continue;
			
			foreach ($psrs_map[$rid] as $psr)
			{
				$finds = FALSE;
				$index = 0;
				foreach ($ps_titles as $t)
				{
					if ($psr['point_series_id'] == $t['id'])
					{
						$finds = TRUE;
						break;
					}
					++$index;
				}
				
				if (!$finds)
				{
					$ps = $this->pointseries_model->get_series_info($psr['point_series_id']);
					$ps_titles[$index] = array('id' => $psr['point_series_id'], 'name' => $ps['short_name']);
				}
				
				if (empty($result['ps_points']))
				{
					$result['ps_points'] = array();
				}
				
				$result['ps_points'][$index] = array(
					'pt' => $psr['point'],
					'bonus' => $psr['bonus']
				);
			}
		}
		
		//var_dump(json_encode($results));
		$data['results'] = $results;
		$data['ps_titles'] = $ps_titles;
		
		$this->_fmt_render('race/view', $data);
	}
	
	/**
	 * リザルトとして表示する time/gap 表現をかえす。トップ選手はタイム。それ以外は遅刻タイムもしくは不足ラップ。
	 * @param array $r リザルト
	 * @param int $top_lap レースのトップ周回数
	 * @param int $top_milli レーストップのゴールタイム
	 * @return string time/gap 表現
	 */
	private function _get_result_timegaps($r, $top_lap, $top_milli)
	{
		$rrs = RacerResultStatus::ofVal($r['status']);

		if ($rrs->isLankedStatus())
		{
			if ($rrs === RacerResultStatus::$FIN && $r['lap'] == $top_lap)
			{
				if (empty($r['goal_milli_sec']))
				{
					return 'Unknown';
				}

				$goal_milli = $r['goal_milli_sec'];

				if ($goal_milli == $top_milli && $r['rank'] == 1)
				{
					return Util::milli2Time($r['goal_milli_sec'], false, 1);
				}
				else
				{
					// time gap
					if ($r['goal_milli_sec'] < $top_milli)
					{
						// unlikely...
						return '-' . Util::milli2Mss($top_milli - $r['goal_milli_sec'], 0);
					}
					else
					{
						return '+' . Util::milli2Mss($r['goal_milli_sec'] - $top_milli, 0);
					}
				}
			}
			else if (isset($r['lap']))
			{
				$lap_gap = $r['lap'] - $top_lap;
				$gap_str =  ($lap_gap > 0) ? '+' : '';
				
				return $gap_str . $lap_gap . 'Lap';
			}
		}
		
		return '';
	}
}
