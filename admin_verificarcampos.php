<?php
class PagosController extends AppController
{
	var $name = 'Pagos';

	function admin_index()
	{
		$this->Pago->recursive = 0;
		$this->set('pagos', $this->paginate());
	}

	function admin_view($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Registro inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('pago', $this->Pago->read(null, $id));
	}

	function admin_add()
	{
		if (!empty($this->data))
		{
			$this->Pago->create();
			if ($this->Pago->save($this->data))
			{
				$this->Session->setFlash(__('Registro guardado correctamente', true));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('El registro no pudo ser guardado. Por favor intenta nuevamente', true));
			}
		}
	}

	function admin_edit($id = null)
	{
		if (!$id && empty($this->data))
		{
			$this->Session->setFlash(__('Registro inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data))
		{
			if ($this->Pago->save($this->data))
			{
				$this->Session->setFlash(__('Registro guardado correctamente', true));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('El registro no pudo ser guardado. Por favor intenta nuevamente', true));
			}
		}
		if (empty($this->data))
		{
			$this->data = $this->Pago->read(null, $id);
		}
	}

	function admin_delete($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Registro inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Pago->delete($id))
		{
			$this->Session->setFlash(__('Registro eliminado', true));
			$this->redirect(array('action' => 'index'));
		}
		else
		{
			$this->Session->setFlash(__('El registro no pudo ser eliminado. Por favor intenta nuevamente', true));
			$this->redirect(array('action' => 'index'));
		}
	}

	function admin_verificarCampos()
	{
		$camposARevisar = [
			'id', 'usuario_id', 'compra_id', 'numeroOrden', 'monto', 'fecha', 
			'hora', 'estado', 'codAutorizacion', 'created', 'modified'
		];

		$registros = $this->Pago->find('all', [
			'order' => ['Pago.id' => 'desc'],
			'limit' => 1000
		]);

		$registrosInvalidos = [];

		foreach ($registros as $registro) {
			$camposNulos = [];
			foreach ($camposARevisar as $campo) {
				if (!isset($registro['Pago'][$campo]) || is_null($registro['Pago'][$campo])) {
					$camposNulos[] = $campo;
				}
			}
			if (!empty($camposNulos)) {
				$registrosInvalidos[] = [
					'registro' => $registro,
					'camposNulos' => $camposNulos
				];
			}
		}

		$this->set('totalRegistros', count($registros));
		$this->set('registrosInvalidos', $registrosInvalidos);

		if (empty($registrosInvalidos)) {
			$this->Session->setFlash(__('Todos los campos están completos en los últimos 1000 registros.', true));
		} else {
			$this->Session->setFlash(__('Existen campos nulos en algunos registros.', true));
		}
	}
}
?>
