@extends('layouts.master')
@section('title')
  Dashboard
@endsection

@section('css')
  <link href="{{ asset('assets/css/jquery-confirm.css') }}" rel="stylesheet"> 
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <link href="{{ asset('assets/vendors/bower_components/fullcalendar/dist/fullcalendar.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendors/bower_components/animate.css/animate.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendors/vendors/bootgrid/jquery.bootgrid.min.css') }}" rel="stylesheet">
  <!-- Datatables -->
  <link href="{{ asset('assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendors/bower_components/google-material-color/dist/palette.css') }}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/sweetalert-master/dist/sweetalert.css')}}">
  <style type="text/css">
/* *********  tables styling  ******************************* */

.bulk-actions {
  display: none;
}
table.countries_list { 
  width: 100%;
}
table.countries_list td {
  padding: 0 10px;
  line-height: 30px;
  border-top: 1px solid #eeeeee;
}
.dataTables_paginate a {
  padding: 6px 9px !important;
  background: #ddd !important;
  border-color: #ddd !important;
}
.paging_full_numbers a.paginate_active {
  background-color: rgba(38, 185, 154, 0.59) !important;
  border-color: rgba(38, 185, 154, 0.59) !important;
}
button.DTTT_button, div.DTTT_button, a.DTTT_button {
  border: 1px solid #E7E7E7 !important;
  background: #E7E7E7 !important;
  box-shadow: none !important;
}
table.jambo_table {
  border: 1px solid rgba(221, 221, 221, 0.78);
}
table.jambo_table thead {
  background: rgba(52, 73, 94, 0.94);
  color: #ECF0F1;
}
table.jambo_table tbody tr:hover td {
  background: rgba(38, 185, 154, 0.07);
  border-top: 1px solid rgba(38, 185, 154, 0.11);
  border-bottom: 1px solid rgba(38, 185, 154, 0.11);
}
table.jambo_table tbody tr.selected {
  background: rgba(38, 185, 154, 0.16);
}
table.jambo_table tbody tr.selected td {
  border-top: 1px solid rgba(38, 185, 154, 0.40);
  border-bottom: 1px solid rgba(38, 185, 154, 0.40);
}
.dataTables_paginate a {
  background: #ff0000;
}
.dataTables_wrapper {
  position: relative;
  clear: both;
  zoom: 1;
  /* Feeling sorry for IE */
}
.dataTables_processing {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 250px;
  height: 30px;
  margin-left: -125px;
  margin-top: -15px;
  padding: 14px 0 2px 0;
  border: 1px solid #ddd;
  text-align: center;
  color: #999;
  font-size: 14px;
  background-color: white;
}
.dataTables_length {
  width: 40%;
  float: left;
}
.dataTables_filter {
  width: 50%;
  float: right;
  text-align: right;
}
.dataTables_info {
  width: 60%;
  float: left;
}
.dataTables_paginate {
  float: right;
  text-align: right;
}
table.dataTable th.focus,
table.dataTable td.focus {
    outline: 2px solid #1ABB9C !important;
    outline-offset: -1px;
}

/* Pagination nested */

