<?php

/**
* 
*/
class UserController extends Controller
{
	static $routes = array(
		'all' 		=>	'getAll',
		'one'			=>	'getById',
		'add' 		=>	'create',
		'update'	=>	'update',
		'suscrip'	=>	'suscribirse',
		'auth'		=>	'authentication',
		'img'			=>	'addImage',
		'search'	=>  'search'
	);

	private $DIRECTORY = __DIR__ . '/../../uploads/usuario/';
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
	private $attributes = array('username', 'email', 'password', 'nombre', 'paterno', 'materno', 'type');

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
	public function getAll(Array $params)
	{	
		$usuarios = null;
		$lista_usuarios = array();
		$params = $this->sanitize($params);
		$type = 0;

		if (array_key_exists('type', $params)) { $type = intval($params['type']); }

		if ($type === 0 && is_int($type)) // Todos los usuarios
		{
			$usuarios = User::orderBy('username', 'ASC')->get();
		}
		elseif ($type === 1 && $type != null) // Usuarios de tipo emprendedor
		{
			$rol = Role::where('rol', '=', 'emprendedor')->get();
			if (count($rol) > 0) { $usuarios = $rol[0]->users; }
		}
		elseif ($type === 2 && $type != null) // Usuarios de tipo mentor
		{
			$rol = Role::where('rol', '=', 'mentor')->get();
			if (count($rol) > 0) { $usuarios = $rol[0]->users; }
		}
		elseif ($type === 3 && $type != null) // Usuarios de tipo administrador
		{
			$rol = Role::where('rol', '=', 'admin')->get();
			if (count($rol) > 0) { $usuarios = $rol[0]->users; }	
		}
		else 
		{
			$this->response['message'] = 'El parámetro type es requerido y debe de ser un tipo de dato numérico.';
		}

		if (count($usuarios) > 0)
		{
			foreach ($usuarios as $key => $value) {
				
				$usr = new User();
				$usr->usuario_id = $value->usuario_id;
				$usr->username = $value->username;
				$usr->nombre = $value->persona->nombre;
				$usr->paterno = $value->persona->apellido_paterno;
				$usr->materno = $value->persona->apellido_materno;
				$usr->email = $value->email;
				$usr->imagen = ($value->imagen != "" || $value->imagen != null) ? $this->DIRECTORY . $value->imagen : '';
				$usr->last_login = $value->last_login;
				$usr->estatus = $value->status;

				$usr->roles = $value->roles;

				if (count($usr->roles) > 0)
				{
					foreach ($usr->roles as $key => $r) {

						if (strtoupper($r->rol) === 'MENTOR')
						{
							$mentor = Mentor::find($usr->usuario_id);
							$usr->cargo = $mentor->cargo;
							$usr->descr = $mentor->descr;
						}

						if (strtoupper($r->rol) === 'EMPRENDEDOR')
						{
							if (count($usr->convocatorias) > 0)
							{
								foreach ($usr->convocatorias as $llave => $convocatoria) {
									$convocatoria->path = (strlen($convocatoria->path) > 0) ? __DIR__ . '/../../uploads/convocatoria/' . $convocatoria->path : '';
									$convocatoria->universidad;
									$convocatoria->universidad->imagen = (strlen($convocatoria->universidad->imagen) > 0) ? __DIR__ . '/../../uploads/universidad/' . $convocatoria->universidad->imagen : '';
									unset($convocatoria->universidad_id);
									unset($convocatoria->pivot);
								}
							}
						}

						$r->permisos = $r->permisos;
						unset($r->pivot);

						if (count($r->permisos) > 0)
						{
							foreach ($r->permisos as $k => $permiso) {
								unset($permiso->pivot);
							}
						}
					}
				}

				$lista_usuarios[] = $usr;
			}
			$this->response['message'] = 'Correcto';
		}

		$this->response['code'] = 1;
		$this->response['data'] = $lista_usuarios;

		return $this->response;
	}	

