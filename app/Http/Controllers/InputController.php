<?php

namespace App\Http\Controllers;

use Request;
use DB;
use DateTime;
use DateTimeZone;
use Session;
use Schema;
use Excel;
use Alert;
use Date; 
use Illuminate\Support\Str; 

class InputController extends Controller
{
    public function index($id_survey,$id_tahapan) {

        if(Session::get('username')=="alvian" || Session::get('username')=="aneksa") {
            $user=DB::table('users')->where('username', session::get('username')) ->first();
            $level=$user->level_user;
            $survey = DB::table('survey')->get();
            $survey2 = DB::table('survey')->where('id_survey', $id_survey) -> first();
            $tahapan = DB::table('tahapansurvey') ->where('id_tahapan',$id_tahapan)->where('id_survey', $id_survey)->first(); 
            $tahapanSurvey2 = DB::table('tahapansurvey') -> where('id_survey', $id_survey) -> get();
            $daftarWilayah = DB::table('wilayah')->where('id_survey',$id_survey)->get();
            return view('role.superadmin.inputprogress',compact('user','id_survey','id_tahapan','survey','survey2','tahapan','tahapanSurvey2','daftarWilayah','level')); 
        } else { 
            return redirect('login');
        }

        $users=DB::table($id_survey.'-hakakses')->where('id_users', Session::get('username'))->first();
        if($users){
            $user=DB::table('users') -> where('username', Session::get('username')) -> first();
            $level=$users->hakakses;

            $survey = DB::table('survey')->get();
            $survey2 = DB::table('survey')->where('id_survey', $id_survey) -> first();
            $tahapan = DB::table('tahapansurvey') ->where('id_tahapan',$id_tahapan)->where('id_survey', $id_survey)->first();
            $tahapanSurvey2 = DB::table('tahapansurvey') -> where('id_survey', $id_survey) -> get();
            $daftarWilayah = DB::table('wilayah')->where('id_survey',$id_survey)->get();

            if($level) {
                return view('role.superadmin.inputprogress',compact('user','id_survey','id_tahapan','survey','survey2','tahapan','tahapanSurvey2','daftarWilayah','level'));
            }
            else {
                return back();
            }          
        }
        else {
            Alert::error("Maaf, anda tidak punya hak akses")->persistent("Oke");
            return back();
        }
    }

