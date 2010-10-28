<?php

class ItemsController extends AppController
{

        // Appel du Helper Tree
	var $helpers = array ('Tree');

	function edit($id = null)
        {
                $this->set('title_for_layout', 'Ajouter une compétence');
                
                if(isset($this->data))
                {
                  $this->Item->set($this->data);
                  $this->Item->save();
                  $this->redirect(array('action' => 'edit'));
                }

                $this->data = $this->Item->read(null, $id);

                // Passage de la liste à la Vue :
		$this->set('competences', $this->Item->Competence->generatetreelist());

	}

}
