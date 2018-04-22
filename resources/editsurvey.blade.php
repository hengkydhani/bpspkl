@extends('layouts.master')
@section('title')
    Survey Form
@endsection

@section('css')
    <link href="{{ asset('assets/vendors/alela/css/demo.css') }}" rel="stylesheet">
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
                <ul class="breadcrumb" style="margin-bottom: 5px;">
                  <li><a href="{{URL('/')}}">Home</a></li>
                  <li><a href="{{URL('survey/'.$id_survey)}}">{{$id_survey}}</a></li>
                  <li class="active">Edit</li>
                </ul>
                <div class="card">
                    <div class="card-body card-padding">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>{{$this_survey->nama_survey}}<small>Edit</small></h2>        
                                <div class="clearfix"></div>
                                <p>Pastikan field yang ada terisi semua dengan benar</p>
                            </div>
                            <br>
                        
                            <div class="x_content">
                                <!-- Smart Wizard -->
                                    <form id="formEditSurvey" class="form-horizontal form-label-left" action="{{url('survey/'.$id_survey.'/edit')}}" method="post" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                        <div id="step-1">
                                            <h4 class="StepTitle">Step 1 Monitoring / Survey</h4>
                                            <br>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="surveyname">Nama Survey </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" id="surveyname" name="surveyname" required="required" class="form-control col-md-7 col-xs-12" value="{{$this_survey->nama_survey}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="surveyidentity">Identitas Survey </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" id="surveyidentity" name="surveyidentity" required="required" class="form-control col-md-7 col-xs-12" value="{{$this_survey->id_survey}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Mulai </label>
                                                <div class="col-md-2 col-sm-6 col-xs-12">
                                                  <input id="tgl_mulai" name="tgl_mulai" class="date-picker form-control col-md-7 col-xs-12" data-date-format="YYYY-MM-DD" required="required" type="text" value="{{$this_survey->tgl_mulai}}" disabled>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Selesai </label>
                                                <div class="col-md-2 col-sm-6 col-xs-12">
                                                  <input id="tgl_selesai" name="tgl_selesai" class="date-picker form-control col-md-7 col-xs-12" data-date-format="YYYY-MM-DD" required="required" type="text" value="{{$this_survey->tgl_selesai}}">
                                                </div>
                                            </div>
                                        </div>
                                        <br>

                                        <div id="step-2">
                                            <h4 class="StepTitle">Step 2 Tahapan</h4>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Tahapan</th>
                                                        <th>Mulai</th>
                                                        <th>Selesai</th>
                                                    </tr>
                                                </thead>
                                                <tbody id=con_edit_tahapan>
                                                    <?php $this_counter=1; ?>
                                                    @foreach($this_tahapan as $f_this_tahapan)
                                                        <tr>
                                                            <td>{{$this_counter++}}</td>
                                                            <td>
                                                                <input type="text" class="form-control input-sm" id="nama_tahapan" name="nama_tahapan[]" value="{{$f_this_tahapan->nama_tahapan}}">
                                                            </td>
                                                            <td>
                                                                <input id="tgl_mulai" name="tahapan_mulai[]" class="date-picker form-control col-md-7 col-xs-12" data-date-format="YYYY-MM-DD" required="required" type="text" value="{{$f_this_tahapan->tgl_mulai}}" disabled>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-12 col-sm-6 col-xs-12">
                                                                    <input id="tgl_selesai" name="tahapan_selesai[]" class="date-picker form-control col-md-7 col-xs-12" data-date-format="YYYY-MM-DD" required="required" type="text" value="{{$f_this_tahapan->tgl_selesai}}">
                                                                </div>
                                                            </td>
                                                            <input type="hidden" name="id_tahapan[]" value="{{$f_this_tahapan->id_tahapan}}">
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>                                 
                                        </div>
                                        <br><br>
                                        <div class="modal-footer">
                                        <a href="{{url('survey/'.$id_survey)}}" class="btn btn-default">Batal</a>
                                        <button type="submit" class="btn palette-Teal bg">Simpan</button>
                                        </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Start Modals -->

                <div class="modal fade" id="modalTambahTahapan" tabindex="-1" role="dialog" >
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title">Tambah Tahapan</h4>
                        </div>
                        <div class="modal-body">
                            <form id="tambahTahapan" method="post" name="tambahTahapan">
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_tahapan">Nama Tahapan </label>
                                <input type="text" id="m_nama_tahapan" name="m_nama_tahapan" required="required" class="form-control">
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Mulai </label>
                                <input id="m_tahapan_mulai" name="m_tahapan_mulai" data-date-format="YYYY-MM-DD" class="date-picker form-control" required="required" type="text">
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Selesai </label>
                                <input id="m_tahapan_selesai" name="m_tahapan_selesai" data-date-format="YYYY-MM-DD" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                              </div>
                              
                              <br><br>
                              <div class="form-group">
                                <input class="pull-right" type="button" name="remove_item" value="remove" id="remove_item">
                                <input class="pull-right" type="button" name="add_btn" value="Add" id="add_btn">
                              </div>
                              <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Data</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                        <tbody  id = "con_tambah_tahapan">
                                            <tr>
                                                <td>1</td>
                                                <td class="form-group">
                                                    <div class="fg-line record">
                                                        <input type="text" class="form-control input-sm" id="m_data_tahapan" name="m_data_tahapan">
                                                    </div>
                                                </td>
                                                <td class="form-group">
                                                    <div class="fg-line record">
                                                        <select class="form-control input-sm" id="m_type_tahapan" name="m_type_tahapan">
                                                            <option value="1">String</option>
                                                            <option value="2">Integer</option>
                                                            <option value="3">Float</option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                </table>
                            </form>
                        </div>
                        
                        <div class="modal-footer">
                          <a id="hapus" data-dismiss="modal" class="btn btn-default pull-rigth">Batal</a>
                          <a id="tambah_tahapan" class="btn btn-success pull-rigth">Tambahkan</a>
                        </div>
                      </div>
                    </div> 
                </div>
                <!-- End Modal -->
            </div>
            
        </section>             
    @endsection

@section('js')

        <!-- Alela Javascript -->

        <!-- FastClick -->
        <script src="{{ asset('assets/vendors/alela/fastclick/lib/fastclick.js') }}"></script>
        <!-- NProgress -->
        <script src="{{ asset('assets/vendors/alela/nprogress/nprogress.js') }}"></script>
        <!-- Custom Theme Scripts -->
        <script src="{{ asset('assets/js/custom.js') }}"></script>
        <!-- jQuery Smart Wizard -->
        <script src="{{ asset('assets/vendors/alela/jQuery-Smart-Wizard/js/jquery.smartWizard.js') }}"></script>
        <!-- jQuery Smart Wizard -->
        <script>
          $(document).ready(function() {
            $('#wizard').smartWizard();

            $('#wizard_verticle').smartWizard({
              transitionEffect: 'slide'
            });

            $('.buttonNext').addClass('btn btn-success');
            $('.buttonPrevious').addClass('btn btn-primary');
            $('.buttonFinish').addClass('btn btn-default');
          });
        </script>
        <script src="{{ asset('assets/js/tahapan.js') }}"></script>
        <script src="{{ asset('assets/js/wilayah.js') }}"></script>
@endsection