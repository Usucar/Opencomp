<?php
class PupilsController extends AppController {

	var $name = 'Pupils';

	function index() {
		$this->Pupil->recursive = 0;
		$this->set('pupils', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid pupil', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('pupil', $this->Pupil->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Pupil->create();
			if ($this->Pupil->save($this->data)) {
				$this->Session->setFlash(__('The pupil has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pupil could not be saved. Please, try again.', true));
			}
		}
		$classrooms = $this->Pupil->Classroom->find('list');
		$this->set(compact('classrooms'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid pupil', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Pupil->save($this->data)) {
				$this->Session->setFlash(__('The pupil has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pupil could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Pupil->read(null, $id);
		}
		$classrooms = $this->Pupil->Classroom->find('list');
		$this->set(compact('classrooms'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for pupil', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Pupil->delete($id)) {
			$this->Session->setFlash(__('Pupil deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Pupil was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>