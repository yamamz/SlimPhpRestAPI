<?php

class SqlHelper{



  function SearchDepartments($conn) {

      $stid = oci_parse($conn, 'SELECT departments.department_id,departments.department_name,departments.manager_id,employees.first_name,employees.last_name
,departments.location_id,locations.street_address,locations.postal_code,locations.city,locations.state_province,locations.country_id
FROM departments
LEFT JOIN employees ON departments.manager_id=employees.employee_id
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

      $responseDeparment["departments"]= array();
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
    array_push($responseDeparment["departments"],$department);
}



      return $responseDeparment;
  }


    function SearchDepartment($conn,$deptID) {

      $stid = oci_parse($conn, 'SELECT departments.department_id,departments.department_name,departments.manager_id,employees.first_name,employees.last_name
,departments.location_id,locations.street_address,locations.postal_code,locations.city,locations.state_province,locations.country_id
FROM departments
LEFT JOIN employees ON departments.manager_id=employees.employee_id
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


function createDepartment($conn,$deptName,$managerId,$locationId){

$responseDeparmentAdd = array();
$stid = oci_parse($conn, 'INSERT INTO departments (department_name,manager_id,location_id) VALUES(:department_name,:manager_id,:location_id)');

oci_bind_by_name($stid, ':department_name', $deptName);
oci_bind_by_name($stid,':manager_id',$managerId);
oci_bind_by_name($stid,':location_id',$locationId);
$r = oci_execute($stid);  //executes and commits
if ($r) {

$responseDeparmentAdd["department_name"]=$deptName;
$responseDeparmentAdd["manager_id"]=$managerId;
$responseDeparmentAdd["location_id"]=$locationId;
}
else{
  echo json_encode("Failed");
}

return $responseDeparmentAdd;

    }

//delete department
function deleteDepartment($conn,$deptId){
$response = array();
$stid = oci_parse($conn, "DELETE FROM departments WHERE department_id =:department_id");
//sql injection protection
oci_bind_by_name($stid, ':department_id', $deptId);
$r = oci_execute($stid);  //executes and commits
if ($r) {
$response["department_id"]=$deptId;
echo json_encode($response);
}
else{
  echo json_encode("Failed");
}
 return $response;
}


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
// Fetch the results of the query
$responseDeparmentUpdated= array();
if($r){
        $department = array();
        $department["department_id"] =$dept_Id;
        $department["department_name"] = $deptNameUpdate;
        $department["manager_id"] = $managerIdUpdate;
        $department["location_id"] = $locationIdUpdate;
        array_push($responseDeparmentUpdated,$department);
}



   return $responseDeparmentUpdated;

    }

}
