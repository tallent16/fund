<?php 
namespace App\models;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class UserModel extends TranWrapper implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	 
	protected $table = 'users';
	
	protected $primaryKey = 'user_id';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id','username', 'email', 'password','usertype','status'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];
	
	public function getLastInsertRow() {
		
		$sql	= "	SELECT 	* 
					FROM 	users 
					ORDER BY user_id DESC LIMIT 1";
				
		$users 	= $this->dbFetchAll($sql);
		$row	= array(	"DT_RowId"=>"row_".$users[0]->user_id,
							"user_id"=>$users[0]->user_id,
							"username"=>$users[0]->username,
							"email"=>$users[0]->email,
							"password"=>"",
							"usertype"=>$users[0]->usertype,
							"status"=>$users[0]->status,
					);
		return $row;
	}
	
	public function getUpdatedRow($id) {
		
		$sql	= "	SELECT 	* 
					FROM 	users 
					WHERE 	user_id=".$id;
		
		$users 	= $this->dbFetchAll($sql);
		$row 	= array(	"DT_RowId"=>"row_".$users[0]->user_id,
							"user_id"=>$users[0]->user_id,
							"username"=>$users[0]->username,
							"email"=>$users[0]->email,
							"password"=>"",
							"usertype"=>$users[0]->usertype,
							"status"=>$users[0]->status,
						);
		return $row;
	}
	
	public function processRegstration($postArray) {
		
		$id				=	0;
		$current_date 	= 	date("Y-m-d H:i:s");
		$activation		=	md5($postArray['EmailAddress'].time()); // encrypted email+timestamp
		switch($postArray['Userrole']){
			case 'Borrower':
				$userType	=	1;
				break;
			case 'Investor':
				$userType	=	2;
				break;
		}
		$dataArray		=	array(	'email'=>$postArray['EmailAddress'],
									'password'=>\Hash::make($postArray['ConfirmPassword']),
									'created_at'=>$current_date,
									'activation'=>$activation,
									'username'=>'user',
									'usertype'=>$userType,
							);
		$id 			= 	$this->dbInsert('users', $dataArray, true);
		
		if($id){
				
				$whereArry	=	array("user_id" =>$id);
				$dataArry	=	array('status' => 1,'username' => "User".$id);
				$this->dbUpdate('users',$dataArry, $whereArry);
				
				$mailArry	=	array(	"email"=>$postArray['EmailAddress'],
										"subject"=>"Email verification",
										"confirmation_url"=>url()."/activation/".$activation,
								);
				$this->sendMail($mailArry);
		}
		return	$id;
	}
}
