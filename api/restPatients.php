<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}
include_once('../models/patientsmodel.php');
switch($_SERVER['REQUEST_METHOD']){
    case "GET":
        header("Content-Type: application/json");
        $class = new Patient("");
        if(isset($_GET['id'])) 
            $class->getPatient($_GET['id']);     
        else
            $class->getPatients();
    break;
    case "POST":
        $json =file_get_contents('php://input');
        $_POST= json_decode($json,true);
        $class = new Patient('');
        $class->postPatient($_POST);
    break;
    case "PUT":
       $json =file_get_contents('php://input');
        $_POST= json_decode($json,true);
        $class = new Patient('');

        $class->putPatient($_POST,$_GET['id']);
    break;
    case "DELETE":
        $class = new Patient("");
        $class->deletePatient($_GET['id']); 
    break;
}
?>