<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Badan Pusat Statistika | @yield('title')</title>

        <!-- Vendor CSS --> 
        <link href="{{ asset('assets/vendors/bower_components/animate.css/animate.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/bower_components/google-material-color/dist/palette.css') }}" rel="stylesheet">

        <link href="{{ asset('assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/bower_components/nouislider/distribute/jquery.nouislider.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/farbtastic/farbtastic.css') }}" rel="stylesheet') }}">
        <link href="{{ asset('assets/vendors/bower_components/chosen/chosen.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/summernote/dist/summernote.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/sweetalert-master/dist/sweetalert.css')}}">
        @yield('css')

        <!-- CSS -->
        <link href="{{ asset('assets/css/app.min.1.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/app.min.2.css') }}" rel="stylesheet">
    </head> 
    @if(session::get('username'))
    <input type="hidden" id="name" value="{{ $user->name }}">
    @endif
    <body data-ma-header="teal">
        <header id="header" class="media">
            <div class="pull-left h-logo">
                <a href="{{ url('/') }}" class="hidden-xs">
                    Monitor Survey
                    <small>Hi, {{ $user->name }}</small>
                </a>
                <div class="menu-collapse" data-ma-action="sidebar-open" data-ma-target="main-menu">
                    <div class="mc-wrap">
                        <div class="mcw-line top palette-White bg"></div>
                        <div class="mcw-line center palette-White bg"></div>
                        <div class="mcw-line bottom palette-White bg"></div>
                    </div>
                </div>
            </div>

            <ul class="pull-right h-menu">
                <li class="hm-search-trigger">
                    <a href="" data-ma-action="search-open">
                        <i class="hm-icon zmdi zmdi-search"></i>
                    </a>
                </li>
                
                <li class="dropdown hidden-xs hidden-sm h-apps">
                    <a data-toggle="dropdown" href="">
                        <i class="hm-icon zmdi zmdi-apps"></i>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <?php
                            $survey = DB::table('survey') -> get();
                            $i=0;
                        ?>
                        @foreach($survey as $f_survey)
                        <li>
                            <a href="">
                            <?php
                                $a=array("Red","Green","Blue","yellow","brown");
                                $color=$a[$i];
                                $i++; 
                                $palette = "palette-".$color."-400 bg zmdi zmdi-folder-outline";
                            ?>
                            <a href="{{ url('survey/'.$f_survey->id_survey) }}"> <i class="{{ $palette }}"></i><small>{{ $f_survey -> id_survey}}</small></a>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                <li class="dropdown hidden-xs">
                    <a data-toggle="dropdown" href=""><i class="hm-icon zmdi zmdi-more-vert"></i></a>
                    <ul class="dropdown-menu dm-icon pull-right">
                        @foreach ($survey as $f_survey) 
                            <li class="hidden-xs">
                                <?php
                                    $hakakses = DB::table($f_survey->id_survey.'-hakakses') -> where('id_users', $user->username) -> get();
                                ?>
                                @foreach ($hakakses as $f_hakakses)
                                    <a href="{{url($f_survey->id_survey)}}">
                                        {{ $f_survey->id_survey }} -> {{ $f_hakakses->hakakses }}
                                    </a>
                                @endforeach
                                <?php
                                    if($user->level_user == 1){ ?>
                                        <a href="{{url($f_survey->id_survey)}}">
                                            {{ $f_survey->id_survey }} -> Superadmin
                                        </a>
                                <?php } ?>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="dropdown hm-profile">
                    <a data-toggle="dropdown" href="">
                        <img src="{{ asset('assets/img/profile-pics/1.jpg') }}" alt="">
                    </a>
                    
                    <ul class="dropdown-menu pull-right dm-icon">
                        <li>
                            <a href="{{ url('profile/'.$user -> username) }}"><i class="zmdi zmdi-time-restore"></i> Profile</a>
                        </li>
                        <li>
                            <a href="{{ url('/logout/'.$user -> id_user) }}"><i class="zmdi zmdi-time-restore"></i> Keluar</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </header>
        <section id="main">
            @yield('leftNavbar')
            @yield('content')
            <footer id="footer">
                Copyright &copy; 2015 Badan Pusat Statistik

                <ul class="f-menu">
                    <li><a href="">Beranda</a></li>
                    <li><a href="">Survey</a></li>
                    <li><a href="">Laporan</a></li>
                    <li><a href="">Data</a></li>
                    <li><a href="">Pengguna</a></li>
                </ul>
            </footer>
        </section>
        <!-- Page Loader -->
        <div class="page-loader palette-Teal bg">
            <div class="preloader pl-xl pls-white">
                <svg class="pl-circular" viewBox="25 25 50 50">
                    <circle class="plc-path" cx="50" cy="50" r="20"/>
                </svg>
            </div>
        </div>
    
        <!-- Javascript Libraries -->
        <script src="{{ asset('assets/vendors/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        
        <script src="{{ asset('assets/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/Waves/dist/waves.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bootstrap-growl/bootstrap-growl.min.js') }}"></script>

        <script src="{{ asset('assets/vendors/bower_components/moment/min/moment.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/nouislider/distribute/jquery.nouislider.all.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/typeahead.js/dist/typeahead.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/summernote/dist/summernote-updated.min.js') }}"></script>
        
        <script src="{{ asset('assets/vendors/bower_components/chosen/chosen.jquery.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/fileinput/fileinput.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/input-mask/input-mask.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/farbtastic/farbtastic.min.js') }}"></script>
        
        <script src="{{ asset('assets/js/functions.js') }}"></script>
        <script src="{{ asset('assets/js/actions.js') }}"></script>
        <script src="{{ asset('assets/js/demo.js') }}"></script>
        <script src="{{ asset('assets/vendors/sweetalert-master/dist/sweetalert.min.js')}}"></script>
        @include('sweet::alert')
        @yield('js')
    </body>
  </html>