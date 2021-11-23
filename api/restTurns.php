<?php
header("Content-Type: application/json");
include_once('../models/turnsmodel.php');
switch($_SERVER['REQUEST_METHOD']){
    case "GET":
        $turns = new Turns("");
        if(isset($_GET['id']))
            $turns->getTurn($_GET['id']);    
        else
            $turns->getTurns();
    break;
    case "POST":
        $_POST= json_decode(file_get_contents('php://input'),true);
        $turn = new Turns($_POST);
        $turn->postTurn();
    break;
    case "PUT":
        $_POST= json_decode(file_get_contents('php://input'),true);
        $turn = new Turns($_POST);
        $turn->putTurn($_GET['id']);
    break;
    case "DELETE":
        $turns = new Turns("");
        $turns->deleteTurn($_GET['id']);
    break;
}
?>