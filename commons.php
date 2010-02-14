<?php
/*
 * ========================================================================
 * Copyright (C) 2008 Sadaoui Akim
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 * ========================================================================
 */
	include ("configs.php");
	include ("define.php");

	function printMsg($title, $msg, $redirMsg, $redirLink, $redirTime = 2)
	{
		header('Refresh: '.$redirTime.';URL='.$redirLink);
		printHead($title, $menu = 0);
?>
			<div id="msgBox">
<?php echo "\t\t\t\t<span id=\"msg\">$msg</span><br />\n\t\t\t\t<span id=\"redirMsg\">$redirMsg</span>\n\t\t\t\t<span id=\"redirNow\"><a href=\"$redirLink\">Ne pas attendre</a></span>";?>
			</div>
		</div>
	<body>
</html>
<?php
		ob_end_flush();
		exit;
	}

	function printHead($title, $menu = 1)
	{
		ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
	<head>
		<title><?php echo $title?> - Gnote <?php echo VERSION?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link rel="stylesheet" media="screen" type="text/css" title="Design" href="design.css" />
		<link rel="icon" type="image/png" href="img/Gnote.png" />
	</head>
	<body>
<?php
		if($menu)
		{
			include ("configs.php");
			include("menu.php");
		}
	}

	function query($sql_query)
	{
		include ("configs.php");
		$db = mysql_connect($db_host,$db_login,$db_pwd);
		mysql_select_db($db_name,$db);
		$fp = fopen("error.log","a");
		$rep = mysql_query($sql_query)or die(fputs($fp,date('D j d Y; G:i:s')." FROM IP: ".$_SERVER['REMOTE_ADDR']."\nSQL : ".$sql_query."\nErro : ".mysql_error())."\n\n");
		mysql_close($db);
		return $rep;
	}

	function queryAndLog($sql_query)
	{
		include ("configs.php");
		$db = mysql_connect($db_host,$db_login,$db_pwd);
		mysql_select_db($db_name,$db);
		$fp = fopen("sql.log","a");
		$fp2 = fopen("error.log","a");
		mysql_query($sql_query)or die(fputs($fp2,"\n\n".date('D j d Y; G:i:s')." FROM IP: ".$_SERVER['REMOTE_ADDR']."\nSQL : ".$sql_query."\nErro : ".mysql_error())."\n\n");
		$sqllog = date('D j d Y; G:i:s')."  FROM  IP: ".$_SERVER['REMOTE_ADDR']."\nSQL : ".$sql_query."\n";
		fputs($fp,$sqllog);
		fclose($fp2);
		fclose($fp);
		global $last_insert_id;
		$last_insert_id = mysql_insert_id();
		mysql_close($db);
	}

	function format($var)
	{
		return substr(addslashes(htmlentities(trim($var))),0,50);
	}

	function formatnospec($string)
	{
		$string = strtr($string,
		"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",
		"AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn");
		$string = str_replace (" ","_",$string);
		$string = str_replace ("@","_at_",$string);
		$string = str_replace ("#","_diese_",$string);
		$string = str_replace ("&","_and_",$string);
		$string = str_replace ("²","_carre_",$string);
		$string = str_replace ("~","_tilde_",$string);
		$string = str_replace ("\"","_dguill_",$string);
		$string = str_replace ("'","_guill_",$string);
		$string = str_replace ("{","_accoo_",$string);
		$string = str_replace ("}","_accof_",$string);
		$string = str_replace ("(","_paro_",$string);
		$string = str_replace (")","_parf_",$string);
		$string = str_replace ("[","_croco_",$string);
		$string = str_replace ("]","_crocf_",$string);
		$string = str_replace ("-","_moin_",$string);
		$string = str_replace ("+","_plus_",$string);
		$string = str_replace ("=","_egal_",$string);
		$string = str_replace ("*","_star_",$string);
		$string = str_replace ("|","_OR_",$string);
		$string = str_replace ("`","_sguill_",$string);
		$string = str_replace ("\\","_ifrac_",$string);
		$string = str_replace ("/","_frac_",$string);
		$string = str_replace ("^","_chap_",$string);
		$string = str_replace ("°","_num_",$string);
		$string = str_replace ("µ","_mu_",$string);
		$string = str_replace ("¨","_trem_",$string);
		$string = str_replace (",","_vir_",$string);
		$string = str_replace ("?","_int_",$string);
		$string = str_replace (";","_pvir_",$string);
		$string = str_replace (".","_dot_",$string);
		$string = str_replace (":","_ddot_",$string);
		$string = str_replace ("!","_exc_",$string);
		$string = str_replace ("§","_zarb_",$string);
		$string = str_replace ("%","_pourc_",$string);
		$string = str_replace ("$","_dol_",$string);
		$string = str_replace ("£","_liv_",$string);
		$string = str_replace ("¤","_sun_",$string);
		$string = str_replace ("<","_inf_",$string);
		$string = str_replace (">","_sup_",$string);
		return $string;
	};
?>
