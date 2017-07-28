<?php

class SqlHelper{

//search all departments
function SearchDepartments($conn) {

$stid = oci_parse($conn, 'SELECT departments.department_id,departments.department_name,departments.manager_id,
employees.first_name,employees.last_name,departments.location_id,locations.city FROM departments LEFT JOIN employees ON departments.manager_id=employees.employee_id
LEFT JOIN locations ON departments.location_id=locations.location_id');
if (!$stid) {
    $e = oci_error($conn);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
// Perform the logic of the query
$r = oci_execute($stid);
if (!$r) {
    $e = oci_error($stid);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
// Fetch the results of the query
$response["departments"]= array();
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
        $department = array();
        $department["department_id"] = $row["DEPARTMENT_ID"];
        $department["department_name"] = $row["DEPARTMENT_NAME"];
        $department["manager_id"] = $row["MANAGER_ID"];
        $department["manager_name"] = $row["FIRST_NAME"].' '.$row["LAST_NAME"];
        $department["location_id"] = $row["LOCATION_ID"];
        $department["location_city"] = $row["CITY"];

    array_push($response["departments"],$department);

}
    // echoing JSON response
    return $response;
  }

//search deparment
function SearchDepartment($conn,$deptID) {

$stid = oci_parse($conn, 'SELECT departments.department_id,departments.department_name,departments.manager_id,employees.first_name,employees.last_name
,departments.location_id,locations.street_address,locations.postal_code,locations.city,locations.state_province,locations.country_id
FROM departments LEFT JOIN employees ON departments.manager_id=employees.employee_id
LEFT JOIN locations ON departments.location_id=locations.location_id   WHERE departments.department_id=:department_id');

oci_bind_by_name($stid, ':department_id', $deptID);

if (!$stid) {
    $e = oci_error($conn);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
// Perform the logic of the query
$r = oci_execute($stid);
if (!$r) {
    $e = oci_error($stid);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
        //store results in array
        $responseDeparment["department"]= array();
        // Fetch the results of the query
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
        $department = array();
        $manager=array();
        $loc=array();
        //for manager object
        $manager["employee_id"]=$row["MANAGER_ID"];
        $manager["first_name"]=$row["FIRST_NAME"];
        $manager["last_name"]=$row["LAST_NAME"];
        //for location object
        $loc["location_id"]=$row["LOCATION_ID"];
        $loc["street_address"]=$row["STREET_ADDRESS"];
        $loc["postal_code"]=$row["POSTAL_CODE"];
        $loc["city"]=$row["CITY"];
        $loc["state_province"]=$row["STATE_PROVINCE"];
        $loc["country"]=$row["COUNTRY_ID"];
        //for deparment object
        $department["department_id"] = $row["DEPARTMENT_ID"];
        $department["department_name"] = $row["DEPARTMENT_NAME"];
        $department["manager"] = $manager;
        $department["location"] = $loc;
        array_push($responseDeparment["department"],$department);
}
return  $responseDeparment;
}

//add deparment
function createDepartment($conn,$deptName,$managerId,$locationId){
//store results in arra

$stid = oci_parse($conn, 'INSERT INTO departments (department_name,manager_id,location_id) VALUES(:department_name,:manager_id,:location_id)');
oci_bind_by_name($stid, ':department_name', $deptName);
oci_bind_by_name($stid,':manager_id',$managerId);
oci_bind_by_name($stid,':location_id',$locationId);
$r = oci_execute($stid);  //executes and commits
if ($r) {

$response="Success: Ok";
}
else{
$response="Success: failed";
}
return $response;
}

//delete department
function deleteDepartment($conn,$deptId){

$stid = oci_parse($conn, "DELETE FROM departments WHERE department_id =:department_id");
//sql injection protection
oci_bind_by_name($stid, ':department_id', $deptId);
$r = oci_execute($stid);  //executes and commits
if ($r) {
$response="Success: Ok";
}
else{
 $response="Success: failed";
}
return $response;
}

//update department
function updateDepartment($conn,$dept_Id,$deptNameUpdate,$managerIdUpdate,$locationIdUpdate){
$stid = oci_parse($conn, 'UPDATE departments
SET department_name =:department_name , manager_id=:manager_id, location_id=:location_id
WHERE department_id = :department_id');
//sql injection protection
oci_bind_by_name($stid, ':department_id', $dept_Id);
oci_bind_by_name($stid, ':department_name', $deptNameUpdate);
oci_bind_by_name($stid,':manager_id',$managerIdUpdate);
oci_bind_by_name($stid,':location_id',$locationIdUpdate);
if (!$stid) {
    $e = oci_error($conn);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
// Perform the logic of the query
$r = oci_execute($stid);
if (!$r) {
    $e = oci_error($stid);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

if($r){
$response="Success: ok";
}
    else{
    $response="Success: failed";
    }

return $response;
}

//create logs
function createLogs($conn,$smsText,$reciepient_no,$status){

$stid = oci_parse($conn, 'INSERT INTO sms_logs(sms_text,reciepient_no,status) VALUES(:SMS_TEXT,:RECIEPIENT_NO,:STATUS)');
//sql injection protection
oci_bind_by_name($stid,':SMS_TEXT',$smsText);
oci_bind_by_name($stid,':RECIEPIENT_NO',$reciepient_no);
oci_bind_by_name($stid,':STATUS',$status);
$r = oci_execute($stid);  //executes and commits

if ($r) {
$response="Success: Ok";
}
else{
$response="Success: failed";
}
return $response;
}

//get contacts
function getContacts($conn){
$stid = oci_parse($conn, 'SELECT * FROM contacts');
if (!$stid) {
$e = oci_error($conn);
trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Perform the logic of the query
$r = oci_execute($stid);
if (!$r) {
$e = oci_error($stid);
trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
// Fetch the results of the query
$response["contacts"]= array();
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    $contact = array();
    $contact["contact_id"] = $row["CONTACT_ID"];
    $contact["full_name"] = $row["FULL_NAME"];
    $contact["mobile_no"] = $row["MOBILE_NO"];
    array_push($response["contacts"],$contact);
}
 return $response;
}

function getEmployees($conn){

$stid=oci_parse($conn,'SELECT * FROM employees');

if (!$stid){
      $e = oci_error($conn);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

    $r=oci_execute($stid);

   if(!$r){
    $e = oci_error($stid);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    $response["employees"]=array();

   while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

        $employee=array();
        $employee["id"]=$row["EMPLOYEE_ID"];
        $employee["first_name"]=$row["FIRST_NAME"];
        $employee["last_name"]=$row["LAST_NAME"];
        $employee["email"]=$row["EMAIL"];
        $employee["phone_number"]=$row["PHONE_NUMBER"];
        $employee["hire_date"]=$row["HIRE_DATE"];
        $employee["job_id"]=$row["JOB_ID"];
        $employee["salary"]=$row["SALARY"];
        $employee["commission_point"]=$row["COMMISSION_PCT"];
        $employee["manager_id"]=$row["MANAGER_ID"];
        $employee["department_id"]=$row["DEPARTMENT_ID"];
     array_push($response["employees"],$employee);
    }
    return $response;
}
}
