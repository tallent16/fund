<?php 

class DbLink {

    public $host='localhost' ;
    public $user='root';
    public $pass='letmein2!';
    public $dbase='project_db';
    public $connection;

    public function __construct()
    {
        $this->connection = new PDO("mysql:host={$this->host};dbname={$this->dbase}", $this->user, $this->pass);
        //$this->connection = new PDO("mysql:host={$host};dbname={$dbase}", $user, $pass);
        //echo "Connected";
      //  die;
    }
    //~ public function connect()
    //~ {
        //~ return $this->connection;
    //~ }
    //~ public function close()
    //~ {
        //~ unset($this->connection);
        //~ return true;
    //~ }
    //~ 
    
   public function getData($queryStr){
		$dataSet = array();
		$dataSet = $this->connection->query($queryStr)->fetchAll(PDO::FETCH_ASSOC);
		return $dataSet;
   }	
   public function updateData($updatequery) {
	   $upData = $this->connection->query($updatequery);	
	   return $upData;
	}   	
  public function deleteData($deletequery) {
	  $delData = $this->connection->query($deletequery);
	  return $delData;
	}   	
}

class person extends DbLink {						
	public function getPersonDetails()
	{		
		$personSql = "SELECT * from person";
		//die;
		$personData =  $this->getData($personSql);		
		return $personData;
	}	
	
	public function updateDetails()
	{		
		$personUpSql = "UPDATE person SET name ='priya' WHERE name ='gomathi'";
		$perUpData =$this->updateData($personUpSql);
		return $perUpData;
	}	
	
	public function deleteDetails()
	{
		$persondelSql = "DELETE from person where name ='priya'";
		$perDelData = $this->deleteData($persondelSql);
		return $perDelData;
	}	
}	

class student extends person {			
		public function getStudentDetails($studId)
	{
		$studentSql = "SELECT * from student where fkuser_id={$studId}";
		//die;
		$studentData =  $this->getData($studentSql);		
		return 	$studentData;
	}		
}	

class employee extends person {
		public function getEmployeeDetails()
	{
			$employeeSql = "SELECT * FROM employee";
			$employeeData = $this->getData($employeeSql);			
			return $employeeData;
	}	
}

try {

$student1 = new student();
$employee1 = new employee();
//die;
		$result = $student1->getStudentDetails(12);
		foreach($result as $key =>$value)
		{		
			$school = $value['school'];
			$personId= $value['fkuser_id'];			
			$sub1_marks= $value['sub1_marks'];			
			$sub2_marks= $value['sub2_marks'];			
			$grade= $value['grade'];			
		}	

		$personData = $student1->getPersonDetails();
		foreach($personData as $key =>$value)
		{		
			$personName = $value['name'];
			$personAge = $value['age'];
			$personSex = $value['sex'];
		}	
	
		$employeeResult = $employee1->getEmployeeDetails();		 
		foreach($employeeResult as $key => $value)
		{
			$employeeCompany = $value['company'];
			$employeeSalary = $value['salary'];
			$employeeDepartment = $value['department'];
			$employeeDesignation = $value['designation'];
		}	
		
		
		$personDeData = $student1->deleteDetails();
			
		echo "Name:".$personName."<br>";
		echo "Age:".$personAge."<br>";
		echo "School:".$school."<br>";
		echo "Salary:".$employeeSalary."<br>";
		echo "Designation:".$employeeDesignation."<br>";
		
		$personUpDate = $student1->updateDetails();	
		
}catch (PDOException $e)
    {
		
        //exit('Connected to Databse');
        //echo ("Caught the error");
        exit($e->getMessage());
    }

?>
