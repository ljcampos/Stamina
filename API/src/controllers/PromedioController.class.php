<?php 


/**
* 
*/
class PromedioController extends Controller
{
	static $routes = array(
		'all' 		=>	'getAll',
		'one'		=>	'getById',
		'add' 		=>	'create',
		'update'	=>	'update',
		'del'		=>	'delete'
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
	private $attributes = array('promedio', 'conclusion', 'id_emprendedor_convocatoria');

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
		$promedio = Promedio::orderBy('promedio', 'ASC')->get();
		$this->response['code'] = 1;
		$this->response['data'] = $promedio;
		$this->response['message'] = 'Lista completa de promedios';

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
			$promedio = Promedio::find(intval($params[0]));
			if ($promedio != null)
			{
				$this->response['code'] = 1;
				$this->response['data'] = $promedio;
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
			$this->response['message'] = 'El identificador de promedio debe ser de tipo numérico.';
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

			if (empty($params['promedio']) || is_null($params['promedio']) || strlen($params['promedio']) == 0)
			{
				$messages[] = 'El campo promedio no debe estar vacío.';
			}
			elseif (count(Promedio::where('promedio', '=', $params['promedio'])->get()) > 0)
			{
				$messages[] = 'Ya existe una promedio con el nombre: \'' . $params['promedio'] . '\'';
			}

			if (empty($params['promedio']) || is_null($params['promedio']) || strlen($params['promedio']) == 0 || strlen($params['promedio']) > 255)
			{
				$messages[] = 'El campo promedio no puede quedar vacío ni contener mas de 255 caracteres.';	
			}

			if (empty($params['conclusion']) || is_null($params['conclusion']) || strlen($params['conclusion']) == 0 || strlen($params['conclusion']) > 255)
			{
				$messages[] = 'El campo conclusion no puede quedar vacío.';	
			}

			if (is_int(intval($params['id_emprendedor_convocatoria'])) == false)
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
					$promedio 								= new Promedio();					
					$promedio->promedio 					= $params['promedio'];
					$promedio->conclusion 					= $params['conclusion'];
					$promedio->id_emprendedor_convocatoria 	= intval($params['id_emprendedor_convocatoria']);
					

					if ($promedio->save())
					{
						$db::commit();
						$this->response['code'] = 1;
						$this->response['data'] = $promedio;
						$this->response['messages'] = 'Se ha guardado correctamente la promedio.';
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

			if (empty($params['promedio']) || is_null($params['promedio']) || strlen($params['promedio']) == 0)
			{
				$messages[] = 'El campo promedio no debe estar vacío.';
			}
			elseif (count(Promedio::where('promedio', '=', $params['promedio'])->get()) > 0)
			{
				$messages[] = 'Ya existe una promedio con el nombre: \'' . $params['promedio'] . '\'';
			}

			if (empty($params['promedio']) || is_null($params['promedio']) || strlen($params['promedio']) == 0 || strlen($params['promedio']) > 255)
			{
				$messages[] = 'El campo promedio no puede quedar vacío ni contener mas de 255 caracteres.';	
			}

			if (empty($params['conclusion']) || is_null($params['conclusion']) || strlen($params['conclusion']) == 0 || strlen($params['conclusion']) > 255)
			{
				$messages[] = 'El campo conclusion no puede quedar vacío.';	
			}

			if (is_int(intval($params['id_emprendedor_convocatoria'])) == false)
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
					$promedio 								= Promedio::find($params['id']);

					if ($promedio == null) 
					{
						$this->response['code'] = 4;
						$this->response['message'] = 'Recurso no encontrado';	
					}
					else
					{
						
						$promedio->promedio 					= $params['promedio'];
						$promedio->conclusion 					= $params['conclusion'];
						$promedio->id_emprendedor_convocatoria 	= intval($params['id_emprendedor_convocatoria']);

						if ($promedio->save())
						{
							$db::commit();
							$this->response['code'] = 1;
							$this->response['data'] = $promedio;
							$this->response['message'] = 'Se ha actualizado correctamente la promedio.';
						}
						else
						{
							$this->response['code'] = 5;
							$this->response['messages'] = 'No se pudo completar la acción, intentelo más tarde.';
						}
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
		$promedio = Promedio::with('user')
							->where('id', '=', $params[0])->get();

		if (count($promedio) > 0)
		{
			/*if (count($promedio[0]->users) > 0)
			{
				$this->response['code'] = 5;
				$this->response['message'] = 'Existen referencias con usuarios.';
			}
			if (count($promedio[0]->permisos) > 0)
			{
				$this->response['code'] = 5;
				$this->response['message'] = 'Existen referencias con permisos.';
			}*/
			if (count($promedio[0]->user) > 0)
			{
				$this->response['code'] = 5;
				$this->response['message'] = 'Existen referencias con emprendedor.';
			}
			else
			{
				print_r($promedio);
				/*$db = Connection::getConnection();
				$db::beginTransaction();

				try 
				{
					if ($promedio[0]->delete())
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

				}*/
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