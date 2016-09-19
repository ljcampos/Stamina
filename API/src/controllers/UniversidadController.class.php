<?php

/**
* 
*/
class UniversidadController extends Controller
{
	static $routes = array(
		'all' 		=>	'getAll',
		'one'			=>	'getById',
		'add' 		=>	'create',
		'update'	=>	'update'
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
	private $attributes = array('nombre', 'usuario_id', 'estado_id');

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
		$universidades = Universidad::orderBy('nombre', 'ASC')->get();

		if (count($universidades) > 0)
		{
			foreach ($universidades as $key => $universidad) {
				$universidad->user;
				$universidad->user->status;
				$universidad->convocatorias;
				unset($universidad->user->password);
				unset($universidad->user->salt);
				unset($universidad->user->token);
				unset($universidad->user->estatus_id);
			}
		}

		$this->response['code'] = 1;
		$this->response['data'] = $universidades;
		$this->response['message'] = 'Correcto';
		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;

	}	

	/**
	* 
	*/
	public function getById($universidad_id)
	{
		$params = $this->sanitize(array($universidad_id));
		
		if (is_int(intval($params[0])))
		{
			$universidad = Universidad::find(intval($params[0]));

			if ($universidad != null)
			{
				$universidad->convocatorias;
				$this->response['code'] = 1;
				$this->response['data'] = $universidad->toArray();
				$this->response['message'] = 'Recurso encontrado';
			}
			else
			{
				$this->response['code'] = 4;
				$this->response['message'] = 'Recurso no encontrado';		
			}
		}	
		else
		{
			$this->response['code'] = 2;
			$this->response['message'] = 'El identificador de la universidad debe ser de tipo número.';
		}

		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;
	}

	/**
	* 
	*/
	public function create(Array $params)
	{
		if (count($params) == 0 || ($this->checkAttributes($params)) == false) 
		{
			$this->response['code'] = 2;
			$this->response['message'] = 'Todos los parámetros son requeridos';
		}
		else 
		{
			$params = $this->sanitize($params);
			$messages = array();

			if (empty($params['nombre']) || is_null($params['nombre']) 
				|| strlen($params['nombre']) == 0 || strlen($params['nombre']) > 100)
			{
				$messages[] = 'El campo nombre no puede quedar vacío ni tener una longitud mayor a 100 caracteres';
			}
			elseif (count(Universidad::where('nombre', '=', $params['nombre'])->get()) > 0 )
			{
				$messages[] = 'Ya existe una universidad con el nombre: \'' . $params['nombre'] . '\'';	
			}

			if (empty($params['usuario_id']) || !intval($params['usuario_id']) 
				|| !filter_var($params['usuario_id'], FILTER_VALIDATE_INT))
			{
				$messages[] = 'El id del usuario no es valido';
			}
			elseif (User::find(intval($params['usuario_id'])) === null)
			{
				$messages[] = 'Usuario con el identificador: \'' . $params['usuario_id'] . '\' no existe';	
			}

			if (empty($params['estado_id']) || !intval($params['estado_id'])
					|| !filter_var($params['estado_id'], FILTER_VALIDATE_INT))
			{
				$messages[] = 'El id del estado no es valido';
			}
			elseif (Estado::find(intval($params['estado_id'])) === null)
			{
				$messages[] = 'Estado con el identificador: \'' . $params['estado_id'] . '\' no existe';
			}


			if (count($messages) > 0)
			{
				$this->response['code'] = 2;
				$this->response['data'] = $params;
				$this->response['message'] = $messages;
			}
			else
			{
				$db = Connection::getConnection();
				$db::beginTransaction();
				$saved = false;

				try 
				{
					$universidad = new Universidad();
					$universidad->nombre = $params['nombre'];
					$universidad->usuario_id = $params['usuario_id'];
					$universidad->estado_id = $params['estado_id'];
					$imagen = $this->saveImage();
					$universidad->imagen = ($imagen['saved'] == true) ? $imagen['url'] : '';

					if ($universidad->save())
					{
						$this->response['code'] = 1;
						$this->response['data'] = $universidad;
						$this->response['message'] = 'Se ha creado un nuevo registro de universidad';
						$db::commit();
					}
					else
					{
						$this->response['code'] = 5;
						$this->response['data'][] = $params;
						$this->response['message'] = 'No se ha podido completar la acción, inténtelo más tarde.';
						unlink($image['url']);
					}
					
				} catch (PDOException $e) 
				{
					$db::rollBack();
					$this->response['message'] = $e->getMessage();
				}
			}
		}

		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;
	}