.paginate_disabled_previous, .paginate_enabled_previous, .paginate_disabled_next, .paginate_enabled_next {
  height: 19px;
  float: left;
  cursor: pointer;
  color: #111 !important;
}
.paginate_disabled_previous:hover, .paginate_enabled_previous:hover, .paginate_disabled_next:hover, .paginate_enabled_next:hover {
  text-decoration: none !important;
}
.paginate_disabled_previous:active, .paginate_enabled_previous:active, .paginate_disabled_next:active, .paginate_enabled_next:active {
  outline: none;
}
.paginate_disabled_previous, .paginate_disabled_next {
  color: #666 !important;
}
.paginate_disabled_previous, .paginate_enabled_previous {
  padding-left: 23px;
}
.paginate_disabled_next, .paginate_enabled_next {
  padding-right: 23px;
  margin-left: 10px;
}
.paginate_disabled_previous {
  background: url('assets/img/back_disabled.png') no-repeat top left;
}
.paginate_enabled_previous {
  background: url('assets/img/back_enabled.png') no-repeat top left;
}
.paginate_enabled_previous:hover {
  background: url('assets/img/back_enabled_hover.png') no-repeat top left;
}
.paginate_disabled_next {
  background: url('assets/img/forward_disabled.png') no-repeat top right;
}
.paginate_enabled_next {
  background: url('assets/img/forward_enabled.png') no-repeat top right;
}
.paginate_enabled_next:hover {
  background: url('assets/img/forward_enabled_hover.png') no-repeat top right;
}
table.display {
  margin: 0 auto;
  clear: both;
  width: 100%;
}
table.display thead th {
  padding: 8px 18px 8px 10px;
  border-bottom: 1px solid black;
  font-weight: bold;
  cursor: pointer;
}
table.display tfoot th {
  padding: 3px 18px 3px 10px;
  border-top: 1px solid black;
  font-weight: bold;
}
table.display tr.heading2 td {
  border-bottom: 1px solid #aaa;
}
table.display td {
  padding: 3px 10px;
}
table.display td.center {
  text-align: center;
}
table.display thead th:active, table.display thead td:active {
  outline: none;
}
.dataTables_scroll {
  clear: both;
}
.dataTables_scrollBody {
  *margin-top: -1px;
  -webkit-overflow-scrolling: touch;
}
.top, .bottom {}
.top .dataTables_info {
  float: none;
}
.clear {
  clear: both;
}
.dataTables_empty {
  text-align: center;
}
tfoot input {
  margin: 0.5em 0;
  width: 100%;
  color: #444;
}
tfoot input.search_init {
  color: #999;
}
td.group {
  background-color: #d1cfd0;
  border-bottom: 2px solid #A19B9E;
  border-top: 2px solid #A19B9E;
}
td.details {
  background-color: #d1cfd0;
  border: 2px solid #A19B9E;
}
.example_alt_pagination div.dataTables_info {
  width: 40%;
}
.paging_full_numbers {
  width: 400px;
  height: 22px;
  line-height: 22px;
}
.paging_full_numbers a:active {
  outline: none
}
.paging_full_numbers a:hover {
  text-decoration: none;
}
.paging_full_numbers a.paginate_button, .paging_full_numbers a.paginate_active {
  border: 1px solid #aaa;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  padding: 2px 5px;
  margin: 0 3px;
  cursor: pointer;
}
.paging_full_numbers a.paginate_button {
  background-color: #ddd;
}
.paging_full_numbers a.paginate_button:hover {
  background-color: #ccc;
  text-decoration: none !important;
}
.paging_full_numbers a.paginate_active {
  background-color: #99B3FF;
}
table.display tr.even.row_selected td {
  background-color: #B0BED9;
}
table.display tr.odd.row_selected td {
  background-color: #9FAFD1;
}
div.box {
  height: 100px;
  padding: 10px;
  overflow: auto;
  border: 1px solid #8080FF;
  background-color: #E5E5FF;
}

/* *********  /tables styleing  ****************************** */
    </style>
@endsection

@section('leftNavbar')
    <aside id="s-main-menu" class="sidebar">
            <div class="smm-header">
                <i class="zmdi zmdi-long-arrow-left" data-ma-action="sidebar-close"></i>
            </div>

            <ul class="smm-alerts">
                <li data-user-alert="sua-messages" data-ma-action="sidebar-open" data-ma-target="user-alerts">
                    <i class="zmdi zmdi-email"></i>
                </li>
                <li data-user-alert="sua-notifications" data-ma-action="sidebar-open" data-ma-target="user-alerts">
                    <i class="zmdi zmdi-notifications"></i>
                </li>
                <li data-user-alert="sua-tasks" data-ma-action="sidebar-open" data-ma-target="user-alerts">
                    <i class="zmdi zmdi-view-list-alt"></i>
                </li>
            </ul>

            <ul class="main-menu">
                <li>
                    <a href="{{ url('/home') }}"><i class="zmdi zmdi-home"></i> Beranda</a>
                </li>

                <li class="sub-menu">
                    <a  href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-format-underlined"></i> Monitoring Survey</a>
                    <ul>
                        <li>
                            <a href="{{ url('/create') }}"> Buat Baru</a>
                        </li>
                        @foreach($survey as $survei)
                            <li><a href="{{ url($survei->id_survey) }}">{{$survei->id_survey}}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="sub-menu">
                    <a  href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-format-underlined"></i>Input Data {{ $survey2->id_survey }}</a>
                    <ul>
                            @foreach($tahapanSurvey2 as $f_tahapan)
                            <li>
                                <?php
                                    $survei2 = DB::table('tahapansurvey') -> where('id_survey', $id_survey)-> where('id_tahapan', $f_tahapan->id_tahapan) -> first();
                                ?>
                                <a href="{{ url($survei2->id_survey.'/'.$f_tahapan->id_tahapan.'/input') }}">{{ $f_tahapan->nama_tahapan }}</a>
                            </li>
                            @endforeach
                    </ul>
                </li>
                <li @yield('administration')>
                    <a href="{{ url($survey2->id_survey.'/administrasi') }}"><i class="zmdi zmdi-swap-alt"></i> Administrasi {{ $survey2->id_survey }}</a>
                </li>
                @if($user -> level_user == "1")
                <li>
                    <a href="{{ url('user') }}" ><i class="zmdi zmdi-home"></i> Pengguna</a>
                </li>
                @endif
                <li class="sub-menu">
                    <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-trending-up"></i> Riwayat</a>
                   <ul>
                        <li class="sub-menu">
                            <a href="" data-ma-action="submenu-toggle">SUKERNAS</a>
                            <ul>
                                <li><a href="alternative-header.html">Pemutakhiran</a></li>
                                <li><a href="colored-header.html">Pencacahan</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="" data-ma-action="submenu-toggle">SUSENAS</a>
                            <ul>
                                <li><a href="alternative-header.html">Pemutakhiran</a></li>
                                <li><a href="colored-header.html">Pencacahan</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
    </aside>
