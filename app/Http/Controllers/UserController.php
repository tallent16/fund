<?php 
namespace App\Http\Controllers;  
include( app_path()."/libraries/php/DataTables.php" );
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Join,
	DataTables\Editor\Validate;
	use DataTables\Database;
	
use Auth;  

use Request;

use DB;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class UserController extends MoneyMatchController {
	/**
	 * The Guard implementation.
	 *
	 * @var \Illuminate\Contracts\Auth\Guard
	 */
	protected $auth;

	/**
	 * The registrar implementation.
	 *
	 * @var \Illuminate\Contracts\Auth\Registrar
	 */
	protected $registrar;

	/**
	 * Show the application registration form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	
	public function __construct() {	
		$this->init();
	}
	
	public function index() { 
	
		$withArry	=	array(	"classname"=>"fa fa-users fa-fw");
		return view('user')->with($withArry); 
	}  
  
	public function view_user() { 
	
		global $moneydb;
		
		if(isset($_POST['action'])){
		//print_r($_POST);

			if($_POST['action'] == "create") { 

				try{
					if(empty($_POST['data']['username'])) {
						throw new Exception("User Name should not be empty");
					}
					if(empty($_POST['data']['email'])) {
						throw new Exception("User Email should not be empty");
					}
					$email = $_POST['data']['email'];
					if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					  throw new Exception("Invalid email format");
					}
					if($this->user->CheckUserName($_POST['data']['username'])) {
						throw new Exception("Duplicate Entry of User Name");
					}
					if($this->user->CheckUserEmail($_POST['data']['email'])) {
						throw new Exception("Duplicate Entry of User Email");
					}
					if(empty($_POST['data']['password'])) {
						throw new Exception("User Password should not be empty");
					}
					if (strlen($_POST['data']['password']) < 6) {
						throw new Exception("Password requires at least 6 characters" );
					}
					if(empty($_POST['data']['status'])) {
						throw new Exception("Please Select Status");
					}
					
					DB::insert("insert into users (username,
									email,password,usertype,status,email_verified) 
									values (?,?,?,?,?,?)",array($_POST['data']['username'],
														$_POST['data']['email'],
														\Hash::make($_POST['data']['password']),
														USER_TYPE_ADMIN,
														$_POST['data']['status'],
														USER_EMAIL_VERIFIED
													)
								);
					$row = $this->user->getLastInsertRow();
					return json_encode(array("row"=>$row));
				}
				catch(Exception $e) {
				
					return json_encode(array("error"=>$e->getMessage()));
					
				}
				
			}
			if($_POST['action'] == "edit") {
				//~ echo "<pre>",print_r($_POST),"</pre>";
				//~ die;
				try{
					if(empty($_POST['data']['username'])) {
						throw new Exception("User Name should not be empty");
					}
					if(empty($_POST['data']['email'])) {
						throw new Exception("User Email should not be empty");
					}
					$email = $_POST['data']['email'];
					if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					  throw new Exception("Invalid email format");
					}
					if($this->user->CheckExistingUserName($_POST['data']['username'],str_replace("row_","",$_POST['id'])) ){
						throw new Exception("Duplicate Entry of User Name");
					}
					if($this->user->CheckExistingUserEmail($_POST['data']['email'],str_replace("row_","",$_POST['id'])) ){
						throw new Exception("Duplicate Entry of User Email");
					}
					DB::statement("	UPDATE 	users 
										SET 	username = '".$_POST['data']['username']."',
												email='".$_POST['data']['email']."',
												status='".$_POST['data']['status']."',
												email_verified='".USER_EMAIL_VERIFIED."'
												WHERE user_id ='".str_replace("row_","",$_POST['id'])."'"
												
									); 
					$row = $this->user->getUpdatedRow(str_replace("row_","",$_POST['id']));
					return json_encode(array("row"=>$row));
				}
				catch(Exception $e){
					return json_encode(array("error"=>$e->getMessage()));
				}
			}
			
			if($_POST['action'] == "remove") {
				
				Editor::inst($moneydb , "users" ,"user_id")
					->fields(
								Field::inst( 'user_id' ),
								Field::inst( 'username' ),
								Field::inst( 'email' ),
								Field::inst( 'password' )
							)
					->process( $_POST )
					->json();
			}

		}else{
			
			$rows		=	array();
			$options	=	array();
			$rows		=	$this->user->geFetchAllRow();
			
			return json_encode(array("data"=>$rows,"options"=>$options));
		}
	}
	
	public function uploadShowWelcomeMessageStatus() {
		
		$postArray	=	Request::all();
		$this->user->uploadShowWelcomeMessageStatus($postArray);
		return "update successfully";
	} 
}
