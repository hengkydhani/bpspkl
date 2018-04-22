<?php $no=1; ?>
@foreach($users as $f_users)  
<tr>
    <td>{{ $no++ }}</td>
    <td>{{ $f_users -> name }}</td>
    <td>{{ $f_users -> username }}</td>
    <td>{{ $f_users -> nip_user }}</td>
    <td>
        <a  onclick="openmodaledit('<?php echo $f_users->id_user  ?>','<?php echo $f_users->name  ?>','<?php echo $f_users->username  ?>','<?php echo $f_users->nip_user ?>')"  class="btn palette-Indigo bg">Edit</a>
        
        <a onclick="openmodaldelete('<?php echo $f_users->id_user  ?>','<?php echo $f_users->name  ?>','<?php echo $f_users->username  ?>')" class="btn palette-Red bg">Delete</a>
    </td>
</tr>
@endforeach 