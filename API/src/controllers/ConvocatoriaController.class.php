<?php
/**
* 
*/
class ConvocatoriaController extends Controller
{
	static $routes = array(
		'all' 	=>	'getAll',
		'add' 	=>	'create',
		'auth'	=>	'authentication'
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