<?php

//~ $settings_sql= "	SELECT 	*
					//~ FROM 	system_settings";
			
//~ $settings_rs 		=	DB::select("SELECT 	*
										//~ FROM 	system_settings");
//~ $settings_rs 		=	\DB::table('system_settings')->first();
//~ print_r($settings_rs);
//~ die;
//~ $driver 			=	$settings_rs[0]->mail_driver;
//~ $host 				=	$settings_rs[0]->mail_host;
//~ $port				=	$settings_rs[0]->mail_port;
//~ $email_from			=	$settings_rs[0]->mail_default_from;
//~ $email_from_name	=	$settings_rs[0]->application_name;
//~ $password			=	$settings_rs[0]->mail_password;
//~ $smtp_userid		=	$settings_rs[0]->mail_username;
$driver 			=	"smtp";
$host 				=	"smtp.gmail.com";
$port				=	"465";
$email_from			=	"cs@fundyourselvesnow.com";
$email_from_name	=	"FundYourselvesNow";
$password			=	"ganapathi20122012";//
$smtp_userid		=	"sathya@syllogic.in";//"deepan@syllogic.in";//
$encrption			=	"ssl";

return [

	/*
	|--------------------------------------------------------------------------
	| Mail Driver
	|--------------------------------------------------------------------------
	|
	| Laravel supports both SMTP and PHP's "mail" function as drivers for the
	| sending of e-mail. You may specify which one you're using throughout
	| your application here. By default, Laravel is setup for SMTP mail.
	|
	| Supported: "smtp", "mail", "sendmail", "mailgun", "mandrill", "log"
	|
	*/

	'driver' => $driver,

	/*
	|--------------------------------------------------------------------------
	| SMTP Host Address
	|--------------------------------------------------------------------------
	|
	| Here you may provide the host address of the SMTP server used by your
	| applications. A default option is provided that is compatible with
	| the Mailgun mail service which will provide reliable deliveries.
	|
	*/

	'host' => $host,

	/*
	|--------------------------------------------------------------------------
	| SMTP Host Port
	|--------------------------------------------------------------------------
	|
	| This is the SMTP port used by your application to deliver e-mails to
	| users of the application. Like the host we have set this value to
	| stay compatible with the Mailgun e-mail application by default.
	|
	*/

	'port' => $port,

	/*
	|--------------------------------------------------------------------------
	| Global "From" Address
	|--------------------------------------------------------------------------
	|
	| You may wish for all e-mails sent by your application to be sent from
	| the same address. Here, you may specify a name and address that is
	| used globally for all e-mails that are sent by your application.
	|
	*/

	'from' => ['address' => $email_from, 'name' => $email_from_name],

	/*
	|--------------------------------------------------------------------------
	| E-Mail Encryption Protocol
	|--------------------------------------------------------------------------
	|
	| Here you may specify the encryption protocol that should be used when
	| the application send e-mail messages. A sensible default using the
	| transport layer security protocol should provide great security.
	|
	*/

	'encryption' => $encrption,

	/*
	|--------------------------------------------------------------------------
	| SMTP Server Username
	|--------------------------------------------------------------------------
	|
	| If your SMTP server requires a username for authentication, you should
	| set it here. This will get used to authenticate with your server on
	| connection. You may also set the "password" value below this one.
	|
	*/

	'username' =>$smtp_userid,

	/*
	|--------------------------------------------------------------------------
	| SMTP Server Password
	|--------------------------------------------------------------------------
	|
	| Here you may set the password required by your SMTP server to send out
	| messages from your application. This will be given to the server on
	| connection so that the application will be able to send messages.
	|
	*/

	'password' => $password,

	/*
	|--------------------------------------------------------------------------
	| Sendmail System Path
	|--------------------------------------------------------------------------
	|
	| When using the "sendmail" driver to send e-mails, we will need to know
	| the path to where Sendmail lives on this server. A default path has
	| been provided here, which will work well on most of your systems.
	|
	*/

	'sendmail' => '/usr/sbin/sendmail -bs',

	/*
	|--------------------------------------------------------------------------
	| Mail "Pretend"
	|--------------------------------------------------------------------------
	|
	| When this option is enabled, e-mail will not actually be sent over the
	| web and will instead be written to your application's logs files so
	| you may inspect the message. This is great for local development.
	|
	*/

	'pretend' => false,

];
