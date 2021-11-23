<?php
include_once('../lib/model.php');
include_once('../models/turn.php');
class Turns extends Model{
    private $turnDentist;
    private $turnShift;  
    private $turnPatient;
    public function __construct($turn)
    {
        parent::__construct();
        if($turn<>""){
            $this->turnDentist  = $turn["dentist"];
            $this->turnShift    = $turn['shift'];
            $this->turnPatient  = $turn['patient'];            
        }
    }
    public function getTurns(){
        $turns = [];
        try {
            $query = $this->db->connect()->query(
                'SELECT * FROM TURNS;'
            );
            while($row = $query->fetch()){
                
                $turn = new TurnM;
                $turn->Id       = $row["turnID"];
                $turn->Dentist  = $row["turnDentist"];
                $turn->Shift    = $row["turnShift"];
                $turn->Patient  = $row["turnPatient"];
                array_push ($turns,$turn);
            }
            echo json_encode($turns);
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function getTurn($id){
        try {
            $query = $this->db->connect()->query(
                'SELECT * FROM TURNS WHERE turnID='.$id
            );
            $row = $query->fetch();
            if ($row<>false){
                $turn = new TurnM;
                $turn->Id       = $row["turnID"];
                $turn->Dentist  = $row["turnDentist"];
                $turn->Shift    = $row["turnShift"];
                $turn->Patient  = $row["turnPatient"];
            }
            else{
                $turn = "No existe ID";
            }
            echo json_encode($turn);
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function postTurn(){
        try {
            $query = $this->db->connect()->prepare(
                'INSERT INTO TURNS
                (turnDentist,turnShift,turnPatient)
                VALUES
                (:dentist,:shift,:patient)'
            );
            $query->execute([
                'dentist' => $this->turnDentist,
                'shift'   => $this->turnShift,
                'patient' => $this->turnPatient
            ]);
            return true;
        } catch (PDOException) {
            return false;
        }
    }
    public function putTurn($id){
        try {
            $sql = "UPDATE TURNS 
                    SET 
                        turnDentist = '".$this->turnDentist."',
                        turnShift = '".$this->turnShift."',
                        turnPatient = '".$this->turnPatient."'
                    WHERE 
                        turnID = ".$id; 
            $query = $this->db->connect()->prepare($sql);
            $query->execute();
            return true;
        } catch (PDOException) {
            return false;
        }  
    }
    public function deleteTurn($id){
        try {
            $sql = "DELETE FROM TURNS 
                    WHERE 
                        turnID = ".$id; 
            $query = $this->db->connect()->prepare($sql);
            $query->execute();
            return true;
        } catch (PDOException) {
            return false;
        } 
    }
}
?>