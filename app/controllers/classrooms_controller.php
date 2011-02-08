<?php
class ClassroomsController extends AppController {

	var $name = 'Classrooms';

	function index() {
		$this->Classroom->recursive = 0;
                $this->set('title_for_layout', 'Liste des classes');
		$this->set('classrooms', $this->paginate());
	}

	function view($id = null) {
            $this->set('title_for_layout', 'Affichage d\'une classe');
		if (!$id) {
			$this->Session->setFlash(__('Invalid classroom', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('classroom', $this->Classroom->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Classroom->create();
			if ($this->Classroom->save($this->data)) {
				$this->Session->setFlash('The classroom has been saved', 'message_succes');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The classroom could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid classroom', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Classroom->save($this->data)) {
				$this->Session->setFlash(__('The classroom has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The classroom could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Classroom->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for classroom', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Classroom->delete($id)) {
			$this->Session->setFlash(__('Classroom deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Classroom was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>