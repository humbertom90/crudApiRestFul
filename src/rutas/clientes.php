<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//GET Todos los clientes
$app->get('/api/clientes', function(Request $request, Response $response){
	$sql = "Select * From clientes";
	try{
		$db = new db();
		$db = $db->conectDB();
		$resultado = $db->query($sql);

		if($resultado->rowCount() > 0){
			$clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
			echo json_encode($clientes);
		}else{
			echo json_encode("No existen clientes en la BD");
		}
		$resultado = null;
		$db = null;

	}catch(PDOException $e){
		echo '{"error" : {"text":'.$e->getMessage().'}';
	}
});

//GET un cliente por id
$app->get('/api/clientes/{id}', function(Request $request, Response $response){
	$id_cliente = $request->getAttribute('id');
	$sql = "Select * From clientes Where id = '$id_cliente'";
	try{
		$db = new db();
		$db = $db->conectDB();
		$resultado = $db->query($sql);
		if($resultado->rowCount() > 0){
			$cliente = $resultado->fetchAll(PDO::FETCH_OBJ);
			echo json_encode($cliente);
		}else{
			echo json_encode("No existen clientes en la BD");
		}
		$resultado = null;
		$db = null;

	}catch(PDOException $e){
		echo '{"error" : {"text":'.$e->getMessage().'}';
	}
});

//POST crear un nuevo cliente
$app->post('/api/clientes/nuevo', function(Request $request, Response $response){
	$nombres = $request->getParam('nombres');
	$apellidos = $request->getParam('apellidos');
	$telefono = $request->getParam('telefono');
	$email = $request->getParam('email');
	$direccion = $request->getParam('direccion');
	$ciudad = $request->getParam('ciudad');

	$sql = "Insert Into clientes (nombres, apellidos, telefono, email, direccion, ciudad) Values (:nombres, :apellidos, :telefono, :email, :direccion, :ciudad)";
	try{
		$db = new db();
		$db = $db->conectDB();
		$resultado = $db->prepare($sql);

		$resultado->bindParam(':nombres', $nombres);
		$resultado->bindParam(':apellidos', $apellidos);
		$resultado->bindParam(':telefono', $telefono);
		$resultado->bindParam(':email', $email);
		$resultado->bindParam(':direccion', $direccion);
		$resultado->bindParam(':ciudad', $ciudad);

		$resultado->execute();
		echo json_encode("Nuevo cliente guardado");
		
		$resultado = null;
		$db = null;

	}catch(PDOException $e){
		echo '{"error" : {"text":'.$e->getMessage().'}';
	}
});



