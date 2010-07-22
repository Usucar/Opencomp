<?php

/*
 * ========================================================================
 * Copyright (C) 2010 Traullé Jean
 *
 * This file is part of Opencomp.
 *
 * Opencomp is free software; you can redistribute it and/or modify
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
 * with Opencomp. If not, see <http://www.gnu.org/licenses/>
 * ========================================================================
 */

//Initialisation de la session
session_start() ;

//Inclusions des fichiers
require_once("config.php");
require_once("func.php");

$chemin = $_SERVER['PHP_SELF'];
$fichier = explode('/', $chemin);
$fichier = array_pop($fichier);

if ($fichier == 'auth.php')
{
	require_once("core/localization.php");
}
else
{
	require_once("../core/localization.php");
}

class myPDO extends PDO 
{
	
	protected $count 		= 0; 
	protected $racine; 
	protected $memoryQuery	= array();
	protected $time			= 0;

	// GETTER
	
	public function count()    			{ return $this->count; }
	public function memoryQuery()     	{ return $this->memoryQuery; }
	public function time()     			{ return $this->time; }
 
	public function increment() 
	{ 
		$this->count ++; 
	}
	public function addQuery($query, $time=0)
	{	
		$this->memoryQuery[$this->count()]['query'] = $query;
		$this->memoryQuery[$this->count()]['time'] = $time;
	}
	public function addTime($time)
	{	
		$this->time += $time;
	}
 
	function __construct($dsn, $username="", $password="", $driver_options=array()) 
	{
		parent::__construct($dsn,$username,$password, $driver_options);
		
		// Utilisation de myPDOStatement 
		$this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('myPDOStatement', array($this)));		
	}
	
	public function query($query) 
	{
		
		$tmpTemps = microtime(true);  
		$return = parent::query($query);
		$addTime = round(microtime(true) - $tmpTemps,5);


		$this->addQuery($query,$addTime);
		$this->addTime($addTime);
		$this->increment();
		
		return $return;
	}
	
	public function exec($query) 
	{

		$tmpTemps = microtime(true);  
		$return = parent::exec($query);
		$addTime = round(microtime(true) - $tmpTemps,5);
		
		$this->addQuery($query,$addTime);
		$this->addTime($addTime);
		$this->increment();
		
		return $return;
	}
 
}

class myPDOStatement extends PDOStatement 
{
 
    protected $pdo;
    
    public function count() { return $this->pdo->count(); }
    
    
    protected function __construct($_pdo) 
    {
        $this->pdo = $_pdo;
    }
 
    
    public function execute($input = array ()) 
    {
		$tmpTemps = microtime(true);  
		$return = parent::execute($input);
		$addTime = round(microtime(true) - $tmpTemps, 5);

		$this->pdo->increment();
        $this->pdo->addQuery($this->queryString, $addTime);
		$this->pdo->addTime($addTime);
		
		return $return;
    }
 
}


//Connexion sql
try 
{
	$bdd = new myPDO(DSN1, USER1, PASS1);
	$bdd->exec('SET CHARACTER SET utf8');
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
	print "Erreur ! : " . $e->getMessage() . "<br />";
	die();
}

/*
@mysql_connect($dbhote, $dbuser, $dbpass) or die('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" ><head><title>Identifiez vous...</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><link type="text/css" href="style/style.css" rel="stylesheet" /></head><body class="identification"><form method="post" action="auth.php" class="identification"><div class="top_msg_error"><p class="icon_error">Oups ... erreur critique</p></div><div class="contenuform"><p class="infoform">Il est impossible de se connecter à la base de données.<br /><br />Vous pouvez tenter de rafraichir la page.<br /><br />Si le problème persiste, vous avez la possibilité de contacter l\'administrateur de l\'application Opencomp.</p></div><p class="bottomform"><input type="button" value="Actualiser" ONCLICK="location.reload()"></p></form></body></html>' ); // Connexion à MySQL

@mysql_select_db($dbbase); // Sélection de la base


//Uniquement à partir de PHP 5.2.3
//mysql_set_charset('utf8');
mysql_query("set names 'utf8';"); //Définition de l'utf8 comme jeu de caractères
*/
?>
