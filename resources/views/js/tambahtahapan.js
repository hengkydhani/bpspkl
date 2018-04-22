$('#th_tambah').click(function(){
  nama_tahapan       = $('#nama_tahapan').val();
  mulai_tahapan      = $('#mulai_tahapan').val();
  selesai_tahapan    = $('#selesai_tahapan').val();
  data = "nama_tahapan="+ nama_tahapan + "&mulai_tahapan=" + mulai_tahapan + "&selesai_tahapan=" +selesai_tahapan;
  ajax =1 ;
  if (!nama_tahapan) {
    hideerror(0); ajax = 0;
  }
  if (!mulai_tahapan){
    hideerror(1); ajax = 0;
  }
  if (!selesai_tahapan) {
    hideerror(2); ajax = 0;
  }
  if (ajax == 1) {
  	$.ajax({
  		type: 'POST',
  		url: "tahapan",
  		data: data,
  		success: function(data) {
          $('#form-refresh').load('js/createsurvey.blade.php').fadeIn("slow");
          $.notify({
            message: 'Tahapan berhasil ditambahkan'
          },{
            type: 'success',
            newest_on_top: true,
            placement: {
              from: "top",
              align: "center"
            }
          });
      },
      error: function(){
           $.notify({
            message: 'Gagal memasukan Tahapan'
          },{
            type: 'error',
            newest_on_top: true,
            placement: {
              from: "top",
              align: "center"
            }
          });
  	   }
    })
  }
})