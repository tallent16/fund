<?php namespace App\models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_login';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id','user_name', 'email', 'password','user_type','status'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];
	
	public static function CheckUserName($userName)
	{
		$sql= "select count(*) cnt from user_login where user_name = '".$userName."'";
		$users = DB::select($sql);
		$cnt = $users[0]->cnt;
		return ($cnt == 0)?false:true;
	}
	public static function CheckExistingUserName($userName,$id)
	{
		$sql= "select count(*) cnt from user_login where user_name = '".$userName."' AND id <>".$id;
		$users = DB::select($sql);
		$cnt = $users[0]->cnt;
		return ($cnt == 0)?false:true;
	}
	
	public static function CheckUserEmail($userEmail)
	{
		$sql= "select count(*) cnt from user_login where email = '".$userEmail."'";
		$users = DB::select($sql);
		$cnt = $users[0]->cnt;
		return ($cnt == 0)?false:true;
	}
	
	public static function CheckExistingUserEmail($userEmail,$id)
	{
		$sql= "select count(*) cnt from user_login where email = '".$userEmail."' AND id <>".$id;
		$users = DB::select($sql);
		$cnt = $users[0]->cnt;
		return ($cnt == 0)?false:true;
	}
	
	public static function getLastInsertRow()
	{
		$sql= "select * from user_login order by id desc LIMIT 1";
		$users = DB::select($sql);
		$row = array(	"DT_RowId"=>"row_".$users[0]->id,
						"id"=>$users[0]->id,
						"user_name"=>$users[0]->user_name,
						"email"=>$users[0]->email,
						"password"=>"",
						"user_type"=>$users[0]->user_type,
						"status"=>$users[0]->status,
				);
		return $row;
	}
	public static function getUpdatedRow($id)
	{
		$sql= "select * from user_login where id=".$id;
		$users = DB::select($sql);
		$row = array(	"DT_RowId"=>"row_".$users[0]->id,
						"id"=>$users[0]->id,
						"user_name"=>$users[0]->user_name,
						"email"=>$users[0]->email,
						"password"=>"",
						"user_type"=>$users[0]->user_type,
						"status"=>$users[0]->status,
				);
		return $row;
	}
}
