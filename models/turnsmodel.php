<?php
include_once('../lib/model.php');
include_once('../models/turn.php');
class Turns extends Model{
    private $turnDoctor;
    private $turnPatient;
    private $turnDate;
    private $turnShift;  
    public function __construct($turn)
    {
        parent::__construct();
        if($turn<>""){
            $this->turnDoctor   = $turn["doctor"];
            $this->turnPatient  = $turn['patient'];
            $this->turnDate     = $turn['date'];            
            $this->turnShift    = $turn['shift'];
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
                $turn->id       = $row["turnID"];
                $turn->doctor   = $row["turnDoctor"];
                $turn->patient  = $row["turnPatient"];
                $turn->date     = $row["turnDate"];
                $turn->shift    = $row["turnShift"];
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
                $turn->id       = $row["turnID"];
                $turn->doctor   = $row["turnDoctor"];
                $turn->patient  = $row["turnPatient"];
                $turn->date     = $row["turnDate"];
                $turn->shift    = $row["turnShift"];
            }
            else{
                $turn = "No existe ID = ".$id;
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
                (turnDoctor,turnPatient,turnDate,turnShift)
                VALUES
                (:doctor,:patient,:date,:shift)'
            );
            $query->execute([
                'doctor' => $this->turnDoctor,
                'patient'=> $this->turnPatient,
                'date'   => $this->turnDate, 
                'shift'  => $this->turnShift
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
                        turnDoctor  = '".$this->turnDoctor."',
                        turnPatient = '".$this->turnPatient."',
                        turnDate    = '".$this->turnDate."',
                        turnShift   = '".$this->turnShift."'
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