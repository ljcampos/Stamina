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

	private $DIRECTORY = __DIR__ . '/../../uploads/convocatoria/';
	private $MIME = 'application/pdf';
	private $MAX_FILE_UPLOAD = 1572864;

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
				$value->path = (strlen($value->path) > 0) ? /*$this->DIRECTORY . */'/API/uploads/convocatoria/' . $value->path : '';
				unset($value->universidad->user->password);
				unset($value->universidad->user->salt);
				unset($value->universidad->user->token);
				$value->universidad->user->status;
				$value->universidad->imagen = (strlen($value->universidad->imagen) > 0) ? __DIR__ . '/../../uploads/universidad/' . $value->universidad->imagen : '';

				if (count($value->emprendedores) > 0)
				{
					foreach ($value->emprendedores as $k => $val) {
						$val->imagen = ($val->imagen != "" || $val->imagen != null) ? __DIR__ . '/../../uploads/usuario/' . $val->imagen : '';
						unset($val->password);
						unset($val->salt);
						unset($val->token);
						unset($val->pivot);
					}
				}
			}
		}

		$this->response['code'] = 1;
		$this->response['data'] = $convocatorias;
		$this->response['message'] = 'Correcto';

		return $this->response;

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
				//unset($value->universidad_id);
				unset($convocatoria->universidad_id);
				$convocatoria->path = (strlen($convocatoria->path) > 0) ? /*$this->DIRECTORY .*/ '/API/uploads/convocatoria/' .  $convocatoria->path : '';
				$convocatoria->universidad->imagen = (strlen($convocatoria->universidad->imagen) > 0) ? __DIR__ . '/../../uploads/universidad/' . $convocatoria->universidad->imagen : '';

				if (count($convocatoria->emprendedores) > 0)
				{	
					foreach ($convocatoria->emprendedores as $key => $value) {
						$value->imagen = ($value->imagen != "" || $value->imagen != null) ? __DIR__ . '/../../uploads/usuario/' . $value->imagen : '';
						unset($convocatoria->emprendedores[$key]->token);
						unset($convocatoria->emprendedores[$key]->password);
						unset($convocatoria->emprendedores[$key]->salt);
						unset($convocatoria->emprendedores[$key]->pivot);
					}
				}
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
						if ($parametros['saved'] == true) 
						{
							$convocatoria->path = $parametros['url'];
						}
						else
						{
							$convocatoria->path = '';
							$this->response['message'][] = 'archivo invalido';
						}

						if ($convocatoria->save()) { $saved = true; }
					}
					else 
					{
						$this->response['message'][] = 'La fecha inicio no puede ser mayor a la fecha fin';
					}
					
					if ($saved === true)
					{	
						$convocatoria->path = (strlen($convocatoria->path) > 0) ? $this->DIRECTORY . $convocatoria->path : '';
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

			if (Convocatoria::find(intval($params['id'])) === null)
			{
				$messages[] = 'La convocatoria no existe';
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
								if (file_exists($this->DIRECTORY . $convocatoria->path)) 
								{ 
									unlink($this->DIRECTORY . $convocatoria->path); 
								}
								$convocatoria->path = $parametros['url'];	
							}
							else
							{
								$this->response['message'][] = 'archivo invalido';
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
						$convocatoria->path = (strlen($convocatoria->path) > 0) ? $this->DIRECTORY . $convocatoria->path : '';
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

		return $this->response;
	}


	/**
	* 
	*/
	public function delete($id)
	{
		$params = $this->sanitize(array($id));
		$convocatoria = Convocatoria::with('emprendedores')->where('id', '=', $params[0])->get();

		if (count($convocatoria) > 0)
		{
			if (count(EmprendedorConvocatoria::where('id_convocatoria', '=', $convocatoria[0]->id)
																				->get()) > 0)
			{
				$this->response['code'] = 5;
				$this->response['message'] = 'Existen referencias.';
			}
			else
			{
				$db = Connection::getConnection();
				$db::beginTransaction();
				$this->response['message'] = 'Ocurrió un error, favor de contactar al administrador.';

				try 
				{
					if (file_exists($this->DIRECTORY . $convocatoria[0]->path)) 
					{ 
						unlink($this->DIRECTORY . $convocatoria[0]->path); 
					}
					if ($convocatoria[0]->delete())
					{	
						$db::commit();
						$this->response['code'] = 1;
						$this->response['message'] = 'Se ha eliminado correctamente';
					}
				} 
				catch (Exception $e) 
				{
					$db::rollBack();
					$this->response['e'] = $e->getMessage();
					$this->response['code'] = 5;
					$this->response['message'] = 'Ocurrió un error, favor de contactar al administrador.';
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

			if ($_FILES['size'] <= $this->MAX_FILE_UPLOAD) 
			{
				$recurso 	= finfo_open(FILEINFO_MIME_TYPE);
				$mime 		=	finfo_file($recurso, $_FILES['file']['tmp_name']);

				if ($this->MIME === $mime)
				{
					$nombre_archivo = date('Y_m_d') . '_' . uniqid();
					$nombre_archivo = $nombre_archivo . '.pdf';
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