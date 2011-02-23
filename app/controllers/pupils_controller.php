<?php
class PupilsController extends AppController {

	var $name = 'Pupils';

	function index() 
        {
            $this->Pupil->recursive = 0;
            $this->set('title_for_layout', 'Liste des élèves');
            $this->set('pupils', $this->paginate());
	}

	function view($id = null) 
        {            
            $this->set('title_for_layout', 'Consultation d\'un élève');
            if (!$id) 
            {
                $this->Session->setFlash(__('Invalid pupil', true));
                $this->redirect(array('action' => 'index'));
            }
            $this->set('pupil', $this->Pupil->read(null, $id));
	}

	function add() 
        {
                $this->set('title_for_layout', 'Ajouter un élève');
		if (!empty($this->data)) 
                {
			$this->Pupil->create();
			if ($this->Pupil->save($this->data)) 
                        {
                            $this->Session->setFlash('L\'élève a été ajouté', 'message_succes');
                            $this->redirect(array('action' => 'index'));
			} 
                        else 
                        {
                            $this->Session->setFlash('L\'élève n\'a pas été ajouté en raison d\'une erreur interne', 'message_erreur');
			}
		}
		$classrooms = $this->Pupil->Classroom->find('list');
		$this->set(compact('classrooms'));
	}

	function edit($id = null)
        {
                $this->set('title_for_layout', 'Editer un élève');
		if (!$id && empty($this->data))
                {
                    $this->Session->setFlash('L\'élève que vous souhaitez éditer n\'existe pas', 'message_erreur');                    $this->redirect(array('action' => 'index'));
		}
                
		if (!empty($this->data)) 
                {
                    if ($this->Pupil->save($this->data)) 
                    {
                        $this->Session->setFlash('Vos modifications ont été sauvegardées', 'message_succes');
			$this->redirect(array('action' => 'index'));
                    } 
                    else
                    {
                        $this->Session->setFlash('Vos modifications n\'ont pas été sauvegardées en raison d\'une erreur interne', 'message_erreur');
                    }
		}
		
                if (empty($this->data))
                {
                    $this->data = $this->Pupil->read(null, $id);
		}
		
                $classrooms = $this->Pupil->Classroom->find('list');
		$this->set(compact('classrooms'));
	}

	function delete($id = null) 
        {
                $this->set('title_for_layout', 'Supprimer un élève');
		if (!$id)
                {
			$this->Session->setFlash('L\'élève que vous souhaitez supprimer n\'existe pas', 'message_erreur');
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Pupil->delete($id))
                {
			$this->Session->setFlash('L\'élève a été correctement supprimé', 'message_succes');
			$this->redirect(array('action'=>'index'));
		}
		
                $this->Session->setFlash('L\'élève n\'a pas pu être supprimé en raison d\'une erreur interne', 'message_erreur');
		$this->redirect(array('action' => 'index'));
	}
}
?>