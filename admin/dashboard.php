<?php

/*
 * ========================================================================
 * Copyright (C) 2010 Traullé Jean
 *
 * This file is part of Gnote.
 *
 * Gnote is free software; you can redistribute it and/or modify
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
 * with Gnote. If not, see <http://www.gnu.org/licenses/>
 * ========================================================================
 */

require_once("../core/init.php");

if (isset ($_SESSION['pseudo']))
{
	if ($_SESSION['pseudo'] = 'admin')
	{
		printHead('Tableau de bord administrateur', 'auth', 'ifconnectfail', $dbprefixe);

		/* LA SUITE DE LA PAGE ADMIN ICI */

		printFooter();
	}
	else
	{
		header('Refresh: 0; url=auth.php');
		exit();
	}
}
else
	{
		header('Refresh: 0; url=auth.php');
		exit();
	}
?>
