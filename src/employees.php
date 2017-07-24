<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;





$app = new \Slim\App;

//search all department route
$app->get('/api/departments', function (Request $request, Response $response) {
    //for db connection
require $_SERVER['DOCUMENT_ROOT'].'/SlimWebApi/src/config.php';
    //for my sqlfunction
require $_SERVER['DOCUMENT_ROOT'].'/SlimWebApi/src/SqlHeper.php';

$helper=new SqlHelper;
$db=new db;
 //connect oracle db
$conn=$db->connect();

$responseDeparments=$helper->SearchDepartments($conn);
// Fetch the results of the query

$response->getBody()->write(json_encode($responseDeparments));
return $response;

oci_free_statement($stid);
oci_close($conn);

});

//Search Department Route
$app->get('/api/department/{id}', function (Request $request, Response $response) {
    $id=$request->getAttribute('id');

//for db connection
require $_SERVER['DOCUMENT_ROOT'].'/SlimWebApi/src/config.php';
//for my sqlfunction
require $_SERVER['DOCUMENT_ROOT'].'/SlimWebApi/src/SqlHeper.php';

$helper=new SqlHelper;
$db=new db;
 //connect oracle db
$conn=$db->connect();

 $responseDeparment=$helper->SearchDepartment($conn,$id);

$response->getBody()->write(json_encode($responseDeparment));
return $response;

oci_free_statement($stid);
oci_close($conn);

});
//add to db route
$app->post('/api/department/add', function (Request $request, Response $response) {
$deptName = $request->getParam('DEPARTMENT_NAME');
$managerId=$request->getParam('MANAGER_ID');
$locationId=$request->getParam('LOCATION_ID');

    //for db connection
require $_SERVER['DOCUMENT_ROOT'].'/SlimWebApi/src/config.php';
    //for my sqlfunction
require $_SERVER['DOCUMENT_ROOT'].'/SlimWebApi/src/SqlHeper.php';

$helper=new SqlHelper;
$db=new db;
 //connect oracle db
$conn=$db->connect();

 $responseDeparmentCreated=$helper->createDepartment($conn,$deptName,$managerId,$locationId);

$response->getBody()->write(json_encode($responseDeparmentCreated));
return $response;

oci_free_statement($stid);
oci_close($conn);

});


$app->delete('/api/department/delete/{id}', function (Request $request, Response $response) {
    $id=$request->getAttribute('id');

//for db connection
require $_SERVER['DOCUMENT_ROOT'].'/SlimWebApi/src/config.php';
//for my sqlfunction
require $_SERVER['DOCUMENT_ROOT'].'/SlimWebApi/src/SqlHeper.php';

$helper=new SqlHelper;
$db=new db;
 //connect oracle db
$conn=$db->connect();

 $responseDeparment=$helper->deleteDepartment($conn,$id);

$response->getBody()->write(json_encode($responseDeparment));
return $response;

oci_free_statement($stid);
oci_close($conn);

});

$app->put('/api/department/update/{id}', function (Request $request, Response $response) {
$dept_Id=$request->getAttribute('id');
$deptNameUpdate = $request->getParam('DEPARTMENT_NAME');
$managerIdUpdate=$request->getParam('MANAGER_ID');
$locationIdUpdate=$request->getParam('LOCATION_ID');

    //for db connection
require $_SERVER['DOCUMENT_ROOT'].'/SlimWebApi/src/config.php';
    //for my sqlfunction
require $_SERVER['DOCUMENT_ROOT'].'/SlimWebApi/src/SqlHeper.php';

$helper=new SqlHelper;
$db=new db;
 //connect oracle db
$conn=$db->connect();

$responseDeparmentUpdated=$helper->updateDepartment($conn,$dept_Id,$deptNameUpdate,$managerIdUpdate,$locationIdUpdate);

    $response->getBody()->write(json_encode($responseDeparmentUpdated));

return $response;

oci_free_statement($stid);
oci_close($conn);

});


