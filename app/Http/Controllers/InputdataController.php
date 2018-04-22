<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use DateTime;
use Session;

class InputdataController extends Controller
{
    public function index() {
        if(session::has('email')){
            $user=DB::table('users')
                ->where('email', session::get('email'))
                ->first();
            return view('inputdata',compact('user'));
        }
        else {
            return redirect('/');
        }
    }
}
