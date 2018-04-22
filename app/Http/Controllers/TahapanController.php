<?php

namespace App\Http\Controllers;

use Request;
use DB;
use DateTime;
use Session;
use Schema;
use Excel;
use Illuminate\Database\Schema\Blueprint;

use App\Http\Requests;

class TahapanController extends Controller
{
    //VIEW TAHAPAN
    public function viewTahapan($id_survey, $id_tahapan){ 
        if(Session::get('username')=="alvian" || Session::get('username')=="aneksa") {
        	$user = DB::table('users')->where('username', session::get('username'))->first();
            $level=$user->level_user; 
 
            $survey = DB::table('survey')->get();
            $survey2 = DB::table('survey')->where('id_survey', $id_survey) -> first();
            $tahapanSurvey2 = DB::table('tahapansurvey') -> where('id_survey', $id_survey) -> get();
            $tahapan = DB::table('tahapansurvey') -> where('id_survey', $id_survey) -> where('id_tahapan', $id_tahapan) -> first();
            $ambildata = DB::table($id_survey.'-'.$tahapan->nama_tahapan) -> get();
            $ambilprovinsi = DB::table($id_survey.'-provinsi') ->get();
            return view('role.superadmin.tahapansurvey', compact('user','id_survey','id_tahapan','survey', 'survey2', 'tahapanSurvey2','tahapan','ambildata','ambilprovinsi'));
        } else { 
            return redirect('login');
        }
        $users=DB::table($id_survey.'-hakakses')->where('id_users', Session::get('username'))->first();
        if($users) { 
            $user=DB::table('users') -> where('username', Session::get('username')) -> first();
            $level=$users->hakakses;

            $survey = DB::table('survey')->get();
            $survey2 = DB::table('survey')->where('id_survey', $id_survey) -> first();
            $tahapanSurvey2 = DB::table('tahapansurvey') -> where('id_survey', $id_survey) -> get();

            if($level) {
                 return view('role.superadmin.tahapansurvey', compact('user','id_survey','id_tahapan','survey', 'survey2', 'tahapanSurvey2'));
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

    public function viewcreatetahapan($id_survey) {
        $user = DB::table('users')->where('username', session::get('username'))->first();
        $level=$user->level_user;
        $survey=DB::table('survey')->get();
        $survey2 = DB::table('survey')->where('id_survey', $id_survey) -> first();
        $tahapanSurvey2 = DB::table('tahapansurvey') -> where('id_survey', $id_survey) -> get();
        if($level == "1") {
            return view('role.superadmin.createtahapan', compact('user', 'survey','id_survey','$survey','survey2','tahapanSurvey2'));
        }else{
            Alert::error("Maaf, anda tidak punya hak akses")->persistent("Oke");
            return back();
        } 
    }

    //CREATE
    public function create($id_survey){
        $user_login = Session::get('username');
        $tahapan_mulai = Request::get('tahapan_mulai');
        $tahapan_selesai = Request::get('tahapan_selesai');
        $nama_tahapan = Request::get('nama_tahapan');
        $size = count($nama_tahapan);
        $nama_wilayah = Request::get('nama_wilayah');
        $length_wilayah = Request::get('length_wilayah');
        $data_tahapan = Request::get('data_tahapan');
        $type_tahapan = Request::get('type_tahapan');

        //Cakupan Wilayah
        $count=Request::get('count');
        $index=count($count);
        for($j=1;$j<=$index;$j++){
            $dat = Request::file('wilayah'.$j);
            DB::table('wilayah')->insert([
                'id_wilayah'=>$j,
                'id_survey'=>$id_survey,
                'nama_wilayah'=>$nama_wilayah[$j-1],
                'data_wilayah'=>$id_survey.'-'.$nama_wilayah[$j-1],
                'tgl_create'=>$now,
                'tgl_update'=>$now,
                'user_create' => $user_login,
                'user_update' => $user_login
            ]);

            $exdata = Excel::selectSheetsByIndex(0)->load($dat, function($reader) {})->get();

            Schema::create($id_survey.'-'.$nama_wilayah[$j-1], function(Blueprint $table)use($j,$nama_wilayah,$length_wilayah){
                for($k=$j-1;$k>=0;$k--){
                    if($k==$j-1){
                        $table->string('id_'.$nama_wilayah[$k],$length_wilayah[$k])->primary();
                    } else {
                        $table->string('id_'.$nama_wilayah[$k],$length_wilayah[$k]);
                    }
                }
                $table->string('nama_'.$nama_wilayah[$j-1]);
                    
            });
            foreach ($exdata->toArray() as $row) {
                DB::table($id_survey.'-'.$nama_wilayah[$j-1])->insert([$row]);
            }
        }
        //End Cakupan Wilayah

        //Hak Akses
        $admin = Request::get('admin');

        Schema::create($id_survey.'-hakakses', function(Blueprint $table){

            $table->string('id_users');
            $row_hakakses[] = 'id_users';
            $table->string('hakakses');
            $row_hakakses[] = 'hakakses';
            $table->primary($row_hakakses);
            $table->dateTime('tgl_create');
            $table->dateTime('tgl_update');
            $table->string('user_create');
            $table->string('user_update');
        });

        Schema::create($id_survey.'-hakakses-wilayah', function(Blueprint $table)use($nama_wilayah,$length_wilayah){
            foreach(array_combine($nama_wilayah, $length_wilayah) as $wil=>$length){
                $table->string('id_'.$wil,$length);
                $row_hakakses[] = 'id_'.$wil;
            }
            $table->string('id_users');
            $row_hakakses[] = 'id_users';
            $table->primary($row_hakakses);
            $table->dateTime('tgl_create');
            $table->dateTime('tgl_update');
            $table->string('user_create');
            $table->string('user_update');
        });
        //End Hak Akses

        //Tahapan Survey
        for($i=0;$i<$size;$i++){
            if($tahapan_mulai[$i]>=$tahapan_selesai[$i] or $tahapan_mulai[$i]<$survey_mulai or $tahapan_mulai[$i]>$survey_selesai or $tahapan_selesai[$i]<$survey_mulai or $tahapan_selesai[$i]>$survey_selesai){

                DB::table('survey')->where('id_survey', $id_survey)->where('tgl_create', $now)->delete();
                DB::table('wilayah')->where('id_survey', $id_survey)->where('tgl_create', $now)->delete();
                DB::table('tahapansurvey')->where('id_survey', $id_survey)->where('tgl_create', $now)->delete();
                $this->deleteTableWilayah($index,$id_survey,$nama_wilayah);
                Alert::error("Tanggal tahapan yang anda masukkan salah")->persistent("Oke");
                return redirect('survey/'.$id_survey.'/create');

            } else {    
                DB::table('tahapansurvey')->insert([
                    'id_tahapan'=>$i+1,
                    'id_survey'=> $id_survey,
                    'nama_tahapan'=>$nama_tahapan[$i],
                    'tgl_mulai'=>$tahapan_mulai[$i],
                    'tgl_selesai'=>$tahapan_selesai[$i],
                    'tgl_create'=>$now,
                    'tgl_update'=>$now,
                    'user_create' => $user_login,
                    'user_update' => $user_login

                ]);

                $this->createTableTahapan($id_survey,$nama_tahapan,$nama_wilayah,$length_wilayah,$data_tahapan,$type_tahapan,$i);
            }
        }
        //End Tahapan Survey
        Alert::success("Survey telah berhasil dibuat, silakan atur hak akses terlebih dahulu")->persistent("Oke");
        return redirect($survey->id_survey.'/administrasi');
    } 

    protected function createTableTahapan($id_survey,$nama_tahapan,$nama_wilayah,$length_wilayah,$data_tahapan,$type_tahapan,$i){
        Schema::create($id_survey.'-'.$nama_tahapan[$i], function(Blueprint $table)use($nama_wilayah,$length_wilayah,$data_tahapan,$type_tahapan,$i){    
            foreach(array_combine($nama_wilayah, $length_wilayah) as $wil=>$length){
                $table->string('id_'.$wil,$length);
                $primary[] = 'id_'.$wil;
            }
            $size_tambah_tahapan=count($data_tahapan[$i+1]);
            for($j=0;$j<$size_tambah_tahapan;$j++){
                if($type_tahapan[$i+1][$j]=='1'){
                    $table->string($data_tahapan[$i+1][$j]);
                }else if($type_tahapan[$i+1][$j]=='2'){
                    $table->integer($data_tahapan[$i+1][$j]);
                }else if($type_tahapan[$i+1][$j]=='3'){
                    $table->float($data_tahapan[$i+1][$j]);
                }
            }
            $table->integer('target');
            $table->primary($primary);
            $table->dateTime('tgl_create');
            $table->dateTime('tgl_update');
            $table->string('user_create');
            $table->string('user_update');
        });
                    
        Schema::create($id_survey.'-'.$nama_tahapan[$i].'-hist', function(Blueprint $table)use($nama_wilayah,$length_wilayah,$data_tahapan,$type_tahapan,$i){      
            foreach(array_combine($nama_wilayah, $length_wilayah) as $wil=>$length){
                $table->string('id_'.$wil,$length);
                $primary[] = 'id_'.$wil;
            }
            $size_tambah_tahapan=count($data_tahapan[$i+1]);
            for($j=0;$j<$size_tambah_tahapan;$j++){
                if($type_tahapan[$i+1][$j]=='1'){
                    $table->string($data_tahapan[$i+1][$j]);
                }else if($type_tahapan[$i+1][$j]=='2'){
                    $table->integer($data_tahapan[$i+1][$j]);
                }else if($type_tahapan[$i+1][$j]=='3'){
                    $table->float($data_tahapan[$i+1][$j]);
                }
            }
            $table->integer('target');
            $table->dateTime('tgl_create');
            $primary[] = 'tgl_create';
            $table->primary($primary);
            $table->dateTime('tgl_update');
            $table->string('user_create');
            $table->string('user_update');
        });

        Schema::create($id_survey.'-'.$nama_tahapan[$i].'-histgl', function(Blueprint $table)use($nama_wilayah,$length_wilayah,$data_tahapan,$type_tahapan,$i){      
            foreach(array_combine($nama_wilayah, $length_wilayah) as $wil=>$length){
                $table->string('id_'.$wil,$length);
                $primary[] = 'id_'.$wil;
            }
            $size_tambah_tahapan=count($data_tahapan[$i+1]);
            for($j=0;$j<$size_tambah_tahapan;$j++){
                if($type_tahapan[$i+1][$j]=='1'){
                    $table->string($data_tahapan[$i+1][$j]);
                }else if($type_tahapan[$i+1][$j]=='2'){
                    $table->integer($data_tahapan[$i+1][$j]);
                }else if($type[$i+1][$j]=='3'){
                    $table->float($data_tahapan[$i+1][$j]);
                }
            }
            $table->integer('target');
            $table->date('tgl_create');
            $primary[] = 'tgl_create';
            $table->primary($primary);
            $table->dateTime('tgl_update');
            $table->string('user_create');
            $table->string('user_update');
        });

        //import target
        $user_login = session::get('username'); 
        $now = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $wilayah = DB::table('wilayah')->where('id_survey', $id_survey)->get();
    
        $size = count($nama_tahapan);
        
        for($i=1;$i<=$size;$i++){
            $dat = Request::file('target'.$i);
            $exdata = Excel::selectSheetsByIndex(0)->load($dat, function($reader) {})->get();

            foreach ($exdata->toArray() as $f_exdata) {
                $row1_create=$f_exdata;
                $row2_create=$f_exdata;
                $row3_create=$f_exdata;
                $row1_edit=$f_exdata;
                $row3_edit=$f_exdata;

                for($j=0;$j<count($wilayah);$j++){
                    $a=strtolower('id_'.$wilayah[$j]->nama_wilayah);
                    $in_wilayah[$a]=$f_exdata[$a];
                }

                $size_tambah_tahapan=count($data_tahapan[$i]);
                for($j=0;$j<$size_tambah_tahapan;$j++){
                    $row1_create[$data_tahapan[$i][$j]]=0;
                    $row2_create[$data_tahapan[$i][$j]]=0;
                    $row3_create[$data_tahapan[$i][$j]]=0;
                    $row1_edit[$data_tahapan[$i][$j]]=0;
                    $row3_edit[$data_tahapan[$i][$j]]=0;     
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

                $survey_tahapan = DB::table($id_survey.'-'.$nama_tahapan[$i-1]) -> where($in_wilayah) -> first();     

                //tahapan
                if($survey_tahapan) {
                    DB::table($id_survey.'-'.$nama_tahapan[$i-1])->where($in_wilayah)->update($row1_edit);
                } else {
                    DB::table($id_survey.'-'.$nama_tahapan[$i-1])->insert($row1_create);
                }

                //tahapan-hist
                $cek_hist=$in_wilayah;
                $cek_hist['tgl_create']=$now;
                $cek_tahapan = DB::table($id_survey.'-'.$nama_tahapan[$i-1].'-hist') -> where($cek_hist) -> first();
                    
                if($cek_tahapan){
                    DB::table($id_survey.'-'.$nama_tahapan[$i-1].'-hist')->where($cek_hist)->update($row2_create);    
                } else { 
                    DB::table($id_survey.'-'.$nama_tahapan[$i-1].'-hist')->insert($row2_create);
                }

                //untukhisttgl
                $now_date = date('Y-m-d');
                $survey_tahapan_histgl = DB::table($id_survey.'-'.$nama_tahapan[$i-1].'-histgl')->where($in_wilayah)->orderBy('tgl_create', 'DESC')->first();

                if($survey_tahapan_histgl){
                    if($now_date > $survey_tahapan_histgl->tgl_create) {
                        DB::table($id_survey.'-'.$nama_tahapan[$i-1].'-histgl')->insert($row3_create);
                    } else {
                        DB::table($id_survey.'-'.$nama_tahapan[$i-1].'-histgl')->where($in_wilayah)->update($row3_edit);
                    }
                } else {
                    DB::table($id_survey.'-'.$nama_tahapan[$i-1].'-histgl')->insert($row3_create);
                }

            }
        }
    }

}
