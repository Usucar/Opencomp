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
	include ("../configs.php");
	include ("../commons.php");
	$fp = fopen("../hack.log","a");
	$hacklog = date('D j d Y; G:i:s')."  FROM  IP: ".$_SERVER['REMOTE_ADDR']." WITH : ".$_SERVER['HTTP_USER_AGENT']."\nURL : Gnote/img/\n";
	fputs($fp,$hacklog);
	fclose($fp);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
	<head>
		<title>Backdoor - Gnote alpha 1</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	</head>
	<body>
		<h3>Coin !!!</h3>
		<h6><em>ps : ton ip (<?php echo $_SERVER['REMOTE_ADRR']?>) sera enregistr&eacute;e et associ&eacute;e aux requ&ecirc;tes que tu effectueras et la CIA, le NSA, le FBI ainsi que le KGB sonneront &agrave; ta porte d'ici 3 minutes :p</em></h6>
	</body>
</html>
