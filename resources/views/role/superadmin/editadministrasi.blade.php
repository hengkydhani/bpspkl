@extends('layouts.master')
    @section('title')
        Administrasi | Superadmin
    @endsection
    
    @section('css')
        <link href="{{ asset('assets/vendors/bower_components/animate.css/animate.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/bower_components/google-material-color/dist/palette.css') }}" rel="stylesheet">


        <link href="{{ asset('assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/bower_components/nouislider/distribute/jquery.nouislider.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/farbtastic/farbtastic.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/bower_components/chosen/chosen.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/summernote/dist/summernote.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/vendors/bootgrid/jquery.bootgrid.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/vendors/bower_components/google-material-color/dist/palette.css') }}" rel="stylesheet">

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
                        <a  href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-format-underlined"></i>Input Data {{ $id_survey }}</a>
                        <ul>
                                @foreach($tahapan_survey as $f_tahapan_survey)
                                <li>
                                    <?php
                                        $survei2 = DB::table('tahapansurvey') -> where('id_survey', $id_survey)-> where('id_tahapan', $f_tahapan_survey->id_tahapan) -> first();
                                    ?>
                                    <a href="{{ url($id_survey.'/'.$f_tahapan_survey->id_tahapan.'/input') }}">{{ $f_tahapan_survey->nama_tahapan }}</a>
                                </li>
                                @endforeach
                        </ul>
                    </li>
                    <li @yield('administration')>
                        <a href="{{ url($id_survey.'/administrasi') }}"><i class="zmdi zmdi-swap-alt"></i> Administrasi {{ $id_survey }}</a>
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
                    <li><a href="{{ url('home') }}">Home</a></li>
                    <li><a href="{{ url($id_survey) }}">{{ $id_survey }}</a></li>
                    <li><a href="{{ url($id_survey.'/administrasi') }}">Administrasi</a></li>
                    <li>Edit</li>
                </ol>
                
                <div class="card">
                    <div class="card-header">
                        <h2>Remember :<small>
                        1. Define your survey's name <br>
                        2. Assign a number of phase <br>
                        3. Determine an admin of survey Extend form controls by adding text or buttons before, after, or on both sides of any text-based inputs.</small></h2>
                        <br>
                        <div class="dropdown">
                            <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-primary" data-target="#" href="/page.html">
                                Survey <span class="caret"></span> 
                            </a>
                            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                              <li class="dropdown-submenu">
                                <a tabindex="-1" href="#">Survey 1</a>
                              </li>
                              <li class="divider"></li>
                              <li class="dropdown-submenu">
                                <a tabindex="-1" href="#">Survey 2</a>
                              </li>
                              <li class="divider"></li>
                              <li class="dropdown-submenu">
                                <a tabindex="-1" href="#">Survey 3</a>
                              </li>
                              <li class="divider"></li>
                              <li class="dropdown-submenu">
                                <a tabindex="-1" href="#">Survey 4</a>
                              </li>
                              <li class="divider"></li>
                              <li class="dropdown-submenu">
                                <a tabindex="-1" href="#">Survey 5</a>
                              </li>
                              <li class="divider"></li>
                              <li class="dropdown-submenu">
                                <a tabindex="-1" href="#">Survey 6</a>
                              </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Form 1 -->
                    <div class="card">
                        <div class="card-header cw-header palette-Blue-400 bg">
                            <h2><font color="white">Edit Pengguna</font></h2>
                        </div>
                        <br>
                        <br>
                        
                        <div class="card-body card-padding">
                        <form action="{{url($id_survey.'/administrasi/'.$user_hakakses.'/edit')}}" method="post" name="formedittahapan">
                        {!! csrf_field() !!}
                        <?php 
                            $get_hakakses = DB::table($id_survey.'-hakakses')->where('id_users', $user_hakakses)->first();
                        ?>
                            <div class="form-group">
                                <label class="control-label" for="{{$wilayah->nama_wilayah}}">{{$wilayah->nama_wilayah}} </label>
                                <select class="selectpicker" multiple data-live-search="true" name="wilayah[]">
                                    <?php
                                    $data_wilayah = DB::table($id_survey.'-'.$wilayah->nama_wilayah)->get();
                                    $header_data_wilayah = Schema::getColumnListing($id_survey.'-'.$wilayah->nama_wilayah);
                                    $count = count($header_data_wilayah);
                                    ?>
                                    @foreach($data_wilayah as $f_data_wilayah)
                                        <?php 
                                            $cek_hakakses_wil = DB::table($id_survey.'-hakakses-wilayah')->where('id_users', $user_hakakses)->where('id_'.$wilayah->nama_wilayah, $f_data_wilayah->$header_data_wilayah[0])->first();
                                        ?>
                                        <option value="{{$f_data_wilayah->$header_data_wilayah[0]}}" <?php if($cek_hakakses_wil) echo "selected"; ?> >{{ $f_data_wilayah->$header_data_wilayah[$count-1] }}</option> 
                                    @endforeach
                                </select>
                            </div>

                            <?php $nip = DB::table('users')->where('username', $get_hakakses->id_users)->first(); ?>
                            <input type="text" id="nip" name="nip" required="required" class="hidden" value="{{$nip->nip_user}}">
                                        
                            <div class="form-group">
                                <label class="control-label" for="hakakses">Hak Akses</label>                
                                <select class="selectpicker" data-live-search="true" name="hakakses">
                                    <option value="Admin" <?php if($get_hakakses->hakakses=='Admin') echo 'selected' ?> >Admin</option>
                                    <option value="Supervisor" <?php if($get_hakakses->hakakses=='Supervisor') echo 'selected' ?> >Supervisor</option>
                                    <option value="Operator" <?php if($get_hakakses->hakakses=='Operator') echo 'selected' ?> >Operator</option>
                                </select>                                           
                            </div> 
                            <br><br>
                            <button data-dismiss="modal" class="btn btn-default pull-rigth">Batal</button>
                            <button type="submit" class="btn btn-success pull-rigth">Simpan</button>
                            </form>
                        </div>  
                    </div>       
            </div>
                        
        </section>



@endsection

@section('js')
        <script src="{{ asset('assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/nouislider/distribute/jquery.nouislider.all.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/typeahead.js/dist/typeahead.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/summernote/dist/summernote-updated.min.js') }}"></script>

        <script src="{{ asset('assets/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/autosize/dist/autosize.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/salvattore/dist/salvattore.min.js') }}"></script>

        <script src="{{ asset('assets/vendors/input-mask/input-mask.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/chosen/chosen.jquery.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/farbtastic/farbtastic.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/fileinput/fileinput.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bootgrid/jquery.bootgrid.updated.min.js') }}"></script>

        <!-- Data Table -->
        <script type="text/javascript">
            $(document).ready(function(){
                //Basic Example
                $("#data-table-basic").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                });
                
                //Selection
                $("#data-table-selection").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                    selection: true,
                    multiSelect: true,
                    rowSelect: true,
                    keepSelection: true
                });
                
                //Command Buttons
                $("#data-table-command").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                    formatters: {
                        "commands": function(column, row) {
                            return "<button type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></button> " + 
                            "<button type=\"button\" class=\"btn btn-icon command-delete waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-delete\"></span></button>";
                        }
                    }
                });
            });
        </script>
        <script>
        $(document).ready(function(){
          $('.dropdown-submenu a.test').on("click", function(e){
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
          });
        });
        </script>

        <script>
            function editmodal(no, nip, name, hakakses ) {
                $('#e_nip_user').val(nip);
                $('#e_name').val(name);
                $('#e_hakakses').val(hakakses);
                $('#editmodal').modal();
            }

        </script>

@endsection