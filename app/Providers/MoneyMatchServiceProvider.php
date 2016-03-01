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
		
		Blade::extend(function($value) {
			return preg_replace('/\@var(.+)/', '<?php ${1}; ?>', $value);
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
