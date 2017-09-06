<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use \App\models\AdminManageBidsModel;
use \App\models\AdminNotificationsModel;
use \App\models\AdminBulkMailerModel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'App\Console\Commands\Inspire',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		// $schedule->command('inspire')  ->hourly();
		
		$schedule->call(function () {
			$manageBids = new AdminManageBidsModel();
			$manageBids->autoCloseBid();
		})->daily();
		
		$schedule->call(function () { 
			//Call broadcast notification  cron job
			$notificationsModel = new AdminNotificationsModel();
			$notificationsModel->cronBroadcastNotifications();
			
			//Call bulk mailer cron job
			$mailerModel = new AdminBulkMailerModel();
			$mailerModel->cronBulkMailer();
			// $mailerModel->sendBulkMails("Test Every Minute","test",array("muthu.openit@gmail.com"));
			
		})->cron('* * * * * *');
		
	}

}