    public function tambah($id_survey, $id_tahapan) {
        $users=DB::table($id_survey.'-hakakses')->where('id_users', Session::get('username'))->first();
        if($users) {
            $level=$users->hakakses;
                if($level=="Operator" || $level="Admin") {
                    
                    $user=DB::table('users') -> where('username', Session::get('username')) -> first();
                        $user_login = session::get('username'); 
                        $count_wil = Request::get('count_wil');
                        $count_input = Request::get('count_input');
                        $now = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                        $tahapan = DB::table('tahapansurvey') -> where([
                                                                    ['id_tahapan', '=', $id_tahapan],
                                                                    ['id_survey', '=', $id_survey],
                                                                ]) -> first();
                        $header_wilayah = Schema::getColumnListing($id_survey.'-'.$tahapan->nama_tahapan);
                        for($i=0;$i<count($header_wilayah);$i++){
                            if($i<count($count_wil)){
                                $row1_create[$header_wilayah[$i]]=Request::get('wilayah'.$count_wil[$i]);
                                $row1_edit[$header_wilayah[$i]]=Request::get('wilayah'.$count_wil[$i]);
                                $row2_create[$header_wilayah[$i]]=Request::get('wilayah'.$count_wil[$i]);
                                $row3_create[$header_wilayah[$i]]=Request::get('wilayah'.$count_wil[$i]);
                                $row3_edit[$header_wilayah[$i]]=Request::get('wilayah'.$count_wil[$i]);
                            } else if ($i<count($count_input)+count($count_wil)){
                                $row1_create[$header_wilayah[$i]]=Request::get('input'.$count_input[$i-count($count_wil)]);
                                $row1_edit[$header_wilayah[$i]]=Request::get('input'.$count_input[$i-count($count_wil)]);
                                $row2_create[$header_wilayah[$i]]=Request::get('input'.$count_input[$i-count($count_wil)]);
                                $row3_create[$header_wilayah[$i]]=Request::get('input'.$count_input[$i-count($count_wil)]);
                                $row3_edit[$header_wilayah[$i]]=Request::get('input'.$count_input[$i-count($count_wil)]);
                            }
                        }

                        $row1_create['tgl_create'] = $now;
                        $row1_create['tgl_update'] = $now;
                        $row2_create['tgl_create'] = $now;
                        $row2_create['tgl_update'] = $now;
                        $row3_create['tgl_create'] = date('Y-m-d');
                        $row3_create['tgl_update'] = $now;

                        $row1_edit['tgl_update'] = $now;
                        $row3_edit['tgl_update'] = $now;

                        $row1_create['user_create'] = $user_login;
                        $row1_create['user_update'] = $user_login;
                        $row1_edit['user_update'] = $user_login;
                        $row2_create['user_create'] = $user_login;
                        $row2_create['user_update'] = $user_login;
                        $row3_create['user_create'] = $user_login;
                        $row3_create['user_update'] = $user_login;
                        $row3_edit['user_update'] = $user_login;

                        $wilayah = DB::table('wilayah')->where('id_survey', $id_survey)->get();
                        $size_wilayah = count($wilayah);
                        for($i=0;$i<$size_wilayah;$i++){
                            $head[]=$wilayah[$i]->nama_wilayah;
                        }

                        for($i=count($count_wil)-1;$i>=0;$i--){
                            $in_wilayah['id_'.$head[$i]] = Request::get('wilayah'.$count_wil[$i]);
                        }
                        
                        $cek_wilayah = DB::table($id_survey.'-'.$wilayah[count($wilayah)-1]->nama_wilayah)->where($in_wilayah)->first();

                        //if($cek_wilayah){            
                            $survey_tahapan = DB::table($id_survey.'-'.$tahapan->nama_tahapan) -> where($in_wilayah) -> first();

                            $row1_create['target'] = $survey_tahapan->target;
                            $row2_create['target'] = $survey_tahapan->target;
                            $row3_create['target'] = $survey_tahapan->target;

                            $row1_update['target'] = $survey_tahapan->target;
                            $row3_update['target'] = $survey_tahapan->target;


                            if($survey_tahapan) {
                                DB::table($id_survey.'-'.$tahapan->nama_tahapan)->where($in_wilayah)->update($row1_edit);
                            } else {
                                DB::table($id_survey.'-'.$tahapan->nama_tahapan)->insert($row1_create);
                            }

                            DB::table($id_survey.'-'.$tahapan->nama_tahapan.'-hist')->insert($row2_create);

                            $now_date = date('Y-m-d');
                            $survey_tahapan_histgl = DB::table($id_survey.'-'.$tahapan->nama_tahapan.'-histgl')->where($in_wilayah)->orderBy('tgl_create', 'DESC')->first();
                            if($survey_tahapan_histgl){
                                if($now_date > $survey_tahapan_histgl->tgl_create) {
                                    DB::table($id_survey.'-'.$tahapan->nama_tahapan.'-histgl')->insert($row3_create);
                                } else {
                                    DB::table($id_survey.'-'.$tahapan->nama_tahapan.'-histgl')->where($in_wilayah)->update($row3_edit);
                                }
                            } else {
                                DB::table($id_survey.'-'.$tahapan->nama_tahapan.'-histgl')->insert($row3_create);
                            }

                        /*} else {
                            Alert::warning('wilayah tidak cocok..')->persistent('Oke');
                            return redirect($id_survey.'/'.$id_tahapan.'/input');
                        }*/

                        Alert::success('Data telah berhasil ditambahkan')->persistent('Oke');
                        return redirect($id_survey.'/'.$id_tahapan.'/input');
                }
                else {
                    Alert::error("Maaf, anda tidak punya hak akses")->persistent("Oke");
                    return back(); 
                }
        }
        if((Session::get('username')=="alvian") || (Session::get('username')=="aneksa")) {
               $user=DB::table('users') -> where('username', Session::get('username')) -> first();
                    $user_login = session::get('username'); 
                    $count_wil = Request::get('count_wil');
                    $count_input = Request::get('count_input');
                    $now = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                    $tahapan = DB::table('tahapansurvey') -> where([
                                                                ['id_tahapan', '=', $id_tahapan],
                                                                ['id_survey', '=', $id_survey],
                                                            ]) -> first();
                    $header_wilayah = Schema::getColumnListing($id_survey.'-'.$tahapan->nama_tahapan);
                    for($i=0;$i<count($header_wilayah);$i++){
                        if($i<count($count_wil)){
                            $row1_create[$header_wilayah[$i]]=Request::get('wilayah'.$count_wil[$i]);
                            $row1_edit[$header_wilayah[$i]]=Request::get('wilayah'.$count_wil[$i]);
                            $row2_create[$header_wilayah[$i]]=Request::get('wilayah'.$count_wil[$i]);
                            $row3_create[$header_wilayah[$i]]=Request::get('wilayah'.$count_wil[$i]);
                            $row3_edit[$header_wilayah[$i]]=Request::get('wilayah'.$count_wil[$i]);
                        } else if ($i<count($count_input)+count($count_wil)){
                            $row1_create[$header_wilayah[$i]]=Request::get('input'.$count_input[$i-count($count_wil)]);
                            $row1_edit[$header_wilayah[$i]]=Request::get('input'.$count_input[$i-count($count_wil)]);
                            $row2_create[$header_wilayah[$i]]=Request::get('input'.$count_input[$i-count($count_wil)]);
                            $row3_create[$header_wilayah[$i]]=Request::get('input'.$count_input[$i-count($count_wil)]);
                            $row3_edit[$header_wilayah[$i]]=Request::get('input'.$count_input[$i-count($count_wil)]);
                        }
                    }

                    $row1_create['tgl_create'] = $now;
                    $row1_create['tgl_update'] = $now;
                    $row2_create['tgl_create'] = $now;
                    $row2_create['tgl_update'] = $now;
                    $row3_create['tgl_create'] = date('Y-m-d');
                    $row3_create['tgl_update'] = $now;

                    $row1_edit['tgl_update'] = $now;
                    $row3_edit['tgl_update'] = $now;

                    $row1_create['user_create'] = $user_login;
                    $row1_create['user_update'] = $user_login;
                    $row1_edit['user_update'] = $user_login;
                    $row2_create['user_create'] = $user_login;
                    $row2_create['user_update'] = $user_login;
                    $row3_create['user_create'] = $user_login;
                    $row3_create['user_update'] = $user_login;
                    $row3_edit['user_update'] = $user_login;

                    $wilayah = DB::table('wilayah')->where('id_survey', $id_survey)->get();
                    $size_wilayah = count($wilayah);
                    for($i=0;$i<$size_wilayah;$i++){
                        $head[]=$wilayah[$i]->nama_wilayah;
                    }

                    for($i=count($count_wil)-1;$i>=0;$i--){
                        $in_wilayah['id_'.strtolower($head[$i])] = Request::get('wilayah'.$count_wil[$i]);
                    }
                    
                    $cek_wilayah = DB::table($id_survey.'-'.$wilayah[count($wilayah)-1]->nama_wilayah)->where($in_wilayah)->first();

                    if($cek_wilayah){            
                        $survey_tahapan = DB::table($id_survey.'-'.$tahapan->nama_tahapan) -> where($in_wilayah) -> first();

                        $row1_create['target'] = $survey_tahapan->target;
                        $row2_create['target'] = $survey_tahapan->target;
                        $row3_create['target'] = $survey_tahapan->target;

                        $row1_update['target'] = $survey_tahapan->target;
                        $row3_update['target'] = $survey_tahapan->target;


                        if($survey_tahapan) {
                            DB::table($id_survey.'-'.$tahapan->nama_tahapan)->where($in_wilayah)->update($row1_edit);
                        } else {
                            DB::table($id_survey.'-'.$tahapan->nama_tahapan)->insert($row1_create);
                        }

                        DB::table($id_survey.'-'.$tahapan->nama_tahapan.'-hist')->insert($row2_create);

                        $now_date = date('Y-m-d');
                        $survey_tahapan_histgl = DB::table($id_survey.'-'.$tahapan->nama_tahapan.'-histgl')->where($in_wilayah)->orderBy('tgl_create', 'DESC')->first();
                        if($survey_tahapan_histgl){
                            if($now_date > $survey_tahapan_histgl->tgl_create) {
                                DB::table($id_survey.'-'.$tahapan->nama_tahapan.'-histgl')->insert($row3_create);
                            } else {
                                DB::table($id_survey.'-'.$tahapan->nama_tahapan.'-histgl')->where($in_wilayah)->update($row3_edit);
                            }
                        } else {
                            DB::table($id_survey.'-'.$tahapan->nama_tahapan.'-histgl')->insert($row3_create);
                        }

                    } else {
                        Alert::warning('wilayah tidak cocok..')->persistent('Oke');
                        return redirect($id_survey.'/'.$id_tahapan.'/input');
                    }

                    Alert::success('Data telah berhasil ditambahkan')->persistent('Oke');
                    return redirect($id_survey.'/'.$id_tahapan.'/input');
        }
        else {
            Alert::error("Maaf, anda tidak punya hak akses")->persistent("Oke");
            return back();
        } 
    }

