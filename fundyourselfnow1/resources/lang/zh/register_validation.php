<?php

$array =  [

	/*
	|--------------------------------------------------------------------------
	| Pagination Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines are used by the paginator library to build
	| the simple pagination links. You are free to change them to anything
	| you want to customize your views to better match your application.
	|
	*/

	'username_error'		 => "请输入用户名",
	'Email_error'   		 =>   "请输入邮箱"
	'Email_error1'   		 =>   "邮箱已被占用。您可以选择忘记密码去重设登录信息。",
	'Email_error2'   		 =>   "邮箱地址无效。",
	'username_error1'     	 =>  "请使用字母、数字作为用户名 ",
	'first_name'	         => "请输入您的名字",
	'lastname'                => "请输入您的姓氏",	
	'password_error'    	 => "请输入密码",
	'password_error1'    	 => "密码应至少包含10位字符", 
    'password_error1_text'   =>  "密码应至少包含1个大写字母，1个小写字母，1个数字和1个特殊字符 (!@#$%^&*)",
	'cpassword_error'    	 => "请输入确认密码",
	'cpassword_error1'    	 =>  "两次密码不一致",
	

];
 
return json_encode($array);