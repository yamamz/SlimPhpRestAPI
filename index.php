<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require $_SERVER['DOCUMENT_ROOT'].'/OracleAPI/vendor/autoload.php';

$app = new \Slim\App;

require $_SERVER['DOCUMENT_ROOT'].'/OracleAPI/src/routes.php';
$app->run();
