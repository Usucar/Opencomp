<?php

class UsersController extends AppController{
	
    var $name = 'Users';

    var $paginate = array(
        'User' => array(
            'limit' => 10,
            'order' => array(
                'User.nom' => 'Asc',
                'User.prenom' => 'Asc'
            )
        )
    );

    function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('login');
    }


    function index()
    {
        $this->set('title_for_layout', 'Liste des utilisateurs');
        $q = $this->paginate('User');
        $this->set('listedesutilisateurs', $q);
    }

    
    //Fonction permettant d'éditer
    function edit($id = null)
    {

        //Si le formulaire n'a pas été rempli on tente de le préremplir         
        //avec l'id fourni dans le champ hidden
        if (empty($this->data))
        {
            $this->User->id = $id;
            $this->data = $this->User->read();
			
            //Petite attention, on distingue la modification de l'ajout même
            //si une seule méthode effectue les deux opérations.
            if (!empty($this->data['User']['id']))
            {
                $this->set('title_for_layout', 'Modifier un utilisateur');
            }
            else
            {
                $this->set('title_for_layout', 'Ajouter un utilisateur');
            }

        }
        else
        {
            // Si le formulaire est rempli, on sauve les données si elles sont 
            // valides, et on affiche une confirmation, sinon, on affiche un 
            // avertissement invitant les personnes à corriger leur saisie.
            if ($this->User->save($this->data))
            {
                if (!empty($this->data['User']['id']))
                {
                    $this->Session->setFlash('L\'utilisateur a été édité avec succès !', 'message_succes');
                    $this->redirect('index');
                }
                else
                {
                    $this->Session->setFlash('L\'utilisateur a été ajouté avec succès !', 'message_succes');
                    $this->redirect('index');
                }
            }
            else
            {
                //Petite attention, on distingue la modification de l'ajout même
                //si une seule méthode effectue les deux opérations.
                if (!empty($this->data['User']['id']))
                {
                        $this->set('title_for_layout', 'Modifier un utilisateur');
                }
                else
                {
                        $this->set('title_for_layout', 'Ajouter un utilisateur');
                }
				
                $this->Session->setFlash('Corrigez les erreurs mentionnées', 'message_attention');
            }

        }
    }

    function delete ($id)
    {
        $utilisateur = $this->User->findById($id);
        $nb_admin = $this->User->find('count', array('conditions' => array('User.role' => 'admin')));
        
        if ($utilisateur['User']['role'] == 'admin' && $nb_admin == 1)
        {
            $this->Session->setFlash('Vous devez conserver au moins un administrateur pour gérer les utilisateurs !', 'message_erreur');
            $this->redirect('index');
        }
        else
        {
            $this->User->delete($id);
            $this->Session->setFlash('L\'utilisateur a été correctement supprimé !', 'message_succes');
            $this->redirect('index');
        }
        
    }

    function login()
    {
        $this->set('title_for_layout', "Authentification");
        $this->layout = 'auth';

        // On teste l'existance de $this->Auth->user(), si la variable n'est pas vide,
        // c'est que l'utilisateur est déjà connecté ; il n'a donc rien à faire sur la
        // page de login et on le redirige vers un module au choix !
        $user = $this->Auth->user();
        if (isset($user))
        $this->redirect(array('controller'=>'users', 'action'=>'index'));
    }

    function logout()
    {
        $this->redirect($this->Auth->logout());
    }
}
	
?>
