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
                <ul class="breadcrumb" style="margin-bottom: 5px;">
                  <li><a href="{{URL('/')}}">Beranda</a></li>
                  <li class="active">Buat Baru</li>
                </ul>
                <div class="card">
                    <div class="card-body card-padding">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Form Pembuatan Survey</h2>    
                                <div class="clearfix"></div>
                            </div>
                        
                            <div class="x_content">
                                <!-- Smart Wizard -->
                                <p>Pastikan field yang ada terisi semua dengan benar</p>
                                <div id="wizard" class="form_wizard wizard_horizontal">
                                    <ul class="wizard_steps">
                                        <li>
                                          <a href="#step-1">
                                            <span class="step_no">1</span>
                                            <span class="step_descr">
                                                <b>Tahap 1<br />
                                                <small>Detil Survey</small></b>
                                            </span>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#step-2">
                                            <span class="step_no">2</span>
                                            <span class="step_descr">
                                                <b>Tahap 2<br />
                                                <small>Tahapan</small></b>
                                            </span>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#step-3">
                                            <span class="step_no">3</span>
                                            <span class="step_descr">
                                                <b>Tahap 3<br />
                                                <small>Cakupan Wilayah</small></b>
                                            </span>
                                          </a>
                                        </li>
                                    </ul>
                                    
                                    <form id="formSurvey" class="form-horizontal form-label-left" action="{{url('createsurvey')}}" method="post" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                        <div id="step-1">
                                            <br>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="surveyname">Nama Survey </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" id="surveyname" name="surveyname" required="required" class="form-control col-md-7 col-xs-12">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="surveyidentity">Identitas Survey </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" id="surveyidentity" name="surveyidentity" required="required" class="form-control col-md-7 col-xs-12">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Mulai </label>
                                                <div class="col-md-2 col-sm-6 col-xs-12">
                                                  <input id="tgl_mulai" name="tgl_mulai" class="date-picker form-control col-md-7 col-xs-12" data-date-format="YYYY-MM-DD" required="required" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Selesai </label>
                                                <div class="col-md-2 col-sm-6 col-xs-12">
                                                  <input id="tgl_selesai" name="tgl_selesai" class="date-picker form-control col-md-7 col-xs-12" data-date-format="YYYY-MM-DD" required="required" type="text">
                                                </div>
                                            </div>
                                        </div>

                                        <div id="step-2">
                                                <input class="pull-right" type="button" name="remove_tahapan" value="-" id="remove_tahapan">
                                                <input class="pull-right" type="button" name="add_tahapan" value="+" data-toggle="modal" href="#modalTambahTahapan">
                                            </h2>
                                            <br>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Tahapan</th>
                                                        <th>Mulai</th>
                                                        <th>Selesai</th>
                                                        <th>Target</th>
                                                    </tr>
                                                </thead>
                                                <tbody id=con_tahapan>
                                                </tbody>
                                            </table>                                 
                                        </div>

                                        <div id="step-3">
                                            <h2 class="StepTitle">Step 3 Cakupan Wilayah
                                                <input class="pull-right" type="button" name="remove_wil" value="-" id="remove_wil">
                                                <input class="pull-right" type="button" name="add_wil" value="+" id="add_wil">
                                            </h2>
                                            <br>

                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Wilayah</th>
                                                        <th>Length</th>
                                                        <th>Data</th>
                                                    </tr>
                                                </thead>
                                                <tbody  id = "conwil">
                                                    <tr>
                                                        <td>1</td>
                                                        <td class="form-group">
                                                            <div class="fg-line record">
                                                                <input type="text" class="form-control input-sm" id="nama_wilayah" name="nama_wilayah[]">
                                                           </div>
                                                        </td>
                                                        <td class="form-group">
                                                            <div class="fg-line record">
                                                            <input type="number" class="form-control input-sm" id="length_wilayah" min="0" name="length_wilayah[]">
                                                            </div>
                                                        </td>
                                                        <td class="form-group">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <span class="btn btn-primary btn-file m-r-10">
                                                                    <span class="fileinput-new">Select file</span>
                                                                    <span class="fileinput-exists">Change</span>
                                                                    <input type="file" name="wilayah1">
                                                                    <input type="hidden" name="count[]" value='1'>
                                                                </span>
                                                                <span class="fileinput-filename"></span>
                                                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <!-- End SmartWizard Content -->
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