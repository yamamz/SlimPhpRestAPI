<?php


class db{



    function connect(){
    $user='hr';
    $password='hr';
    $db='192.168.81.233/XE';

       $conn = oci_connect($user, $password, $db);
        if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

        return $conn;

    }



}

