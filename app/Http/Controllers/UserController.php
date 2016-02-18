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

class UserController extends Controller {
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
	 
	public function index() { 
	
		return view('user'); 
	}  
  
	public function view_user() { 
	
		global $moneydb;
		
		if(isset($_POST['action'])){
		//print_r($_POST);

			if($_POST['action'] == "create"){

				try{
					if(empty($_POST['data']['user_name'])){
						throw new Exception("User Name should not be empty");
					}
					if(empty($_POST['data']['email'])){
						throw new Exception("User Email should not be empty");
					}
					$email = $_POST['data']['email'];
					if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					  throw new Exception("Invalid email format");
					}
					if(empty($_POST['data']['user_type'])){
						throw new Exception("Please Select User Type");
					}
					if(empty($_POST['data']['status'])){
						throw new Exception("Please Select Status");
					}
					if(empty($_POST['data']['password'])){
						throw new Exception("User Password should not be empty");
					}
					if(\App\models\User::CheckUserName($_POST['data']['user_name'])){
						throw new Exception("Duplicate Entry of User Name");
					}
					if(\App\models\User::CheckUserEmail($_POST['data']['email'])){
						throw new Exception("Duplicate Entry of User Email");
					}
					DB::insert("insert into user_login (user_name,
									email,password,user_type,status) 
									values (?,?,?,?,?)",array($_POST['data']['user_name'],
														$_POST['data']['email'],
														\Hash::make($_POST['data']['password']),
														$_POST['data']['user_type'],
														$_POST['data']['status']
													)
								);
					$row = \App\models\User::getLastInsertRow();
					return json_encode(array("row"=>$row));
				}
				catch(Exception $e){
				
					return json_encode(array("error"=>$e->getMessage()));
					
				}
				
			}
			if($_POST['action'] == "edit"){
				//~ echo "<pre>",print_r($_POST),"</pre>";
				//~ die;
				try{
					if(empty($_POST['data']['user_name'])){
						throw new Exception("User Name should not be empty");
					}
					if(empty($_POST['data']['email'])){
						throw new Exception("User Email should not be empty");
					}
					$email = $_POST['data']['email'];
					if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					  throw new Exception("Invalid email format");
					}
					if(\App\models\User::CheckExistingUserName($_POST['data']['user_name'],str_replace("row_","",$_POST['id'])) ){
						throw new Exception("Duplicate Entry of User Name");
					}
					if(\App\models\User::CheckExistingUserEmail($_POST['data']['email'],str_replace("row_","",$_POST['id'])) ){
						throw new Exception("Duplicate Entry of User Email");
					}
					if(empty($_POST['data']['password'])){
						
						DB::statement("UPDATE user_login SET user_name = '".$_POST['data']['user_name']."',
												email='".$_POST['data']['email']."',
												user_type='".$_POST['data']['user_type']."',
												status='".$_POST['data']['status']."'
												WHERE id ='".str_replace("row_","",$_POST['id'])."'"
												
									); 
							
					}else{
						
						DB::statement("UPDATE user_login SET user_name = '".$_POST['data']['user_name']."',
												email='".$_POST['data']['email']."',
												password='".\Hash::make($_POST['data']['password'])."',
												user_type='".$_POST['data']['user_type']."',
												status='".$_POST['data']['status']."'
												WHERE id ='".str_replace("row_","",$_POST['id'])."'"
									);
					}
					
					$row = \App\models\User::getUpdatedRow(str_replace("row_","",$_POST['id']));
					return json_encode(array("row"=>$row));
				}
				catch(Exception $e){
				
					return json_encode(array("error"=>$e->getMessage()));
					
				}
				
			}
			if($_POST['action'] == "remove"){
				
				Editor::inst($moneydb , "user_login" ,"id")
					->fields(
								Field::inst( 'id' ),
								Field::inst( 'username' ),
								Field::inst( 'email' ),
								Field::inst( 'password' )
							)
					->process( $_POST )
					->json();
			}


			}else{
			Editor::inst($moneydb , "user_login" ,"id")
					->fields(
								Field::inst( 'id' ),
								Field::inst( 'user_name' ),
								Field::inst( 'email' ),
								Field::inst( 'user_type' ),
								Field::inst( 'status' )
							)
					->process( $_POST )
					->json();
			}
		}
}
