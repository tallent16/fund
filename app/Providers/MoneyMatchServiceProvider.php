<?php namespace App\Providers;
use Blade;
use Illuminate\Support\ServiceProvider;

class MoneyMatchServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {
		
		Blade::extend(function($value)	{
			
			$value = preg_replace('/(?<=\s)@switch\((.*)\)(\s*)@case\((.*)\)(?=\s)/', '<?php switch($1):$2case $3: ?>', $value);
			$value = preg_replace('/(?<=\s)@endswitch(?=\s)/', '<?php endswitch; ?>', $value);
			$value = preg_replace('/(?<=\s)@case\((.*)\)(?=\s)/', '<?php case $1: ?>', $value);
			$value = preg_replace('/(?<=\s)@default(?=\s)/', '<?php default: ?>', $value);
			$value = preg_replace('/(?<=\s)@break(?=\s)/', '<?php break; ?>', $value);
			$value = preg_replace('/\@var(.+)/', '<?php ${1}; ?>', $value);
			return $value;
		});
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}

}
