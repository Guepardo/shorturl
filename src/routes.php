<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require('/../vendor/classes/Link.php'); 
// Routes

// $app->get('/[{name}]', function ($request, $response, $args) {
//     // Sample log message
//     $this->logger->info("Slim-Skeleton '/' route");

//     // Render index view
//     return $this->renderer->render($response, 'index.phtml', $args);
// });

$app->get("/", function (Request $req, Response $res, $args){
	return $res->getBody()->write("Teste"); 
}); 

$app->get("/teste", function (Request $req, Response $res, $args){
	return $res->getBody()->write("Teste"); 
}); 

$app->post("/register", function(Request $req, Response $res, $args){

	if(isset($_POST['link']))
		$linkParam = $_POST['link']; 

	if(empty($linkParam))
		return $res->getBody()->write(json_encode(array('status' => false) ) ); 
	
	$link = new Link(); 
	$link->setData($linkParam); 
	$hashLink = $link->save(); 

	return $res->getBody()->write(json_encode( array( 'status' => true, 'hash' => $hashLink ) ) ); 
}); 
