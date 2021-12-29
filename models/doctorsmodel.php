<?php
include_once('../lib/model.php');
include_once('../models/doctor.php');
class Doctors extends Model{
    private $doctorName;
    private $doctorSurname;
    private $doctorPhone;
    private $doctorCredential;
    private $doctorEmail;
    private $doctorPassword;
    public function __construct($doctor)
    {
        parent::__construct();
        if($doctor<>""){
            $this->doctorName = $doctor['name'];
            $this->doctorSurname = $doctor['surname'];
            $this->doctorPhone = $doctor['phone'];
            $this->doctorCredential = $doctor['credential'];
            $this->doctorEmail = $doctor['email'];
            $this->doctorPassword = $doctor['password'];
        }
    }
    public function getDoctors(){
        $doctors = [];
        try {
            $query = $this->db->connect()->query(
                'SELECT * FROM doctors;'
            );
            while($row = $query->fetch()){
                $doctor = new DoctorM;
                $doctor->id         = $row['doctorID'];
                $doctor->name       = $row['doctorName'];
                $doctor->surname    = $row['doctorSurname'];
                $doctor->phone      = $row['doctorPhone'];
                $doctor->credential = $row['doctorCredential'];
                $doctor->email      = $row['doctorEmail'];
                $doctor->password   = $row['doctorPassword'];
                array_push($doctors,$doctor);
            }
            echo json_encode($doctors);
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function getDoctor($id){
        try {
            $query = $this->db->connect()->query(
                'SELECT * FROM doctors WHERE doctorID='.$id
            );
            $row = $query->fetch();
            if($row<>false){
                $doctor = new DoctorM;
                $doctor->id         = $row['doctorID'];
                $doctor->name       = $row['doctorName'];
                $doctor->surname    = $row['doctorSurname'];
                $doctor->phone      = $row['doctorPhone'];
                $doctor->credential = $row['doctorCredential'];
                $doctor->email      = $row['doctorEmail'];
                $doctor->password   = $row['doctorPassword'];
            }else{
                $doctor = "There is not Doctor with that ID= ".$id;
            }
            echo json_encode($doctor);
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function postDoctor(){
        try {
            $query = $this->db->connect()->prepare(
                'INSERT INTO doctors
                (doctorName,doctorSurname,doctorPhone,doctorCredential,doctorEmail,doctorPassword)
                VALUES
                (:name,:surname,:phone,:credential,:email,:password)'
            );
            $query->execute([
                'name'      => $this->doctorName,
                'surname'   => $this->doctorSurname,
                'phone'     => $this->doctorPhone,
                'credential'=> $this->doctorCredential,
                'email'     => $this->doctorEmail,
                'password'  => $this->doctorPassword
            ]);
            return true;
        } catch (PDOException $e) {
            echo $e;   
        }
    }
    public function putDoctor($id){
        try {
            $query = $this->db->connect()->prepare(
                "UPDATE doctors
                SET
                    doctorName       = '".$this->doctorName."',
                    doctorSurname    = '".$this->doctorSurname."',
                    doctorPhone      = '".$this->doctorPhone."',
                    doctorCredential = '".$this->doctorCredential."',
                    doctorEmail      = '".$this->doctorEmail."',
                    doctorPassword   = '".$this->doctorPassword."'
                WHERE
                    doctorID = ".$id
            );
            $query->execute();
            return true;
        } catch (PDOException $e) {
            echo $e;   
        }
    }
    public function deleteDoctor($id){
        try {
            $query = $this->db->connect()->prepare(
                'DELETE FROM doctors
                WHERE doctorID = '.$id
            );
            $query->execute();
            return true;
        } catch (PDOException $e) {
            echo $e;
        }
    }
}
?>