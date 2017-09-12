<?php

require_once(APPPATH . 'etc/cyclox/Const/RacerResultStatus.php');
require_once(APPPATH . 'etc/cyclox/Const/RacerEntryStatus.php');

/**
 * Corss system 用 Util クラス
 *
 * @author shun
 */
class Xsys_util {
	
	/**
	 * リザルト表現（順位や DNF など）を返す
	 * @param int $rank 順位
	 * @param int $result_status RacerResultStatus の val 値
	 * @param int $entry_status RacerEntryStatus の val 値
	 * @return string リザルト表現
	 */
	public static function rank_express($rank, $result_status, $entry_status)
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
		
		if ($entry_status == RacerEntryStatus::$OPEN->val())
		{
			$exp .= '/OPEN';
		}
		
		return $exp;
	}
}
