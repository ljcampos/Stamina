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
		'update'	=>	'update',
		'del'			=>	'delete'
	);

	private $DIRECTORY;
	private $MAX_FILE_UPLOAD;

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
	private $attributes = array('nombre', 'usuario_id', 'fecha_inicio_servicio', 'fecha_final_servicio', 'estado_id');

	/**
	*
	*/
	public function __construct($app = null)
	{
		$this->app = $app;
		$this->DIRECTORY = __DIR__ . '/../../uploads/universidad/';
		$this->MAX_FILE_UPLOAD = 1572864;
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
				$universidad->imagen = (strlen($universidad->imagen) > 0) ? /*$this->DIRECTORY .*/'/API/uploads/universidad/' . $universidad->imagen : '';
				$universidad->user;
				$universidad->user->imagen = ($universidad->user->imagen != "" || $universidad->user->imagen != null) ? __DIR__ . '/../../uploads/usuario/' . $universidad->user->imagen : '';
				$universidad->user->status;
				$universidad->fecha_inicio_servicio;
				$universidad->fecha_final_servicio;
				unset($universidad->user->password);
				unset($universidad->user->salt);
				unset($universidad->user->token);
				unset($universidad->user->estatus_id);

				if (count($universidad->convocatorias) > 0)
				{
					foreach ($universidad->convocatorias as $k => $conv) {
						$conv->path = (strlen($conv->path) > 0) ? __DIR__ . '/../../uploads/convocatoria/' . $conv->path : '';
					}
				}
			}
		}

		$this->response['code'] = 1;
		$this->response['data'] = $universidades;
		$this->response['message'] = 'Correcto';

		return $this->response;
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
				$universidad->imagen = (strlen($universidad->imagen) > 0) ? /*$this->DIRECTORY .*/'/API/uploads/universidad/' . $universidad->imagen : '';
				$universidad->user;
				$universidad->user->imagen = ($universidad->user->imagen != "" || $universidad->user->imagen != null) ? __DIR__ . '/../../uploads/usuario/' . $universidad->user->imagen : '';
				$universidad->user->status;
				$universidad->fecha_inicio_servicio;
				$universidad->fecha_final_servicio;
				unset($universidad->user->password);
				unset($universidad->user->salt);
				unset($universidad->user->token);
				unset($universidad->user->estatus_id);

				if (count($universidad->convocatorias) > 0)
				{
					foreach ($universidad->convocatorias as $k => $conv) {
						$conv->path = (strlen($conv->path) > 0) ? __DIR__ . '/../../uploads/convocatoria/' . $conv->path : '';
					}
				}

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

		return $this->response;
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

			if (strtotime($params['fecha_inicio_servicio']) === false)
			{
				$messages[] = 'Fecha inicio no valida';
			}

			if (strtotime($params['fecha_final_servicio']) === false)
			{
				$messages[] = 'Fecha final no valida';
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
					$universidad->fecha_inicio_servicio = $params['fecha_inicio_servicio'];
					$universidad->fecha_final_servicio = $params['fecha_final_servicio'];
					$universidad->estado_id = $params['estado_id'];
					$imagen = $this->saveImage();

					if ($imagen['saved'] === true)
					{
						$universidad->imagen = $imagen['url'];
					}
					else
					{
						$universidad->imagen = '';
						$this->response['error_image'] = 'Imagen invalida';
					}

					if ($universidad->save())
					{
						$universidad->path = (strlen($universidad->path) > 0) ? /*$this->DIRECTORY .*/ '/API/uploads/universidad/' . $universidad->path : '';
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

		return $this->response;
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

			if (strtotime($params['fecha_inicio_servicio']) === false)
			{
				$messages[] = 'Fecha inicio no valida';
			}

			if (strtotime($params['fecha_final_servicio']) === false)
			{
				$messages[] = 'Fecha final no valida';
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
					$id 					= intval($params['universidad_id']);
					$nombre 				= trim($params['nombre']);
					$fecha_inicio_servicio 	= strtotime($params['fecha_inicio_servicio']);
					$fecha_final_servicio 	= strtotime($params['fecha_final_servicio']);
					$usuario_id 			= intval($params['usuario_id']);
					$estado_id  			= intval($params['estado_id']);

					$universidad = Universidad::find($id);
					$universidad->nombre = $nombre;
					$universidad->usuario_id = $usuario_id;
					$universidad->fecha_inicio_servicio = $fecha_inicio_servicio;
					$universidad->fecha_final_servicio = $fecha_final_servicio;
					$universidad->estado_id = $estado_id;

					$imagen = $this->saveImage();
					if ($imagen['saved'] == true)
					{
						if ($universidad->imagen != '' || $universidad->imagen != null)
						{
							$url = $this->DIRECTORY . $universidad->imagen;
							if (file_exists($url) === true)
							{
								try { unlink($this->DIRECTORY . $universidad->imagen); }
								catch (Exception $e) { }
							}
						}

						$universidad->imagen = $imagen['url'];
					}
					else
					{
						$this->response['error_image'] = 'Imagen invalida';
					}

					if ($universidad->save())
					{
						$db::commit();
						$universidad->imagen = (strlen($universidad->imagen) > 0) ? /*$this->DIRECTORY .*/'/API/uploads/universidad/' . $universidad->imagen : '';
						$this->response['code'] = 1;
						$this->response['data'] = $universidad;
						$this->response['message'] = 'Se ha actualizado correctamente';
					}


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

		return $this->response;
	}

	/**
	*
	*/
	public function delete($id)
	{
		$params = $this->sanitize(array($id));
		$universidad = Universidad::with('convocatorias')->where('universidad_id', '=', $params[0])->get();

		if (count($universidad) > 0)
		{
			if (count($universidad[0]->convocatorias) > 0)
			{
				$this->response['code'] = 5;
				$this->response['message'] = 'Existen referencias.';
			}
			else
			{
				$db = Connection::getConnection();
				$db::beginTransaction();
				$this->response['message'] = 'Ocurrió un error, favor de contactar al administrado.';
				try
				{
					if ($universidad[0]->delete())
					{
						$db::commit();

						try
						{
							if ($universidad[0]->imagen != '' || $universidad[0]->imagen != null)
							{
								if (file_exists($this->DIRECTORY . $universidad[0]->imagen))
								{
									unlink($this->DIRECTORY . $universidad[0]->imagen);
								}
							}
						} catch (Exception $e)
						{

						}

						$this->response['code'] = 1;
						$this->response['message'] = 'Se ha eliminado correctamente.';
					}
				}
				catch (Exception $e)
				{
					$db::rollBack();
					$this->response['code'] = 5;
					$this->response['message'] = 'Ocurrió un error, favor de contactar al administrado.';
				}
			}
		}
		else
		{
			$this->response['code'] = 4;
			$this->response['message'] = 'Recurso no encontrado.';
		}

		return $this->response;
	}


	/**
	*
	*/
	public function saveImage()
	{
		$params = array('saved' => false, 'url' => '') ;

		if (!empty($_FILES) && $_FILES['file']['error'] === 0)
		{
			if ($_FILES['file']['size'] <= $this->MAX_FILE_UPLOAD)
			{
				$mimes 		= array('image/png', 'image/jpeg');
				$recurso 	= finfo_open(FILEINFO_MIME_TYPE);
				$mime 		=	finfo_file($recurso, $_FILES['file']['tmp_name']);

				if (in_array($mime, $mimes))
				{
					$nombre_archivo = date('Y_m_d') . '_' . uniqid();
					$nombre_archivo = ($mime === $mimes[0]) ? $nombre_archivo .= '.png' : $nombre_archivo .= '.jpeg';
					$fichero_subido = $this->DIRECTORY . $nombre_archivo;

					if (move_uploaded_file($_FILES['file']['tmp_name'], $fichero_subido))
					{
						$params['saved'] = true;
						$params['url'] = $nombre_archivo;
					}
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
