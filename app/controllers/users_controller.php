<?php

class UsersController extends AppController{
	
    var $name = 'Users';

    var $paginate = array(
        'User' => array(
            'limit' => 10,
            'order' => array(
                'User.nom' => 'Asc'
            )
        )
    );

    function index()
    {
        $q = $this->paginate('User');
        $this->set('listedesutilisateurs', $q);
    }

    function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('login');
    }

    //Fonction permettant d'éditer
    function edit($id = null)
    {

        // Si le formulaire n'a pas été rempli on tente de le préremplir avec l'id fourni dans le champ hidden
        if (empty($this->data))
        {
            $this->User->id = $id;
            $this->data = $this->User->read();
        }
        else
        {
            // Si le formulaire est rempli, on sauve les données si elles sont valides, et on affiche une
            // confirmation, sinon, on affiche un avertissement invitant les personnes à corriger leur saisie.
            if ($this->User->save($this->data))
            {
                if (!empty($this->data['User']['id']))
                {
                    $this->Session->setFlash('L\'utilisateur a été édité avec succès !');
                    $this->redirect('index');
                }
                else
                {
                    $this->Session->setFlash('L\'utilisateur a été ajouté avec succès !');
                    $this->redirect('index');
                }
            }
            else
            {
                $this->Session->setFlash('Corrigez les erreurs mentionnées');
            }

        }
    }

    function delete ($id)
    {
        $utilisateur = $this->User->findById($id);
        $nb_admin = $this->User->find('count', array('conditions' => array('User.role' => 'admin')));
        
        if ($utilisateur['User']['role'] == 'admin' && $nb_admin == 1)
        {
            $this->Session->setFlash('Vous devez conserver au moins un administrateur pour gérer les utilisateurs !');
            $this->redirect('index');
        }
        else
        {
            $this->User->delete($id);
            $this->Session->setFlash('L\'utilisateur a été correctement supprimé !');
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
        $this->redirect(array('controller'=>'utilisateurs', 'action'=>'index'));
    }

    function logout()
    {
        $this->redirect($this->Auth->logout());
    }
}
	
?>