<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require '../src/config/db.php';
require '../vendor/autoload.php';
require '../src/rutas/clientes.php';

$app->run();