	public function search($facebookId) {
		$params = $this->sanitize(array($facebookId));

		if (is_int(intval($params[0]))) {
			$facebookUser = $params[0];
			$usuario = User::with('roles')->where('facebookId', '=', $facebookUser)->get();

			if (count($usuario) > 0) {
				// $usr = new User();
				// $usr->username 		= $usuario[0]->username;
				// $usr->nombre 			= $usuario[0]->persona->nombre;
				// $usr->paterno 		= $usuario[0]->persona->apellido_paterno;
				// $usr->materno 		= $usuario[0]->persona->apellido_materno;
				// $usr->email 			= $usuario[0]->email;
				// $usr->imagen 			= $usuario[0]->imagen;
				// $usr->last_login 	= $usuario[0]->last_login;
				// $usr->estatus 		= $usuario[0]->status;
				// $usr->roles 			= $usuario[0]->roles;
				// $usr->roles->permisos;
				$this->response['code'] = 1;
				$this->response['data'] = true;
				$this->response['message'] = 'Recurso encontrado';
			} else {
				$this->response['code'] = 4;
				$this->response['message'] = 'El usuario con el identificaro \'' . $params[0] . '\' no existe.';
			}
		} else {
			$this->response['code'] = 2;
			$this->response['message'] = 'El identificador del usuario debe ser de tipo número.';
		}

		// $json = json_encode($this->response, JSON_FORCE_OBJECT);
		$json = $this->response;
		return $json;
	}

	/**
	* 
	*/
	public function getById($usuario_id)
	{

		$params = $this->sanitize(array($usuario_id));

		if (is_int(intval($params[0])))
		{
			$usuario_id = intval($params[0]);
			$usuario = User::with('roles')->where('usuario_id', '=', $usuario_id)->get();

			if (count($usuario) > 0)
			{
				$usr = new User();
				$usr->usuario_id 	=	$usuario[0]->usuario_id;
				$usr->username 		= $usuario[0]->username;
				$usr->nombre 			= $usuario[0]->persona->nombre;
				$usr->paterno 		= $usuario[0]->persona->apellido_paterno;
				$usr->materno 		= $usuario[0]->persona->apellido_materno;
				$usr->email 			= $usuario[0]->email;
				$usr->imagen 			= ($usuario[0]->imagen != "" || $usuario[0]->imagen != null) ? $this->DIRECTORY . $usuario[0]->imagen : '';
				$usr->last_login 	= $usuario[0]->last_login;
				$usr->estatus 		= $usuario[0]->status;
				$usr->roles 			= $usuario[0]->roles;

				if (count($usr->roles) > 0)
				{
					foreach ($usr->roles as $key => $rol) {
						if (strtoupper($rol->rol) === 'MENTOR')
						{
							$mentor = Mentor::find($usr->usuario_id);
							$usr->cargo = $mentor->cargo;
							$usr->descr = $mentor->descr;
						}

						if (strtoupper($rol->rol) === 'EMPRENDEDOR')
						{
							if (count($usr->convocatorias) > 0)
							{
								foreach ($usr->convocatorias as $llave => $convocatoria) {
									$convocatoria->path = (strlen($convocatoria->path) > 0) ? __DIR__ . '/../../uploads/convocatoria/' . $convocatoria->path : '';
									$convocatoria->universidad;
									$convocatoria->universidad->imagen = (strlen($convocatoria->universidad->imagen) > 0) ? __DIR__ . '/../../uploads/universidad/' . $convocatoria->universidad->imagen : '';
									unset($convocatoria->universidad_id);
									unset($convocatoria->pivot);
								}
							}
						}

						$rol->permisos;
					}
				}

				$this->response['code'] = 1;
				$this->response['data'] = $usr;
				$this->response['message'] = 'Recurso encontrado';
			}
			else
			{
				$this->response['code'] = 4;
				$this->response['message'] = 'El usuario con el identificador \'' . $params[0] . '\' no existe.';		
			}
		}
		else
		{
			$this->response['code'] = 2;
			$this->response['message'] = 'El identificador del usuario debe ser de tipo número.';
		}

		return $this->response;
	}

