<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Input;
use Session;
use DB;
use Excel;
use Schema;
use Illuminate\Database\Schema\Blueprint;
 
class ExcelController extends Controller
{
    public function exportuser() {
        $export = User::all();
        Excel::create('Data Hak Akses' ,function($excel) use($export) {
            $excel -> sheet('DataUser' ,function($sheet) use($export) {
                $sheet -> fromArray($export);
            });
        }) -> export('csv');
    }
    
    public function exportwilayah() {
        $provinsi = Provinsi::all();
        $kabkot = Kabkot::all();
        
        Excel::create('Data Wilayah' ,function($excel) use($provinsi, $kabkot) {
            $excel -> sheet('DataProvinsi' ,function($sheet) use($provinsi) {
                $sheet -> fromArray($provinsi);
            });
            $excel->sheet('DataKabkot', function($sheet) use($kabkot) {
                $sheet -> fromArray($kabkot);
            });
        }) -> export('xlsx');
    }
    
    public function importwilayah() {
        $data = Request::file('inputwilayah');
        $data = Excel::selectSheetsByIndex(0)->load($data, function($reader) use($data) {
            })->get();
        Schema::create('SEN-Wilayah-Provinsi', function(Blueprint $table)use($data){
           
            $header=$data->first();
            foreach ($header as $key=>$row) {
                $table->string($key);
            }
        });
        foreach ($data->toArray() as $row) {
            DB::table('SEN-Wilayah-Provinsi')->insert([$row]);
        }        
        return back();
    }
    
}
