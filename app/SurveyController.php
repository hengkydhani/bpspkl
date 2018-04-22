<?php

namespace App\Http\Controllers;

use Request;
use DB; 
use Date;
use DateTime;
use DateTimeZone;
use Session;
use Schema;
use Excel;
use Alert;
use Illuminate\Database\Schema\Blueprint;

use App\Http\Requests;

class SurveyController extends Controller
{
    //INDEX 
    public function index() 
    {  
        $user = DB::table('users')->where('username', session::get('username'))->first();
        $level=$user->level_user;

        $survey=DB::table('survey')->get();
        if($level == "1") {
            return view('role.superadmin.createsurvey', compact('user', 'survey'));
        }else{
            Alert::error("Maaf, anda tidak punya hak akses")->persistent("Oke");
            return back();
        } 
    }

    //CREATE
    public function create(){
        $now = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $date = date('Y');
        $dateTime = date('Y-m-d');
        $id_survey = Request::get('surveyidentity');
        $survey_mulai = Request::get('tgl_mulai');
        $survey_selesai = Request::get('tgl_selesai');
        $user_login = Session::get('username');
        $tahapan_mulai = Request::get('tahapan_mulai');
        $tahapan_selesai = Request::get('tahapan_selesai');
        $nama_tahapan = Request::get('nama_tahapan');
        $size = count($nama_tahapan);
        $nama_wilayah = Request::get('nama_wilayah');
        $length_wilayah = Request::get('length_wilayah');
        $data_tahapan = Request::get('data_tahapan');
        $type_tahapan = Request::get('type_tahapan');
        
        //DB::beginTransaction();

        //try{
            //Monitoring/survey
            if($survey_mulai>=$survey_selesai or $survey_mulai<$dateTime or $survey_selesai<=$dateTime){
                Alert::error("Tanggal survey yang anda masukkan salah")->persistent("Oke");
                return redirect('createsurvey');
            } else {
                DB::table('survey')->insert([
                    'id_survey' => $id_survey,
                    'nama_survey' => Request::get('surveyname'),
                    'tgl_mulai' => $survey_mulai,
                    'tgl_selesai' => $survey_selesai,
                    'status' => 0,
                    'tahun' => $date,
                    'tgl_create' => $now,
                    'tgl_update' => $now,
                    'user_create' => $user_login,
                    'user_update' => $user_login
                ]);
            }
        /*}   catch (\Exception $e) {
            DB::table('survey')->where('id_survey', $id_survey)->where('tgl_create', $now)->delete();
            Alert::error("Terdapat data survey yang terisi secara tidak benar.")->persistent("Oke");
            return redirect('createsurvey');
        }*/

        $survey = DB::table('survey')->where('id_survey', $id_survey)->first();

        //try{
            //Cakupan Wilayah
            $count=Request::get('count');
            $index=count($count);
            for($j=1;$j<=$index;$j++){
                $dat = Request::file('wilayah'.$j);
                DB::table('wilayah')->insert([
                    'id_wilayah'=>$j,
                    'id_survey'=>$survey->id_survey,
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

        /*}catch (\Exception $e) {
            DB::table('survey')->where('id_survey', $id_survey)->where('tgl_create', $now)->delete();
            DB::table('wilayah')->where('id_survey', $id_survey)->where('tgl_create', $now)->delete();
            $this->deleteTableWilayah($index,$id_survey,$nama_wilayah);
            Alert::error("Terdapat data tahapan yang terisi secara tidak benar.")->persistent("Oke");
            return redirect('createsurvey');
        }

        try{*/
            //Tahapan Survey
            for($i=0;$i<$size;$i++){
                if($tahapan_mulai[$i]>=$tahapan_selesai[$i] or $tahapan_mulai[$i]<$survey_mulai or $tahapan_mulai[$i]>$survey_selesai or $tahapan_selesai[$i]<$survey_mulai or $tahapan_selesai[$i]>$survey_selesai){

                    DB::table('survey')->where('id_survey', $id_survey)->where('tgl_create', $now)->delete();
                    DB::table('wilayah')->where('id_survey', $id_survey)->where('tgl_create', $now)->delete();
                    DB::table('tahapansurvey')->where('id_survey', $id_survey)->where('tgl_create', $now)->delete();
                    $this->deleteTableWilayah($index,$id_survey,$nama_wilayah);
                    Alert::error("Tanggal tahapan yang anda masukkan salah")->persistent("Oke");
                    return redirect('createsurvey');

                } else {    
                    DB::table('tahapansurvey')->insert([
                        'id_tahapan'=>$i+1,
                        'id_survey'=> $survey->id_survey,
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
        /*}catch (\Exception $e) {
            DB::table('survey')->where('id_survey', $id_survey)->where('tgl_create', $now)->delete();
            DB::table('wilayah')->where('id_survey', $id_survey)->where('tgl_create', $now)->delete();
            DB::table('tahapansurvey')->where('id_survey', $id_survey)->where('tgl_create', $now)->delete();
            $this->deleteTableTahapan($index,$nama_tahapan,$id_survey,$nama_wilayah);
            Alert::error("Terdapat data tahapan yang terisi secara tidak benar.")->persistent("Oke");
            return redirect('createsurvey');
        }

        DB::commit();*/
        Alert::success("Survey telah berhasil dibuat, silakan atur hak akses terlebih dahulu")->persistent("Oke");
        return redirect($survey->id_survey.'/administrasi');

    } 

    public function survey($id_survey){
        if(Session::get('username')=="alvian" || Session::get('username')=="aneksa") {
            $user=DB::table('users') -> where('username', Session::get('username')) -> first();
            $level=$user->level_user;
            $survey = DB::table('survey')->get();
            $survey2 = DB::table('survey')->where('id_survey', $id_survey) -> first();
            $tahapanSurvey2 = DB::table('tahapansurvey') -> where('id_survey', $id_survey) -> get();

            return view('role.superadmin.survey', compact('user', 'id_survey', 'survey','tahapanSurvey2','survey2'));
        }
        $users=DB::table($id_survey.'-hakakses')->where('id_users', Session::get('username'))->first();
        if($users) {   
            $user=DB::table('users') -> where('username', Session::get('username')) -> first();
            $level=$users->hakakses;
            $survey = DB::table('survey')->get();
            $survey2 = DB::table('survey')->where('id_survey', $id_survey) -> first();
            $tahapanSurvey2 = DB::table('tahapansurvey') -> where('id_survey', $id_survey) -> get();

            if($level) {
                return view('role.superadmin.survey', compact('user', 'id_survey', 'survey','tahapanSurvey2','survey2'));
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

    //FORM EDIT SURVEY
    public function formEdit($id_survey){
        $user = DB::table('users')->where('username', session::get('username'))->first();
        $level=$user->level_user;

        $survey=DB::table('survey')->get();
        $this_survey=DB::table('survey')->where('id_survey', $id_survey)->first();
        $this_tahapan=DB::table('tahapansurvey')->where('id_survey', $id_survey)->get();
        if($level == "1") {
            return view('role.superadmin.editsurvey', compact('user', 'survey', 'this_survey', 'id_survey', 'this_tahapan'));
        }else{
            Alert::error("Maaf, anda tidak punya hak akses")->persistent("Oke");
            return back();
        } 
    }

    //EDIT SURVEY
    public function editSurvey($id_survey){
        $user = DB::table('users')->where('username', session::get('username'))->first();

        $now = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $user_login = Session::get('username');
        
        $in_id_survey = Request::get('surveyidentity');
        $nama_survey = Request::get('surveyname');
        $survey_mulai = Request::get('tgl_mulai');
        $survey_selesai = Request::get('tgl_selesai');

        $id_tahapan = Request::get('id_tahapan');
        $nama_tahapan = Request::get('nama_tahapan');
        $tahapan_mulai = Request::get('tahapan_mulai');
        $tahapan_selesai = Request::get('tahapan_selesai');
        
        $this_survey = DB::table('survey')->where('id_survey', $id_survey)->first();

        foreach ($id_tahapan as $f_id_tahapan){
            if($survey_selesai<$tahapan_selesai[$f_id_tahapan-1] or $survey_mulai>$survey_selesai or $tahapan_mulai[$f_id_tahapan-1]>$tahapan_selesai[$f_id_tahapan-1]){
                Alert::error("Maaf, tanggal yang anda masukkan salah")->persistent("Oke");
                return redirect('survey/'.$id_survey.'/edit');
            }
        }
        

        if($this_survey->id_survey==$in_id_survey)
        {
            DB::table('survey')->where('id_survey', $id_survey)->update(['nama_survey' => $nama_survey, 'tgl_selesai' => $survey_selesai, 'tgl_update' => $now, 'user_update' => $user_login]);
            $cek_survey=0;
        } else
        {
            $from = $id_survey.'-hakakses';
            $to = $in_id_survey.'-hakakses';
            $fromWil = $id_survey.'-hakakses-wilayah';
            $toWil = $in_id_survey.'-hakakses-wilayah';
            $cek_survey = 1;
            
            if($from!=$to)
                Schema::rename($from, $to);

            if($fromWil!=$toWil)
                Schema::rename($fromWil,$toWil); 

            $this_wilayah = DB::table('wilayah')->where('id_survey', $id_survey)->get();
            foreach ($this_wilayah as $f_this_wilayah) {
                $from = $id_survey.'-'.$f_this_wilayah->nama_wilayah;
                $to = $in_id_survey.'-'.$f_this_wilayah->nama_wilayah;

                DB::table('wilayah')->where('id_wilayah', $f_this_wilayah->id_wilayah)->where('id_survey', $id_survey)->update(['id_survey' => $in_id_survey, 'tgl_update' => $now, 'user_update' => $user_login]);
                if($from!=$to)
                    Schema::rename($from ,$to);
            }

            DB::table('survey')->where('id_survey', $id_survey)->update(['id_survey' => $in_id_survey, 'nama_survey' => $nama_survey, 'tgl_selesai' => $survey_selesai, 'tgl_update' => $now, 'user_update' => $user_login]);
                
                
        }

        foreach ($id_tahapan as $f_id_tahapan) {
            $f_tahapan = DB::table('tahapansurvey')->where('id_tahapan', $f_id_tahapan)->where('id_survey', $id_survey)->first();
            
            $from = $id_survey.'-'.$f_tahapan->nama_tahapan;
            $to = $in_id_survey.'-'.$nama_tahapan[$f_id_tahapan-1];
            if($from!=$to and $cek_survey)
                Schema::rename($from, $to); 

            $from = $id_survey.'-'.$f_tahapan->nama_tahapan.'-hist';
            $to = $in_id_survey.'-'.$nama_tahapan[$f_id_tahapan-1].'-hist';
            if($from!=$to and $cek_survey)
                Schema::rename($from, $to); 

            $from = $id_survey.'-'.$f_tahapan->nama_tahapan.'-histgl';
            $to = $in_id_survey.'-'.$nama_tahapan[$f_id_tahapan-1].'-histgl';
            if($from!=$to and $cek_survey)
                Schema::rename($from, $to);
    
            DB::table('tahapansurvey')->where('id_tahapan', $f_id_tahapan)->where('id_survey', $id_survey)->update(['id_survey' => $in_id_survey, 'nama_tahapan'=>$nama_tahapan[$f_id_tahapan-1],'tgl_selesai'=>$tahapan_selesai[$f_id_tahapan-1], 'tgl_update' => $now, 'user_update' => $user_login]);
        }

        return redirect('survey/'.$id_survey);
        
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

    protected function deleteTableTahapan($nama_tahapan,$id_survey,$nama_wilayah){
        foreach ($nama_tahapan as $f_nama_tahapan) {
            Schema::drop($id_survey.'-'.$f_nama_tahapan);
            Schema::drop($id_survey.'-'.$f_nama_tahapan.'-hist');
            Schema::drop($id_survey.'-'.$f_nama_tahapan.'-histgl');
            $this->deleteTableWilayah($index,$id_survey,$nama_wilayah);
        }
    }

    protected function deleteTableWilayah($index,$id_survey,$nama_wilayah){
       for($j=1;$j<=$index;$j++){
            Schema::drop($id_survey.'-'.$nama_wilayah[$j-1]);
        }
        Schema::drop($id_survey.'-hakakses-wilayah');
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
}
