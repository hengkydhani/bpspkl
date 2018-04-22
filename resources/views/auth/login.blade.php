<!DOCTYPE html>
<html>
    <!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login - Monitoring BPS</title>
        
        <!-- Vendor CSS -->
        <link href="{{ asset('assets/vendors/bower_components/animate.css/animate.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/bower_components/google-material-color/dist/palette.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css') }}" rel="stylesheet">
            
        <!-- CSS -->
        <link href="{{ asset('assets/css/app.min.1.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/app.min.2.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/sweetalert-master/dist/sweetalert.css')}}">
    </head>
    
    <body>
        <div class="login" data-lbg="teal">
            <!-- Login -->
            <div class="l-block toggled" id="l-login">
                <div class="lb-header palette-Teal bg">
                    <img src="{{ asset('assets/img/logobps.png') }}" alt="" width="50" height="50">
                    &nbsp;&nbsp;Badan Pusat Statistik
                </div>
                <form class="form-horizontal" role="form" method="post" action="{{ url('/login') }}">
                    {!! csrf_field() !!}
                    <div class="lb-body">
                        <div class="form-group fg-float">
                            <div class="fg-line">
                                <label class="fg-label">Username</label>
                                <input type="text" name="username" class="input-sm form-control fg-input">
                            </div>
                        </div>

                        <center><button type="submit" class="btn palette-Teal bg">Sign in</button>
                        </center>
                    </div>
                </form>
            </div>

            <!-- Register -->
            <div class="l-block" id="l-register">
                <div class="lb-header palette-Blue bg">
                    <i class="zmdi zmdi-account-circle"></i>
                    Create an account
                </div>
                
                     <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}
                      <div class="lb-body">
                          
                        <div class="form-group fg-float{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="fg-line">
                                <input id="name" type="text" class="input-sm form-control fg-input" name="name" value="{{ old('name') }}">
                                <label for="name" class="fg-label">Name</label>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group fg-float{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="fg-line">
                                <input id="email" type="email" class="input-sm form-control fg-input" name="email" value="{{ old('email') }}">
                                <label for="email" class="fg-label">E-Mail Address</label>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                       <div class="form-group fg-float{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="fg-line">
                                <input id="username" type="text" class="input-sm form-control fg-input" name="username" value="{{ old('username') }}">
                                <label for="username" class="fg-label">Username</label>
                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group fg-float{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="fg-line">
                                <input id="password" type="password" class="input-sm form-control fg-input" name="password">
                                <label for="password" class="fg-label">Password</label>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group fg-float{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <div class="fg-line">
                                <input id="password-confirm" type="password" class="input-sm form-control fg-input" name="password_confirmation">
                                <label for="password-confirm" class="fg-label">Confirm Password</label>
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    
                        <div class="form-group fg-float{{ $errors->has('nip_User') ? ' has-error' : '' }}">
                            <div class="fg-line">
                                <input id="nip_User" type="text" class="input-sm form-control fg-input" name="nip_User" value="{{ old('nip_User') }}">
                                <label for="nip_User" class="fg-label">NIP</label>
                                
                                @if ($errors->has('nip_User'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nip_User') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group fg-float">
                             <label class="col-md-4 control-label"> Privileges</label>
                            <div class="col-md-6">
                                <select class="form-control" name="level_User">
                                <option>-- Pilih hak akses --</option>
                                <option value="1">Superadmin</option>
                                <option value="2">Admin</option>
                                <option value="3">Operator</option>
                                <option value="4">Pemantau</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Register
                                </button>
                            </div>
                        </div>
                       </div>
                    </form>
            </div>

            <!-- Forgot Password -->
            <div class="l-block" id="l-forget-password">
                <div class="lb-header palette-Purple bg">
                    <i class="zmdi zmdi-account-circle"></i>
                    Forgot Password?
                </div>

                <div class="lb-body">
                    <p class="m-b-30">Lorem ipsum dolor fringilla enim feugiat commodo sed ac lacus.</p>

                    <div class="form-group fg-float">
                        <div class="fg-line">
                            <input type="text" class="input-sm form-control fg-input">
                            <label class="fg-label">Email Address</label>
                        </div>
                    </div>

                    <button class="btn palette-Purple bg">Create Account</button>

                    <div class="m-t-30">
                        <a data-block="#l-login" data-bg="teal" class="palette-Purple text d-block m-b-5" href="">Already have an account?</a>
                        <a data-block="#l-register" data-bg="blue" href="" class="palette-Purple text">Create an account</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Older IE warning message -->
        <!--[if lt IE 9]>
            <div class="ie-warning">
                <h1 class="c-white">Warning!!</h1>
                <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
                <div class="iew-container">
                    <ul class="iew-download">
                        <li>
                            <a href="http://www.google.com/chrome/">
                                <img src="img/browsers/chrome.png" alt="">
                                <div>Chrome</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.mozilla.org/en-US/firefox/new/">
                                <img src="img/browsers/firefox.png" alt="">
                                <div>Firefox</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.opera.com">
                                <img src="img/browsers/opera.png" alt="">
                                <div>Opera</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.apple.com/safari/">
                                <img src="img/browsers/safari.png" alt="">
                                <div>Safari</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                                <img src="img/browsers/ie.png" alt="">
                                <div>IE (New)</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <p>Sorry for the inconvenience!</p>
            </div>
        <![endif]-->

        <!-- Javascript Libraries -->
        <script src="{{ asset('assets/vendors/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/bower_components/Waves/dist/waves.min.js') }}"></script>

        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->

        <script src="{{ asset('assets/js/functions.js') }}"></script>
        <script src="{{ asset('assets/vendors/sweetalert-master/dist/sweetalert.min.js')}}"></script>
        @include('sweet::alert')
    </body>
</html>