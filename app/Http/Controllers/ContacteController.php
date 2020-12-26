<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Mail\MailFormulariContacte;
use Illuminate\Support\Facades\Mail;

class ContacteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return $request->session()->all();
        if($request->checkbox == 'on'){
            Mail::to('oriolrg@gmail.com')->send(new MailFormulariContacte($request));
            return back()->with(array('msg' => 'Missatge enviat correctament'));
        }else{
            return back()->with(array('msg' => 'Problemes a l\'enviar el missatge'));
        }
    }
}
