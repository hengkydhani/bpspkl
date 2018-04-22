<html>
    <head>
        <script src="{{ asset('assets/vendors/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <script type="text/javascript">
            $('document').ready(function() {
                $('#btn').click(function() {
                   var   nama_tahapan        = $('#nama_tahapan').val();
                   var   mulai_tahapan       = $('#mulai_tahapan').val();
                   var   selesai_tahapan      = $('#selesai_tahapan').val();
                   var   data = "nama_tahapan = "+ nama_tahapan + "&mulai_tahapan = " + mulai_tahapan + "&selesai_tahapan = " +selesai_tahapan;
                    $.ajax({
                        type: 'POST',
                        url: "home.blade.php",
                        data: data,
                        success: function() {
                            $('#tampil').load("coba.blade.php");
                        },
                         error: function(){
                            alert('Gagal memasukan Tahapan');
                       }
                    });
                });
            });
        </script>
        <style>
            .lab{
                width:150px;
            }
            .ipt{
                width: 300px;
                height: 30px;
                border:1px solid #fff;
                padding-left: 10px;
                font-size: 12pt;
            }
            #btn{
                width: 200px;
                height: 25px;
                margin-top:10px;
                background: #2ECC71;
                border:1px solid #2ECC71;
                color:#fff;
            }
            h1{
                font-family:sans-serif;
                text-align: center;
            }
            #tbl_input{
                margin-left: 450px;
            }
        </style>
    </head>
    <body>
        <div id="lay">
            <h1>FORM INPUT AJAX JQUERY CARIKODE.COM</h1>
            <div id="form-inp">

                <form method="post" action="" id="form-input">
                    <table id="tbl_input">
                        <tr>
                            <td class="lab">Nama </td><td><input class="ipt" type="text" name="nama" id="nama"></td>
                        </tr>
                        <tr>
                            <td class="lab">Mulai </td><td><input class="ipt" type="date" name="mulai_tahapan" id="mulai_tahapan"></td>
                        </tr>
                        <tr>
                            <td class="lab">Selesai </td><td><input class="ipt" type="date" name="selesai_tahapan" id="selesai_tahapan"></td>
                        </tr>
                        <tr>
                            <td></td><td><input id="btn" type="button" value="Insert"></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="tampil"></div>
        </div>
    </body>
</html>