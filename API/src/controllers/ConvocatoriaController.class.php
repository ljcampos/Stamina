<?php
/**
* 
*/
class ConvocatoriaController extends Controller
{
	static $routes = array(
		'all' 		=>	'getAll',
		'one' 		=>	'getById',
		'add' 		=>	'create',
		'update'	=>	'update',
		'delete' 	=>	'delete'
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
	private $attributes = array('nombre', 'fecha_inicio', 'fecha_cierre', 'universidad_id');

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
		$convocatorias = Convocatoria::with('universidad')->orderBy('nombre', 'ASC')->get();

		if(count($convocatorias) > 0)
		{
			foreach ($convocatorias as $key => $value) {
				unset($value->universidad->user->password);
				unset($value->universidad->user->salt);
				unset($value->universidad->user->token);
				$value->universidad->user->status;
			}
		}

		$this->response['code'] = 1;
		$this->response['data'] = $convocatorias;
		$this->response['message'] = 'Correcto';

		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;

	}	

	/**
	* 
	*/
	public function getById($convocatoria_id)
	{
		$params = $this->sanitize(array($convocatoria_id));
		
		if (is_int(intval($params[0])))
		{
			$convocatoria = Convocatoria::find(intval($params[0]));

			if ($convocatoria != null)
			{	
				$convocatoria->universidad;			
				$this->response['code'] = 1;
				$this->response['data'] = $convocatoria->toArray();
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
			$this->response['message'] = 'El identificador de la convocatoria debe ser de tipo número.';
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
			$this->response['atributos'] = $this->checkAttributes($params);
		}
		else 
		{
			$params = $this->sanitize($params);
			$messages = array();

			if (empty($params['nombre']) || strlen($params['nombre']) == 0 || strlen($params['nombre']) > 255)
			{
				$messages[] = 'El campo nombre no puede quedar vacío ni tener una longitud mayor a 255 caracteres';
			}
			elseif (count(Convocatoria::where('nombre', '=', $params['nombre'])->get()) > 0)
			{
				$messages[] = 'Ya existe una convocatoria con el nombre: \'' . $params['nombre'] . '\'';
			}

			if (strtotime($params['fecha_inicio']) === false)
			{
				$messages[] = 'Fecha inicio no valida';
			}
			
			if (strtotime($params['fecha_cierre']) === false)
			{
				$messages[] = 'Fecha cierre no valida';
			}

			if (Universidad::find(intval($params['universidad_id'])) === null)
			{
				$messages[] = 'Universidad con el identificador: \'' . $params['universidad_id'] . '\' no existe';	
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
					$inicio = strtotime($params['fecha_inicio']);
					$fin 		=	strtotime($params['fecha_cierre']);

					if ($inicio < $fin)
					{
						$convocatoria = new Convocatoria();
						$convocatoria->nombre = $params['nombre'];
						$convocatoria->fecha_inicio = $params['fecha_inicio'];
						$convocatoria->fecha_cierre = $params['fecha_cierre'];
						$convocatoria->universidad_id = $params['universidad_id'];

						$parametros = $this->saveImage();

						$convocatoria->path = ($parametros['saved'] == true) ? $parametros['url'] : '';

						if ($convocatoria->save()) { $saved = true; }
					}
					else 
					{
						$this->response['message'][] = 'La fecha inicio no puede ser mayor a la fecha fin';
					}
					
					if ($saved === true)
					{
						$this->response['code'] = 1;
						$this->response['data'] = $convocatoria;
						$this->response['message'][] = 'Se ha creado una nueva convocatoria';
						$db::commit();
					}
					else
					{
						$this->response['code'] = 5;
						$this->response['data'] = $params;
						$this->response['message'][] = 'Ha ocurrido un error';
						$db::commit();
					}

				} catch (PDOException $e) 
				{
					$db::rollBack();
					$this->response['code'] = 5;
					$this->response['data'][] = $params;
					$this->response['message'][] = 'No se ha podido completar la acción, inténtelo más tarde.';
					$this->response['message'][] = $e->getMessage();
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
			$this->response['atributos'] = $this->checkAttributes($params);
		}
		else 
		{
			$params = $this->sanitize($params);
			$messages = array();

			if (empty($params['id']) || !is_int(intval($params['id'])))
			{
				$messages[] = 'Identificador no valido.';	
			}

			if (empty($params['nombre']) || strlen($params['nombre']) == 0 || strlen($params['nombre']) > 255)
			{
				$messages[] = 'El campo nombre no puede quedar vacío ni tener una longitud mayor a 255 caracteres';
			}
			elseif (count(Convocatoria::where('nombre', '=', $params['nombre'])
										->where('id', '!=', $params['id'])->get()) > 0)
			{
				$messages[] = 'Ya existe una convocatoria con el nombre: \'' . $params['nombre'] . '\'';
			}

			if (strtotime($params['fecha_inicio']) === false)
			{
				$messages[] = 'Fecha inicio no valida';
			}
			
			if (strtotime($params['fecha_cierre']) === false)
			{
				$messages[] = 'Fecha cierre no valida';
			}

			if (Universidad::find(intval($params['universidad_id'])) === null)
			{
				$messages[] = 'Universidad con el identificador: \'' . $params['universidad_id'] . '\' no existe';	
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
					$inicio = strtotime($params['fecha_inicio']);
					$fin 		=	strtotime($params['fecha_cierre']);

					if ($inicio < $fin)
					{
						$convocatoria = Convocatoria::find(intval($params['id']));
						if ($convocatoria != null)
						{
							$convocatoria->nombre = $params['nombre'];
							$convocatoria->fecha_inicio = $params['fecha_inicio'];
							$convocatoria->fecha_cierre = $params['fecha_cierre'];
							$convocatoria->universidad_id = $params['universidad_id'];

							$parametros = $this->saveImage();

							if ($parametros['saved'] == true)
							{
								if (file_exists($convocatoria->path)) { unlink($convocatoria->path); }
								$convocatoria->path = $parametros['url'];	
							}
							
							if ($convocatoria->save()) { $saved = true; }							
						}
						
					}
					else 
					{
						$this->response['message'][] = 'La fecha inicio no puede ser mayor a la fecha fin';
					}
					
					if ($saved === true)
					{
						$this->response['code'] = 1;
						$this->response['data'] = $convocatoria;
						$this->response['message'][] = 'Se ha modificado correctamente';
						$db::commit();
					}
					else
					{
						$this->response['code'] = 5;
						$this->response['data'] = $params;
						$this->response['message'][] = 'Ha ocurrido un error';
						$db::commit();
					}

				} catch (PDOException $e) 
				{
					$db::rollBack();
					$this->response['code'] = 5;
					$this->response['data'][] = $params;
					$this->response['message'][] = 'No se ha podido completar la acción, inténtelo más tarde.';
					$this->response['message'][] = $e->getMessage();
				}
			}
		}

		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;
	}


	/**
	* 
	*/
	public function delete($id)
	{
		$params = $this->sanitize(array($id));
		$messages = array();

		if (!is_int(intval($params[0])))
		{
			$messages[] = 'El identificador debe ser de tipo numérico.';
		}
		if (Convocatoria::find(intval($params[0])) == null)
		{
			$messages[] = 'Recurso no encontrado.';
		}
		if (count(EmprendedorConvocatoria::where('id_convocatoria', '=', $params[0])->get()) > 0)
		{
			$messages[] = 'Existen referencias.';
		}

		if (count($messages) > 0)
		{
			$this->response['code'] = 2;
			$this->response['message'] = $messages;
		}
		else
		{
			$db = Connection::getConnection();
			$db::beginTransaction();

			try 
			{
				$convocatoria = Convocatoria::find(intval($params[0]));	
				if (file_exists($convocatoria->path)) { unlink($convocatoria->path); }
				if ($convocatoria->delete())
				{	

					$this->response['code'] = 1;
					$this->response['message'] = 'Se ha eliminado correctamente';
				}
			} 
			catch (Exception $e) 
			{
				$db::rollBack();
				$this->response['message'] = 'Ocurrió un error, favor de contactar al administrador.';
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