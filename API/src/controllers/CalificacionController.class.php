<?php

/**
* 
*/
class CalificacionController extends Controller
{
	static $routes = array(
		'all' 		=>	'getAll',
		'one'			=>	'getById',
		'add' 		=>	'create',
		'update'	=>	'update',
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
	private $attributes = array('id_respuesta', 'calificacion', 'comentario', 'tipo', 'id_usuario');

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
		$calificaciones = Calificacion::orderBy('calificacion', 'ASC')->get();
		$this->response['code'] = 1;
		$this->response['data'] = $calificaciones;
		$this->response['message'] = 'Lista completa de calificaciones';

		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;
	}

	/**
	* 
	*/
	public function getById($id)
	{
		$params = $this->sanitize(array($id));

		if (is_int(intval($params[0])))
		{
			$calificacion = Calificacion::find(intval($params[0]));
			if ($calificacion != null)
			{
				$this->response['code'] = 1;
				$this->response['data'] = $calificacion;
				$this->response['message'] = 'Recurso encontrado.';
			}
			else
			{
				$this->response['code'] = 4;
				$this->response['message'] = 'Recurso no encontrado.';
			}
		}
		else
		{
			$this->response['code'] = 5;
			$this->response['message'] = 'El identificador de calificacion debe ser de tipo numérico.';
		}

		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;
	}

	/**
	* 
	*/
	public function create(Array $params)
	{
		if (count($params) > 0 && $this->checkAttributes($params) === true)
		{
			$params = $this->sanitize($params);
			$messages = array();

			if (empty($params['calificacion']) || is_null($params['calificacion']) || strlen($params['calificacion']) == 0)
			{
				$messages[] = 'El campo calificacion no debe estar vacío.';
			}
			elseif (count(Calificacion::where('calificacion', '=', $params['calificacion'])->get()) > 0)
			{
				$messages[] = 'Ya existe una calificacion con el nombre: \'' . $params['calificacion'] . '\'';
			}

			if (is_int(intval($params['id_respuesta'])) == false)
			{
				$messages[] = 'El campo respuesta debe ser de tipo numérico.';	
			}

			if (empty($params['calificacion']) || is_null($params['calificacion']) || strlen($params['calificacion']) == 0 || strlen($params['calificacion']) > 255)
			{
				$messages[] = 'El campo calificacion no puede quedar vacío ni contener mas de 255 caracteres.';	
			}

			if (empty($params['comentario']) || is_null($params['comentario']) || strlen($params['comentario']) == 0 || strlen($params['comentario']) > 255)
			{
				$messages[] = 'El campo comentario no puede quedar vacío.';	
			}

			if (is_int(intval($params['tipo'])) == false)
			{
				$messages[] = 'El campo tipo debe ser de tipo numérico.';	
			}	

			if (is_int(intval($params['id_usuario'])) == false)
			{
				$messages[] = 'El campo emprendedor debe ser de tipo numérico.';	
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

				try 
				{
					$calificacion 				= new Calificacion();
					$calificacion->id_respuesta = intval($params['id_respuesta']);
					$calificacion->calificacion = $params['calificacion'];
					$calificacion->comentario 	= $params['comentario'];
					$calificacion->tipo 		= intval($params['tipo']);
					$calificacion->id_usuario 	= intval($params['id_usuario']);

					if ($calificacion->save())
					{
						$db::commit();
						$this->response['code'] = 1;
						$this->response['data'] = $calificacion;
						$this->response['messages'] = 'Se ha guardado correctamente la calificacion.';
					}
					else
					{
						$this->response['code'] = 5;
						$this->response['messages'] = 'No se pudo completar la acción, intentelo más tarde.';
					}
				} 
				catch (Exception $e) 
				{
					$db::rollBack();
					$this->response['code'] = 5;
					$this->response['messages'] = 'Ocurrió un error, favor de contactar al administrador.';
					$this->response['error'] = $e->getMessage();
				}
			}

		}
		else
		{
			$this->response['code'] = 2;
			$this->response['data'] = $params;
			$this->response['message'] = 'Todos los parámetros son requeridos.';
		}

		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;
	}

