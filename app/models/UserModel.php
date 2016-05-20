<?php 
namespace App\models;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Bican\Roles\Traits\HasRoleAndPermission;
use Bican\Roles\Contracts\HasRoleAndPermissionContract;

class UserModel extends TranWrapper implements AuthenticatableContract, CanResetPasswordContract,HasRoleAndPermissionContract {

	use Authenticatable, CanResetPassword, HasRoleAndPermission;

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
	
	public function geFetchAllRow()
	{
		$adminUsers_rs		=	array();
		$row				=	array();
		
		$adminUsers_sql		= "	SELECT 	* 
								FROM 	users
								WHERE	usertype	=	:system_role_param 
								ORDER BY user_id";
				
		$adminUsers_rs		= $this->dbFetchWithParam($adminUsers_sql,["system_role_param"=>USER_TYPE_ADMIN]);
		foreach($adminUsers_rs as $adminUserRow) {
				$row[] 	= array(	"DT_RowId"=>"row_".$adminUserRow->user_id,
									"user_id"=>$adminUserRow->user_id,
									"username"=>$adminUserRow->username,
									"email"=>$adminUserRow->email,
									"password"=>$adminUserRow->password,
									"usertype"=>$adminUserRow->usertype,
									"status"=>$adminUserRow->status,
								);
		}
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
									'username'=>$postArray['username'],
									'firstname'=>$postArray['firstname'],
									'lastname'=>$postArray['lastname'],
									'usertype'=>$userType,
							);
		$id 			= 	$this->dbInsert('users', $dataArray, true);
		
		if($id){
				
				$dataArray1		=	array(	'challenge_id'=>$postArray['SecurityQuestion1'],
											'challenge_answer'=>$postArray['SecurityQuestionAnswer1'],
											'user_id'=>$id
										);
				$this->dbInsert('user_challenges', $dataArray1, true);
				
				$whereArry	=	array("user_id" =>$id);
				$dataArry	=	array('status' => USER_STATUS_UNVERIFIED,'email_verified'=>USER_EMAIL_UNVERIFIED);
				$this->dbUpdate('users',$dataArry, $whereArry);
				
				$moneymatchSettings = $this->getMailSettingsDetail();
				
				
				$mailContents		= $moneymatchSettings[0]->borrower_signup_content;
				$mailSubject		= $moneymatchSettings[0]->borrower_signup_subject;

				$fields 			= array('[borrower_firstname]', '[borrower_lastname]', '[signup_email]',
											'[investor_firstname]', '[investor_lastname]', ' [confirmation_url]',
											'[application_name]');
				$replace_array 		= array();
				
				$replace_array 		= array( $postArray['firstname'], $postArray['lastname'], $postArray['EmailAddress'], 
											$postArray['firstname'], $postArray['lastname'],
											url()."/activation/".$activation, $moneymatchSettings[0]->application_name);
									
				$new_content 		= str_replace($fields, $replace_array, $mailContents);
				$new_subject 		= str_replace($fields, $replace_array, $mailSubject);
				
				$msgarray = array("content" => $new_content);			
				$msgData = array(	"subject" => $moneymatchSettings[0]->application_name." - ".$new_subject, 
									"from" => $moneymatchSettings[0]->mail_default_from,
									"from_name" => $moneymatchSettings[0]->application_name,
									"to" => $postArray['EmailAddress'],
									"cc" => $moneymatchSettings[0]->admin_email,
									"live_mail" => $moneymatchSettings[0]->send_live_mails,
									"template"=>"emails.confirmation");
									
				//~ $mailArry	=	array(	"email"=>$postArray['EmailAddress'],
										//~ "subject"=>"Email verification",
										//~ "template"=>"emails.confirmation",
										//~ "confirmation_url"=>url()."/activation/".$activation,
								//~ );
				$mailArry	=	array(	"msgarray"=>$msgarray,
										"msgData"=>$msgData);
				$this->sendMail($mailArry);
		}
		return	$id;
	}
	
}
