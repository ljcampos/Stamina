<?php

/**
* 
*/
class PermissionController extends Controller
{
	static $routes = array(
		'all' 		=> 	'getAll',
		'add' 		=>	'create',
		'one'			=>	'getById',
		'update' 	=> 'update'
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
		
		$permisos = Permission::orderBy('permiso', 'ASC')->get();
		$this->response['data'] = $permisos;
		$this->response['message'] = 'Lista de permisos creados para la plataforma';
		$json = json_encode($this->response, JSON_FORCE_OBJECT);

		return $json;
	}	

	/**
	* 
	*/
	public function create(Array $params)
	{
		if (count($params) == 0 || (!isset($params['permiso']) || !isset($params['descr'])))
		{
			$this->response['code'] = 2;
			$this->response['message'] = 'Todos los parámetros son requeridos';
		}
		else
		{
			$params = $this->sanitize($params);
			$messages = array();

			if (strlen($params['permiso']) == 0 || strlen($params['permiso']) > 50) 
			{ 
				$messages[] = 'El campo permiso no puede quedar vacío ni tener una longitud mayor a 40 caracteres';
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
				$total = Permission::where('permiso', '=', $params['permiso'])->get();
				
				if (count($total) > 0)
				{
					$this->response['code'] = 3;
					$this->response['data'] = $params;
					$this->response['message'] = 'Ya existe un permiso con el nombre \'' . $params['permiso'] . '\'';
				}
				else 
				{
					$db = Connection::getConnection();
					$db::beginTransaction();

					try 
					{
						$permiso = new Permission();
						$permiso->permiso = $params['permiso'];
						$permiso->descr = $params['descr'];

						if ($permiso->save()) 
						{ 
							$db::commit();
							$this->response['code'] = 1;
							$this->response['data'] = $permiso->toArray();
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

		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;
	}

	/**
	* 
	*/
	public function getById($permission_id)
	{
		try 
		{	
			$params = array($permission_id);
			$params = $this->sanitize($params);

			$permiso = Permission::find($params[0]);

			if ($permiso != null)
			{
				$this->response['data'] = $permiso->toArray();
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

		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;
	}


	/**
	* 
	*/
	public function update(Array $params)
	{
		if (count($params) == 0 || (!isset($params['permiso']) || !isset($params['descr'])) || !isset($params['id']))
		{ 
			$this->response['code'] = 2;
			$this->response['message'] = 'Todos los parámetros son requeridos';
		}
		else
		{
			$params = $this->sanitize($params);
			$messages = array();

			if (strlen($params['permiso']) == 0 || strlen($params['permiso']) > 50) 
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
				$total = Permission::where('permiso', '=', $params['permiso'])
											->where('permiso_id', '!=', $params['id'])
											->get();
				
				if (count($total) > 0)
				{
					$this->response['code'] = 3;
					$this->response['data'] = $params;
					$this->response['message'] = 'Ya existe un permiso con el nombre \'' . $params['permiso'] . '\'';
				}
				else 
				{
					$db = Connection::getConnection();
					$db::beginTransaction();

					try 
					{
						$permiso = Permission::find($params['id']);

						if ($permiso == null)
						{
							$this->response['code'] = 4;
							$this->response['message'] = 'Recurso no encontrado';	
						}
						else 
						{

							$permiso->permiso = $params['permiso'];
							$permiso->descr = $params['descr'];

							if ($permiso->save()) 
							{ 
								$db::commit();
								$this->response['code'] = 1;
								$this->response['data'] = $permiso->toArray();
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

		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;
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