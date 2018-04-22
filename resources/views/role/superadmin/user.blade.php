@extends('layouts.master')
@section('title')
    Dashboard
@endsection

@section('css')
    <link href="{{ asset('assets/vendors/bower_components/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/bootgrid/jquery.bootgrid.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/bower_components/google-material-color/dist/palette.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
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
                    <li><a href="{{ url('home') }}">Beranda</a></li>
                    <li>Administrasi</li>
                </ol>
                    <div class="card">
                        <div class="card-header">
                            <h2>Input Data Pengguna Baru</h2>
                            <p>
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </p>
                        </div>

                        <div class="card-body card-padding">
                            <div class="row">
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
                                        <div class="fg-line">
                                                <input type="text" id="name0" name="name" class="form-control" placeholder="Nama Lengkap" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                                        <div class="fg-line">
                                            <input type="number" id="nip0" name="nip" class="form-control" placeholder="NIP" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">  
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="zmdi zmdi-pin"></i></span>
                                        <div class="fg-line">
                                            <select class="selectpicker" data-live-search="true" id="level0" name="level" required> 
                                                <option value="2">User</option>
                                                <option value="1">Superadmin</option>
                                            </select>
                                        </div>    
                                    </div>  
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-5"></div>
                                <div class="col-sm-6">
                                    <button onclick="adduser()" class="btn btn-primary">Tambah</button>   
                                </div> 
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h2>Daftar Pengguna</h2>
                            <br>
                            @if(Session::has('success_message'))
                                <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="fa fa-info-circle"></i>{{ Session::get('success_message') }}
                                </div>
                            @endif
                        </div>

                        <div class="card-body card-padding">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>NIP</th>
                                            <th>Tindakan</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="tableuser"> 
                                        <?php $no=1; ?>
                                        @foreach($users as $f_users)  
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $f_users -> name }}</td>
                                            <td>{{ $f_users -> username }}</td>
                                            <td>{{ $f_users -> nip_user }}</td>
                                            <td>
                                                <a  onclick="openmodaledit('<?php echo $f_users->id_user  ?>','<?php echo $f_users->name  ?>','<?php echo $f_users->username  ?>','<?php echo $f_users->nip_user ?>')"  class="btn palette-Indigo bg">Ubah</a>
                                                
                                                <a onclick="openmodaldelete('<?php echo $f_users->id_user  ?>','<?php echo $f_users->name  ?>','<?php echo $f_users->username  ?>')" class="btn palette-Red bg">Hapus</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

            <!--Edit Modal -->
            <div class="modal fade" id="editmodal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"     aria-hidden="true"> 
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Ubah Hak Akses</h4>
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
                                <option value="2">User</option>
                                <option value="1">Superadmin</option>
                            </select>                 
                        </div>   
                        <br><br>
                    </div>
                         
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default pull-rigth">Batal</button>
                        <button onclick="edituser()" class="btn btn-success pull-rigth">Ubah</button>
                    </div>
                  </div>
                </div>
            </div>

            <!--Delete Modal -->
            <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" >
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Hapus Hak Akses</h4>
                    </div>
                    <input type="hidden" id="id2">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" name="username" id="username2" class="form-control" placeholder="Username">
                    <div class="modal-body">
                        <h5>Apakah anda ingin menghapus dari database? </h5> 
                        <br><br>
                    </div>
                         
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default pull-rigth">Batal</button>
                        <button onclick="deleteuser()" class="btn btn-success pull-rigth">Hapus</button>
                    </div>
                  </div>
                </div>
            </div>
        <div id="c-grid" class="clearfix" data-columns></div>       
</section>

@endsection

@section('js')
        <!-- Javascript Libraries -->
        <script src="{{ asset('assets/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/Waves/dist/waves.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bootstrap-growl/bootstrap-growl.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/moment/min/moment.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/salvattore/dist/salvattore.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/js/datatables/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/notify/notify.js') }}"></script>
        <script src="{{ asset('assets/js/notify/notify.min.js') }}"></script>
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

        <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
        </script>

        <script type="text/javascript">
          function openmodaledit(id,nama,username,nip){
              $('#id').val(id);
              $('#nama').val(nama);
              $('#username').val(username);
              $('#nip').val(nip);
              $('#editmodal').modal(); 
          }
        </script>

        <script type="text/javascript">
          function openmodaldelete(id2,nama2,username2){
              $('#id2').val(id2);
              $('#nama2').val(nama2);
              $('#username2').val(username2);
              $('#deletemodal').modal(); 
          }
        </script>

        <script>
        function adduser() {
            var name = $('#name0').val();
            $.ajax({
                type: 'POST',
                url: 'user/create',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'name': $('#name0').val(),
                    'nip' : $('#nip0').val(),
                    'level' : $('#level0').val()
                },
                success: function() {
                  $('#tableuser').load('user/tableuser').fadeIn("slow");
                  $.notify("Data "+name+ " berhasil ditambah ke database", "success");
                },
                error: function() {
                  $.notify("Data "+name+ " tidak berhasil ditambah. Silahkan coba kembali", "success");
                }
            });
            $('#name0').val('');
            $('#nip0').val('');
            $('#level0').val('');
        }
        </script>

        <script>
        function edituser() {
            var id = $('#id').val();
            $.ajax({
                type: 'GET',
                url: 'user/edit/' + id,
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': $("#id").val(),
                    'name': $('#nama').val(),
                    'username' : $('#username').val(),
                    'nip' : $('#nip').val(),
                    'level' : $('#level').val()
                },
                success: function() {
                  $('#tableuser').load('user/tableuser').fadeIn("slow");
                  $.notify("Data "+name+ " berhasil diubah ke database", "success");
                },
                error: function() {
                  $.notify("Data "+name+ " tidak berhasil diubah. Silahkan coba kembali", "success");
                }
            });
            $('#editmodal').modal('hide');
        }
        </script>

        <script>
        function deleteuser() {
            var id2 = $('#id2').val();
            var username2 = $('#username2').val();
            $.ajax({
                type: 'GET',
                url: 'user/delete/' + id2,
                success: function() {
                  $('#tableuser').load('user/tableuser').fadeIn("slow");
                  $.notify("Data "+name2+ " berhasil dihapus dari database", "success");
                },
                error: function() {
                  $.notify("Data "+username2+ " tidak berhasil dihapus. Silahkan coba kembali", "success");
                }
            });
            $('#deletemodal').modal('hide');  
        }
        </script>
@endsection