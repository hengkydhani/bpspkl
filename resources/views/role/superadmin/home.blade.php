@extends('layouts.master')
@section('title')
    Dashboard
@endsection

@section('css')
<link href="{{ asset('assets/vendors/bower_components/animate.css/animate.min.css') }}" rel="stylesheet"><!-- 
        <link href="{{ asset('assets/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/bower_components/google-material-color/dist/palette.css') }}" rel="stylesheet"> -->
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
                    <a href="{{ url('home') }}"><i class="zmdi zmdi-home"></i> Beranda</a>
                </li>

                <li class="sub-menu">
                    <a  href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-format-underlined"></i> Monitoring Survey</a>
                    <ul>
                        <li>
                            <a href="{{ url('create') }}"> Buat Baru</a>
                        </li>
                        @foreach($survey as $f_survey)
                            <li><a href="{{ url($f_survey->id_survey) }}">{{$f_survey->id_survey}}</a></li>
                        @endforeach
                    </ul>
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
                    </ul>
                </li>
            </ul>
    </aside>
@endsection

@section('content')
    <section id="content">
        <div class="container">
            <ol class="breadcrumb" style="margin-bottom: 5px;">
                <li>Beranda</li>
            </ol>
            <div class="card">
                <div class="card-header">
                    @if (session()->has('flash_notif.message'))
                    <div class="container">
                        <div class="alert alert-{{ session()->get('flash_notif.level') }}">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!! session()->get('flash_notif.message') !!}
                        </div>
                    </div>
                    @endif

                    <h2>Badan Pusat Statistik<h3>Sistem Monitoring Data & Informasi Survey</h3></h2>

                    <ul class="actions">
                        <li>
                            <a href="">
                                <i class="zmdi zmdi-check-all"></i>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="zmdi zmdi-trending-up"></i>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="" data-toggle="dropdown">
                                <i class="zmdi zmdi-more-vert"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="chart-edge">
                        <div id="curved-line-chart" class="flot-chart "></div>
                    </div>
                </div>
            </div>

            <div id="c-grid" class="clearfix" data-columns>
                <div class="card">
                    <div class="card-header ch-img" style="background-image: url({{ asset('assets/img/home1.jpg') }}); height: 250px;"></div>
                    <div class="card-header">
                        <h2>
                            Monitoring Data & Informasi Survey
                        </h2>
                    </div>
                    <div class="card-body card-padding">
                        <p>Sistem monitoring bertujuan memudahkan pemantau baik di pusat maupun di daerah untuk melihat keseluruhan hasil monitoring. Kegiatan yang harus dilaporkan adalah Monitoring Pelaksanaan Pendataan. Monitoring Kualitas dan Monitoring Pengolahan Data. Informasi hasil monitoring dapat dilihat dari seluruh perangkat elektronik.</p>
                        <br>
                        <p>Website (situs) ini bersifat realtime karena setiap pengiriman laporan yang dilakukan oleh petugas akan secara otomatis di update, sehingga seluruh tabulasi dan grafik juga akan mengalami perubahan. Situs ini hanya bisa diakses oleh pengguna @bps.go.id yang telah terdaftar dan tidak dipublikasikan untuk umum. </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2>Aktivitas Pengguna <small>baru-baru ini</small></h2>
                    </div>
                    <div class="list-group lg-alt">
                    <?php
                        $user = DB::table('users') -> where('username', session::get('username')) -> first();
                        foreach ($log as $loguser) {
                            if ($loguser -> waktu_logout == "0000-00-00 00:00:00") {
                                $status = "Online";
                                $tanggal = "Login : ".$loguser ->waktu_login;
                            }
                            else {
                                $status = "Offline"; 
                                $tanggal = "Logout : ".$loguser ->waktu_logout;     
                            }
                        ?>
                            <a href="" class="list-group-item media">
                                <div class="pull-left">
                                    <img class="avatar-img mCS_img_loaded" src="{{ asset('assets/img/users/alvian.jpg') }}" alt="">
                                </div>

                                <div class="media-body">
                                    @if($loguser->id_users == $user->id_user)
                                    <b><div class="lgi-heading">Kamu</div></b>
                                    @else
                                    <div class="lgi-heading">{{$loguser->name}}</div>
                                    @endif
                                    @if ($loguser -> waktu_logout == "0000-00-00 00:00:00") 
                                    <b><font color="blue">{{$status}}</font></b>
                                    @else
                                    <b><font color="red">{{$status}}</font></b>
                                    @endif
                                    <h5><div class="lgi-heading">{{$tanggal}}</div></h5>
                                </div>
                            </a>
                        <?php
                        }
                    ?>
                    </div>
                    {!! $log -> links() !!}
                </div>
            </div>

            <div id="c-grid" class="clearfix" data-columns></div>
        </div>
    </section>
@endsection

@section('js')
        <script src="{{ asset('assets/vendors/bower_components/salvattore/dist/salvattore.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/flot/jquery.flot.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/flot/jquery.flot.resize.js') }}"></script>
        <script src="{{ asset('assets/js/flot-charts/curved-line-chart.js') }}"></script>
        <script>
            $(window).load(function(){
                //Welcome Message (not for login page)
                function notify(message, type){
                    $.growl({
                        message: message
                    },{
                        type: type,
                        allow_dismiss: false,
                        label: 'Cancel',
                        className: 'btn-xs btn-inverse',
                        placement: {
                            from: 'bottom',
                            align: 'right'
                        },
                        delay: 2500,
                        animate: {
                                enter: 'animated fadeInRight',
                                exit: 'animated fadeOutRight'
                        },
                        offset: {
                            x: 30,
                            y: 30
                        }
                    });
                };

                if (!$('.login-content')[0]) {
                    notify('Welcome back ' + $('#name').val(), 'inverse');
                }
            });
        </script>
@endsection