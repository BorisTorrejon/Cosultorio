<?php
header ('Content-Type: application/json');
include_once('../models/doctorsmodel.php');
switch($_SERVER['REQUEST_METHOD']){
    case"GET":
        $doctors = new Doctors("");
        if(isset($_GET['id']))
            $doctors->getDoctor($_GET['id']);
        else
            $doctors->getDoctors();
    break;
    case"POST":
        $_POST = json_decode(file_get_contents('php://input'),true);
        $doctor = new Doctors($_POST);
        $doctor->postDoctor();
    break;
    case"PUT":
        $_POST = json_decode(file_get_contents('php://input'),true);
        $doctor = new Doctors($_POST);
        $doctor->putDoctor($_GET['id']);
    break;
    case"DELETE":
        $doctor = new Doctors("");
        $doctor->deleteDoctor($_GET['id']);
    break;
};
?>