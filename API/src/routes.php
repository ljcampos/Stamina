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

		header('Content-Type: application/json');
		//echo $_GET["callback"]."(" . $json . ")";
		echo $json;

	})->setName('get_users');


	/**
	* 
	*/
	$this->get('/{usuario_id}/', function ($request, $response, $args)
	{
		$usuario_id = $args['usuario_id'];
		$controller = new UserController();
		$json = $controller->callAction('one', $usuario_id);

		header('Content-Type: application/json');
		//echo $_GET["callback"]."(" . $json . ")";
		echo $json;

	})->setName('get_one_user');

	/**
	* 
	*/
	$this->post('/', function ($request, $response, $args) 
	{
		$post = $request->getParams();
		$controller = new UserController();
		$json = $controller->callAction('add', $post);

		header('Content-Type: application/json');
		echo $_GET["callback"]."(" . $json . ")";
		//echo $json;

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
		header('Content-Type: application/json');
		echo $_GET["callback"]."(" . $json . ")";
		//echo $json;

	})->setName('set_image');

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

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('get_universidades');

	/**
	* 
	*/
	$this->post('/', function ($request, $response, $args)
	{
		$post = $request->getParams();
		$controller = new UniversidadController();
		$json = $controller->callAction('add', $post);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";
	})->setName('create_univ');

	/**
	* 
	*/
	$this->get('/{universidad_id}/', function ($request, $response, $args)
	{
		$universidad_id = $args['universidad_id'];
		$controller = new UniversidadController();
		$json = $controller->callAction('one', $universidad_id);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

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

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('update_univ');

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

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('get_convocatorias');

	/**
	* 
	*/
	$this->post('/', function ($request, $response, $args) 
	{
		$post = $request->getParams();
		$controller = new ConvocatoriaController();
		$json = $controller->callAction('add', $post);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('add_convocatoria');


	/**
	* 
	*/
	$this->get('/{convocatoria_id}/', function ($request, $response, $args)
	{
		$convocatoria_id = $args['convocatoria_id'];
		$controller = new ConvocatoriaController();
		$json = $controller->callAction('one', $convocatoria_id);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('get_convocatoria');

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

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('list_rol');

	/**
	* 
	*/
	$this->post('/', function ($request, $response, $args)
	{
		$post = $request->getParams();

		$controller = new RolController();
		$json = $controller->callAction('add', $post);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('create_rol');

	/**
	* 
	*/
	$this->get('/{id}', function ($request, $response, $args)
	{
		$controller = new RolController();
		$json = $controller->callAction('one', $args['id']);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('get_by_id');

	/**
	* 
	*/
	$this->post('/update/{id}', function ($request, $response, $args)
	{
		$id = $args['id'];
		$post = $request->getParams();
		$post['id'] = $id;

		$controller = new RolController();
		$json = $controller->callAction('update', $post);
		
		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('update_role');

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

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

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
				$json = json_encode($json);
			}

		} else 
		{
			$json['message'] = 'Debe enviar la lista de identificadores de permisos';
			$json = json_encode($json);
		}

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

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
				$json = json_encode($json);
			}

		} else 
		{
			$json['message'] = 'Debe enviar la lista de identificadores de permisos';
			$json = json_encode($json);
		}

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('del_permissions_by_role');	

});

/**
* 
*/
$app->group('/api/v1/permisos', function ()
{
	$this->get('/', function ($request, $response, $args) 
	{
		$controller = new PermissionController();
		$json = $controller->callAction('all');

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('list_permissions');

	$this->post('/', function ($request, $response, $args)
	{
		$post = $request->getParams();

		$controller = new PermissionController();
		$json = $controller->callAction('add', $post);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('create_permission');

	$this->get('/{id}', function ($request, $response, $args)
	{
		$controller = new PermissionController();
		$json = $controller->callAction('one', $args['id']);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('permission_by_id');

	$this->post('/update/{id}', function ($request, $response, $args)
	{
		$id = $args['id'];
		$post = $request->getParams();
		$post['id'] = $id;

		$controller = new PermissionController();
		$json = $controller->callAction('update', $post);
		
		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('update_permission');
});

/**
* 
*/
$app->group('/api/v1/estatus', function ()
{
	$this->get('/', function ($request, $response, $args) 
	{
		$controller = new StatusController();
		$json = $controller->callAction('all');

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('list_status');

	$this->post('/', function ($request, $response, $args)
	{
		$post = $request->getParams();

		$controller = new StatusController();
		$json = $controller->callAction('add', $post);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('create_status');

	$this->get('/{id}', function ($request, $response, $args)
	{
		$controller = new StatusController();
		$json = $controller->callAction('one', $args['id']);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('status_by_id');

	$this->post('/update/{id}', function ($request, $response, $args)
	{
		$id = $args['id'];
		$post = $request->getParams();
		$post['id'] = $id;

		$controller = new StatusController();
		$json = $controller->callAction('update', $post);
		
		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";	

	})->setName('update_status');
});

/**
* 
*/
$app->group('/api/v1/estados', function ()
{
	$this->get('/', function ($request, $response, $args) 
	{
		$controller = new EstadoController();
		$json = $controller->callAction('all');

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('list_estados');

	$this->post('/', function ($request, $response, $args)
	{
		$post = $request->getParams();

		$controller = new EstadoController();
		$json = $controller->callAction('add', $post);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('create_estado');

	$this->get('/{id}', function ($request, $response, $args)
	{
		$controller = new EstadoController();
		$json = $controller->callAction('one', $args['id']);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('estado_by_id');

	$this->post('/update/{id}', function ($request, $response, $args)
	{
		$id = $args['id'];
		$post = $request->getParams();
		$post['id'] = $id;

		$controller = new EstadoController();
		$json = $controller->callAction('update', $post);
		
		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('update_estado');
});

$app->get('/prueba/json/', function ($request, $response, $args) {

	$json = $request->getParsedBody();
	var_dump($json);
});