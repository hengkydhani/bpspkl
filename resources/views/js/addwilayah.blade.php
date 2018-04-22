<script>

//add/remove wilayah
$(document).ready(function() {
    var count = 1;

    $("#add_wil").click(function(){
        count += 1;
        $('#containerwilayah').append(
            '<div id=records'+count+'>'
            +   '<div class="form-group">'
            +       '<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_tahapan">Nama Wilayah </label>'
            +       '<div class="col-md-6 col-sm-6 col-xs-12">'
            +           '<input type="text" id="nama_wilayah" name="nama_wilayah[]" required="required" class="form-control col-md-7 col-xs-12" placeholder="ex. Provinsi/Kabupaten/Kota">'
            +       '</div>'
            +   '</div>'
            +   '<div class="form-group">'
            +       '<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_tahapan">File Wilayah </label>'
            +       '<div class="fileinput fileinput-new" data-provides="fileinput">'
            +           '<span class="btn btn-primary btn-file m-r-10">'
            +               '<span class="fileinput-new">Select file</span>'
            +               '<span class="fileinput-exists">Change</span>'
            +               '<input type="file" name="wilayah'+count+'">'
            +               '<input type="hidden" name="count[]" value='+count+'>'
            +           '</span>'
            +           '<span class="fileinput-filename"></span>'
            +           '<a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>'
            +       '</div>'
            +   '</div>'
            +'</div>'
        ); 
        
    });
 
    $("#remove_wil").click(function(){
        $('#records'+ count +'').remove();
        $('#records'+ count +'').fadeOut('slow');
        count -= 1;
        if(count<2){
            count=1;
        }
    });
});

</script>