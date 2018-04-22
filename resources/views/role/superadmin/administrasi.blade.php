@extends('layouts.master')
    @section('title')
        Administrasi | Superadmin
    @endsection
    
    @section('css')
        <link href="{{ asset('assets/css/jquery-confirm.css') }}" rel="stylesheet"> 
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link href="{{ asset('assets/vendors/bower_components/animate.css/animate.min.css') }}" rel="stylesheet">
        <!--link href="{{ asset('assets/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/bower_components/google-material-color/dist/palette.css') }}" rel="stylesheet"> -->

 
        <link href="{{ asset('assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/bower_components/nouislider/distribute/jquery.nouislider.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
        <!--<link href="{{ asset('assets/vendors/farbtastic/farbtastic.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/bower_components/chosen/chosen.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/summernote/dist/summernote.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/vendors/bootgrid/jquery.bootgrid.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/vendors/bower_components/google-material-color/dist/palette.css') }}" rel="stylesheet"> -->
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
                        <a href="{{ url('/home') }}"><i class="zmdi zmdi-home"></i> Home</a>
                    </li>

                    <li class="sub-menu">
                        <a  href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-format-underlined"></i> Monitoring & Survey</a>
                        <ul>
                            <li>
                                <a href="{{ url('/createsurvey') }}"> Create new</a>
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
                        <a href="{{ url($survey2->id_survey.'/administrasi') }}"><i class="zmdi zmdi-swap-alt"></i> Administration {{ $survey2->id_survey }}</a>
                    </li>
                    @if($user -> level_user == "1")
                    <li>
                        <a href="{{ url('user') }}" ><i class="zmdi zmdi-home"></i> Users</a>
                    </li>
                    @endif
                    <li class="sub-menu">
                        <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-trending-up"></i> History</a>
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
                    <li>Administrasi</li>
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
                              @foreach ($survey as $f_survey)
                              <li class="dropdown-submenu">
                                <a tabindex="-1" href="{{ url($f_survey -> id_survey.'/administrasi') }}">{{ $f_survey -> nama_survey }} ( {{$f_survey -> id_survey}} )</a>
                              </li>
                              <li class="divider"></li>
                              @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
                  date_default_timezone_set("Asia/Jakarta"); 
                  $now = date('Y-m-d'); //Returns IST  
                  $tglskrg = date_create($now);
                  $tgldeadline = date_create($survey2->tgl_selesai);
                  $interval = date_diff($tgldeadline, $tglskrg); 
                ?>
                <!-- Form 1 -->
                <div class="card">
                    <div class="card-header cw-header palette-Blue-400 bg">
                        <h2><font color="white">Tabel Daftar Pengguna {{$id_survey}}</font></h2>
                        @if($level=="Admin" || Session::get('username')=="alvian" || Session::get('username')=="aneksa")
                            @if ($interval->format('%a') > 0)
                              @if ( $interval->format('%R') == "+" )
                                <a class="example2-1 btn palette-Red bg btn-float waves-effect waves-circle waves-float"><i class="zmdi zmdi-plus"></i></a>
                              @elseif ( $interval->format('%R') == "-" )
                                <a  data-toggle="modal" href="#TambahHakAkses" class="btn palette-Red bg btn-float waves-effect waves-circle waves-float"><i class="zmdi zmdi-plus"></i></a>
                              @endif
                            @else ($interval->format('%a') == 0)
                               <a  data-toggle="modal" href="#TambahHakAkses" class="btn palette-Red bg btn-float waves-effect waves-circle waves-float"><i class="zmdi zmdi-plus"></i></a>
                            @endif     
                        @endif
                    </div>
                    <br>
                    <br>
                    <div class="card-body card-padding">
                                        <div class="form-group">
                                            <div class="col-md-2"></div>
                                            <label class="control-label col-md-2">Username</label>
                                            <div class="col-md-4">                                                
                                                <input id="quick-search" class="form-control"/>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>   
                        <!--@foreach($username as $f_username)
                            <input type="hidden" value="{{ $f_username -> username }}">
                        @endforeach
                        <?php
                            $countusername= count($username);
                        ?> -->
                        <table id="data-table" class="table table-striped table-vmiddle">
                            <thead>
                                <tr>
                                    <th data-column-id="id" data-type="numeric" data-order="asc">No</th>
                                    <th data-column-id="received">NIP</th>
                                    <th data-column-id="sender">Name</th>
                                    <th data-column-id="sender">Hak Akses</th>
                                    @if($level=="Admin" || Session::get('username')=="alvian" || Session::get('username')=="aneksa")
                                    <th>Action</th>
                                    @endif
                                    
                                </tr>
                            </thead>
                            <tbody>                         
                                @foreach($daftarHakAkses as $hakakses) 
                                
                                <?php
                                
                                $user = DB::table('users')
                                    ->where('username', $hakakses->id_users)
                                    ->first();
                                $no=1;
                                ?>       
                                
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $user -> nip_user }}</td>
                                    <td>{{ $user -> name }}</td>
                                    <td>{{ $hakakses -> hakakses }}</td>
                                    @if($level=="Admin" || Session::get('username')=="alvian" || Session::get('username')=="aneksa")
                                    <td>
                                        <a href="{{ url($id_survey.'/administrasi/'.$user->username.'/edit') }}" type="button" class="btn palette-Indigo bg">Edit</a>
                                        <!-- <a  onclick="openmodaledit('<?php echo $user->id_user  ?>','<?php echo $user->name  ?>','<?php echo $user->username  ?>','<?php echo $user->nip_user ?>','<?php echo $hakakses->hakakses ?>')"  class="btn palette-Indigo bg">Edit</a> -->
                                        
                                        <a href="{{ url($id_survey.'/administrasi/'.$user->username.'/delete' ) }}" type="button" class="btn palette-Red bg">Delete</a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>       
            </div>

            @if($level=="Admin" || Session::get('username')=="alvian" || Session::get('username')=="aneksa")
            <!-- Tambah Modal -->
            <div class="modal fade" id="TambahHakAkses" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Tambah Hak Akses</h4>
                    </div>
                    <form action="{{url($id_survey.'/administrasi/tambah')}}" method="post" name="formtambahtahapan">
                    {!! csrf_field() !!}
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="control-label" for="{{$wilayah->nama_wilayah}}">{{$wilayah->nama_wilayah}} </label>
                                <select class="selectpicker" multiple data-live-search="true" name="wilayah[]">
                                    <?php
                                    $data_wilayah = DB::table($id_survey.'-'.$wilayah->nama_wilayah)->get();
                                    $header_data_wilayah = Schema::getColumnListing($id_survey.'-'.$wilayah->nama_wilayah);
                                    $count = count($header_data_wilayah);
                                    ?>
                                    @foreach($data_wilayah as $f_data_wilayah)
                                        <option value="{{$f_data_wilayah->$header_data_wilayah[0]}}">{{ $f_data_wilayah->$header_data_wilayah[$count-1] }}</option> 
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="nip">Username</label>
                                <select class="selectpicker" name="username">
                                    @foreach($username as $f_username)
                                        <?php 
                                            $daftar_hakakses = DB::table($id_survey.'-hakakses')->where('id_users', $f_username->username)->first();
                                            if(!$daftar_hakakses){
                                        ?>
                                            <option value="{{ $f_username -> username }}">{{ $f_username -> username }}</option>
                                        <?php } ?>
                                    @endforeach
                                </select>
                            </div>              
                            <div class="form-group">
                                <label class="control-label" for="hakakses">Hak Akses</label>
                                <select class="selectpicker" data-live-search="true" name="hakakses">
                                    <option value="Admin">Admin</option>
                                    <option value="Supervisor">Supervisor</option>
                                    <option value="Operator">Operator</option>
                                </select>                
                                           
                            </div>
                                    
                            <br><br>
                        </div>
                             
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-default pull-rigth">Batal</button>
                            <button type="submit" class="btn btn-success pull-rigth">Tambahkan</button>
                        </div>
                    </form>
                  </div>
                </div> 
            </div>
            @endif

            <!--Edit Modal -->
            <div class="modal fade" id="editmodal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"     aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Tambah Hak Akses</h4>
                    </div>
                    <input type="hidden" id="id">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label" for="">Nama</label>
                            <input type="text" name="name" id="nama" class="form-control" placeholder="Full Name">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="nip">Username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                        </div>  
                        <div class="form-group">
                            <label class="control-label" for="nip">NIP</label>
                            <input type="text" name="nip" id="nip" class="form-control" placeholder="Username">
                        </div>              
                        <div class="form-group">
                            <label class="control-label" for="hakakses">Hak Akses</label>
                            <select class="selectpicker" data-live-search="true" id="level" name="level">
                                <option value="Admin">Admin</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Operator">Operator</option>
                            </select>                 
                        </div>   
                        <br><br>
                    </div>
                         
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default pull-rigth">Batal</button>
                        <button onclick="edituser()" class="btn btn-success pull-rigth">Tambahkan</button>
                    </div>
                  </div>
                </div>
            </div>

        </div>
  </section>