@endsection

@section('content')

<section id="content">
  <div class="container">
      <ol class="breadcrumb" style="margin-bottom: 5px;"> 
        <li><a href="{{url('/')}}">Beranda</a></li>
        <li><a href="{{url($id_survey) }}">{{ $survey2 -> id_survey }}</a></li>
        <li><a href="{{url($id_survey.'/'.$tahapan->id_tahapan)}}">{{ $tahapan -> nama_tahapan }}</a>
        <li>Input Data</li>
      </ol> 
      <div class="card">
          <div class="card-header">
              <h2>Ketentuan :<small>
              1. Pengisian laporan data survey oleh pihak yang berwenang<br>
              2. Pastikan nilai "jumlah" tidak melebihi nilai "target"<br>
              3. Pengisian nilai "jumlah" sebelum batas ambang
              </small></h2>
              <br>
               <div class="dropdown">
                  <button class="btn palette-Teal bg dropdown-toggle" type="button" data-toggle="dropdown">Survey
                  <span class="caret"></span></button>
                  <ul class="dropdown-menu">
                  @foreach ($survey as $f_survey)
                    <li class="dropdown-submenu">
                      <a class="test" tabindex="-1" href="#">{{ $f_survey -> nama_survey }} ( {{$f_survey -> id_survey}} )<span class="caret"></span></a>
                      <ul class="dropdown-submenu">
                      @foreach ($tahapanSurvey2 as $f_tahapanSurvey2)
                            <li><a class="test" tabindex="-1" href="#">{{ $f_tahapanSurvey2 -> nama_tahapan }}</a></li>
                      @endforeach
                      </ul>
                    </li>
                  @endforeach
                  </ul>
                </div>
          </div>
      </div>

      <?php
        date_default_timezone_set("Asia/Jakarta"); 
        $now = date('Y-m-d'); //Returns IST  
        $tglskrg = date_create($now);
        $tgldeadline = date_create($tahapan->tgl_selesai);
        $interval = date_diff($tgldeadline, $tglskrg); 
      ?>

      @if($level=="Admin" || $level=="Operator" || Session::get('username')=="alvian" || Session::get('username')=="aneksa")
      <div class="card">
        <div class="card-header">
        @if ($interval->format('%a') > 0)
          @if ( $interval->format('%R') == "+" )
            <div class="alert alert-danger" role="alert">
              <marquee><strong>Tahap {{ $tahapan -> nama_tahapan }} - {{ $survey2 -> nama_survey }} ({{$survey2->id_survey}})</strong> Sudah ditutup</marquee>
            </div>
          @elseif ( $interval->format('%R') == "-" )
          <div class="alert alert-info" role="alert">
            <marquee><strong>Tahap {{ $tahapan -> nama_tahapan }} - {{ $survey2 -> nama_survey }} ({{$survey2->id_survey}})!</strong> tersisa {{ $interval->format('%a') }} hari lagi.</marquee>
          </div>
          @endif 
        @else ($interval->format('%a') == 0)
          <div class="alert alert-info" role="alert">
            <marquee><strong>Tahap {{ $tahapan -> nama_tahapan }} - {{ $survey2 -> nama_survey }} ({{$survey2->id_survey}})!</strong> sudah deadline! Harap mengisi jumlah data setiap targetnya.</marquee>
          </div>
        @endif
          <h2><img src="{{ asset('assets/img/input.png') }}"  width="40" height="40" > Input Data {{$id_survey}}-{{ $tahapan -> nama_tahapan}}</h2>
          <br>
          <div class="row">
            <form class="form-horizontal" role="form" method="post" action="{{ url($id_survey.'/'.$id_tahapan.'/input/tambah') }}">
              {!! csrf_field() !!}
              <div class="col-sm-6 m-b-20">
                  <?php
                      $count_wil=1
                  ?>
                  <p>Pastikan field terisi semua</p>
                  @foreach ($daftarWilayah as $f_daftarWilayah)
                      <p class="f-500 m-b-15 c-black">{{$f_daftarWilayah->nama_wilayah}} :</p>
                      <select class="selectpicker" data-live-search="true" name="wilayah{{$count_wil}}" required>
                          <?php
                          $dataWilayah = DB::table($f_daftarWilayah->id_survey.'-'.$f_daftarWilayah->nama_wilayah)->get();
                          $nameWilayah = Schema::getColumnListing($f_daftarWilayah->id_survey.'-'.$f_daftarWilayah->nama_wilayah);
                          $count = count($nameWilayah);
                          ?>
                                          
                          @foreach($dataWilayah as $f_dataWilayah)
                          <option value="{{$f_dataWilayah->$nameWilayah[0]}}">{{ $f_dataWilayah->$nameWilayah[$count-1] }} {{$f_dataWilayah->$nameWilayah[0]}}</option>
                          @endforeach
                      </select>
                      <input type="hidden" name="count_wil[]" value="{{$count_wil++}}">
                      <br>
                      <br>
                  @endforeach
                  <?php 
                      $nametahapan = Schema::getColumnListing($id_survey.'-'.$tahapan->nama_tahapan);
                      $counttahapan = count($nametahapan);
                      $typetahapan = DB::select("select data_type from information_schema.columns where table_name='$id_survey-$tahapan->nama_tahapan'");
                      $count_input=1;
                      $count=DB::table('wilayah')->where('id_survey', $id_survey)->get();
                      for($i=count($count);$i<$counttahapan-5;$i++){ ?>
                          <p class="f-500 m-b-15 c-black">{{ $nametahapan[$i] }}</p>
                          @if($typetahapan[$i]->data_type == 'int' OR $typetahapan[$i]->data_type =='float' OR $typetahapan[$i]->data_type =='longint' OR $typetahapan[$i]->data_type =='double' OR $typetahapan[$i OR $typetahapan[$i]->data_type =='float']->data_type =='real')
                            <input type="number" id="number" class="form-control input-mask" name="input{{ $count_input }}" required>
                          @else
                            <input type="text" class="form-control input-mask" name="input{{ $count_input }}"  required>
                          @endif
                          <input type="hidden" name="count_input[]" value="<?php echo $count_input++ ?>">
                          <br>
                      <?php  }
                  ?> 
                  @if ($interval->format('%a') > 0)
                    @if ( $interval->format('%R') == "+" )
                      <a class="example2-1 btn btn-danger">Simpan</a>
                    @elseif ( $interval->format('%R') == "-" )
                      <button class="btn btn-primary">Simpan</button> 
                    @endif
                  @else ($interval->format('%a') == 0)
                     <button class="btn btn-primary">Simpan</button> 
                  @endif     
              </div>   
            </form>
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;
            <form class="form-horizontal" role="form" method="post" action="{{ url($id_survey.'/'.$id_tahapan.'/input/tambah/file') }}" enctype="multipart/form-data">
             {!! csrf_field() !!}
             <div class="col-sm-6 m-b-20">
                <p>Input data dengan file excel (.xlsx)</p>

                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <span class="btn btn-primary btn-file m-r-10">
                        <span class="fileinput-new">Select file</span>
                        <span class="fileinput-exists">Change</span>
                        <input type="file" name="data">
                    </span>
                    <span class="fileinput-filename"></span>
                    <a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>
                </div>
                @if ($interval->format('%a') > 0)
                  @if ( $interval->format('%R') == "+" )
                    <a class="example2-1 btn btn-danger">Simpan</a>
                  @elseif ( $interval->format('%R') == "-" )
                    <button type="submit" class="btn btn-primary">Simpan</button>  
                  @endif
                @else ($interval->format('%a') == 0)
                   <button type="submit" class="btn btn-primary">Simpan</button>  
                @endif     
             </div>
            </form>
          </div>   
        </div>    
      </div>  
      @endif  

      <div class="card">
          <div class="card-header cw-header palette-Blue-400 bg">
              <h2><font color="white">Tabel Data Input {{$id_survey}}</font></h2>
              <a  data-toggle="modal" href="#TambahHakAkses"></a>
          </div>

          <div class="card-body card-padding">
          <br>
          <br>
            <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                       <?php
                            $ambildata = DB::table($id_survey.'-'.$tahapan -> nama_tahapan) -> get();
                            $ambilkolom = Schema::getColumnListing($id_survey.'-'.$tahapan -> nama_tahapan);
                            $count = count($ambilkolom);
                        ?>
                        @if($count==7)
                          <tr>
                          <?php for($i=0;$i<5;$i++) { ?>
                            <th data-column-id="id" data-type="numeric">{{ $ambilkolom[$i] }}</th>
                          <?php } ?>
                            <th>Status</th>
                          <?php for($i=5;$i<$count;$i++) { ?>
                            <th data-column-id="id" data-type="numeric">{{ $ambilkolom[$i] }}</th>
                          <?php } ?>
                          </tr>
                        @endif 

                        @if($count==8)
                          <tr>
                          <?php for($i=0;$i<6;$i++) { ?>
                            <th data-column-id="id" data-type="numeric">{{ $ambilkolom[$i] }}</th>
                          <?php } ?>
                            <th>Status</th>
                          <?php for($i=6;$i<$count;$i++) { ?>
                            <th data-column-id="id" data-type="numeric">{{ $ambilkolom[$i] }}</th>
                          <?php } ?>
                          </tr>
                        @endif
                    </thead>
                    <tbody>
                        <?php $i=0; ?>
                        @foreach($ambildata as $f_ambildata)
                            <tr>
                            @if($count==7) <!-- Jika Cakupan Wilayah = Provinsi -->
                                <?php for($i=0;$i<5;$i++) { ?> 
                                <td>{{ $f_ambildata -> $ambilkolom[$i] }}</td>
                                <?php } ?>
                                @if($f_ambildata -> $ambilkolom[1] == $f_ambildata -> $ambilkolom[2]) 
                                <td><span class="btn btn-success">Selesai</span></td>
                                @endif
                                @if($f_ambildata -> $ambilkolom[1] < $f_ambildata -> $ambilkolom[2]) 
                                    @if($f_ambildata -> $ambilkolom[1]=="0") 
                                    <td><span class="btn btn-default">Belum terisi</span></td>
                                    @endif
                                    @if($f_ambildata -> $ambilkolom[1]!="0")
                                    <td><span class="btn palette-Orange bg">Kurang</span></td> 
                                    @endif
                                @endif
                                @if($f_ambildata -> $ambilkolom[1] > $f_ambildata -> $ambilkolom[2]) 
                                <td><span class="btn btn-danger">Melebihi</span></td>
                                @endif
                                <?php for($i=5;$i<$count;$i++) { ?> 
                                <td>{{ $f_ambildata -> $ambilkolom[$i] }}</td>
                                <?php } ?>
                            @endif
                            @if($count==8) <!-- Jika Cakupan Wilayah = Kabkot -->
                                <?php for($i=0;$i<6;$i++) { ?> 
                                <td>{{ $f_ambildata -> $ambilkolom[$i] }}</td>
                                <?php } ?>
                                @if($f_ambildata -> $ambilkolom[2] == $f_ambildata -> $ambilkolom[3]) 
                                <td><span class="btn btn-success">Selesai</span></td>
                                @endif
                                @if($f_ambildata -> $ambilkolom[2] < $f_ambildata -> $ambilkolom[3]) 
                                    @if($f_ambildata -> $ambilkolom[2]=="0") 
                                    <td><span class="btn btn-default">Belum terisi</span></td>
                                    @endif
                                    @if($f_ambildata -> $ambilkolom[2]!="0")
                                    <td><span class="btn palette-Orange bg">Kurang</span></td>
                                    @endif
                                @endif
                                @if($f_ambildata -> $ambilkolom[2] > $f_ambildata -> $ambilkolom[3]) 
                                <td><span class="btn btn-danger">Melebihi</span></td>
                                @endif
                                <?php for($i=6;$i<$count;$i++) { ?> 
                                <td>{{ $f_ambildata -> $ambilkolom[$i] }}</td>
                                <?php } ?>
                            @endif
                            @if($count==9) <!-- Jika Cakupan Wilayah = Desa -->
                                <?php for($i=0;$i<7;$i++) { ?> 
                                <td>{{ $f_ambildata -> $ambilkolom[$i] }}</td>
                                <?php } ?>
                                @if($f_ambildata -> $ambilkolom[3] == $f_ambildata -> $ambilkolom[4]) 
                                <td><span class="btn btn-success">Selesai</span></td>
                                @endif
                                @if($f_ambildata -> $ambilkolom[3] < $f_ambildata -> $ambilkolom[4]) 
                                    @if($f_ambildata -> $ambilkolom[3]=="0") 
                                    <td><span class="btn btn-default">Belum terisi</span></td>
                                    @endif
                                    @if($f_ambildata -> $ambilkolom[3]!="0")
                                    <td><span class="btn palette-Orange bg">Kurang</span></td>
                                    @endif
                                @endif
                                @if($f_ambildata -> $ambilkolom[3] > $f_ambildata -> $ambilkolom[4]) 
                                <td><span class="btn btn-danger">Melebihi</span></td>
                                @endif
                                <?php for($i=7;$i<$count;$i++) { ?> 
                                <td>{{ $f_ambildata -> $ambilkolom[$i] }}</td>
                                <?php } ?>                                    
                            @endif
                            </tr>
                        @endforeach    
                    </tbody>  
                </table>
            </div>
          </div>
      </div>   
  </div>  
