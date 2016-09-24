<?php 
// Routes

$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    //return $this->renderer->render($response, 'index.phtml', $args);
    echo 'inicio';
});

$app->group('/api/v1/formularioAplicacion', function ()
{
	$this->get('/', function ($request, $response, $args)
	{
		$controller = new FormularioAplicacionController();
		$json = $controller->callAction('all');

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('list_formularioAplicacion');

	/**
	* 
	*/
	$this->post('/', function ($request, $response, $args) 
	{
		$post = $request->getParams();
		$controller = new FormularioAplicacionController();
		$json = $controller->callAction('add', $post);

		header('Content-Type: application/json');
		//echo $_GET["callback"]."(" . $json . ")";
		echo $json;

	})->setName('create_seccion');


	$this->get('/{id}/', function ($request, $response, $args)
	{
		$controller = new FormularioAplicacionController();
		$json = $controller->callAction('one', $args['id']);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('formulario_aplicacion_by_id');

	$this->post('/update/{id}/', function ($request, $response, $args)
	{
		$id = $args['id'];
		$post = $request->getParams();
		$post['id'] = $id;

		$controller = new FormularioAplicacionController();
		$json = $controller->callAction('update', $post);
		
		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('update_formulario_aplicacion');

	$this->post('/{id}/delete/', function ($request, $response, $args)
	{
		$controller = new FormularioAplicacionController();
		$json = $controller->callAction('del', $args['id']);

		header('Content-Type: application/json');
		echo $json;

	})->setName('delete_formulario_aplicacion');


});

$app->group('/api/v1/pregunta', function ()
{
	/**
	* 
	*/
	$this->get('/', function ($request, $response, $args)
	{
		$controller = new PreguntaController();
		$json = $controller->callAction('all');

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";
	})->setName('get_questions');

	/**
	* 
	*/
	$this->get('/{id}/', function ($request, $response, $args)
	{	
		$id = $args['id'];
		$controller = new PreguntaController();
		$json = $controller->callAction('one', $id);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('get_one_question');

	/**
	* 
	*/
	$this->post('/', function($request, $response, $args)
	{
		$params = $request->getParams();
		$controller = new PreguntaController();
		$json = $controller->callAction('add', $params);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";
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

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('update_question');

	$this->post('/{id}/delete/', function ($request, $response, $args)
	{
		$controller = new PreguntaController();
		$json = $controller->callAction('del', $args['id']);

		header('Content-Type: application/json');
		echo $json;

	})->setName('delete_question');

});

$app->group('/api/v1/respuesta', function(){
	/**
	* 
	*/
	$this->get('/', function ($request, $response, $args)
	{
		$controller = new RespuestaController();
		$json = $controller->callAction('all');

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";
	})->setName('get_answers');

	/**
	* 
	*/
	$this->get('/{id}/', function ($request, $response, $args)
	{	
		$id = $args['id'];
		$controller = new RespuestaController();
		$json = $controller->callAction('one', $id);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('get_one_answer');

	/**
	* 
	*/
	$this->post('/', function($request, $response, $args)
	{
		$params = $request->getParams();
		$controller = new RespuestaController();
		$json = $controller->callAction('add', $params);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";
	})->setName('create_answer');

	/**
	* 
	*/
	$this->post('/{id}/update/', function ($request, $response, $args)
	{
		$params = $request->getParams();
		$params['id'] = $args['id'];
		$controller = new RespuestaController();
		$json = $controller->callAction('update', $params);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('update_answer');

	$this->post('/{id}/delete/', function ($request, $response, $args)
	{
		$controller = new RespuestaController();
		$json = $controller->callAction('del', $args['id']);

		header('Content-Type: application/json');
		echo $json;

	})->setName('delete_answer');

});

$app->group('/api/v1/calificacion', function(){
	/**
	* 
	*/
	$this->get('/', function ($request, $response, $args)
	{
		$controller = new CalificacionController();
		$json = $controller->callAction('all');

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";
	})->setName('get_score');


	/**
	* 
	*/
	$this->get('/{id}/', function ($request, $response, $args)
	{	
		$id = $args['id'];
		$controller = new CalificacionController();
		$json = $controller->callAction('one', $id);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('get_one_score');

	/**
	* 
	*/
	$this->post('/', function($request, $response, $args)
	{
		$params = $request->getParams();
		$controller = new CalificacionController();
		$json = $controller->callAction('add', $params);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";
	})->setName('create_score');

	/**
	* 
	*/
	$this->post('/{id}/update/', function ($request, $response, $args)
	{
		$params = $request->getParams();
		$params['id'] = $args['id'];
		$controller = new CalificacionController();
		$json = $controller->callAction('update', $params);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('update_score');

	$this->post('/{id}/delete/', function ($request, $response, $args)
	{
		$controller = new CalificacionController();
		$json = $controller->callAction('del', $args['id']);

		header('Content-Type: application/json');
		echo $json;

	})->setName('delete_score');
});

$app->group('/api/v1/promedio', function(){
	/**
	* 
	*/
	$this->get('/', function ($request, $response, $args)
	{
		$controller = new PromedioController();
		$json = $controller->callAction('all');

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";
	})->setName('get_average');


	/**
	* 
	*/
	$this->get('/{id}/', function ($request, $response, $args)
	{	
		$id = $args['id'];
		$controller = new PromedioController();
		$json = $controller->callAction('one', $id);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('get_one_average');

	/**
	* 
	*/
	$this->post('/', function($request, $response, $args)
	{
		$params = $request->getParams();
		$controller = new PromedioController();
		$json = $controller->callAction('add', $params);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";
	})->setName('create_average');

	/**
	* 
	*/
	$this->post('/{id}/update/', function ($request, $response, $args)
	{
		$params = $request->getParams();
		$params['id'] = $args['id'];
		$controller = new PromedioController();
		$json = $controller->callAction('update', $params);

		header('Content-Type: application/json');
		echo $json;
		//echo $_GET["callback"]."(" . $json . ")";

	})->setName('update_average');

	$this->post('/{id}/delete/', function ($request, $response, $args)
	{
		$controller = new PromedioController();
		$json = $controller->callAction('del', $args['id']);

		header('Content-Type: application/json');
		echo $json;

	})->setName('delete_average');
});








?>