<?php

require_once(APPPATH . 'etc/cyclox/Const/RacerResultStatus.php');

/**
 * Corss system 用 Util クラス
 *
 * @author shun
 */
class Xsys_util {
	
	public static function rank_express($rank, $result_status)
	{
		if (empty($rank))
		{
			$exp = RacerResultStatus::ofVal($result_status)->code();
		}
		else
		{
			$exp = $rank;
			
			if ($result_status == RacerResultStatus::$LAPOUT->val()
					|| $result_status == RacerResultStatus::$LAPOUT80->val())
			{
				$exp .= ' (' . RacerResultStatus::ofVal($result_status)->shortCode() . ')';
			}
		}
		
		return $exp;
	}
}
