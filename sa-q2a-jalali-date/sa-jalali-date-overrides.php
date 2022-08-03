<?php
/*
* Sa Jalali Date Q2A Plugin
* 
* @author    https://sevlin.com/
* @copyright Copyright Ⓒ 2020 sevlin.com <@email:support@sevlin.com>
* @license   You only can use module, nothing more!
*/

function sa_div($a,$b) 
{
	return (int) ($a / $b);
}

function gregorian_to_jalaliq2a ($timestamp)
{
	$timestamp = (int) $timestamp;
	@list($g_y, $g_m, $g_d) = explode(',',date("Y,m,d",$timestamp));	
	$g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	$j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);


	$gy = $g_y-1600;
	$gm = $g_m-1;
	$gd = $g_d-1;

	$g_day_no = 365*$gy+sa_div($gy+3,4)-sa_div($gy+99,100)+sa_div($gy+399,400);

	for ($i=0; $i < $gm; ++$i)
		$g_day_no += $g_days_in_month[$i];
		if ($gm>1 && (($gy%4==0 && $gy%100!=0) || ($gy%400==0)))
		/* leap and after Feb */
			$g_day_no++;
			$g_day_no += $gd;

			$j_day_no = $g_day_no-79;

			$j_np = sa_div($j_day_no, 12053); /* 12053 = 365*33 + 32/4 */
			$j_day_no = $j_day_no % 12053;

		$jy = 979+33*$j_np+4*sa_div($j_day_no,1461); /* 1461 = 365*4 + 4/4 */

		$j_day_no %= 1461;

		if ($j_day_no >= 366) {
				$jy += sa_div($j_day_no-1, 365);
				$j_day_no = ($j_day_no-1)%365;
		}

		for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; $i++)
			$j_day_no -= $j_days_in_month[$i];
		$jm = $i+1;
		$jd = $j_day_no+1;

return array($jy, $jm, $jd);
}
// copyright sevlin.com

	function qa_when_to_html($timestamp, $fulldatedays)
/*
	Return array of split HTML (prefix, data, suffix) to represent unix $timestamp, with the full date shown if it's
	more than $fulldatedays ago
*/
	{
		$monthes= array('1'=>'فروردین',
				'2'=>'اردیبهشت',
				'3'=>'خرداد',
				'4'=>'تیر',
				'5'=>'مرداد',
				'6'=>'شهریور',
				'7'=>'مهر',
				'8'=>'آبان',
				'9'=>'آذر',
				'10'=>'دی',
				'11'=>'بهمن',
				'12'=>'اسفند');
					
		$interval=qa_opt('db_time')-$timestamp;
		
		if ( ($interval<0) || (isset($fulldatedays) && ($interval>(86400*$fulldatedays))) ) { // full style date
			$stampyear=date('Y', $timestamp);
			$thisyear=date('Y', qa_opt('db_time'));
			list($year,$month,$day)=gregorian_to_jalaliq2a($timestamp);
			return array(
				'data' => qa_html(strtr(qa_lang(($stampyear==$thisyear) ? 'main/date_format_this_year' : 'main/date_format_other_years'), array(
					'^day' =>$day ,//date((qa_lang('main/date_day_min_digits')==2) ? 'd' : 'j', $timestamp),
					'^month' => $monthes[$month],//qa_lang('main/date_month_'.date('n', $timestamp)),
					'^year' => ((qa_lang('main/date_year_digits')==2) ? substr($year,2,4) : $year),
				))),
			);

		} else // ago-style date
			return qa_lang_html_sub_split('main/x_ago', qa_html(qa_time_to_string($interval)));
	}

?>
