<?php 

/**
* 
*/
class FormularioAplicacionController extends Controller
{
	static $routes = array(
		'all' 		=>	'getAll',
		'one'		=>	'getById',
		'add' 		=>	'create',
		'update'	=>	'update',
		'del'		=>	'delete',
		'forPre'	=>	'seccionPreguntas'
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
	private $attributes = array('seccion', 'estatus');

	/**
	* 
	*/
	public function __construct($app = null)
	{
		$this->app = $app;
	}

	public function getAll()
	{
		
		$formulariosAplicacion = FormularioAplicacion::orderBy('seccion', 'ASC')->get();
		$this->response['data'] = $formulariosAplicacion;
		$this->response['message'] = 'Lista de secciones';
		$json = json_encode($this->response, JSON_FORCE_OBJECT);

		return $json;

	}

	public function getById($id)
	{

		try
		{
			$params = array($id);
			$params = $this->sanitize($params);

			$formularioAplicacion = FormularioAplicacion::find($params[0]);

			if ($formularioAplicacion != null) 
			{
				$this->response['data'] = $formularioAplicacion->toArray();
				$this->response['message'] = 'Recurso encontrado';
			}
			else
			{
				$this->response['code'] = 4;
				$this->response['message'] = 'Recurso no encontrado';
			}

		}catch(Exception $e)
		{
			$this->response['code'] = 5;
			$this->response['message'][] = 'Ha ocurrido un error, favor de contactar al administrador';
			$this->response['error'] = $e->getMessage();
		}
		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;
	}

	public function create(Array $params)
	{
		if (count($params) == 0 || (!isset($params['seccion'])) || (!isset($params['estatus']))) 
		{
			$this->response['code'] = 2;
			$this->response['message'] = 'Todos los parámetros son requeridos';
		}
		else
		{
			$params = $this->sanitize($params);
			$messages = array();

			if (strlen($params['seccion']) == 0 || strlen($params['seccion']) > 255) 
			{
				$messages[] = 'El campo seccion no puede quedar vacío ni tener una longitud mayor a 255 caracteres';
			}
			if (strlen($params['estatus']) == 0 || strlen($params['estatus']) > 1) 
			{
				$messages[] = 'El campo estatus no puede quedar vacío ni tener una longitud mayor a 1 caracteres';
			}
			if (count($messages) > 0) 
			{
				$this->response['code'] = 2;
				$this->response['data'] = $params;
				$this->response['message'] = $messages;
			}
			else
			{
				$total = FormularioAplicacion::where('seccion', '=', $params['seccion'])->get();

				if (count($total) > 0) 
				{
					$this->response['code'] = 3;
					$this->response['data'] = $params;
					$this->response['message'] = 'Ya existe una seccion con el nombre \'' . $params['seccion'] . '\'';
				}
				else
				{
					$db = Connection::getConnection();
					$db::beginTransaction();

					try
					{
						 $formularioAplicacion = new FormularioAplicacion();
						 $formularioAplicacion->seccion = $params['seccion'];
						 $formularioAplicacion->estatus = $params['estatus'];

						 if ($formularioAplicacion->save()) 
						 {
						 	$db::commit();
						 	$this->response['code'] = 1;
						 	$this->response['data'] = $formularioAplicacion->toArray();
						 	$this->response['message'] = 'Se ha creado una nueva seccion de manera exitosa';

						 }
						 else
						 {
						 	$this->response['code'] = 5;
							$this->response['message'] = 'Ocurrió un error, favor de intentar más tarde.';
						 }
					}catch (PDOException $e) 
					{
						$db::rollBack();
						$this->response['error'] = $e->getMessage();
					}
				}
			}
		}

		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;

	}

	public function update(Array $params)
	{
		if (count($params) == 0 || (!isset($params['seccion'])) || (!isset($params['estatus']))) 
		{
			$this->response['code'] = 2;
			$this->response['message'] = 'Todos los parámetros son requeridos';
		}
		else
		{
			$params = $this->sanitize($params);
			$messages = array();

			if (strlen($params['seccion']) == 0 || strlen($params['seccion']) > 255) 
			{ 
				$messages[] = 'El campo seccion no puede quedar vacío ni tener una longitud mayor a 255 caracteres';
			}
			if (strlen($params['estatus']) == 0 || strlen($params['estatus']) > 1) 
			{ 
				$messages[] = 'El campo estatus no puede quedar vacío ni tener una longitud mayor a 1 caracteres';
			}

			if (count($messages) > 0) 
			{
				$this->response['code'] = 2;
				$this->response['data'] = $params;
				$this->response['message'] = $messages;
			}
			else
			{
				$total = FormularioAplicacion::where('seccion', '=', $params['seccion'])
											 ->where('id', '!=', $params['id'])
											 ->get();

				if (count($total) > 0) 
				{
					$this->response['code'] = 3;
					$this->response['data'] = $params;
					$this->response['message'] = 'Ya existe un estatus con el nombre \'' . $params['seccion'] . '\'';
				}
				else
				{
					$db = Connection::getConnection();
					$db::beginTransaction();

					try
					{

						$formularioAplicacion = FormularioAplicacion::find($params['id']);

						if ($formularioAplicacion == null) 
						{
							$this->response['code'] = 4;
							$this->response['message'] = 'Recurso no encontrado';	
						}
						else
						{
							$formularioAplicacion->seccion = $params['seccion'];
							$formularioAplicacion->estatus = $params['estatus'];

							if ($formularioAplicacion->save()) 
							{
								$db::commit();
								$this->response['code'] = 1;
								$this->response['data'] = $formularioAplicacion->toArray();
								$this->response['message'] = 'Se ha acualizado de manera exitosa';

							}
							else
							{
								$this->response['code'] = 5;
								$this->response['message'] = 'Ocurrió un error, favor de intentar más tarde.';	
							}
						}



					}catch(PDOException $e)
					{
						$db::rollBack();
						$this->response['error'] = $e->getMessage();
					}
				}
			}
		}
		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;

	}

	public function delete($id)
	{
		$params = $this->sanitize(array($id));
		$formularioAplicacion = FormularioAplicacion::with('relacionPreguntasFormularioAplicacion')->where('id', '=', $params[0])->get();

		if (count($formularioAplicacion) > 0)
		{
			
			if (count($formularioAplicacion[0]->relacionPreguntasFormularioAplicacion) > 0)
			{
				$this->response['code'] = 5;
				$this->response['message'] = 'Existen referencias.';
			}
			else
			{

				$db = Connection::getConnection();
				$db::beginTransaction();

				try 
				{
					if ($formularioAplicacion[0]->delete())
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
					$this->response['message'] = 'Ocurrió un error, favor de contactar al administrador. catch';
				}
			}
		}
		else
		{
			$this->response['code'] = 4;
			$this->response['message'] = 'Recurso no encontrado.';
		}

		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;
	}

	/**
	*
	*/
	public function seccionPreguntas($id)
	{
		try
		{
			$params = array($id);
			$params = $this->sanitize($params);

			$formularioAplicacion = FormularioAplicacion::with('preguntas')
													->find($params[0]);

			if ($formularioAplicacion != null) 
			{
				$this->response['data'] = $formularioAplicacion->toArray();
				$this->response['message'] = 'Recurso encontrado';
			}
			else
			{
				$this->response['code'] = 4;
				$this->response['message'] = 'Recurso no encontrado';
			}

		}catch(Exception $e)
		{
			$this->response['code'] = 5;
			$this->response['message'][] = 'Ha ocurrido un error, favor de contactar al administrador';
			$this->response['error'] = $e->getMessage();
		}
		
		$this->response['code'] = 1;
		$this->response['data'] = $formularioAplicacion;
		
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
