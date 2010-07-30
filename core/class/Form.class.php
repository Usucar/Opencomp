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

class Form
{

    private $echo;
    private $errors = 0;
    private $securedata;

    /**
     * Cette méthode permet d'instancier le formulaire
     * 
     * @param void $chemin Chemin de traitement du formulaire
     */
    public function __construct($chemin)
    {
	if (!isset ($chemin))
        {
            echo '<form method="post" action="'.htmlentities($_SERVER['PHP_SELF']).'">';
        }
        else
        {
            echo '<form method="post" action="'.$chemin.'">';
        }
        
    }



    /**
     * Cette méthode permet de créer un champ de type input text et de le vérifier
     * 
     * @param string $field Nom du champ
     * @param string $label Nom du label (optionel)
     * @param string $type Type du champ à choisir parmi 'alpha','alpha_avec_accent', 'numerique'
     * @param string $javascript Permet de sépcifier du code javascript pour une vérification de saisie ou d'appeller une fonction javascript préalablement définie dans la head
     * @param string value Permet de préremplir le champ avec une valeur.
     * @param int $longueur_mini Longueur minimale de la chaîne de caractères
     * @param int $longueur_maxi Longueur maximale de la chaîne de caractères
     */
    public function input_text($field,$label,$type,$javascript,$value,$longueur_mini,$longueur_maxi)
    {
        if (isset($_POST['submit']))
	{
            switch ($type)
            {
                case 'alpha':

		if (!preg_match('#^[[:alpha:]]{'.$longueur_mini.','.$longueur_maxi.'}$#', $_POST['data_'.$field]))
		{
                    if(!empty ($label))
                    {
                        $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
                    }

                    $this->echo[] = '<input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" ';

                    if(!empty ($javascript))
                    {
                        $this->echo[] .= $javascript;
                    }

                    $this->echo[] .= ' />';

		    $this->echo[] = '<span class="tooltip"><img src="../style/img/error.png" style="vertical-align:-18%;" /> <em><span></span>Vous devez saisir une chaine alphabétique sans accent d\'une longueur minimale de '.$longueur_mini.' caractère(s) !</em></span><br />';

                    $this->errors++;
		}

		else
		{
                    if(!empty ($label))
                    {
                        $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
                    }

                    $this->echo[] = '<input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" ';

                    if(!empty ($javascript))
                    {
                        $this->echo[] .= $javascript;
                    }

                    $this->echo[] .= ' /><br />';

                    $this->securedata[$field] = $_POST['data_'.$field];
		}

		break;

                case 'alpha_avec_accent':

		if (!preg_match('#^[a-zA-ZâêôûÄéÇàèÉÈÊùÌÍÎÏîÒÓÔÕÖÙÚÛÜàáâãäçèéêëìíîïñòóôõöùúûü]{'.$longueur_mini.','.$longueur_maxi.'}$#', $_POST['data_'.$field]))
		{
                    if(!empty ($label))
                    {
                        $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
                    }
                                    
                    $this->echo[] = '<input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" ';

                    if(!empty ($javascript))
                    {
                        $this->echo[] .= $javascript;
                    }

                    $this->echo[] .= ' />';

                    $this->echo[] = '<span class="tooltip"><img src="../style/img/error.png" style="vertical-align:-18%;" /> <em><span></span>Vous devez saisir une chaine alphabétique d\'une longueur minimale de '.$longueur_mini.' caractère(s) !</em></span><br />';

                    $this->errors++;
		}

		else
		{
                    if(!empty ($label))
                    {
                        $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
                    }

                    $this->echo[] = '<input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" ';

                    if(!empty ($javascript))
                    {
                        $this->echo[] .= $javascript;
                    }

                    $this->echo[] .= ' /><br />';

                    $this->securedata[$field] = $_POST['data_'.$field];
		}

		break;

                case 'numerique':

		if (!preg_match('#^[[:digit:]]{'.$longueur_mini.','.$longueur_maxi.'}$#', $_POST['data_'.$field]))
		{
                    if(!empty ($label))
                    {
                        $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
                    }
                                    
                    $this->echo[] = '<input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" ';

                    if(!empty ($javascript))
                    {
                        $this->echo[] .= $javascript;
                    }

                    $this->echo[] .= ' />';

                    $this->echo[] = '<span class="tooltip"><img src="../style/img/error.png" style="vertical-align:-18%;" /> <em><span></span>Vous devez saisir une chaine numérique d\'une longueur minimale de '.$longueur_mini.' caractère(s) !</em></span><br />';

                    $this->errors++;
		}

		else
		{
                    if(!empty ($label))
                    {
                        $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
                    }
                                        
                    $this->echo[] = '<input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" ';

                    if(!empty ($javascript))
                    {
                        $this->echo[] .= $javascript;
                    }

                    $this->echo[] .= ' /><br />';

                    $this->securedata[$field] = $_POST['data_'.$field];
		}

		break;

                case 'email':

		if (!preg_match('#^[a-zA-Z0-9\+._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $_POST['data_'.$field]))
		{
                    if(!empty ($label))
                    {
                        $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
                    }

                    $this->echo[] = '<input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" ';

                    if(!empty ($javascript))
                    {
                        $this->echo[] .= $javascript;
                    }

                    $this->echo[] .= ' />';

                    $this->echo[] = '<span class="tooltip"><img src="../style/img/error.png" style="vertical-align:-18%;" /> <em><span></span>Vous devez saisir une adresse email valide !</em></span><br />';

                    $this->errors++;
		}

		else
		{
                    if(!empty ($label))
                    {
                        $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
                    }

                    $this->echo[] = '<input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" ';

                    if(!empty ($javascript))
                    {
                        $this->echo[] .= $javascript;
                    }

                    $this->echo[] .= ' /><br />';

                    $this->securedata[$field] = $_POST['data_'.$field];
		}

		break;

                case 'password':

		if (!preg_match('#^[[:alpha:]]{'.$longueur_mini.','.$longueur_maxi.'}$#', $_POST['data_'.$field]))
		{
                    if(!empty ($label))
                    {
                        $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
                    }

                    $this->echo[] = '<input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" ';

                    if(!empty ($javascript))
                    {
                        $this->echo[] .= $javascript;
                    }

                    $this->echo[] .= ' />';

                    $this->echo[] = '<span class="tooltip"><img src="../style/img/error.png" style="vertical-align:-18%;" /> <em><span></span>Vous devez saisir un mot de passe d\'une longueur minimale de '.$longueur_mini.' caractère(s) !</em></span><br />';

                    $this->errors++;
		}

		else
		{
                    if(!empty ($label))
                    {
                        $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
                    }

                    $this->echo[] = '<input type="text" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" ';

                    if(!empty ($javascript))
                    {
                        $this->echo[] .= $javascript;
                    }

                    $this->echo[] .= ' /><br />';

                    $this->securedata[$field] = $_POST['data_'.$field];
		}

		break;                                
            }
        }
	else
	{
            if(!empty ($label))
            {
                $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
            }

            $this->echo[] = '<input type="text" name="data_'.$field.'" id="form_'.$field.'" ';

            if(!empty ($value))
            {
                $this->echo[] .= 'value="' . $value . '" ';
            }

             if(!empty ($javascript))
            {
                $this->echo[] .= $javascript;
            }

            $this->echo[] .= ' /><br />';
        }
    }

    /**
     * Cette méthode permet de créer un champ de type input password et de le vérifier
     *
     * @param string $field Nom du champ
     * @param string $label Nom du label (optionel)
     * @param int $longueur_mini Longueur minimale de la chaîne de caractères
     * @param int $longueur_maxi Longueur maximale de la chaîne de caractères
     */
    public function input_password($field,$label,$longueur_mini,$longueur_maxi)
    {
        if (isset($_POST['submit']))
	{
            if (!preg_match('#^[[:graph:]]{'.$longueur_mini.','.$longueur_maxi.'}$#', $_POST['data_'.$field]))
            {
                if(!empty ($label))
                {
                    $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
                }

                $this->echo[] = '<input type="password" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" />';
                $this->echo[] = '<span class="tooltip"><img src="../style/img/error.png" style="vertical-align:-18%;" /> <em><span></span>Vous devez saisir une chaine alphabétique sans accent d\'une longueur minimale de '.$longueur_mini.' caractère(s) !</em></span><br />';

                $this->errors++;
            }

            else
            {
                if(!empty ($label))
                {
                    $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
                }

                $this->echo[] = '<input type="password" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" /><br />';
            }
        }
	else
	{
            if(!empty ($label))
            {
                $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
            }

            $this->echo[] = '<input type="password" name="data_'.$field.'" id="form_'.$field.'" /><br />';
        }
    }

    /**
     * Cette méthode permet de créer un champ de type input password permettant de vérifier la correspondance avec un autre champ
     *
     * @param string $field Nom du champ
     * @param string $label Nom du label (optionel)
     * @param string $matchwith Nom du champ avec lequel ce champs doit correspondre
     */
    public function verification_input_password($field,$label,$matchwith)
    {
        if (isset($_POST['submit']))
	{
            
                if ($_POST['data_'.$field] != $_POST['data_'.$matchwith])
                {
                        if(!empty ($label))
                        {
                            $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
                        }

                        $this->echo[] = '<input type="password" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" />';
                        $this->echo[] = '<span class="tooltip"><img src="../style/img/error.png" style="vertical-align:-18%;" /> <em><span></span>Ce champ ne correspond pas avec le champ précédent !</em></span><br />';

                        $this->errors++;
                }

                else
                {
                    if(!empty ($label))
                    {
                        $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
                    }

                    $this->echo[] = '<input type="password" name="data_'.$field.'" id="form_'.$field.'" value="'.$_POST['data_'.$field].'" /><br />';
                }
            
        }
        else
	{
            if(!empty ($label))
            {
                $this->echo[] = '<label for="form_'.$field.'" >'.$label.'</label>';
            }

            $this->echo[] = '<input type="password" name="data_'.$field.'" id="form_'.$field.'" /><br />';
        }
    }


    /**
     * Cette méthode permet de savoir si des erreurs ont été rencontrés lors de la validation du formulaire.
     *
     * @return bool
     */
    public function iserrors()
    {
        if ($this->errors != 0)
	{
            return true;
	}
    }

    /**
     * Cette méthode permet d'obtenir les valeurs envoyées dans les champs de formulaires après les avoir sécurisé.
     *
     * @return mixed
     */
    public function getsecuredata($field)
    {
        if (isset ($this->securedata[$field]))
        {
            return htmlspecialchars($this->securedata[$field]);
        }
    }

    /**
     * Cette méthode permet d'afficher le bouton submit et de clore le formulaire en fermant la balise <form>
     *
     * @param string $value Valeur du bouton submit
     */
    public function submit($value)
    {
	$this->echo[] = '<input type="submit" name="submit" id="submit" value="'.$value.'" /></form>';
    }


    /**
     * Cette méthode permet d'afficher le formulaire après avoir vérifié si celui ci comportait des erreurs dans le cas ou le formulaire aurait déjà été envoyé.
     * Si c'est le cas, on affiche une alerte avant d'afficher le formulaire !
     */
    public function afficher_formulaire()
    {
        //On vérifie d'abord si il y a eu des erreurs dans le cas ou le formulaire aurait déjà été envoyé.
        //Si c'est le cas, on affiche une alerte
        if ($this->iserrors())
        {
            echo '<ul style="margin-bottom:10px; padding:0px;"><li class="error" id="error">Des erreurs ont été détectées lors de la validation des données saisies dans le formulaire !</li></ul>';

            ?>

            <script type='text/javascript'>

            window.setTimeout(function()
            {
                new Effect.Highlight('error', { startcolor: '#FFFFFF', endcolor: '#FFBDBD', restorecolor: '#FFE7E7',keepBackgroundImage: 'true' });
            }, 200);

            window.setTimeout(function()
            {
                new Effect.Fade('error');
            }, 10000);

            </script>

            <?php
        }

        //Puis on affiche la vue stockée dans la variable echo à l'utilisateur
         foreach ($this->echo as $retour)
         {
            echo $retour;
         }
    }

}