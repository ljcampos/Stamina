<?php

/**
* 
*/
class StatusController extends Controller
{
	static $routes = array(
		'all' 		=> 	'getAll',
		'add' 		=>	'create',
		'one'			=>	'getById',
		'update' 	=> 	'update',
		'del'			=>	'delete'
	);

	/**
	* 
	*/
	private $response = array(
		'code' 		=>	1,
		'data'		=>	array(),
		'message'	=>	''
	);

	/**
	* 
	*/
	public function __construct($app = null)
	{
		$this->app = $app;
	}

	/**
	* 
	*/
	public function getAll()
	{
		
		$status = Status::orderBy('estatus', 'ASC')->get();
		$this->response['data'] = $status;
		$this->response['message'] = 'Lista de estatus disponibles';
		
		return $this->response;
	}	

	/**
	* 
	*/
	public function create(Array $params)
	{
		if (count($params) == 0 || (!isset($params['estatus']) || !isset($params['descr'])))
		{
			$this->response['code'] = 2;
			$this->response['message'] = 'Todos los parámetros son requeridos';
		}
		else
		{
			$params = $this->sanitize($params);
			$messages = array();

			if (strlen($params['estatus']) == 0 || strlen($params['estatus']) > 50) 
			{ 
				$messages[] = 'El campo estatus no puede quedar vacío ni tener una longitud mayor a 50 caracteres';
			}

			if (strlen($params['descr']) == 0 || strlen($params['descr']) > 250)
			{
				$messages[] = 'El campo descripción no puede quedar vacío ni tener una longitud mayor a 250 caracteres';	
			}

			if (count($messages) > 0)
			{
				$this->response['code'] = 2;
				$this->response['data'] = $params;
				$this->response['message'] = $messages;
			}
			else 
			{
				$total = Status::where('estatus', '=', $params['estatus'])->get();
				
				if (count($total) > 0)
				{
					$this->response['code'] = 3;
					$this->response['data'] = $params;
					$this->response['message'] = 'Ya existe un estatus con el nombre \'' . $params['estatus'] . '\'';
				}
				else 
				{
					$db = Connection::getConnection();
					$db::beginTransaction();

					try 
					{
						$estatus = new Status();
						$estatus->estatus = $params['estatus'];
						$estatus->descr 	= $params['descr'];

						if ($estatus->save()) 
						{ 
							$db::commit();
							$this->response['code'] = 1;
							$this->response['data'] = $estatus->toArray();
							$this->response['message'] = 'Se ha creado un nuevo permiso de manera exitosa';
						}
						else 
						{
							$this->response['code'] = 5;
							$this->response['message'] = 'Ocurrió un error, favor de intentar más tarde.';	
						}
					} 
					catch (PDOException $e) 
					{
						$db::rollBack();
					}
				}
			}
		}

		return $this->response;
	}

	/**
	* 
	*/
	public function getById($status_id)
	{
		try 
		{	
			$params = array($status_id);
			$params = $this->sanitize($params);

			$status = Status::find($params[0]);

			if ($status != null)
			{
				$this->response['data'] = $status->toArray();
				$this->response['message'] = 'Recurso encontrado';
			}
			else
			{
				$this->response['code'] = 4;
				$this->response['message'] = 'Recurso no encontrado';
			}
		} 
		catch (Exception $e) 
		{
			$this->response['code'] = 5;
			$this->response['message'][] = 'Ha ocurrido un error, favor de contactar al administrador';
		}

		return $this->response;
	}


	/**
	* 
	*/
	public function update(Array $params)
	{
		if (count($params) == 0 || (!isset($params['estatus']) || !isset($params['descr'])) || !isset($params['id']))
		{ 
			$this->response['code'] = 2;
			$this->response['message'] = 'Todos los parámetros son requeridos';
		}
		else
		{
			$params = $this->sanitize($params);
			$messages = array();

			if (strlen($params['estatus']) == 0 || strlen($params['estatus']) > 50) 
			{ 
				$messages[] = 'El campo permiso no puede quedar vacío ni tener una longitud mayor a 50 caracteres';
			}

			if (strlen($params['descr']) == 0 || strlen($params['descr']) > 250)
			{
				$messages[] = 'El campo descripción no puede quedar vacío ni tener una longitud mayor a 250 caracteres';	
			}

			if (count($messages) > 0)
			{
				$this->response['code'] = 2;
				$this->response['data'] = $params;
				$this->response['message'] = $messages;
			}
			else 
			{
				$total = Status::where('estatus', '=', $params['estatus'])
											->where('estatus_id', '!=', $params['id'])
											->get();
				
				if (count($total) > 0)
				{
					$this->response['code'] = 3;
					$this->response['data'] = $params;
					$this->response['message'] = 'Ya existe un estatus con el nombre \'' . $params['estatus'] . '\'';
				}
				else 
				{
					$db = Connection::getConnection();
					$db::beginTransaction();

					try 
					{
						$estatus = Status::find($params['id']);

						if ($estatus == null)
						{
							$this->response['code'] = 4;
							$this->response['message'] = 'Recurso no encontrado';	
						}
						else 
						{

							$estatus->estatus = $params['estatus'];
							$estatus->descr = $params['descr'];

							if ($estatus->save()) 
							{ 
								$db::commit();
								$this->response['code'] = 1;
								$this->response['data'] = $estatus->toArray();
								$this->response['message'] = 'Se ha acualizado de manera exitosa';
							}
							else 
							{
								$this->response['code'] = 5;
								$this->response['message'] = 'Ocurrió un error, favor de intentar más tarde.';	
							}
						}
					} 
					catch (PDOException $e) 
					{
						$db::rollBack();
					}
				}
			}
		}

		return $this->response;
	}

	/**
	* 
	*/
	public function delete($id)
	{
		$params = $this->sanitize(array($id));
		$estatus = Status::with('users')->where('estatus_id', '=', $params[0])->get();

		if (count($estatus) > 0)
		{
			if (count($estatus[0]->users) > 0)
			{	
				$this->response['code'] = 5;
				$this->response['message'] = 'Existen referencias';		
			}
			else
			{
				$db = Connection::getConnection();
				$db::beginTransaction();
				$this->response['message'] = 'Ocurrió un error favor de contactar al administrador.';	

				try 
				{
					if ($estatus[0]->delete()) 
					{
						$db::commit();
						$this->response['code'] = 1;
						$this->response['message'] = 'Se ha eliminado correctamente.';		
					}
				} 
				catch (Exception $e) 
				{
					$db::rollBack();
					$this->response['code'] = 5;
					$this->response['message'] = 'Ocurrió un error favor de contactar al administrador.';	
				}
			}
		}
		else
		{
			$this->response['code'] = 4;
			$this->response['message'] = 'Recurso no encontrado';
		}

		return $this->response;
	}

	/**
	* 
	*/
	private function sanitize(Array $params)
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $value) {
				$value = strip_tags($value);
				$value = filter_var($value, FILTER_SANITIZE_STRING);
				$value = htmlspecialchars($value);

				if (is_int($value)) 
				{ 
					$value = filter_var($value, FILTER_SANITIZE_NUMBER_INT); 
					$value = filter_id($value, FILTER_VALIDATE_INT);
				}

				$params[$key] = $value;
			}
		}

		return $params;
	}
}