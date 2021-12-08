<?php 
include_once('../lib/model.php');  
include_once('../config/config.php');

class Patient extends Model
{
	
	private $patientID;
	private $patientName;
	private $patientSurname;
	private $patientAge;
	private $patientPhone;
	private $patientEmail;
	private $patientPassword;
	


	public function __construct($patient)//$_POST
	{
		parent::__construct(); //connection
		
		if($patient<>""){

		$this->$patientName = $patient['name'];
		$this->$patientSurname = $patient['surname'];
		$this->$patientAge = $patient['age'];
		$this->$patientPhone = $patient['phone'];
		$this->$patientEmail = $patient['email'];
		$this->$patientPassword = $patient['password']; 
		}
	}// end __construct


	public function getPatients(){
        $patients = array();
        try {
            $query = $this->db->connect()->query(
                'SELECT * FROM patients' 
            );
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
               		
                $patients[]=$row; 
            }
            
        } catch (PDOException $e) {
            echo $e;
        }

        $json = json_encode($patients);
        echo $json; 
       
    }//end function

    public function getPatient($id){

    	 $patient = array();
        try {


            $query = $this->db->connect()->query(
                'SELECT * FROM patients WHERE patientID = ' . $id   
            );

            while($row = $query->fetch(PDO::FETCH_ASSOC)){
               		
               array_push($patient, $row); 
            }
            
        } catch (PDOException $e) {
            echo $e;
        }

     $EmptyTestArray = array_filter($patient);
	 empty($EmptyTestArray)?array_push($patient, "There is no patient with ID = " . $id) : "" ;
		  
		

	 $json = json_encode($patient);

	 echo  $json ;
        


    }//end function

        public function postPatient($arr){

      	 try {
            $query = $this->db->connect()->prepare(
                'INSERT INTO patients(
      			patientName,
                patientSurname,
                patientAge,
                patientPhone,
                patientEmail,
                patientPassword)
                VALUES(:name,:surname,:age,:phone,:email,:password)'
            );
            $query->execute([
                'name'      =>  $arr['name'],
                'surname'   => $arr['surname'],
                'age'     => $arr['age'],
                'phone'=> $arr['phone'],
                'email'     => $arr['email'],
                'password'  => $arr['password'] 
            ]);
            return true;
        } catch (PDOException $e) {
            echo $e;   
        } 



		}//end function

		 public function putPatient($arr,$id){
		  	
      	 try {
            $query = $this->db->connect()->prepare(
                "UPDATE patients SET
                patientName =   '  ".$arr['name']." ' ,
                patientSurname =  '  ".$arr['surname']." ' ,
                patientAge =  '  ".$arr['age']." ' ,
                patientPhone =  '  ".$arr['phone']." ' ,
                patientEmail =   '  ".$arr['email']." ' ,
                patientPassword =  '  ".$arr['password']." ' 
               
                
                WHERE  patientID = " . $id);  
            $query->execute(); 
            return true;
        } catch (PDOException $e) {
            echo $e;   
        } 
		}//end function


		 public function deletePatient($id){
       		 try {
            $query = $this->db->connect()->prepare(
                'DELETE FROM patients
                WHERE patientID = '.$id
            );
            $query->execute();
            return true;
        } catch (PDOException $e) {
            echo $e;
        }
    }




}//end class


 ?>
