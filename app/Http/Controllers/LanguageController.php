<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App;
use URL;
use Lang;

class LanguageController extends Controller
{
    public function setLocale($locale){
        if (!in_array($locale, ['en', 'ca', 'es'])){
            
            $locale = 'en';
        }
        App::setlocale($locale);
        session()->put('locale', $locale);
        //return redirect()->action('HomeController@index');
        return redirect(url(URL::previous()));
    }
}