	/**
	*
	*/
	public function create(Array $params)
	{
		$userType = (isset($params['facebookId'])) ? 'facebook' : 'email';
		$messages = array();

		if (count($params) == 0) { // all the attributes are required

			$this->response['code'] = 2;
			$this->response['message'] = 'Todos los parámetros son requeridos';

		} else if($userType == 'facebook') { // create user with facebook

			if (count(User::where('username', '=', $params['username'])->get()) > 0) {
				$messages[] = 'Ya existe una cuenta de usuario con el nombre: \'' . $params['username'] . '\'';
			}

			if (empty($params['email']) || strlen($params['email']) == 0 || strlen($params['email']) > 50)
			{
				$messages[] = 'El campo email no puede quedar vacío ni tener una longitud mayor a 50 caracteres';
			}
			elseif (count(User::where('email', '=', $params['email'])->get()) > 0) {
				$messages[] = 'Ya existe un usuario asociado a la cuenta de correo: \'' . $params['email'] . '\'';
			}

			if (count($messages) > 0) {
				$this->response['code'] = 2;
				$this->response['data'] = $params;
				$this->response['message'] = $messages;
			} else {
				$db = Connection::getConnection();
				$db::beginTransaction();
				$saved = false;

				try
				{
					$salt 	= hash('sha256', uniqid());
					$token 	= hash('sha256', uniqid());
					// Modelo Usuario
					$user = new User();
					$user->username = $params['username'];
					$user->email = $params['email'];
					$user->facebookId = $params['facebookId'];
					$user->salt = $salt;
					$user->token = $token;
					$user->estatus_id = 1;
					$user->save();

					// Modelo Persona
					$persona = new Persona();
					$persona->persona_id = $user->usuario_id;
					$persona->nombre = $params['nombre'];
					$persona->apellido_paterno = $params['paterno'];
					$persona->apellido_materno = $params['materno'];
					$persona->save();

					$type = intval($params['type']);
					$rol_id = 0;

					if ($type === 3 && $type != null) { // Usuario de tipo emprendedor
						$rol = Role::where('rol', '=', 'emprendedor')->get();
						if (count($rol) > 0) { $rol_id = $rol[0]->rol_id; }
					}
					
					elseif ($type === 2 && $type != null) // Usuarios de tipo mentor
					{
						$rol = Role::where('rol', '=', 'mentor')->get();
						if (count($rol) > 0) 
						{ 
							$rol_id = $rol[0]->rol_id; 
							$mentor = new Mentor();
							$mentor->mentor_id = $user->usuario_id;
							$mentor->cargo = $params['cargo'];
							$mentor->descr = $params['descr'];

							if ($mentor->save()) { $saved = true; }
						}
					}
					elseif ($type === 3 && $type != null) // Usuarios de tipo administrador
					{
						$rol = Role::where('rol', '=', 'admin')->get();
						if (count($rol) > 0) { $rol_id = $rol[0]->rol_id; }
					}
					elseif ($type === 4 && $type != null) // Usuarios de tipo universidad
					{
						$rol = Role::where('rol', '=', 'universidad')->get();
						if (count($rol) > 0) {
							$rol_id = $rol[0]->rol_id;

							$universidad = new Universidad();
							//$universidad->universidad_id = $user->usuario_id;
							$universidad->usuario_id = $user->usuario_id;
							$universidad->nombre = $params['nombre'];
							$universidad->estado_id = 1;

							if ($universidad->save()) { $saved = true; }
						}
					}

					// Asociación Usuario - Rol
					$rol = new RolUsuario();
					$rol->rol_id = $rol_id;
					$rol->user_id = $user->usuario_id;
					$rol->save();

					$usr = new User;
					$usr->usuario_id = $user->usuario_id;
					$usr->username = $user->username;
					$usr->email = $user->email;
					$usr->estatus = $user->status;
					$usr->roles = $user->roles;

					if (count($usr->roles) > 0)
					{
						foreach ($usr->roles as $key => $r) {
							$r->permisos = $r->permisos;
							unset($r->pivot);
						}
					}

					$this->response['code'] = 1;
					$this->response['data'][] = $usr;
					$this->response['message'] = 'Se ha creado un nuevo usuario de manera correcta';
					$db::commit();

				} catch (PDOException $e) {
					$db::rollBack();
					$this->response['code'] = 5;
					$this->response['data'][] = $params;
					$this->response['message'][] = 'No se ha podido completar la acción, inténtelo más tarde.';
					$this->response['message'][] = $e->getMessage();
				}
			}

		}else { // create user with email

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

				if (empty($params['email']) || strlen($params['email']) == 0 || strlen($params['email']) > 50)
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

				if (empty($params['type']) || $params['type'] === null || intval($params['type']) == null)
				{
					$messages[] = 'El campo type debe ser de tipo numérico';
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

						// Modelo Usuario
						$user = new User();
						$user->username = $params['username'];
						$user->email = $params['email'];
						$user->password = $pwd;
						$user->salt = $salt;
						$user->token = $token;
						$user->estatus_id = 1;
						$user->save();

						// Modelo Persona
						$persona = new Persona();
						$persona->persona_id = $user->usuario_id;
						$persona->nombre = $params['nombre'];
						$persona->apellido_paterno = $params['paterno'];
						$persona->apellido_materno = $params['materno'];
						$persona->save();

						$type = intval($params['type']);
						$rol_id = 0;
						
						if ($type === 1 && $type != null) // Usuario de tipo emprendedor
						{
							$rol = Role::where('rol', '=', 'emprendedor')->get();
							if (count($rol) > 0) { $rol_id = $rol[0]->rol_id; }
						}
						elseif ($type === 2 && $type != null) // Usuarios de tipo mentor
						{
							$rol = Role::where('rol', '=', 'mentor')->get();
							if (count($rol) > 0) 
							{ 
								$rol_id = $rol[0]->rol_id; 
								$mentor = new Mentor();
								$mentor->mentor_id = $user->usuario_id;
								$mentor->cargo = $params['cargo'];
								$mentor->descr = $params['descr'];

								if ($mentor->save()) { $saved = true; }
							}
						}
						elseif ($type === 3 && $type != null) // Usuarios de tipo administrador
						{
							$rol = Role::where('rol', '=', 'admin')->get();
							if (count($rol) > 0) { $rol_id = $rol[0]->rol_id; }
						}

						// Asociación Usuario - Rol
						$rol = new RolUsuario();
						$rol->rol_id = $rol_id;
						$rol->user_id = $user->usuario_id;
						$rol->save();
						
						$usr = new User;
						$usr->usuario_id = $user->usuario_id;
						$usr->username = $user->username;
						$usr->email = $user->email;
						$usr->estatus = $user->status;
						$usr->roles = $user->roles;

						if (count($usr->roles) > 0)
						{
							foreach ($usr->roles as $key => $r) {
								$r->permisos = $r->permisos;
								unset($r->pivot);
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
		}

		return $this->response;
		
	}

	/**
	*
	*/
	public function suscribirse(Array $params)
	{	
		$params = $this->sanitize($params);
		$messages = array();

		if (User::find(intval($params['usuario_id'])) == null)
		{
			$messages[] = 'No existe un usuario asociado al identificador \'' . $params['usuario_id'] . '\'';
		}

		if (Convocatoria::find(intval($params['convocatoria_id'])) == null) 
		{
			$messages[] = 'No existe una convocatoria asociado al identificador \'' . $params['convocatoria_id'] . '\'';		
		}

		if (!array_key_exists('estatus', $params['post']) || !is_int(intval($params['post']['estatus'])))
		{
			$messages[] = 'Debe enviar el parámetro estatus.';	
		}

		if (count(EmprendedorConvocatoria::where('id_emprendedor', '=', $params['usuario_id'])
																		->where('id_convocatoria', '=', $params['convocatoria_id'])->get()) > 0)
		{
			$messages[] = 'Ya se inscribió a la convocatoria';
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
				$convocatoria = Convocatoria::find(intval($params['convocatoria_id']));
				$fecha_actual = strtotime(date('Y-m-d'));

				if ($fecha_actual <= strtotime($convocatoria->fecha_cierre))
				{					
					$obj = new EmprendedorConvocatoria();
					$obj->id_emprendedor = $params['usuario_id'];
					$obj->id_convocatoria = $params['convocatoria_id'];
					$obj->estatus = intval($params['post']['estatus']);

					if ($obj->save())
					{
						$db::commit();
						$this->response['code'] = 1;
						$this->response['message'] = 'Se ha agregado correctamente';
					}
					else 
					{
						$this->response['code'] = 5;
						$this->response['message'] = 'Ocurrió un error, favor de intentarlo mas tarde';
					}
				}
				else
				{
					$this->response['code'] = 2;
					$this->response['message'] = 'La fecha actual es mayor a la fecha de cierre de la convocatoria';
				}
			} 
			catch (Exception $e) 
			{
				$db::rollBack();
				$this->response['code'] = 5;
				$this->response['message'] = 'Ocurrió un error, favor de contactar al administrador.';
			}
		}

		return $this->response;
	}

	/**
	* 
	*/
	public function authentication(Array $params)
	{
		$authenticationType = (isset($params['facebookId'])) ? 'facebook' : 'email';

		if (count($params) == 0) { // validate data
			$this->response['code'] = 2;
			$this->response['message'] = 'Todos los parámetros son requeridos';
		} else if($authenticationType == 'facebook') { // login with facebook
			$user = User::where([
				['email', '=', $params['email']],
				['facebookId', '=', $params['facebookId']]
			])->get();

			if (count($user) > 0) {
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
			else {
				$this->response['code'] = 2;
				$this->response['data'] = $params;
				$this->response['message'] = 'Error al iniciar sesion con facebook.';
			}
		} else { // login with email and password
			
			if ((!array_key_exists('email', $params) || !array_key_exists('pwd', $params))) {
				$this->response['code'] = 2;
				$this->response['message'] = 'Todos los parámetros son requeridos';
			} else {
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
		}

		$json = $this->response;
		return $json;
	}


	/**
	* 
	*/
	public function addImage($usuario_id)
	{

		$params = $this->sanitize(array($usuario_id));
		$usuario = User::find($params[0]);

		if ($usuario != null)
		{
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
							$db = Connection::getConnection();
							$db::beginTransaction();

							try 
							{	
								if ($usuario->imagen != '' || $usuario->imagen != null)
								{
									if (file_exists($this->DIRECTORY . $usuario->imagen))
									{
										unlink($this->DIRECTORY . $usuario->imagen);
									}
								}

								$usuario->imagen = $nombre_archivo;
								$usuario->save();
								$db::commit();

								$this->response['code'] = 1;
								$this->response['data'] = $fichero_subido;
								$this->response['message'] = 'Se ha guardado correctamente';
							} 
							catch (Exception $e) 
							{
								$db::rollBack();
								$this->response['code'] = 5;
								$this->response['message'] = 'Ocurrió un error.';
							}
						}
						else
						{
							$this->response['code'] = 5;
							$this->response['message'] = 'Ocurrió un error.';	
						}
					}
					else
					{
						$this->response['code'] = 6;
						$this->response['message'] = 'Debe enviar una imagen con las siguientes extensiones: image/png, image/jpeg';
					}
				}
				else 
				{
					$this->response['code'] = 6;
						$this->response['message'] = 'Debe ser un archivo de máximo 1.5MB';
				}
			}
			else
			{
				$this->response['code']	= 2;
				$this->response['message'] = 'Debe enviar una imagen.';
			}
		}
		else
		{
			$this->response['code'] = 4;
			$this->response['message']  = 'Usuario con el identificador \'' . $params[0] . '\' no existe';
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