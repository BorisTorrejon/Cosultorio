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
                'SELECT * FROM turns;'
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
                'SELECT * FROM turns WHERE turnID='.$id
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
       
            $query = $this->db->connect()->prepare(
                'INSERT INTO turns
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
        
    }
    public function putTurn($id){
      
            $sql = "UPDATE turns
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
        
    }
    public function deleteTurn($id){
      
            $sql = "DELETE FROM turns  
                    WHERE 
                        turnID = ".$id; 
            $query = $this->db->connect()->prepare($sql);
            $query->execute();
            return true;
        
    }
}
?>