    public function tambahdgnfile($id_survey, $id_tahapan) {
        $now = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $user_login = session::get('username');
        $tahapan = DB::table('tahapansurvey') -> where('id_survey', $id_survey) -> where('id_tahapan', $id_tahapan) -> first();
        $dat = Request::file('data');
        $exdata = Excel::selectSheetsByIndex(0)->load($dat, function($reader) {})->get();
        $wilayah = DB::table('wilayah')->where('id_survey', $id_survey)->get();
        foreach ($exdata->toArray() as $f_exdata) {
            $row1_create=$f_exdata;
            $row2_create=$f_exdata;
            $row3_create=$f_exdata;
            $row1_edit=$f_exdata;
            $row3_edit=$f_exdata;
            for($i=0;$i<count($wilayah);$i++){
                $a='id_'.$wilayah[$i]->nama_wilayah;
                $in_wilayah[$a]=$f_exdata[$a];
            }
        
            $row1_create['tgl_create'] = $now;
            $row1_create['tgl_update'] = $now;
            $row1_create['user_create'] = $user_login;
            $row1_create['user_update'] = $user_login;
            $row2_create['tgl_create'] = $now;
            $row2_create['tgl_update'] = $now;
            $row2_create['user_create'] = $user_login;
            $row2_create['user_update'] = $user_login;
            $row3_create['tgl_create'] = date('Y-m-d');
            $row3_create['tgl_update'] = $now;
            $row3_create['user_create'] = $user_login;
            $row3_create['user_update'] = $user_login;

            $row1_edit['tgl_update'] = $now;
            $row1_edit['user_update'] = $user_login;
            $row3_edit['tgl_update'] = $now;
            $row3_edit['user_update'] = $user_login;

            $cek_wilayah = DB::table($id_survey.'-'.$wilayah[count($wilayah)-1]->nama_wilayah)->where($in_wilayah)->first();

            if($cek_wilayah){  

                //untuksurveytahapan          
                $survey_tahapan = DB::table($id_survey.'-'.$tahapan->nama_tahapan) -> where($in_wilayah) -> first();
                
                if($survey_tahapan) {
                    DB::table($id_survey.'-'.$tahapan->nama_tahapan)->where($in_wilayah)->update($row1_edit);
                } else {
                    DB::table($id_survey.'-'.$tahapan->nama_tahapan)->insert($row1_create);
                }

                //untukhist
                $cek_hist=$in_wilayah;
                $cek_hist['tgl_create']=$now;
                $cek_tahapan = DB::table($id_survey.'-'.$tahapan->nama_tahapan.'-hist') -> where($cek_hist) -> first();
                
                if($cek_tahapan){
                    DB::table($id_survey.'-'.$tahapan->nama_tahapan.'-hist')->where($cek_hist)->update($row2_create);    
                } else { 
                    DB::table($id_survey.'-'.$tahapan->nama_tahapan.'-hist')->insert($row2_create);
                }

                //untukhisttgl
                $now_date = date('Y-m-d');
                $survey_tahapan_histgl = DB::table($id_survey.'-'.$tahapan->nama_tahapan.'-histgl')->where($in_wilayah)->orderBy('tgl_create', 'DESC')->first();

                if($survey_tahapan_histgl){
                    if($now_date > $survey_tahapan_histgl->tgl_create) {
                        DB::table($id_survey.'-'.$tahapan->nama_tahapan.'-histgl')->insert($row3_create);
                    } else {
                        DB::table($id_survey.'-'.$tahapan->nama_tahapan.'-histgl')->where($in_wilayah)->update($row3_edit);
                    }
                } else {
                    DB::table($id_survey.'-'.$tahapan->nama_tahapan.'-histgl')->insert($row3_create);
                }

            } else {
                Alert::warning('wilayah tidak cocok..')->persistent('Oke');
                return redirect($id_survey.'/'.$id_tahapan.'/input');
            }

        }
        Alert::success('Data telah berhasil ditambahkan')->persistent('Oke');
            return redirect($id_survey.'/'.$id_tahapan.'/input');
    }
}
