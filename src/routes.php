<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require(ROOT.'/vendor/classes/Link.php'); 
// Routes

//Registrar um novo link, interface.
$app->get("/shortit", function (Request $req, Response $res, $args){
	return $this->renderer->render($res, 'home.phtml', $args); 
}); 

//Redirect para a interface de encurtamente do link.
$app->get("/", function (Request $req, Response $res, $args){
	header("Location: ". DOMAIN."shortit"); 
	die(); 
}); 

//Resolver um link reduzido. 
$app->get("/{hash}", function(Request $req, Response $res, $args){
	$hash = $req->getAttribute('hash'); 
	$link = new Link(); 

	$redirect = $link->find($hash);
	if(!empty($redirect)){
		header("Location: ". $redirect); 
		die(); 
	}
	return $res->getBody()->write("Not Found!"); 
});


//Registrar um novo link
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
