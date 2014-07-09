<?php
App::uses('AppController', 'Controller');
/**
 * PlannedTrainings Controller
 *
 * @property PlannedTraining $PlannedTraining
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class PlannedTrainingsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->PlannedTraining->recursive = 0;
		$this->set('plannedTrainings', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->PlannedTraining->exists($id)) {
			throw new NotFoundException(__('Invalid planned training'));
		}
		$options = array('conditions' => array('PlannedTraining.' . $this->PlannedTraining->primaryKey => $id));
		$this->set('plannedTraining', $this->PlannedTraining->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PlannedTraining->create();
			if ($this->PlannedTraining->save($this->request->data)) {
				$this->Session->setFlash(__('The planned training has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The planned training could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->PlannedTraining->exists($id)) {
			throw new NotFoundException(__('Invalid planned training'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->PlannedTraining->save($this->request->data)) {
				$this->Session->setFlash(__('The planned training has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The planned training could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('PlannedTraining.' . $this->PlannedTraining->primaryKey => $id));
			$this->request->data = $this->PlannedTraining->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->PlannedTraining->id = $id;
		if (!$this->PlannedTraining->exists()) {
			throw new NotFoundException(__('Invalid planned training'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->PlannedTraining->delete()) {
			$this->Session->setFlash(__('The planned training has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The planned training could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
