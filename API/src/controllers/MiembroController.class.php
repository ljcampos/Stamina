<?php

/**
* 
*/
class MiembroController extends Controller
{
	static $routes = array(
		'all' 		=>	'getAll',
		'one'			=>	'getById',
		'add' 		=>	'insert',
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
	private $attributes = array(
		'id_respuesta', 
		'id_emprendedor_convocatoria', 
		'id_pregunta',
		'nombre',
		'apellido_paterno',
		'apellido_materno',
		'telefono',
		'correo',
		'nivel_academico',
		'capital',
		'red',
		'sector',
		'tecnologia',
		'describe1',
		'negocios',
		'innovacion',
		'capacidad',
		'describe2'
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
	public function getAll ()
	{
		
		$miembros = Miembro::all();
		$this->response['code'] = 1;
		$this->response['data'] = $miembros;
		$this->response['message'] = 'Lista de miembros';
		
		return $this->response;
	}

	/**
	*
	*/
	public function getById($id)
	{
		$id = strip_tags($id);
		$id = filter_var($id, FILTER_SANITIZE_STRING);

		$mentor = Miembro::find($id);

		if ($mentor != null)
		{
			$this->response['code'] = 1;
			$this->response['data'] = $mentor;
			$this->response['message'] = 'Recurso encontrado';
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
	public function insert(Array $params)
	{
		$params = $this->sanitize($params);

		if ($this->checkAttributes($params) === true)
		{
			$respuesta 		= Respuesta::find($params['id_respuesta']);
			$emprendedor 	= EmprendedorConvocatoria::find($params['id_emprendedor_convocatoria']);
			$pregunta 		= Pregunta::find($params['id_pregunta']);

			if ($respuesta != null && $emprendedor != null && $pregunta != null)
			{
				if ($params['nombre'] != '' && $params['apellido_paterno'] != '' && $params['apellido_materno'] != ''
					&& $params['telefono'] != '' && $params['correo'] != '' && $params['nivel_academico'] != '' && $params['capital'] != ''
					&& $params['red'] != '' && $params['sector'] != '' && $params['tecnologia'] != '' && $params['describe1'] != '' 
					&& $params['negocios'] != '' && $params['innovacion'] != '' && $params['capacidad'] != '' && $params['describe2'] != '')
				{
					$db = Connection::getConnection();
					$db::beginTransaction();

					try 
					{
						$miembro = new Miembro();
						$miembro->id_respuesta 								= $respuesta->id;
						$miembro->id_emprendedor_convocatoria = $emprendedor->id;
						$miembro->id_pregunta 								= $pregunta->id;
						$miembro->nombre 											= $params['nombre'];
						$miembro->apellido_paterno 						= $params['apellido_paterno'];
						$miembro->apellido_materno 						= $params['apellido_materno'];
						$miembro->telefono 										= $params['telefono'];
						$miembro->correo 											= $params['correo'];
						$miembro->nivel_academico 						= $params['nivel_academico'];
						$miembro->capital 										= $params['capital'];
						$miembro->red 												= $params['red'];
						$miembro->tecnologia 									= $params['tecnologia'];
						$miembro->describe1 									= $params['describe1'];
						$miembro->negocios 										= $params['negocios'];
						$miembro->innovacion 									= $params['innovacion'];
						$miembro->capacidad 									= $params['capacidad'];
						$miembro->describe2 									= $params['describe2'];

						if ($miembro->save() == true) 
						{
							$db::commit();
							$this->response['code'] = 1;
							$this->response['message'] = 'Se ha guardado correctamente';
						}
					} 
					catch (PDOException $e) 
					{
						$db::rollBack();
						$this->response['code'] 		= 5;
						$this->response['message'] 	= 'Ocurrió un error.';		
						$this->response['error']		=	$e->getMessage();
					}
				}
				else
				{
					$this->response['code'] = 5;
					$this->response['message'] = 'No puede enviar valores vacíos';			
				}
			}
			else 
			{
				$this->response['code'] = 5;
				$this->response['message'] = 'Debe enviar un identificador valido para respuesta, emprendedor, pregunta';		
			}

		}	
		else
		{
			$this->response['code'] = 5;
			$this->response['message'] = 'Todos los parámetros son requeridos';
		}

		return $this->response;
	}

	/**
	*
	*/
	public function update(Array $params)
	{
		$params 	= $this->sanitize($params);
		$miembro 	= Miembro::find($params['id']);	

		if ($miembro != null)
		{
			if ($this->checkAttributes($params) === true)
			{
				$respuesta 		= Respuesta::find($params['id_respuesta']);
				$emprendedor 	= EmprendedorConvocatoria::find($params['id_emprendedor_convocatoria']);
				$pregunta 		= Pregunta::find($params['id_pregunta']);

				if ($respuesta != null && $emprendedor != null && $pregunta != null)
				{
					if ($params['nombre'] != '' && $params['apellido_paterno'] != '' && $params['apellido_materno'] != ''
						&& $params['telefono'] != '' && $params['correo'] != '' && $params['nivel_academico'] != '' && $params['capital'] != ''
						&& $params['red'] != '' && $params['sector'] != '' && $params['tecnologia'] != '' && $params['describe1'] != '' 
						&& $params['negocios'] != '' && $params['innovacion'] != '' && $params['capacidad'] != '' && $params['describe2'] != '')
					{
						$db = Connection::getConnection();
						$db::beginTransaction();

						try 
						{
							$miembro->id_respuesta 								= $respuesta->id;
							$miembro->id_emprendedor_convocatoria = $emprendedor->id;
							$miembro->id_pregunta 								= $pregunta->id;
							$miembro->nombre 											= $params['nombre'];
							$miembro->apellido_paterno 						= $params['apellido_paterno'];
							$miembro->apellido_materno 						= $params['apellido_materno'];
							$miembro->telefono 										= $params['telefono'];
							$miembro->correo 											= $params['correo'];
							$miembro->nivel_academico 						= $params['nivel_academico'];
							$miembro->capital 										= $params['capital'];
							$miembro->red 												= $params['red'];
							$miembro->tecnologia 									= $params['tecnologia'];
							$miembro->describe1 									= $params['describe1'];
							$miembro->negocios 										= $params['negocios'];
							$miembro->innovacion 									= $params['innovacion'];
							$miembro->capacidad 									= $params['capacidad'];
							$miembro->describe2 									= $params['describe2'];

							if ($miembro->save() == true) 
							{
								$db::commit();
								$this->response['code'] = 1;
								$this->response['message'] = 'Se ha guardado correctamente';
							}
						} 
						catch (PDOException $e) 
						{
							$db::rollBack();
							$this->response['code'] 		= 5;
							$this->response['message'] 	= 'Ocurrió un error.';		
							$this->response['error']		=	$e->getMessage();
						}
					}
					else
					{
						$this->response['code'] = 5;
						$this->response['message'] = 'No puede enviar valores vacíos';			
					}
				}
				else 
				{
					$this->response['code'] = 5;
					$this->response['message'] = 'Debe enviar un identificador valido para respuesta, emprendedor, pregunta';		
				}

			}	
			else
			{
				$this->response['code'] = 5;
				$this->response['message'] = 'Todos los parámetros son requeridos';
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
	public function delete($id)
	{
		$params = $this->sanitize(array($id));
		$miembro = Miembro::find($params[0]);

		if ($miembro != null)
		{
			$db = Connection::getConnection();
			$db::beginTransaction();

			try 
			{
				if ($miembro->delete()) 
				{
					$db::commit();
					$this->response['code'] = 1;
					$this->response['message'] = 'Se ha eliminado correctamente.';		
				}
			} 
			catch (PDOException $e) 
			{
				$db::rollBack();
				$this->response['code'] = 5;
				$this->response['message'] = 'Ocurrió un error.';	
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


}