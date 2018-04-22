<?php

namespace App\Http\Controllers;

use Request; 
use DB;
use DateTime;
use Session;
use App\Loguser;
use App\Http\Requests;

class HomeController extends Controller
{
    //INDEX
    public function index(){
        if(session::has('username')){
            $user = DB::table('users') -> where('username', session::get('username')) -> first();
            $survey=DB::table('survey')->get(); 
            $log=DB::table('loguser')->join('users', 'id_users', '=', 'users.id_user')->orderBy('id_log','desc')->paginate(5);
            return view('role.superadmin.home', compact('user','survey','log')); 
            
        } 
        else {
            $id_user = DB::table('users') -> where('username', session::get('username')) -> value('id_user'); 
            date_default_timezone_set("Asia/Jakarta"); 
            $status = 0;
            $now = date('Y-m-d H:i:s');
            $loguser=DB::table('loguser')->where('id_users', $id_user)->where('waktu_logout','0000-00-00 00:00:00')->first();

            $updatestatus = DB::table('loguser')->where('id_users',$id_user)->where('id_log', $loguser->id_log)->update(['status'=>$status, 'waktu_logout'=>$now]);
            if($updatestatus) {
                session::forget('username');
                return redirect('login');
            }
            else {
                return redirect('login');
            }
        }
    }
}
