<?php


class db{

    function connect(){
    $user='hr';
    $password='hr';
    $db='localhost/XE';

       $conn = oci_connect($user, $password, $db);
        if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        return $conn;

    }



}

