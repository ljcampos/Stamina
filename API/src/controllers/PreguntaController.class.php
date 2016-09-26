<?php

/**
* 
*/
class PreguntaController extends Controller
{
	static $routes = array(
		'all' 		=>	'getAll',
		'one'			=>	'getById',
		'add' 		=>	'create',
		'update'	=>	'update',
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
	private $attributes = array('pregunta', 'nota', 'ayuda', 'aplica_calificacion', 'id_seccion');

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
		$preguntas = Pregunta::orderBy('pregunta', 'ASC')->get();
		$this->response['code'] = 1;
		$this->response['data'] = $preguntas;
		$this->response['message'] = 'Lista completa de preguntas';

		return $this->response;
	}	

	/**
	* 
	*/
	public function getById($id)
	{
		$params = $this->sanitize(array($id));

		if (is_int(intval($params[0])))
		{
			$pregunta = Pregunta::find(intval($params[0]));
			if ($pregunta != null)
			{
				$this->response['code'] = 1;
				$this->response['data'] = $pregunta;
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
			$this->response['message'] = 'El identificador de pregunta debe ser de tipo numérico.';
		}

		return $this->response;
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

			if (empty($params['pregunta']) || is_null($params['pregunta']) || strlen($params['pregunta']) == 0 || strlen($params['pregunta']) > 255)
			{
				$messages[] = 'El campo pregunta no debe estar vacío ni contener mas de 255 caracteres.';
			}
			elseif (count(Pregunta::where('pregunta', '=', $params['pregunta'])->get()) > 0)
			{
				$messages[] = 'Ya existe una pregunta con el nombre: \'' . $params['pregunta'] . '\'';
			}

			if (empty($params['nota']) || strlen($params['nota']) == 0)
			{
				$messages[] = 'El campo nota no puede quedar vacío.';	
			}

			if (empty($params['ayuda']) || strlen($params['ayuda']) == 0)
			{
				$messages[] = 'El campo ayuda no puede quedar vacío.';	
			}			

			if (is_int(intval($params['aplica_calificacion'])) == false)
			{
				$messages[] = 'El campo aplica calificación debe ser de tipo numérico.';	
			}

			if (is_int(intval($params['id_seccion'])) == false)
			{
				$messages[] = 'El campo sección debe ser de tipo numérico.';	
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
					$pregunta = new Pregunta();
					$pregunta->pregunta = $params['pregunta'];
					$pregunta->nota = $params['nota'];
					$pregunta->ayuda = $params['ayuda'];
					$pregunta->aplica_calificacion = intval($params['aplica_calificacion']);
					$pregunta->id_seccion = intval($params['id_seccion']);

					if ($pregunta->save())
					{
						$db::commit();
						$this->response['code'] = 1;
						$this->response['data'] = $pregunta;
						$this->response['messages'] = 'Se ha guardado correctamente la pregunta.';
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

		return $this->response;
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

			if (Pregunta::find($params['id']) == null)
			{
				$messages[] = 'No existe la pregunta.';
			}

			if (empty($params['pregunta']) || is_null($params['pregunta']) || strlen($params['pregunta']) == 0 || strlen($params['pregunta']) > 255)
			{
				$messages[] = 'El campo pregunta no debe estar vacío ni contener mas de 255 caracteres.';
			}
			elseif (count(Pregunta::where('pregunta', '=', $params['pregunta'])
														->where('id', '!=', $params['id'])->get()) > 0)
			{
				$messages[] = 'Ya existe una pregunta con el nombre: \'' . $params['pregunta'] . '\'';
			}

			if (empty($params['nota']) || strlen($params['nota']) == 0)
			{
				$messages[] = 'El campo nota no puede quedar vacío.';	
			}

			if (empty($params['ayuda']) || strlen($params['ayuda']) == 0)
			{
				$messages[] = 'El campo ayuda no puede quedar vacío.';	
			}			

			if (is_int(intval($params['aplica_calificacion'])) == false)
			{
				$messages[] = 'El campo aplica calificación debe ser de tipo numérico.';	
			}

			if (is_int(intval($params['id_seccion'])) == false)
			{
				$messages[] = 'El campo sección debe ser de tipo numérico.';	
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
					$pregunta = Pregunta::find($params['id']);
					$pregunta->pregunta = $params['pregunta'];
					$pregunta->nota = $params['nota'];
					$pregunta->ayuda = $params['ayuda'];
					$pregunta->aplica_calificacion = intval($params['aplica_calificacion']);
					$pregunta->id_seccion = intval($params['id_seccion']);

					if ($pregunta->save())
					{
						$db::commit();
						$this->response['code'] = 1;
						$this->response['data'] = $pregunta;
						$this->response['message'] = 'Se ha guardado correctamente la pregunta.';
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

		return $this->response;
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