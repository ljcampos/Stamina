<?php

/**
* 
*/
class RespuestaController extends Controller
{
	static $routes = array(
		'all' 		=>	'getAll',
		'one'		=>	'getById',
		'add' 		=>	'create',
		'update'	=>	'update',
		'updateCalComFinal' => 'updateComentarioFinal',
		'emp'		=>	'getByEmprendedor',
		'empFull'	=>	'getByEmprendedorFull',
		'del'		=>	'delete'
	);

	/**
	* 
	*/
	private $response = array(
		'code' 		=>	1,
		'data'		=>	array(),
		'messages'	=>	''
	);

	/**
	* 
	*/
	private $attributes = array('id_pregunta', 'respuesta', 'calificacion_final', 'comentario_final', 'id_emprendedor_convocatoria');

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
		$preguntas = Respuesta::orderBy('respuesta', 'ASC')->get();
		$this->response['code'] = 1;
		$this->response['data'] = $preguntas;
		$this->response['message'] = 'Lista completa de respuestas';

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
			$respuesta = Respuesta::find(intval($params[0]));
			if ($respuesta != null)
			{
				$this->response['code'] = 1;
				$this->response['data'] = $respuesta;
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
			$this->response['message'] = 'El identificador de respuesta debe ser de tipo numérico.';
		}

		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;
	}


	/**
	* 
	*/
	public function getByEmprendedor($id)
	{
		$params = array($id);
		$respuestas = Respuesta::where('id_emprendedor_convocatoria', '=', $id)->get();
		$respuestasParser = array();
		foreach($respuestas as $key => $value){
			//var_dump($value->id);
			array_push($respuestasParser, array('a'.$value->id_pregunta => $value->respuesta, 'index' => $value->id_pregunta));
		}
		//$this->response['data'] = $respuestas;
		$this->response['data'] = $respuestasParser;
		$this->response['code'] = 1;

		return $this->response;
	}

	/**
	* 
	*/
	public function getByEmprendedorFull($id)
	{
		$params = array($id);
		$respuestas = Respuesta::with('pregunta')
								->where('id_emprendedor_convocatoria', '=', $id)->get();

		foreach($respuestas as $key => $value){
			$value->id;
		}
		$this->response['data'] = $respuestas;
		$this->response['code'] = 1;

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

			if (empty($params['respuesta']) || is_null($params['respuesta']) || strlen($params['respuesta']) == 0)
			{
				$messages[] = 'El campo respuesta no debe estar vacío.';
			}
			elseif (count(Respuesta::where('respuesta', '=', $params['respuesta'])->get()) > 0)
			{
				$messages[] = 'Ya existe una respuesta con el nombre: \'' . $params['respuesta'] . '\'';
			}

			if (is_int(intval($params['id_pregunta'])) == false)
			{
				$messages[] = 'El campo pregunta debe ser de tipo numérico.';	
			}

			if (empty($params['calificacion_final']) || is_null($params['calificacion_final']) || strlen($params['calificacion_final']) == 0 || strlen($params['calificacion_final']) > 255)
			{
				$messages[] = 'El campo comentario final no puede quedar vacío ni contener mas de 255 caracteres.';	
			}

			if (empty($params['comentario_final']) || is_null($params['comentario_final']) || strlen($params['comentario_final']) == 0 || strlen($params['comentario_final']) > 255)
			{
				$messages[] = 'El campo comentario final no puede quedar vacío.';	
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
					$respuesta = new Respuesta();
					$respuesta->id_pregunta = intval($params['id_pregunta']);
					$respuesta->respuesta = $params['respuesta'];
					$respuesta->calificacion_final = $params['calificacion_final'];
					$respuesta->comentario_final = $params['comentario_final'];
					$respuesta->id_emprendedor_convocatoria = intval($params['id_emprendedor_convocatoria']);

					if ($respuesta->save())
					{
						$db::commit();
						$this->response['code'] = 1;
						$this->response['data'] = $respuesta;
						$this->response['messages'] = 'Se ha guardado correctamente la respuesta.';
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
		if (count($params) > 0 /*&& $this->checkAttributes($params) === true*/)
		{
			$params = $this->sanitize($params);
			$messages = array();

			$respuestas = Respuesta::where('id_pregunta', '=', $params['id_pregunta'])
								   ->where('id_emprendedor_convocatoria', '=', $params['id_emp_con'])
								   ->orderBy('respuesta', 'ASC')->get();
			
			//print_r($respuestas);
			if ($respuestas == null)
			{
				$messages[] = 'No existe la respuesta.';
			}

			if (empty($params['post']['respuesta']) || is_null($params['post']['respuesta']) || strlen($params['post']['respuesta']) == 0)
			{
				$messages[] = 'El campo respuesta no debe estar vacío.';
			}
			// elseif (count(Respuesta::where('respuesta', '=', $params['post']['respuesta'])->get()) > 0)
			// {
			// 	$messages[] = 'Ya existe una respuesta con el nombre: \'' . $params['post']['respuesta'] . '\'';
			// }

			if (is_int(intval($params['id_pregunta'])) == false)
			{
				$messages[] = 'El campo pregunta debe ser de tipo numérico.';	
			}

			/*if (empty($params['post']['calificacion_final']) || is_null($params['post']['calificacion_final']) || strlen($params['post']['calificacion_final']) == 0 || strlen($params['post']['calificacion_final']) > 255)
			{
				$messages[] = 'El campo comentario final no puede quedar vacío ni contener mas de 255 caracteres.';	
			}

			if (empty($params['post']['comentario_final']) || is_null($params['post']['comentario_final']) || strlen($params['post']['comentario_final']) == 0 || strlen($params['post']['comentario_final']) > 255)
			{
				$messages[] = 'El campo comentario final no puede quedar vacío.';	
			}*/

			if (is_int(intval($params['id_emp_con'])) == false)
			{
				$messages[] = 'El campo emprendedor convocatoria debe ser de tipo numérico.';
			}

			if (count($messages) > 0)
			{
				$this->response['code'] = 2;
				$this->response['data'] = $params;
				$this->response['messages'] = $messages;
			}
			else
			{
				$db = Connection::getConnection();
				$db::beginTransaction();

				try 
				{

					$id = $respuestas[0]->id;
					$respuesta = Respuesta::find($id);

					$respuesta->id_pregunta 				= intval($params['id_pregunta']);
					$respuesta->respuesta 					= $params['post']['respuesta'];
					unset($respuesta->calificacion_final);
					unset($respuesta->comentario_final);
					$respuesta->id_emprendedor_convocatoria = intval($params['id_emp_con']);

					// print_r($respuesta);
					if ($respuesta->save())
					{
						$db::commit();
						$this->response['code'] = 1;
						$this->response['data'] = $respuesta;
						$this->response['messages'] = 'Se ha actualizado correctamente la respuesta.';
					}
					else
					{
						$this->response['code'] = 5;
						$this->response['data'] = $respuesta;
						$this->response['messages'] = 'No se pudo completar la acción, intentelo más tarde.';
					}
				} 
				catch (Exception $e) 
				{
					$db::rollBack();
					$this->response['code'] = 5;
					$this->response['data'] = $respuesta;
					$this->response['messages'] = 'Ocurrió un error, favor de contactar al administrador.';
					$this->response['error'] = $e->getMessage();
				}
			}

		}
		else
		{
			$this->response['code'] = 2;
			$this->response['data'] = $params;
			$this->response['messages'] = 'Todos los parámetros son requeridos.';
		}

		
		return $this->response;
	}

	/**
	* 
	*/
	public function updateComentarioFinal($params)
	{
		if (count($params) > 0 /*&& $this->checkAttributes($params) === true*/)
		{
			$params = $this->sanitize($params);
			$messages = array();

			
			$respuestas = Respuesta::where('id', '=', $params['id_respuesta'])->get();
			
			//print_r($respuestas);
			if ($respuestas == null)
			{
				$messages[] = 'No existe la respuesta.';
			}

			// if (empty($params['post']['respuesta']) || is_null($params['post']['respuesta']) || strlen($params['post']['respuesta']) == 0)
			// {
			// 	$messages[] = 'El campo respuesta no debe estar vacío.';
			// }
			// elseif (count(Respuesta::where('respuesta', '=', $params['post']['respuesta'])->get()) > 0)
			// {
			// 	$messages[] = 'Ya existe una respuesta con el nombre: \'' . $params['post']['respuesta'] . '\'';
			// }

			// if (is_int(intval($params['id_pregunta'])) == false)
			// {
			// 	$messages[] = 'El campo pregunta debe ser de tipo numérico.';	
			// }

			if (empty($params['calificacion_final']) || is_null($params['calificacion_final']) || strlen($params['calificacion_final']) == 0 || strlen($params['calificacion_final']) > 255)
			{
				$messages[] = 'El campo comentario final no puede quedar vacío ni contener mas de 255 caracteres.';	
			}

			if (empty($params['comentario_final']) || is_null($params['comentario_final']) || strlen($params['comentario_final']) == 0 || strlen($params['comentario_final']) > 255)
			{
				$messages[] = 'El campo comentario final no puede quedar vacío.';	
			}

			// if (is_int(intval($params['id_emp_con'])) == false)
			// {
			// 	$messages[] = 'El campo emprendedor convocatoria debe ser de tipo numérico.';
			// }

			if (count($messages) > 0)
			{
				$this->response['code'] = 2;
				$this->response['data'] = $params;
				$this->response['messages'] = $messages;
			}
			else
			{
				$db = Connection::getConnection();
				$db::beginTransaction();

				try 
				{

					$respuesta = Respuesta::find($params['id_respuesta']);

					unset($respuesta->id_pregunta);
					unset($respuesta->respuesta);
					$respuesta->calificacion_final	= $params['calificacion_final'];
					$respuesta->comentario_final 	= $params['comentario_final'];
					unset($respuesta->id_emprendedor_convocatoria);



					// print_r($respuesta);
					if ($respuesta->save())
					{
						$db::commit();
						$this->response['code'] = 1;
						$this->response['data'] = $respuesta;
						$this->response['messages'] = 'Se ha actualizado correctamente la respuesta.';
					}
					else
					{
						$this->response['code'] = 5;
						$this->response['data'] = $respuesta;
						$this->response['messages'] = 'No se pudo completar la acción, intentelo más tarde.';
					}
				} 
				catch (Exception $e) 
				{
					$db::rollBack();
					$this->response['code'] = 5;
					$this->response['data'] = $respuesta;
					$this->response['messages'] = 'Ocurrió un error, favor de contactar al administrador.';
					$this->response['error'] = $e->getMessage();
				}
			}

		}
		else
		{
			$this->response['code'] = 2;
			$this->response['data'] = $params;
			$this->response['messages'] = 'Todos los parámetros son requeridos.';
		}

		
		return $this->response;
	}

	/**
	* 
	*/
	public function delete($id)
	{
		$params = $this->sanitize(array($id));
		$respuesta = Respuesta::with('calificacion')
							->where('id', '=', $params[0])->get();

		if (count($respuesta) > 0)
		{
			/*if (count($respuesta[0]->users) > 0)
			{
				$this->response['code'] = 5;
				$this->response['message'] = 'Existen referencias con usuarios.';
			}
			if (count($respuesta[0]->permisos) > 0)
			{
				$this->response['code'] = 5;
				$this->response['message'] = 'Existen referencias con permisos.';
			}*/
			if (count($respuesta[0]->calificacion) > 0)
			{
				$this->response['code'] = 5;
				$this->response['message'] = 'Existen referencias con calificaciones.';
			}
			else
			{
				$db = Connection::getConnection();
				$db::beginTransaction();

				try 
				{
					if ($respuesta[0]->delete())
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