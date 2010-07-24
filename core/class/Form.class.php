<?php

class Form
{	
	private $data;
	private $errors = 0;
	private $tabaccessid;
	
	public function __construct()
	{		
		echo '<form method="post" action="'.htmlentities($_SERVER['PHP_SELF']).'">';
	}


	
	/*  Cette fonction permet de créer un champ de type input text
	 *
	 *  Elle prend pour paramètre $field qui servira pour l'id et le name du champ
	 *  $lablel permet de définir le label du champ input text
	 *  $type permet de choisir le type de validation souhaité. 
	 */
	public function input($field,$label,$type)
	{			
		if (isset($_POST['submit']))
		{
			switch ($type)
			{
				case 'alpha':
				
				if (!preg_match("#^[a-zA-ZâêôûÄéÇàèÊùÌÍÎÏîÒÓÔÕÖÙÚÛÜàáâãäçèéêëìíîïñòóôõöùúûü]{1,}$#", htmlspecialchars($_POST['data_'.$field])))
				{
					$return = '<label for="form_'.$field.'" >'.$label.'</label><input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" /><br />';
					echo $return;					
					echo 'Vous devez saisir une chaine alphabétique<br /><br />';
					
					$this->errors++;
					echo 'Il y a maintenant un total de '.$this->errors.' erreur(s) pour ce formulaire<br /><br /> ';
				}
				
				else
				{
					$return = '<label for="form_'.$field.'" >'.$label.'</label><input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" /><br />';
					echo $return;
				}
							
				break;
			}
		}
		else
		{
			$return = '<label for="form_'.$field.'" >'.$label.'</label><input type="text" name="data_'.$field.'" id="form_'.$field.'" /><br />';
			echo $return;
		}		
	}
	
	public function geterrors()
	{
		return $this->errors;
	}
	
	public function submit($value)
	{
		echo '<input type="submit" name="submit" id="submit" value="'.$value.'" /></form>';
	}
}
