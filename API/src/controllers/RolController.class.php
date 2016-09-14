<?php

/**
* 
*/
class RolController extends Controller
{
	static $routes = array(
		'all' 			=> 	'getAll',
		'add' 			=>	'create',
		'one'				=>	'getById',
		'update' 		=> 	'update',
		'permisos' 	=> 	'getPermisos',
		'addPerm'		=>	'addPermisos',
		'delPerm'		=>	'delPermisos'
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
	public function __construct($app = null)
	{
		$this->app = $app;
	}

	/**
	* 
	*/
	public function getAll()
	{
		
		$roles = Role::with('permisos')->orderBy('rol', 'ASC')->get()->toArray();
		$this->response['data'] = $roles;
		$this->response['message'] = 'Lista de roles creados para la plataforma';
		$json = json_encode($this->response, JSON_FORCE_OBJECT);

		return $json;
	}	

	/**
	* 
	*/
	public function create(Array $params)
	{
		if (count($params) == 0 || (!isset($params['rol']) || !isset($params['descr'])))
		{
			$this->response['code'] = 2;
			$this->response['message'] = 'Todos los parámetros son requeridos';
		}
		else
		{
			$params = $this->sanitize($params);
			$messages = array();

			if (strlen($params['rol']) == 0 || strlen($params['rol']) > 100) 
			{ 
				$messages[] = 'El campo rol no puede quedar vacío ni tener una longitud mayor a 100 caracteres';
			}

			if (strlen($params['descr']) == 0 || strlen($params['descr']) > 250)
			{
				$messages[] = 'El campo descripción no puede quedar vacío ni tener una longitud mayor a 250 caracteres';	
			}

			if (count($messages) > 0)
			{
				$this->response['code'] = 2;
				$this->response['data'] = $params;
				$this->response['message'] = $messages;
			}
			else 
			{
				$total = Role::where('rol', '=', $params['rol'])->get();
				
				if (count($total) > 0)
				{
					$this->response['code'] = 3;
					$this->response['data'] = $params;
					$this->response['message'] = 'Ya existe un rol con el nombre \'' . $params['rol'] . '\'';
				}
				else 
				{
					$db = Connection::getConnection();
					$db::beginTransaction();

					try 
					{
						$role = new Role();
						$role->rol = $params['rol'];
						$role->descr = $params['descr'];

						if ($role->save()) 
						{ 
							$db::commit();
							$this->response['code'] = 1;
							$this->response['data'] = $role->toArray();
							$this->response['message'] = 'Se ha creado un nuevo rol de manera exitosa';
						}
						else 
						{
							$this->response['code'] = 5;
							$this->response['message'] = 'Ocurrió un error, favor de intentar más tarde.';	
						}
					} 
					catch (PDOException $e) 
					{
						$db::rollBack();
					}
				}
			}
		}

		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;
	}

	/**
	* 
	*/
	public function getById($rol_id)
	{
		try 
		{	
			$params = array($rol_id);
			$params = $this->sanitize($params);

			$rol = Role::find($params[0]);

			if ($rol != null)
			{
				$this->response['data'] = $rol->toArray();
				$this->response['message'] = 'Recurso encontrado';
			}
			else
			{
				$this->response['code'] = 4;
				$this->response['message'] = 'Recurso no encontrado';
			}
		} 
		catch (Exception $e) 
		{
			$this->response['code'] = 5;
			$this->response['message'][] = 'Ha ocurrido un error, favor de contactar al administrador';
		}

		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;
	}


	/**
	* 
	*/
	public function update(Array $params)
	{
		if (count($params) == 0 || (!isset($params['rol']) || !isset($params['descr'])) || !isset($params['id']))
		{ 
			$this->response['code'] = 2;
			$this->response['message'] = 'Todos los parámetros son requeridos';
		}
		else
		{
			$params = $this->sanitize($params);
			$messages = array();

			if (strlen($params['rol']) == 0 || strlen($params['rol']) > 100) 
			{ 
				$messages[] = 'El campo rol no puede quedar vacío ni tener una longitud mayor a 100 caracteres';
			}

			if (strlen($params['descr']) == 0 || strlen($params['descr']) > 250)
			{
				$messages[] = 'El campo descripción no puede quedar vacío ni tener una longitud mayor a 250 caracteres';	
			}

			if (count($messages) > 0)
			{
				$this->response['code'] = 2;
				$this->response['data'] = $params;
				$this->response['message'] = $messages;
			}
			else 
			{
				$total = Role::where('rol', '=', $params['rol'])
											->where('rol_id', '!=', $params['id'])
											->get();
				
				if (count($total) > 0)
				{
					$this->response['code'] = 3;
					$this->response['data'] = $params;
					$this->response['message'] = 'Ya existe un rol con el nombre \'' . $params['rol'] . '\'';
				}
				else 
				{
					$db = Connection::getConnection();
					$db::beginTransaction();

					try 
					{
						$role = Role::find($params['id']);

						if ($role == null)
						{
							$this->response['code'] = 4;
							$this->response['message'] = 'Recurso no encontrado';	
						}
						else 
						{

							$role->rol = $params['rol'];
							$role->descr = $params['descr'];

							if ($role->save()) 
							{ 
								$db::commit();
								$this->response['code'] = 1;
								$this->response['data'] = $role->toArray();
								$this->response['message'] = 'Se ha acualizado de manera exitosa';
							}
							else 
							{
								$this->response['code'] = 5;
								$this->response['message'] = 'Ocurrió un error, favor de intentar más tarde.';	
							}
						}
					} 
					catch (PDOException $e) 
					{
						$db::rollBack();
					}
				}
			}
		}

		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;
	}


	/**
	* 
	*/
	public function getPermisos(Array $params)
	{	
		$params = $this->sanitize($params);

		$rol = Role::find($params['id']);

		if ($rol != null)
		{
			$this->response['code'] = 1;
			
			$permiso_rol = PermisoRol::where('rol_id', '=', $rol->rol_id)->get();
			$lista_permisos = array();

			if (count($permiso_rol) > 0)
			{	
				foreach ($permiso_rol as $key => $value) 
				{
					$permiso = Permission::find($value->permiso_id);
					$lista_permisos[] = $permiso;
				}
			}

			$rol->permisos = $lista_permisos;
			$this->response['data'] = $rol;
			$this->response['message'] = 'Recurso encontrado';
		}
		else 
		{
			$this->response['code'] = 4;
			$this->response['message'] = 'Recurso no encontrado';
		}

		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;
	}

	/**
	* 
	*/
	public function addPermisos(Array $params)
	{
		if (count($params['permisos']) > 0)
		{
			$params = $this->sanitize($params);
			$rol = Role::find($params['role_id']);

			if ($rol != null) 
			{	
				$db = Connection::getConnection();
				$db::beginTransaction();

				try 
				{	
					$contador = 0;
					$lista_permisos = array();
					$messages = array();

					foreach ($params['permisos'] as $key => $value) 
					{
						$permiso = Permission::find($value);	

						if ($permiso != null) 
						{
							$p_r = PermisoRol::where('permiso_id', '=', $value)
															->where('rol_id', '=', $rol->rol_id)->get();
							
							if (count($p_r) == 0)
							{
								$permiso_rol = new PermisoRol();
								$permiso_rol->permiso_id = $permiso->permiso_id;
								$permiso_rol->rol_id = $rol->rol_id;
								if ($permiso_rol->save()) { $contador++; $lista_permisos[] = $permiso_rol; }
							}
							else { $messages[] = 'El rol ya tiene asignado el permiso \'' . $permiso->permiso . '\''; }
						}
						else
						{
							$messages[] = 'El permiso con el identificador \'' . $value . '\' no existe';
						}
					}

					if ($contador == count($params['permisos'])) 
					{
						$this->response['code'] = 1;
						$this->response['data'] = $lista_permisos;
						$this->response['message'] = 'Se han asigando correctamente los permisos';
						$db::commit();
					}
					else
					{
						unset($lista_permisos);
						$this->response['code'] = 5;
						$messages[] = 'Algunos permisos no han sido asignados';
						$this->response['message'] = $messages;
					}

				} catch (PDOException $e) 
				{
					$db::rollBack();
					$this->response['error'] = $e->getMessage();
				}
			}
			else 
			{
				$this->response['code'] = 4;
				$this->response['message'] = 'Recurso no encontrado. El rol con identificador \'' . $params['role_id'] . '\' no existe';		
			}
		}
		else
		{
			$this->response['code'] = 2;
			$this->response['message'] = 'La lista de permisos no puede estar vacía';
		}

		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;
	}

	/**
	* 
	*/
	public function delPermisos(Array $params)
	{
		if (count($params['permisos']) > 0)
		{
			$params = $this->sanitize($params);
			$rol = Role::find($params['role_id']);

			if ($rol != null) 
			{	
				$db = Connection::getConnection();
				$db::beginTransaction();

				try 
				{	
					$contador = 0;
					$lista_permisos = array();
					$messages = array();

					foreach ($params['permisos'] as $key => $value) 
					{
						$permiso = Permission::find($value);	

						if ($permiso != null) 
						{
							$p_r = PermisoRol::where('permiso_id', '=', $value)
															->where('rol_id', '=', $rol->rol_id)->get();
							
							if (count($p_r) > 0)
							{	
								if (PermisoRol::where('permiso_id', '=', $value)
															->where('rol_id', '=', $rol->rol_id)->delete())
								{ 
									$contador++; 
									$lista_permisos[] = $p_r[0]; 
								}
							}
							else { $messages[] = 'El rol \'' . $rol->rol . '\' no tiene asigando el permiso \'' . $permiso->permiso . '\''; }
						}
						else
						{
							$messages[] = 'El permiso con el identificador \'' . $value . '\' no existe';
						}
					}

					if ($contador == count($params['permisos'])) 
					{
						$this->response['code'] = 1;
						$this->response['data'] = $lista_permisos;
						$this->response['message'] = 'Se han eliminado correctamente las referencias';
						$db::commit();
					}
					else
					{
						unset($lista_permisos);
						$this->response['code'] = 5;
						$messages[] = 'Algunos permisos no se pueden eliminar';
						$this->response['message'] = $messages;
					}

				} catch (PDOException $e) 
				{
					$db::rollBack();
					$this->response['error'] = $e->getMessage();
				}
			}
			else 
			{
				$this->response['code'] = 4;
				$this->response['message'] = 'Recurso no encontrado. El rol con identificador \'' . $params['role_id'] . '\' no existe';		
			}
		}
		else
		{
			$this->response['code'] = 2;
			$this->response['message'] = 'La lista de permisos no puede estar vacía';
		}

		$json = json_encode($this->response, JSON_FORCE_OBJECT);
		return $json;
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