</section>

@endsection

@section('js')
  <!-- Javascript Libraries -->
  <script src="{{ asset('assets/js/jquery.chained.min.js') }}"></script>
  <!--<script src="{{ asset('assets/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/bower_components/Waves/dist/waves.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/bootstrap-growl/bootstrap-growl.min.js') }}"></script> -->
  <script src="{{ asset('assets/vendors/bootgrid/jquery.bootgrid.js') }}"></script>
  <!-- Datatables -->
  <script src="{{ asset('assets/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
  <!-- <script src="{{ asset('assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script> -->
  <script src="{{ asset('assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
  <script src="{{ asset('assets/vendors/datatables.net-scroller/js/datatables.scroller.min.js') }}"></script>
  <!-- <script src="{{ asset('assets/vendors/bower_components/moment/min/moment.min.js') }}"></script> -->
  <script src="{{ asset('assets/vendors/bower_components/salvattore/dist/salvattore.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery-confirm.js') }}"></script>        
  <script type="text/javascript">
    $("#Kabkot").chained("#Provinsi");
  </script>
  <!-- Datatables -->
  <script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        var table = $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        TableManageButtons.init();
      });
  </script>
  <!-- /Datatables -->
  <script>
  $(document).ready(function(){
    $('.dropdown-submenu a.test').on("click", function(e){
      $(this).next('ul').toggle();
      e.stopPropagation();
      e.preventDefault();
    });
  });
  </script>
  <script type="text/javascript">
      $('.example2-1').on('click', function () {
        $.alert({
            animation: 'rotateYR',
            closeAnimation: 'rotateYR',
            theme: 'white',
            icon: 'fa fa-spinner fa-spin',
            title: '<font color="black">Ops, maaf :(</font>',
            content: '<font color="black">Batas deadline sudah lewat</font>'
        });
      });
  </script>
  <script>
    // Select your input element.
    var number = document.getElementById('number');

    // Listen for input event on numInput.
    number.onkeydown = function(e) {
        if(!((e.keyCode > 95 && e.keyCode < 106)
          || (e.keyCode > 47 && e.keyCode < 58) 
          || e.keyCode == 8)) {
            return false;
        }
    }
  </script>
@endsection