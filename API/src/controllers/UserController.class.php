<?php

/**
* 
*/
class UserController extends Controller
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
	private $attributes = array('username', 'email', 'password', 'nombre', 'paterno', 'materno', 'isMentor', 'rol');

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
		$usuarios = User::all();
		$lista_usuarios = array();

		if (count($usuarios) > 0)
		{
			foreach ($usuarios as $key => $value) {
				$usr = new User();
				$usr->username = $value->username;
				$usr->email = $value->email;
				$usr->last_login = $value->last_login;
				$usr->estatus = $value->status;

				$usr->roles = $value->roles;

				if (count($usr->roles) > 0)
				{
					foreach ($usr->roles as $key => $r) {
						$r->permisos = $r->permisos;
					}
				}

				$lista_usuarios[] = $usr;
			}
		}

		$this->response['code'] = 1;
		$this->response['data'] = $lista_usuarios;
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

			if (empty($params['username']) || strlen($params['username']) == 0 || strlen($params['username']) > 50)
			{
				$messages[] = 'El campo username no puede quedar vacío ni tener una longitud mayor a 50 caracteres';
			}
			elseif (count(User::where('username', '=', $params['username'])->get()) > 0)
			{
				$messages[] = 'Ya existe una cuenta de usuario con el nombre: \'' . $params['username'] . '\'';
			}

			if (empty($params['email']) || strlen($params['email']) == 0 || strlen($params['username']) > 50)
			{
				$messages[] = 'El campo email no puede quedar vacío ni tener una longitud mayor a 50 caracteres';
			}
			elseif (count(User::where('email', '=', $params['email'])->get()) > 0)
			{
				$messages[] = 'Ya existe un usuario asociado a la cuenta de correo: \'' . $params['email'] . '\'';
			}

			if (!filter_var($params['email'], FILTER_VALIDATE_EMAIL))
			{
				$messages[] = 'El email no es válido';
			}

			if (empty($params['nombre']) || strlen($params['nombre']) == 0 || strlen($params['nombre']) > 50)
			{
				$messages[] = 'El campo nombre no puede quedar vacío ni tener una longitud mayor a 50 caracteres';
			}

			if (empty($params['paterno']) || strlen($params['paterno']) == 0 || strlen($params['paterno']) > 50)
			{
				$messages[] = 'El campo paterno no puede quedar vacío ni tener una longitud mayor a 50 caracteres';
			}

			if (empty($params['materno']) || strlen($params['materno']) == 0 || strlen($params['materno']) > 50)
			{	
				$messages[] = 'El campo paterno no puede quedar vacío ni tener una longitud mayor a 50 caracteres';
			}

			if (empty($params['password']) || strlen($params['password']) == 0)
			{
				$messages[] = 'El campo password no puede quedar vacío';
			}

			if (empty($params['rol']) || $params['rol'] === null)
			{
				$messages[] = 'Debe enviar el rol';
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
					$salt 	= hash('sha256', uniqid());
					$token 	= hash('sha256', uniqid());
					$pwd 		= $params['password'] + $salt;
					$pwd 		= hash('sha256', $pwd);

					$user = new User();
					$user->username = $params['username'];
					$user->email = $params['email'];
					$user->password = $pwd;
					$user->salt = $salt;
					$user->token = $token;
					$user->estatus_id = 1;
					$user->save();

					$rol = new RolUsuario();
					$rol->rol_id = $params['rol'];
					$rol->user_id = $user->usuario_id;
					$rol->save();

					$persona = new Persona();
					$persona->persona_id = $user->usuario_id;
					$persona->nombre = $params['nombre'];
					$persona->apellido_paterno = $params['paterno'];
					$persona->apellido_materno = $params['materno'];
					$persona->save();

					if (intval($params['isMentor']) === 1)
					{
						$mentor = new Mentor();
						$mentor->mentor_id = $user->usuario_id;
						$mentor->cargo = $params['cargo'];
						$mentor->descr = $params['descr'];

						if ($mentor->save()) { $saved = true; }
					}
					
					$usr = new User;
					$usr->username = $user->username;
					$usr->email = $user->email;
					$usr->estatus = $user->status;
					$usr->roles = $user->roles;

					if (count($usr->roles) > 0)
					{
						foreach ($usr->roles as $key => $r) {
							$r->permisos = $r->permisos;
						}
					}

					$this->response['code'] = 1;
					$this->response['data'][] = $usr;
					$this->response['message'] = 'Se ha creado un nuevo usuario de manera correcta';
					$db::commit();

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
	public function authentication(Array $params)
	{
		if (count($params) == 0 || (!array_key_exists('email', $params) || !array_key_exists('pwd', $params)))
		{
			$this->response['code'] = 2;
			$this->response['message'] = 'Todos los parámetros son requeridos';
		}
		else
		{
			$params = $this->sanitize($params);
			$messages = array();

			if (strlen($params['email']) == 0 || strlen($params['email']) > 50 || empty($params['email']))
			{
				$messages[] = 'El campo email no puede quedar vacío ni tener una longitud mayor a 50 caracteres';
			}
			elseif (!filter_var($params['email'], FILTER_VALIDATE_EMAIL))
			{
				$messages[] = 'El email no es valido';
			}

			if (strlen($params['pwd']) == 0 || empty($params['pwd']))
			{
				$messages[] = 'El campo contraseña no puede quedar vacío';
			}

			if (count($messages) > 0)
			{
				$this->response['code'] = 2;
				$this->response['data'] = $params;
				$this->response['message'] = $messages;
			}
			else
			{
				$user = User::where('email', '=', $params['email'])->get();

				if (count($user) > 0)
				{
					$pwd = $params['pwd'] + $user[0]->salt;
					$pwd = hash('sha256', $pwd);

					if ($user[0]->password === $pwd)
					{
						$usr = new User();
						$usr->username = $user[0]->username;
						$usr->email = $user[0]->email;
						$usr->last_login = $user[0]->last_login;
						$usr->estatus = $user[0]->status;

						$usr->roles = $user[0]->roles;

						if (count($usr->roles) > 0)
						{
							foreach ($usr->roles as $key => $r) {
								$r->permisos = $r->permisos;
							}
						}
					
						$this->response['code'] = 1;
						$this->response['data'] = $usr->toArray();
						$this->response['message'] = 'Autenticación correcta';
					}
					else
					{
						$this->response['code'] = 2;
						$this->response['data'] = $params;
						$this->response['message'] = 'Contraseña incorrecta';		
					}
				}
				else
				{
					$this->response['code'] = 4;
					$this->response['data'] = $params;
					$this->response['message'] = 'El usuario no existe';
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