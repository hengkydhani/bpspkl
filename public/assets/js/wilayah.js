$(document).ready(function() {
    var count = 1;

    $("#add_wil").click(function(){
        count += 1;
        $('#conwil').append(
            '<tr id="recordswil'+ count +'" >'
            +   '<td>'+count+'</td>'
            +   '<td class="form-group">'
            +       '<div class="fg-line record">'
            +           '<input type="text" class="form-control input-sm" id="nama_wilayah'+count+'" name="nama_wilayah[]">'
            +       '</div>'
            +   '</td>'
            +   '<td class="form-group">'
            +       '<div class="fg-line record">'
            +           '<input type="number" class="form-control input-sm" id="length_wilayah'+count+'" min="0" name="length_wilayah[]">'
            +       '</div>'
            +   '</td>'
            +   '<td class="form-group">'
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
            +   '</td>'
            +'</tr>'
        ); 
        
    });
 
    $("#remove_wil").click(function(){
        $('#recordswil'+ count +'').remove();
        $('#recordswil'+ count +'').fadeOut('slow');
        count -= 1;
        if(count<2){
            count=1;
        }
    });
});