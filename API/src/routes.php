<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    //return $this->renderer->render($response, 'index.phtml', $args);
    echo 'inicio';
});


/**
* 
*/
$app->group('/api/v1/usuario', function () 
{

	/**
	* 
	*/
	$this->get('/', function ($request, $response, $args)
	{
		$params = $request->getParams();
		$controller = new UserController();
		$json = $controller->callAction('all', $params);
		
		$code = ($json['code'] == 1) ? 200 : 401;
		return $response->withJson($json, $code);

	})->setName('get_users');

	/**
	* 
	*/
	$this->get('/{usuario_id}/', function ($request, $response, $args)
	{
		$usuario_id = $args['usuario_id'];
		$controller = new UserController();
		$json = $controller->callAction('one', $usuario_id);
		
		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('get_one_user');

	/**
	* 
	*/
	$this->post('/', function ($request, $response, $args) 
	{
		$post = $request->getParams();
		$controller = new UserController();
		$json = $controller->callAction('add', $post);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('create_user');

	/**
	* 
	*/
	$this->post('/auth/', function ($request, $response, $args) 
	{
		$post = $request->getParams();
		$controller = new UserController();
		$json = $controller->callAction('auth', $post);

		header('Content-Type: application/json');
		//echo $_GET["callback"]."(" . $json . ")";
		echo $json;

	})->setName('auth');

	/**
	* 
	*/
	$this->post('/{usuario_id}/imagen/', function ($request, $response, $args) 
	{

		$usuario_id = $args['usuario_id'];
		$controller = new UserController();
		$json = $controller->callAction('img', $usuario_id);
		
		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('set_image');


	/**
	* 
	*/
	$this->post('/{usuario_id}/convocatoria/{convocatoria_id}/suscrip/', function ($request, $response, $args)
	{
		$params = array('usuario_id' => $args['usuario_id'], 'convocatoria_id' => $args['convocatoria_id'], 'post' => $request->getParams());
		$controller = new UserController();
		$json = $controller->callAction('suscrip', $params);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('sus_conv');

});

/**
* 
*/
$app->group('/api/v1/universidad', function ()
{
	/**
	* 
	*/
	$this->get('/', function ($request, $response, $args) 
	{
		$controller = new UniversidadController();
		$json = $controller->callAction('all');

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('get_universidades');

	/**
	* 
	*/
	$this->post('/', function ($request, $response, $args)
	{
		$post = $request->getParams();
		$controller = new UniversidadController();
		$json = $controller->callAction('add', $post);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('create_univ');

	/**
	* 
	*/
	$this->get('/{universidad_id}/', function ($request, $response, $args)
	{
		$universidad_id = $args['universidad_id'];
		$controller = new UniversidadController();
		$json = $controller->callAction('one', $universidad_id);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('get_univ');

	/**
	* 
	*/
	$this->post('/{universidad_id}/update/', function ($request, $response, $args)
	{
		$universidad_id = $args['universidad_id'];
		$post = $request->getParams();
		$post['universidad_id'] = $universidad_id;
		
		$controller = new UniversidadController();
		$json = $controller->callAction('update', $post);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('update_univ');

	/**
	* 
	*/
	$this->post('/{universidad_id}/delete/', function ($request, $response, $args)
	{
		$controller = new UniversidadController();
		$json = $controller->callAction('del', $args['universidad_id']);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('delete_univ');

});

/**
* 
*/
$app->group('/api/v1/convocatoria', function ()
{
	/**
	* 
	*/
	$this->get('/', function ($request, $response, $args)
	{

		$controller = new ConvocatoriaController();
		$json = $controller->callAction('all');

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('all_convocatorias');

	/**
	* 
	*/
	$this->post('/', function ($request, $response, $args) 
	{
		$post = $request->getParams();
		$controller = new ConvocatoriaController();
		$json = $controller->callAction('add', $post);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('add_convocatoria');


	/**
	* 
	*/
	$this->get('/{convocatoria_id}/', function ($request, $response, $args)
	{
		$convocatoria_id = $args['convocatoria_id'];
		$controller = new ConvocatoriaController();
		$json = $controller->callAction('one', $convocatoria_id);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('get_convocatoria');

	/**
	* 
	*/
	$this->post('/{convocatoria_id}/update/', function ($request, $response, $args)
	{
		$params = $request->getParams();
		$params['id'] = $args['convocatoria_id'];
		$controller = new ConvocatoriaController();
		$json = $controller->callAction('update', $params);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('update_conv');

	/**
	* 
	*/
	$this->post('/{convocatoria_id}/delete/', function ($request, $response, $args)
	{

		$id = $args['convocatoria_id'];
		$controller = new ConvocatoriaController();
		$json = $controller->callAction('delete', $id);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('delete_conv');

});


/**
* 
*/
$app->group('/api/v1/roles', function () 
{
	/**
	* 
	*/
	$this->get('/', function ($request, $response, $args) 
	{
		$controller = new RolController();
		$json = $controller->callAction('all');

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('list_rol');

	/**
	* 
	*/
	$this->post('/', function ($request, $response, $args)
	{
		$post = $request->getParams();

		$controller = new RolController();
		$json = $controller->callAction('add', $post);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('create_rol');

	/**
	* 
	*/
	$this->get('/{id}/', function ($request, $response, $args)
	{
		$controller = new RolController();
		$json = $controller->callAction('one', $args['id']);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('get_by_id');

	/**
	* 
	*/
	$this->post('/{id}/update/', function ($request, $response, $args)
	{
		$id = $args['id'];
		$post = $request->getParams();
		$post['id'] = $id;

		$controller = new RolController();
		$json = $controller->callAction('update', $post);
		
		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('update_role');


	/**
	* 
	*/
	$this->post('/{id}/delete/', function ($request, $response, $args)
	{
		$controller = new RolController();
		$json = $controller->callAction('del', $args['id']);
		
		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('delete_role');


	// Lista de permisos de un rol (Method = GET) 	=> /api/v1/roles/1/permisos/
	// Asociar permisos a un rol (Method = POST) 	=> /api/v1/roles/1/permisos/
	// Eliminar permisos de un rol (Method = POST) 	=> /api/v1/roles/1/permisos/delete/

	/**
	* 
	*/
	$this->get('/{id}/permisos/', function ($request, $response, $args)
	{	
		$params = array('id' => $args['id']);
		$controller = new RolController();
		$json = $controller->callAction('permisos', $params);			

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('permissions_by_role');

	/**
	* 
	*/
	$this->post('/{id}/permisos/', function ($request, $response, $args)
	{
		$ids = $request->getParsedBody();
		$json = array('code' => 2, 'data' => array(), 'message' => '');

		if (!is_null($ids)) {

			if (array_key_exists('permisos_id', $ids))
			{
				$params = array('role_id' => $args['id'], 'permisos' => $ids['permisos_id']);
				$controller = new RolController();
				$json = $controller->callAction('addPerm', $params);
			}
			else 
			{
				$json['message'] = 'El nombre de la clave que almacena la lista de identificadores de permisos debe llevar por nombre \'permisos_id\'';
			}

		} else 
		{
			$json['message'] = 'Debe enviar la lista de identificadores de permisos';
		}

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('add_permissions_by_role');

	/**
	* 
	*/
	$this->post('/{id}/permisos/delete/', function ($request, $response, $args)
	{
		$ids = $request->getParsedBody();
		$json = array('code' => 2, 'data' => array(), 'message' => '');

		if (!is_null($ids)) {

			if (array_key_exists('permisos_id', $ids))
			{
				$params = array('role_id' => $args['id'], 'permisos' => $ids['permisos_id']);
				$controller = new RolController();
				$json = $controller->callAction('delPerm', $params);
			}
			else 
			{
				$json['message'] = 'El nombre de la clave que almacena la lista de identificadores de permisos debe llevar por nombre \'permisos_id\'';
			}

		} else 
		{
			$json['message'] = 'Debe enviar la lista de identificadores de permisos';
		}

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('del_permissions_by_role');	

});

/**
* 
*/
$app->group('/api/v1/permisos', function ()
{	
	/**
	* 
	*/
	$this->get('/', function ($request, $response, $args) 
	{
		$controller = new PermissionController();
		$json = $controller->callAction('all');

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('list_permissions');

	/**
	* 
	*/
	$this->post('/', function ($request, $response, $args)
	{
		$post = $request->getParams();

		$controller = new PermissionController();
		$json = $controller->callAction('add', $post);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('create_permission');

	/**
	* 
	*/
	$this->get('/{id}/', function ($request, $response, $args)
	{
		$controller = new PermissionController();
		$json = $controller->callAction('one', $args['id']);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('permission_by_id');

	/**
	* 
	*/
	$this->post('/{id}/update/', function ($request, $response, $args)
	{
		$id = $args['id'];
		$post = $request->getParams();
		$post['id'] = $id;

		$controller = new PermissionController();
		$json = $controller->callAction('update', $post);
		
		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('update_permission');

	/**
	* 
	*/
	$this->post('/{id}/delete/', function ($request, $response, $args)
	{

		$controller = new PermissionController();
		$json = $controller->callAction('del', $args['id']);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('delete_permission');

});

/**
* 
*/
$app->group('/api/v1/estatus', function ()
{
	/**
	* 
	*/
	$this->get('/', function ($request, $response, $args) 
	{
		$controller = new StatusController();
		$json = $controller->callAction('all');

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('list_status');

	/**
	* 
	*/
	$this->post('/', function ($request, $response, $args)
	{
		$post = $request->getParams();

		$controller = new StatusController();
		$json = $controller->callAction('add', $post);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('create_status');

	/**
	* 
	*/
	$this->get('/{id}/', function ($request, $response, $args)
	{
		$controller = new StatusController();
		$json = $controller->callAction('one', $args['id']);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('status_by_id');

	/**
	* 
	*/
	$this->post('/{id}/update/', function ($request, $response, $args)
	{
		$id = $args['id'];
		$post = $request->getParams();
		$post['id'] = $id;

		$controller = new StatusController();
		$json = $controller->callAction('update', $post);
		
		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('update_status');

	/**
	* 
	*/
	$this->post('/{id}/delete/', function ($request, $response, $args)
	{
		$controller = new StatusController();
		$json = $controller->callAction('del', $args['id']);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('del_status');

});

/**
* 
*/
$app->group('/api/v1/estados', function ()
{
	/**
	* 
	*/
	$this->get('/', function ($request, $response, $args) 
	{
		$controller = new EstadoController();
		$json = $controller->callAction('all');

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('list_estados');

	/**
	* 
	*/
	$this->post('/', function ($request, $response, $args)
	{
		$post = $request->getParams();

		$controller = new EstadoController();
		$json = $controller->callAction('add', $post);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('create_estado');

	/**
	* 
	*/
	$this->get('/{id}/', function ($request, $response, $args)
	{
		$controller = new EstadoController();
		$json = $controller->callAction('one', $args['id']);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('estado_by_id');

	/**
	* 
	*/
	$this->post('/{id}/update/', function ($request, $response, $args)
	{
		$id = $args['id'];
		$post = $request->getParams();
		$post['id'] = $id;

		$controller = new EstadoController();
		$json = $controller->callAction('update', $post);
		
		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('update_estado');

	/**
	* 
	*/
	$this->post('/{id}/delete/', function ($request, $response, $args)
	{
		$controller = new EstadoController();
		$json = $controller->callAction('del', $args['id']);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('delete_estado');

});

/**
* 
*/
$app->group('/api/v1/pregunta', function ()
{
	/**
	* 
	*/
	$this->get('/', function ($request, $response, $args)
	{
		$controller = new PreguntaController();
		$json = $controller->callAction('all');

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('get_questions');

	/**
	* 
	*/
	$this->get('/{id}/', function ($request, $response, $args)
	{	
		$id = $args['id'];
		$controller = new PreguntaController();
		$json = $controller->callAction('one', $id);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('get_one_question');

	/**
	* 
	*/
	$this->post('/', function($request, $response, $args)
	{
		$params = $request->getParams();
		$controller = new PreguntaController();
		$json = $controller->callAction('add', $params);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('create_question');

	/**
	* 
	*/
	$this->post('/{id}/update/', function ($request, $response, $args)
	{
		$params = $request->getParams();
		$params['id'] = $args['id'];
		$controller = new PreguntaController();
		$json = $controller->callAction('update', $params);

		$code = ($json['code'] == 1) ? 200 : 404;
		return $response->withJson($json, $code);

	})->setName('update_question');

});