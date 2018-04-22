//add/remove new progress
$(document).ready(function() {
    var count = 1;

    $("#add_btn").click(function(){
        count += 1;
        $('#con_tambah_tahapan').append(
            '<tr id="recordstahapan'+ count +'" >'
            +   '<td>'
            +       count
            +   '</td>'
            +   '<td class="form-group">'
            +       '<div class="fg-line record">'
            +           '<input type="text" class="form-control input-sm" id="m_data_tahapan" name="m_data_tahapan">'
            +       '</div>'
            +   '</td>'
            +   '<td class="form-group">'
            +       '<div class="fg-line record">'
            +           '<select class="form-control input-sm" id="m_type_tahapan" name="m_type_tahapan">'
            +               '<option value="1">String</option>'
            +               '<option value="2">Integer</option>'
            +               '<option value="3">Float</option>'
            +           '</select>'
            +       '</div>'
            +   '</td>'
            + '</tr>'
        ); 
        
    });
 
    $("#remove_item").click(function(){
        $('#recordstahapan'+ count +'').remove();
        $('#recordstahapan'+ count +'').fadeOut('slow');
        count -= 1;
        if(count<2){
            count=1;
        }
    });
});

$(document).ready(function() {
    count_tahapan=0;
    $("#tambah_tahapan").click(function(){
        var nama_tahapan = $('#m_nama_tahapan').val();
        var tahapan_mulai = $('#m_tahapan_mulai').val();
        var tahapan_selesai = $('#m_tahapan_selesai').val();
        var data_tahapan = document.getElementsByName('m_data_tahapan');
        var type_tahapan = document.getElementsByName('m_type_tahapan');

        count_tahapan += 1;
        $('#con_tahapan').append(
            '<tr id="recordstahapan'+ count_tahapan +'">'
            +   '<td>'+count_tahapan+'</td>'
            +   '<td>'
            +       '<input type="hidden" class="form-control input-sm" id="nama_tahapan" name="nama_tahapan[]" value="'+nama_tahapan+'">'
            +        nama_tahapan
            +   '</td>'
            +   '<td>'
            +       '<input type="hidden" class="form-control input-sm" id="tahapan_mulai" name="tahapan_mulai[]" value="'+tahapan_mulai+'">'
            +        tahapan_mulai
            +   '</td>'
            +   '<td>'
            +       '<input type="hidden" class="form-control input-sm" id="tahapan_selesai" name="tahapan_selesai[]" value="'+tahapan_selesai+'">'
            +        tahapan_selesai
            +   '</td>'
            +   '<td class="form-group">'
            +       '<div class="fileinput fileinput-new form-control col-md-7 col-xs-12" data-provides="fileinput">'
            +           '<span class="btn btn-primary btn-file m-r-10">'
            +               '<span class="fileinput-new">Select file</span>'
            +               '<span class="fileinput-exists">Change</span>'
            +               '<input id="target'+count_tahapan+'" type="file" name="target'+count_tahapan+'">'
            +           '</span>'
            +           '<span class="fileinput-filename"></span>'
            +           '<a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>'
            +       '</div>'
            +   '</td>'
        );
        for(var i=0; i<data_tahapan.length ; i++){
            $('#con_tahapan').append(
                '<input type="hidden" class="form-control input-sm" id="data_tahapan" name="data_tahapan['+count_tahapan+'][]" value="'+data_tahapan[i].value+'">'
                + '<input type="hidden" class="form-control input-sm" id="type_tahapan" name="type_tahapan['+count_tahapan+'][]" value="'+type_tahapan[i].value+'">'
                + '</tr>'
            );
        }
        $("#modalTambahTahapan").modal("hide");
        document.getElementById("tambahTahapan").reset();

    });

    $("#remove_tahapan").click(function(){
        $('#recordstahapan'+ count_tahapan +'').remove();
        $('#recordstahapan'+ count_tahapan +'').fadeOut('slow');
        count_tahapan -= 1;
        if(count_tahapan<1){
            count_tahapan=0;
        }
    });
});