	/**
	* 
	*/
	public function update(Array $params)
	{
		if (count($params) > 0 && $this->checkAttributes($params) === true)
		{
			$params = $this->sanitize($params);
			$messages = array();

			if (empty($params['calificacion']) || is_null($params['calificacion']) || strlen($params['calificacion']) == 0)
			{
				$messages[] = 'El campo calificacion no debe estar vacío.';
			}
			elseif (count(Calificacion::where('calificacion', '=', $params['calificacion'])->get()) > 0)
			{
				$messages[] = 'Ya existe una calificacion con el nombre: \'' . $params['calificacion'] . '\'';
			}

			if (is_int(intval($params['id_respuesta'])) == false)
			{
				$messages[] = 'El campo respuesta debe ser de tipo numérico.';	
			}

			if (empty($params['calificacion']) || is_null($params['calificacion']) || strlen($params['calificacion']) == 0 || strlen($params['calificacion']) > 255)
			{
				$messages[] = 'El campo calificacion no puede quedar vacío ni contener mas de 255 caracteres.';	
			}

			if (empty($params['comentario']) || is_null($params['comentario']) || strlen($params['comentario']) == 0 || strlen($params['comentario']) > 255)
			{
				$messages[] = 'El campo comentario no puede quedar vacío.';	
			}

			if (is_int(intval($params['tipo'])) == false)
			{
				$messages[] = 'El campo tipo debe ser de tipo numérico.';	
			}	

			if (is_int(intval($params['id_usuario'])) == false)
			{
				$messages[] = 'El campo emprendedor debe ser de tipo numérico.';	
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

				try 
				{
					$calificacion 				= Calificacion::find($params['id']);
					$calificacion->id_respuesta = intval($params['id_respuesta']);
					$calificacion->calificacion = $params['calificacion'];
					$calificacion->comentario 	= $params['comentario'];
					$calificacion->tipo 		= intval($params['tipo']);
					$calificacion->id_usuario 	= intval($params['id_usuario']);

					if ($calificacion->save())
					{
						$db::commit();
						$this->response['code'] = 1;
						$this->response['data'] = $calificacion;
						$this->response['message'] = 'Se ha actualizado correctamente la calificacion.';
					}
					else
					{
						$this->response['code'] = 5;
						$this->response['messages'] = 'No se pudo completar la acción, intentelo más tarde.';
					}
				} 
				catch (Exception $e) 
				{
					$db::rollBack();
					$this->response['code'] = 5;
					$this->response['messages'] = 'Ocurrió un error, favor de contactar al administrador.';
				}
			}
		}
		else
		{
			$this->response['code'] = 2;
			$this->response['data'] = $params;
			$this->response['message'] = 'Todos los parámetros son requeridos.';
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
		$calificacion = Calificacion::with('user')
							->where('id', '=', $params[0])->get();

		if (count($calificacion) > 0)
		{
			/*if (count($calificacion[0]->users) > 0)
			{
				$this->response['code'] = 5;
				$this->response['message'] = 'Existen referencias con usuarios.';
			}
			if (count($calificacion[0]->permisos) > 0)
			{
				$this->response['code'] = 5;
				$this->response['message'] = 'Existen referencias con permisos.';
			}
			if (count($calificacion[0]->user) > 0)
			{
				$this->response['code'] = 5;
				$this->response['message'] = 'Existen referencias con calificaciones.';
			}
			else
			{*/
				$db = Connection::getConnection();
				$db::beginTransaction();

				try 
				{
					if ($calificacion[0]->delete())
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
					$this->response['message'] = 'Ocurrió un error, favor de contactar al administrado.';
					$this->response['error'] = $e->getMessage();

				}
			// }
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