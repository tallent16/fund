<?php 
namespace App\Http\Controllers;  

use Auth;
use Session;
use Input;
use Redirect;

class TranslationController extends MoneyMatchController {

	//changing the language and redirect to current page
    public function languagetranslation($lang)	{
        Session::set('locale', $lang);
        \App::setLocale($lang);
        return Redirect::back();
    }
}
