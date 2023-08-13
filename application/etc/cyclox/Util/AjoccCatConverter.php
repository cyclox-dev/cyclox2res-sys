<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * C1 --> ME1 といったカテゴリー名称の変更を担当するクラス
 *
 * @author shun
 */
class AjoccCatConverter {
	
	/**
	 * カテゴリー名称を変更する
	 * @param string $cat_code カテゴリーコード／レースカテゴリーコード
	 * @param date $date 形式は Y-m-d。カテゴリー名称を使用する日時。2023-04-01以降とそれより前で分かれる。未指定の場合は現在日時で判定される。
	 * @return string 新しいカテゴリー名
	 */
	public static function convert($cat_code, $date = false)
	{
		$format = 'Y-m-d';
		
		if ($date === false) {
			$date = date($format);
		} else {
			if (self::_validateDate($date, $format)) {
				$d = DateTime::createFromFormat($format, $date);
				$date = $d->format($format); // 一応変換し直し
			} else {
				$date = date($format);
			}
		}
		
		if ($date < '2023-04-01') {
			return $cat_code;
		}
		
		$new_name = '';
		$cat_names = explode("+", $cat_code);
		
		foreach ($cat_names as $cn)
		{
			if (! empty($new_name)) {
				$new_name .= '+';
			}
			
			$new_name .= self::_convert($cn);
		}
		
		return $new_name;
	}
	
	private static function _convert($cat_name)
	{
		$map = [
			'C1' => 'ME1',
			'C2' => 'ME2',
			'C3' => 'ME3',
			'C4' => 'ME4',
			
			'CM1' => 'MM1',
			'CM2' => 'MM2',
			'CM3' => 'MM3',
			'CM4' => 'MM4',
			
			'CL1' => 'WE1',
			'CL2' => 'WE2',
			'CL3' => 'WE3',
			
			'CJ' => 'MJ',
		];
		
		if (! array_key_exists($cat_name, $map)) {
			return $cat_name;
		}
		
		return $map[$cat_name];
	}
	
	private static function _validateDate($date, $format = 'Y-m-d')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}

}
