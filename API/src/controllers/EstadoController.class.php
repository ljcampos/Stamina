<?php

/**
* 
*/
class EstadoController extends Controller
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
		
		$estados = Estado::orderBy('estado', 'ASC')->get();
		$this->response['data'] = $estados;
		$this->response['message'] = 'Lista de estados';
		$json = json_encode($this->response, JSON_FORCE_OBJECT);

		return $json;
	}	

	/**
	* 
	*/
	public function create(Array $params)
	{
		if (count($params) == 0 || (!isset($params['estado'])))
		{
			$this->response['code'] = 2;
			$this->response['message'] = 'Todos los parámetros son requeridos';
		}
		else
		{
			$params = $this->sanitize($params);
			$messages = array();

			if (strlen($params['estado']) == 0 || strlen($params['estado']) > 50) 
			{ 
				$messages[] = 'El campo estado no puede quedar vacío ni tener una longitud mayor a 50 caracteres';
			}

			/*if (strlen($params['descr']) == 0 || strlen($params['descr']) > 250)
			{
				$messages[] = 'El campo descripción no puede quedar vacío ni tener una longitud mayor a 250 caracteres';	
			}*/

			if (count($messages) > 0)
			{
				$this->response['code'] = 2;
				$this->response['data'] = $params;
				$this->response['message'] = $messages;
			}
			else 
			{
				$total = Estado::where('estado', '=', $params['estado'])->get();
				
				if (count($total) > 0)
				{
					$this->response['code'] = 3;
					$this->response['data'] = $params;
					$this->response['message'] = 'Ya existe un estado con el nombre \'' . $params['estado'] . '\'';
				}
				else 
				{
					$db = Connection::getConnection();
					$db::beginTransaction();

					try 
					{
						$estado = new Estado();
						$estado->estado = $params['estado'];

						if ($estado->save()) 
						{ 
							$db::commit();
							$this->response['code'] = 1;
							$this->response['data'] = $estado->toArray();
							$this->response['message'] = 'Se ha creado un nuevo estado de manera exitosa';
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
	public function getById($estado_id)
	{
		try 
		{	
			$params = array($estado_id);
			$params = $this->sanitize($params);

			$estado = Estado::find($params[0]);

			if ($estado != null)
			{
				$this->response['data'] = $estado->toArray();
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
		if (count($params) == 0 || (!isset($params['estado']) || !isset($params['id'])))
		{ 
			$this->response['code'] = 2;
			$this->response['message'] = 'Todos los parámetros son requeridos';
		}
		else
		{
			$params = $this->sanitize($params);
			$messages = array();

			if (strlen($params['estado']) == 0 || strlen($params['estado']) > 50) 
			{ 
				$messages[] = 'El campo estado no puede quedar vacío ni tener una longitud mayor a 50 caracteres';
			}

			/*if (strlen($params['descr']) == 0 || strlen($params['descr']) > 250)
			{
				$messages[] = 'El campo descripción no puede quedar vacío ni tener una longitud mayor a 250 caracteres';	
			}*/

			if (count($messages) > 0)
			{
				$this->response['code'] = 2;
				$this->response['data'] = $params;
				$this->response['message'] = $messages;
			}
			else 
			{
				$total = Estado::where('estado', '=', $params['estado'])
											->where('estado_id', '!=', $params['id'])
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
						$estado = Estado::find($params['id']);

						if ($estado == null)
						{
							$this->response['code'] = 4;
							$this->response['message'] = 'Recurso no encontrado';	
						}
						else 
						{

							$estado->estado = $params['estado'];
							//$estado->descr = $params['descr'];

							if ($estado->save()) 
							{ 
								$db::commit();
								$this->response['code'] = 1;
								$this->response['data'] = $estado->toArray();
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