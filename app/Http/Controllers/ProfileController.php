<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;

class ProfileController extends Controller
{
	public function index($username) {
	    if($username){
		    $user = DB::table('users') -> where('username', session::get('username')) -> first();
		    $survey=DB::table('survey')->get(); 
		    return view('role.superadmin.profile', compact('user','survey','f_survey')); 
	            
	    } else { 
	         return redirect('login');
	    }
	}
}
