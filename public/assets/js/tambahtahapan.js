$('document').ready(function() {    
    $('#th_tambah').click(function(){
      nama_tahapan        = $('#nama_tahapan').val();
      mulai_tahapan  = $('#mulai_tahapan').val();
      selesai_tahapan    = $('#selesai_tahapan').val();
      data = "nama_tahapan = "+ nama_tahapan + "&mulai_tahapan = " + mulai_tahapan + "&selesai_tahapan = " +selesai_tahapan;
        $.ajax({
            type: 'POST',
            url: "survey/tahapan",
            data: data,
            success: function(data) {
                alert('Tahapan berhasil ditambahkan');
                $('#form-refresh').load('js/createsurvey.blade.php').fadeIn("slow");
            },
            error: function(){
                alert('Gagal memasukan Tahapan');
           }
        })
    })
});