	/**
	* 
	*/
	public function update(Array $params)
	{
		if (count($params) == 0 || ($this->checkAttributes($params)) == false) 
		{
			$this->response['code'] = 2;
			$this->response['message'] = 'Todos los parámetros son requeridos';
		}
		else 
		{
			$params = $this->sanitize($params);
			$messages = array();

			if (empty($params['universidad_id']) || !intval($params['universidad_id'])
					|| !filter_var($params['universidad_id'], FILTER_VALIDATE_INT))
			{
				$messages[] = 'El id de la universidad no es valido';
			}
			elseif (Universidad::find($params['universidad_id']) === null)
			{
				$messages[] = 'Universidad con el identificador: \'' . $params['univresidad_id'] . '\' no existe';
			}

			if (empty($params['nombre']) || is_null($params['nombre']) 
				|| strlen($params['nombre']) == 0 || strlen($params['nombre']) > 100)
			{
				$messages[] = 'El campo nombre no puede quedar vacío ni tener una longitud mayor a 100 caracteres';
			}
			elseif (count(Universidad::where('nombre', '=', $params['nombre'])
										->where('universidad_id', '!=', $params['universidad_id'])->get()) > 0 )
			{
				$messages[] = 'Ya existe una universidad con el nombre: \'' . $params['nombre'] . '\'';	
			}

			if (empty($params['usuario_id']) || !intval($params['usuario_id']) 
				|| !filter_var($params['usuario_id'], FILTER_VALIDATE_INT))
			{
				$messages[] = 'El id del usuario no es valido';
			}
			elseif (User::find(intval($params['usuario_id'])) === null)
			{
				$messages[] = 'Usuario con el identificador: \'' . $params['usuario_id'] . '\' no existe';	
			}

			if (empty($params['estado_id']) || !intval($params['estado_id'])
					|| !filter_var($params['estado_id'], FILTER_VALIDATE_INT))
			{
				$messages[] = 'El id del estado no es valido';
			}
			elseif (Estado::find(intval($params['estado_id'])) === null)
			{
				$messages[] = 'Estado con el identificador: \'' . $params['estado_id'] . '\' no existe';
			}


			if (count($messages) > 0)
			{
				$this->response['code'] = 2;
				$this->response['data'] = $params;
				$this->response['message'] = $messages;
			}
			else
			{
				$db = Connection::getConnection();
				$db::beginTransaction();
				$saved = false;

				try 
				{
					$id = intval($params['universidad_id']);
					$nombre 		= trim($params['nombre']);
					$usuario_id = intval($params['usuario_id']);
					$estado_id  = intval($params['estado_id']);

					$universidad = Universidad::find($id);
					$universidad->nombre = $nombre;
					$universidad->usuario_id = $usuario_id; 
					$universidad->estado_id = $estado_id;

					$imagen = $this->saveImage();
					if ($imagen['saved'] == true)
					{	
						try { unlink($universidad->imagen); } 
						catch (Exception $e) { }

						$universidad->imagen = $imagen['url'];	
					}
					

					$universidad->save();

					$db::commit();
					$this->response['code'] = 1;
					$this->response['data'] = $universidad;
					$this->response['message'] = 'Se ha actualizado correctamente';
					
				} catch (PDOException $e) 
				{
					$db::rollBack();
					$this->response['code'] = 5;
					$this->response['data'][] = $params;
					$this->response['message'] = 'No se ha podido completar la acción, inténtelo más tarde.';
					$this->response['message'] = $e->getMessage();
				}
			}
		}

		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;
	}


	/**
	* 
	*/
	public function saveImage()
	{
		$params = array('saved' => false, 'url' => '') ;

		if (!empty($_FILES) && $_FILES['file']['error'] === 0)
		{
			$mimes 		= array('image/png', 'image/jpeg');
			$recurso 	= finfo_open(FILEINFO_MIME_TYPE);
			$mime 		=	finfo_file($recurso, $_FILES['file']['tmp_name']);

			if (in_array($mime, $mimes))
			{
				$nombre_archivo = date('Y_m_d') . '_' . uniqid();
				$nombre_archivo = ($mime === $mimes[0]) ? $nombre_archivo .= '.png' : $nombre_archivo .= '.jpeg';
				$fichero_subido = __DIR__ . '/../../uploads/' . $nombre_archivo;

				if (move_uploaded_file($_FILES['file']['tmp_name'], $fichero_subido))
				{	
					$params['saved'] = true;
					$params['url'] = $fichero_subido;
				}		
			}
		}

		return $params;
	}

	/**
	* 
	*/
	private function checkAttributes(Array $params)
	{
		$continuar = true;

		foreach ($this->attributes as $key => $attribute) {
			if (!array_key_exists($attribute, $params)) 
			{ 
				$continuar = false;
				break;
			}
		}

		return $continuar;
	}

	/**
	* 
	*/
	private function sanitize(Array $params)
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $value) {

				if (is_array($value)) { $value = $this->sanitize($value); }
				else {

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
		}

		return $params;
	}
}