<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
//for db connection
require $_SERVER['DOCUMENT_ROOT'].'/OracleAPI/src/config.php';
//for my sqlfunction
require $_SERVER['DOCUMENT_ROOT'].'/OracleAPI/src/SqlHeper.php';


//search all department route
$app->get('/api/departments', function (Request $request, Response $response) {
$helper=new SqlHelper;
$db=new db;
 //connect oracle db
$conn=$db->connect();
$responseDeparments=$helper->SearchDepartments($conn);
// Fetch the results of the query
$response->getBody()->write(json_encode($responseDeparments));
return $response;

});


//Search Department Route
$app->get('/api/department/{id}', function (Request $request, Response $response) {
$id=$request->getAttribute('id');
//instantiate slqhelper class from sqlhelper class
$helper=new SqlHelper;
//instantiate db class from config.php
$db=new db;
//connect oracle db
$conn=$db->connect();
//call function comming from sqlhelper.php
$responseDeparment=$helper->SearchDepartment($conn,$id);
//response into body in JSON
$response->getBody()->write(json_encode($responseDeparment));
return $response;

});


//add to db route
$app->post('/api/department/add', function (Request $request, Response $response) {
//the parameter of getParams is same as the field of your table in db
$deptName = $request->getParam('DEPARTMENT_NAME');
$managerId=$request->getParam('MANAGER_ID');
$locationId=$request->getParam('LOCATION_ID');
//instantiate slqhelper class from sqlhelper class
$helper=new SqlHelper;
$db=new db;
//connect oracle db
$conn=$db->connect();
//call function commimg from sqlhelper.php
$responseDeparmentCreated=$helper->createDepartment($conn,$deptName,$managerId,$locationId);
//response into body in JSON
$response->getBody()->write(json_encode($responseDeparmentCreated));
return $response;

});



//add Logs to Oracle db route
$app->post('/api/logs/add', function (Request $request, Response $response) {
//the parameter of getParams is same as the field of your table in db
$smsText_log = $request->getParam('SMS_TEXT');
$reciepient_no_log=$request->getParam('RECIEPIENT_NO');
$status_log=$request->getParam('STATUS');
//instantiate slqhelper class
$helper=new SqlHelper;
$db=new db;
 //connect oracle db
$conn=$db->connect();
//call the createlogs from sqlhelper.php
$responseLogCreated=$helper->createLogs($conn,$smsText_log,$reciepient_no_log,$status_log);
//response into body in JSON
$response->getBody()->write(json_encode($responseLogCreated));
return $response;

});



//delete department to oracle db route
$app->delete('/api/department/delete/{id}', function (Request $request, Response $response) {
$id=$request->getAttribute('id');
//instantiate sqlhelper to call functions
$helper=new SqlHelper;
$db=new db;
 //connect oracle db
$conn=$db->connect();
//call delete function from sqlhelper.php
$responseDeparment=$helper->deleteDepartment($conn,$id);
//response the result in Json
$response->getBody()->write(json_encode($responseDeparment));
return $response;

});

//update department route
$app->put('/api/department/update/{id}', function (Request $request, Response $response) {
$dept_Id=$request->getAttribute('id');
//the parameter of getParams is same as the field of your table in db
$deptNameUpdate = $request->getParam('DEPARTMENT_NAME');
$managerIdUpdate=$request->getParam('MANAGER_ID');
$locationIdUpdate=$request->getParam('LOCATION_ID');
//instantiate sqlhelper to call functions
$helper=new SqlHelper;
$db=new db;
 //connect oracle db
$conn=$db->connect();
//call update function from sqlhelper
$responseDeparmentUpdated=$helper->updateDepartment($conn,$dept_Id,$deptNameUpdate,$managerIdUpdate,$locationIdUpdate);
//response the result in Json
$response->getBody()->write(json_encode($responseDeparmentUpdated));
return $response;

});

//get contacts from oracle db route
$app->get('/api/contacts', function (Request $request, Response $response) {
//instantiate sqlhelper to call functions from Sqlhelper.php
$helper=new SqlHelper;
//instantiate db from config.php
$db=new db;
 //connect oracle db
$conn=$db->connect();
//call update function from sqlhelper.php
$responseContacts=$helper->getContacts($conn);
//response the result in Json
$response->getBody()->write(json_encode($responseContacts));
return $response;

});

//get employees route
$app->get('/api/employees',function(Request $request, Response $response){
$helper=new SqlHelper;
//instantiate db from config.php
$db=new db;
 //connect oracle db
$conn=$db->connect();
$responseEmployee=$helper->getEmployees($conn);
$response->getBody()->write(json_encode($responseEmployee));
return $response;
});
//add employee route
$app->post('/api/employee/add',function(Request $request, Response $response){
//initial to null for fields that can be null in database
$phone=null;
$comm=null;
$manager_id=null;
$department_id=null;
//get the param for POST value in Body
$first_name=$request->getParam('FIRST_NAME');
$last_name=$request->getParam('LAST_NAME');
$phone=$request->getParam('PHONE_NUMBER');
$email=$request->getParam('EMAIL');
$hire_date=$request->getParam('HIRE_DATE');
$job_id=$request->getParam('JOB_ID');
$salary=$request->getParam('SALARY');
$comm=$request->getParam('COMMISSION_PCT');
$manager_id=$request->getParam('MANAGER_ID');
$department_id=$request->getParam('DEPARTMENT_ID');

$helper=new SqlHelper;
//instantiate db from config.php
$db=new db;
//connect oracle db
$conn=$db->connect();

$responseAppEmployee=$helper->createEmployee($conn,$first_name,$last_name,$email,$phone,$hire_date,$job_id,$salary,$comm,$manager_id,$department_id);

$response->getBody()->write(json_encode($responseAppEmployee));
return $response;
});