@endsection

@section('js')
    <script src="{{ asset('assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js') }}"></script>
<!--         <script src="{{ asset('assets/vendors/bower_components/nouislider/distribute/jquery.nouislider.all.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/bower_components/typeahead.js/dist/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/summernote/dist/summernote-updated.min.js') }}"></script> -->
<!-- 
    <script src="{{ asset('assets/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js') }}"></script> --> -->
    <script src="{{ asset('assets/vendors/bower_components/autosize/dist/autosize.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/bower_components/salvattore/dist/salvattore.min.js') }}"></script>

    <!-- <script src="{{ asset('assets/vendors/input-mask/input-mask.min.js') }}"></script> -->
    <script src="{{ asset('assets/vendors/bower_components/chosen/chosen.jquery.min.js') }}"></script>
    <!-- <script src="{{ asset('assets/vendors/farbtastic/farbtastic.min.js') }}"></script> -->
    <script src="{{ asset('assets/vendors/fileinput/fileinput.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootgrid/jquery.bootgrid.updated.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/jqueryui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/jqueryui/icheck.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-confirm.js') }}"></script>

    <script>
    $(function() {

        var data_1 = [
            "aneksa",
            "alvian",
            "dyetra",
            "eka",
            "hengky",
            "kamal",
            "supriadi"
        ];

        $("#quick-search").autocomplete({
            source: data_1,
            open: function(event, ui) {
                
                var autocomplete = $(".ui-autocomplete:visible");
                var oldTop = autocomplete.offset().top;
                var newTop = oldTop - $("#quick-search").height() + 25;
                autocomplete.css("top", newTop);
                
            }
        });
        
    });            
    </script>
    

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
    <script type="text/javascript">
      function openmodaledit(id,nama,username,nip,hakakses){
          $('#id').val(id);
          $('#nama').val(nama);
          $('#username').val(username);
          $('#nip').val(nip);
          $('#hakakses').val(hakakses);
          $('#editmodal').modal(); 
      }
    </script>
    <script type="text/javascript">
        $('.example2-1').on('click', function () {
          $.alert({
              animation: 'rotateYR',
              closeAnimation: 'rotateYR',
              theme: 'white',
              icon: 'fa fa-spinner fa-spin',
              title: 'Ops, maaf :(',
              content: 'Batas deadline sudah lewat'
          });
        });
    </script>
@endsection