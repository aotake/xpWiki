<?php
class xpwiki_plugin_calendar extends xpwiki_plugin {
	function plugin_calendar_init () {



	}
	// $Id: calendar.inc.php,v 1.3 2007/09/19 11:27:15 nao-pon Exp $
	// Copyright (C)
	//   2002-2003,2005 PukiWiki Developers Team
	//   2001-2002 Originally written by yu-ji
	// License: GPL v2 or (at your option) any later version
	//
	// Calendar plugin
	
	function plugin_calendar_convert()
	{
	//	global $script, $weeklabels, $vars, $command;
	
		$args     = func_get_args();
		$date_str = $this->func->get_date('Ym');
		$page     = '';
	
		if (func_num_args() == 1) {
			if (is_numeric($args[0]) && strlen($args[0]) == 6) {
				$date_str = $args[0];
			} else {
				$page     = $args[0];
			}
		} else if (func_num_args() == 2) {
			if (is_numeric($args[0]) && strlen($args[0]) == 6) {
				$date_str = $args[0];
				$page     = $args[1];
			} else if (is_numeric($args[1]) && strlen($args[1]) == 6) {
				$date_str = $args[1];
				$page     = $args[0];
			}
		}
	
		if ($page === '') {
			$page = $this->root->vars['page'];
		} else if (! $this->func->is_pagename($page)) {
			return FALSE;
		}
		
		$this->func->add_tag_head('calendar.css');
		
		$pre    = $page;
		$prefix = $page . '/';
	
	
		if (! $this->root->command) {
			$cmd = 'read';
		} else {
			$cmd = $this->root->command;
		}
	
		$prefix = strip_tags($prefix);
	
		$yr  = substr($date_str, 0, 4);
		$mon = substr($date_str, 4, 2);
		if ($yr != $this->func->get_date('Y') || $mon != $this->func->get_date('m')) {
			$now_day = 1;
			$other_month = 1;
		} else {
			$now_day     = $this->func->get_date('d');
			$other_month = 0;
		}
		$today = getdate(mktime(0, 0, 0, $mon, $now_day, $yr) - $this->cont['LOCALZONE'] + $this->cont['ZONETIME']);
	
		$m_num = $today['mon'];
		$d_num = $today['mday'];
		$year  = $today['year'];
		$f_today = getdate(mktime(0, 0, 0, $m_num, 1, $year) - $this->cont['LOCALZONE'] + $this->cont['ZONETIME']);
		$wday  = $f_today['wday'];
		$day   = 1;
	
		$m_name = $year . '.' . $m_num . ' (' . $cmd . ')';
	
		$prefix_url = rawurlencode($this->func->is_pagename($pre) ? $pre : '[[' . $pre . ']]');
		$pre = $this->func->strip_bracket($pre);
	
		$ret = <<<EOD
<table class="style_calendar" cellspacing="1" width="150" border="0">
 <tr>
  <td class="style_td_caltop" colspan="7">
   <strong>$m_name</strong><br />
   [<a href="{$this->root->script}?$prefix_url">$pre</a>]
  </td>
 </tr>
 <tr>
EOD;
	
		foreach($this->root->weeklabels as $label)
			$ret .= '  <td class="style_td_week"><strong>' .
			$label . '</strong></td>' . "\n";
	
		$ret .= ' </tr>' . "\n" .
		' <tr>'  . "\n";
	
		// Blank
		for ($i = 0; $i < $wday; $i++)
			$ret .= '    <td class="style_td_blank">&nbsp;</td>' . "\n";
	
		while(checkdate($m_num, $day, $year)) {
			$dt     = sprintf('%04d%02d%02d', $year, $m_num, $day);
			$name   = $prefix . $dt;
			$r_page = rawurlencode($name);
			$s_page = htmlspecialchars($name);
	
			$refer = ($cmd == 'edit') ? '&amp;refer=' . rawurlencode($page) : '';
	
			if ($cmd == 'read' && ! $this->func->is_page($name)) {
				$link = '<strong>' . $day . '</strong>';
			} else {
				$link = '<a href="' . $this->root->script . '?cmd=' . $cmd .
				'&amp;page=' . $r_page . $refer . '" title="' .
				$s_page . '"><strong>' . $day . '</strong></a>';
			}
	
			if ($wday == 0 && $day > 1) {
				$ret .= '  </tr><tr>' . "\n";
			}
			if (! $other_month && ($day == $today['mday']) &&
				($m_num == $today['mon']) && ($year == $today['year']))
			{
				//  Today
				$ret .= '    <td class="style_td_today"><span class="small">' .
				$link . '</span></td>' . "\n";
			} else if ($wday == 0) {
				//  Sunday
				$ret .= '    <td class="style_td_sun"><span class="small">' .
				$link . '</span></td>' . "\n";
			} else if ($wday == 6) {
				//  Saturday
				$ret .= '    <td class="style_td_sat"><span class="small">' .
				$link . '</span></td>' . "\n";
			} else {
				// Weekday
				$ret .= '    <td class="style_td_day"><span class="small">' .
				$link . '</span></td>' . "\n";
			}
			++$day;
			++$wday;
			$wday = $wday % 7;
		}
	
		if ($wday > 0) {
			while($wday < 7){
				// Blank
				$ret .= '    <td class="style_td_blank">&nbsp;</td>' . "\n";
				++$wday;
			}
		}
	
		$ret .= '  </tr>'  . "\n" .
		'</table>' . "\n";
	
		return $ret;
	}
}
?>