@extends('layouts.master')
    @section('title')
        Dashboard
    @endsection
    
    @section('css')
        <link href="{{ asset('assets/vendors/bower_components/fullcalendar/dist/fullcalendar.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/circle.css') }}" rel="stylesheet">
        <style type="text/css">

            body{
                background-color: #f5f5f5;
                margin: 0;
                padding: 0;
                font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
            }

            .page {
                margin: 40px;
            }

            h1{
                margin: 40px 0 60px 0;
            }

            .dark-area {
                background-color: #666;
                padding: 40px;
                margin: 0 -40px 20px -40px;
                clear: both;
            }

            .clearfix:before,.clearfix:after {content: " "; display: table;}
            .clearfix:after {clear: both;}
            .clearfix {*zoom: 1;}
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

    <?php
      date_default_timezone_set("Asia/Jakarta"); 
      $now = date('Y-m-d'); //Returns IST  
      $tglskrg = date_create($now);
      $tgldeadline = date_create($survey2->tgl_selesai);
      $interval = date_diff($tgldeadline, $tglskrg); 
    ?>

    <section id="content">
                <div class="container">                    
                    <ol class="breadcrumb" style="margin-bottom: 5px;">
                      <li><a href="{{URL('/')}}">Beranda</a></li>
                      <li>{{$id_survey}}</li>
                    </ol>
                    <div class="card">
                       <div class="card-header">
                        @if ($interval->format('%a') > 0)
                            @if ( $interval->format('%R') == "+" )
                                <h2><font color="red">Ditutup!</font><h3>Monitoring {{$survey2->nama_survey}}</h3></h2>
                            @elseif ( $interval->format('%R') == "-" )
                                <h2>"tersisa {{ $interval->format('%a') }} hari lagi"<h3>Monitoring {{$survey2->nama_survey}}</h3></h2>
                            @endif 
                        @else ($interval->format('%a') == 0)
                                <h2>Dashboard <h3>Monitoring {{$survey2->nama_survey}}, <font color="red">Deadline!</font></h3></h2>
                        @endif
                        <ul class="actions">
                            <a href="{{url($id_survey.'/edit')}}" class="btn palette-Teal bg">Edit</a>                            
                            <div class="btn-group">
                                <button class="btn palette-Teal bg">Program Tahapan</button>
                                <button type="button" class="btn palette-Teal bg dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Split button dropdowns</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    @foreach($tahapanSurvey2 as $tahapan)
                                        @if($tahapan->id_survey==$survey2->id_survey)
                                            <li><a href="{{url($survey2->id_survey.'/'.$tahapan->id_tahapan)}}">{{$tahapan->nama_tahapan}}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                          </div>
                        </ul>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h2>Indonesia</h2>
                            <br>
                            <?php 
                            $ambiltahapan = DB::table('survey') -> where('id_survey', $id_survey) -> first();
                            ?>
                            <h2>Kondisi sampai tanggal : {{ $ambiltahapan->tgl_selesai }} </h2>
                            <ul class="actions">
                                <a href="{{ url('survey/'.$id_survey.'/create') }}" class="btn palette-Teal bg btn-icon"><i class="zmdi zmdi-plus"></i></a>
                            </ul>    
                        </div>

                        <?php
                          $ambildata = DB::table($id_survey.'-'.$tahapan -> nama_tahapan) -> get();
                          $ambilkolom = Schema::getColumnListing($id_survey.'-'.$tahapan -> nama_tahapan);
                          $count = count($ambilkolom);
                        ?>

                        <?php $i=0;$j=0; ?>
                            @foreach($ambildata as $f_ambildata)
                                @if($count==7) <!-- Jika Cakupan Wilayah = Provinsi -->
                                <?php 
                                    $i+=$f_ambildata -> $ambilkolom[1];
                                    $j+=$f_ambildata -> $ambilkolom[2];
                                ?>
                                @endif

                                @if($count==8) <!-- Jika Cakupan Wilayah = Kabkot -->
                                <?php 
                                    $i+=$f_ambildata -> $ambilkolom[2];
                                    $j+=$f_ambildata -> $ambilkolom[3];
                                ?>
                                @endif
                                
                                @if($count==9) <!-- Jika Cakupan Wilayah = Desa -->
                                <?php 
                                    $i+=$f_ambildata -> $ambilkolom[3];
                                    $j+=$f_ambildata -> $ambilkolom[4];
                                ?>
                                @endif
                            @endforeach
                        
                        <div class="card-body card-padding">
                            <div class="pm-body clearfix">
                            @foreach($tahapanSurvey2 as $tahapan)
                                <div class="col-xs-3">
                                    <p>{{$tahapan->nama_tahapan}}</p>
                                    <div class="c100 p{{round(($i/$j)*100)}}">
                                        <span>{{ round(($i/$j)*100) }}% </span>
                                        <div class="slice">
                                            <div class="bar"></div>
                                            <div class="fill"></div>
                                        </div>
                                    </div>
                                </div>
                             @endforeach
                             </div>
                        </div>
                    </div>
                    <?php
                        date_default_timezone_set("Asia/Jakarta"); 
                        $now = date('Y-m-d'); //Returns IST  
                    ?>
                    <div class="card">
                        <div class="card-header">
                          <h2>Batas Akhir</h2>
                          <br>
                          <h2>Tiap - tiap tahapan </h2>
                        </div> 
                        <div class="card-body card-padding">
                          <div class="pm-body clearfix">
                            @foreach($tahapanSurvey2 as $tahapan)
                            <div class="col-xs-3">
                                <p>{{$tahapan->nama_tahapan}}</p>
                                <img src="{{ asset('assets/img/clock.png') }}" width="100" height="100" alt="">
                                <?php
                                    $tglskrg = date_create($now);
                                    $tgldeadline = date_create($tahapan->tgl_selesai);
                                    $interval = date_diff($tgldeadline, $tglskrg);
                                ?>
                                @if ($interval->format('%a') > 0)
                                    @if ( $interval->format('%R') == "+" )
                                        <h3><p><font color="red">Ditutup!</font></p></h3>
                                    @elseif ( $interval->format('%R') == "-" )
                                        <h3><p><font color="blue">Ongoing</font></p></h3>    
                                    @endif  
                                @else ($interval->format('%a') == 0)
                                    <h3><p><font color="orange">Deadline!</font></p></h3>
                                @endif
                                <p>Sekarang : {{ $now }}</p>
                                <p>Selesai : {{$tahapan->tgl_selesai}}</p>
                            </div>
                            @endforeach
                          </div>
                        </div>
                    </div>

                </div>
            </section>
@endsection

@section('js')
        <!-- Javascript Libraries -->
        <!-- <script src="{{ asset('assets/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js') }}"></script> -->
        <script src="{{ asset('assets/vendors/bower_components/salvattore/dist/salvattore.min.js') }}"></script>
        <!--<script src="{{ asset('assets/vendors/bower_components/flot/jquery.flot.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/flot/jquery.flot.resize.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/flot/jquery.flot.pie.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/flot-orderBars/js/jquery.flot.orderBars.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/flot.curvedlines/curvedLines.js') }}"></script>                         
        <script src="{{ asset('assets/vendors/bower_components/flot-orderBars/js/jquery.flot.orderBars.js') }}"></script> -->

        <!-- Charts - Please read the read-me.txt inside the js folder-->
        <!--<script src="{{ asset('assets/js/flot-charts/curved-line-chart.js') }}"></script>
        <script src="{{ asset('assets/js/flot-charts/line-chart.js') }}"></script>
        <script src="{{ asset('assets/js/flot-charts/bar-chart.js') }}"></script>
        <script src="{{ asset('assets/js/flot-charts/dynamic-chart.js') }}"></script>
        <script src="{{ asset('assets/js/flot-charts/pie-chart.js') }}"></script> -->
        
@endsection