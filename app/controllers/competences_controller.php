<?php

class CompetencesController extends AppController
{
	// Appel du Helper Tree
	var $helpers = array ('Tree');

	/**
	 * Liste des catégories
	 */
	function index()
        {
                $this->set('title_for_layout', 'Référentiel de compétences');

		$this->Competence->recursive = -1;
		$categories = $this->Competence->children(false);

		$this->set(compact('categories'));

                $sql1 = $this->Competence->Item->find('list', array(
                    'fields' => array('intitule', 'type', 'competence_id'),
                    'order' => array('Item.competence_id','Item.place')
                ));
                $this->set('itemsType',$sql1);
                
                $sql2 = $this->Competence->Item->find('list', array(
                    'fields' => array('intitule', 'id', 'competence_id'),
                    'order' => array('Item.competence_id','Item.place')
                ));
                $this->set('itemsPlace',$sql2);
	}

	/**
	 * Ajout/édition d'une catégorie
	 *
	 * @param int $id Id de la catégorie
	 */
	function edit($id = null)
	{
                $title = __('Ajouter',true);

                if(!empty($this->data['Category']['id'])) {
                        $title = __('Modifier',true);
                };

                $title .= ' '.__('une catégorie au référentiel de compétences',true);

                $this->set('title_for_layout', $title);
                
		if(isset($this->data))
		{
			$this->Competence->set($this->data);

			if (!$this->Competence->validates())
			{
				$this->Session->setFlash("Corrigez les erreurs mentionnées.", 'message_attention');
				return;
			}

			$this->Competence->save(null, false);

			$this->Session->setFlash("Données enregistrées.", 'message_succes');
			$this->redirect('edit');
		}

		$this->data = $this->Competence->read(null, $id);
		$this->set('parents', $this->Competence->generatetreelist());
	}


	/**
	 * Monte une catégorie d'un cran
	 *
	 * @param int $id Id de la catégorie
	 */
	function move_up($id = null)
	{
		if(!$this->Competence->moveup($id))
		{
			$this->Session->setFlash("La catégorie ne peut pas aller plus haut.", 'message_erreur');
		}
		else
		{
			$this->Session->setFlash("Ordre mis à jour.", 'message_succes');
		}

		$this->redirect($this->referer());
	}
 
	/**
	 * Descend une catégorie d'un cran
	 *
	 * @param int $id Id de la catégorie
	 */
	function move_down($id = null)
	{
		if(!$this->Competence->movedown($id))
		{
			$this->Session->setFlash("La catégorie ne peut pas aller plus bas.", 'message_erreur');
		}
		else
		{
			$this->Session->setFlash("Ordre mis à jour.", 'message_succes');
		}

		$this->redirect($this->referer());
	}

	/**
	 * Suppression d'une catégorie
	 *
	 * @param int $id Id de la catégorie
	 */
	function delete($id = null)
	{
		$this->Competence->id = $id;

		if(!$this->Competence->exists())
		{
			$this->Session->setFlash("Enregistrement introuvable.",'message_error');
		}
		else
		{
			$this->Competence->removeFromTree($id, true);
			$this->Session->setFlash("Données supprimées.",'message_succes');
		}

		$this->redirect($this->referer());
	}
}
