                            <tbody id="tableadministrasi">                         
                                @foreach($daftarHakAkses as $hakakses) 
                                
                                <?php
                                
                                $user = DB::table('users')
                                    ->where('username', $hakakses->id_users)
                                    ->first();
                                $no=1;
                                ?>       
                                
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $user -> nip_user }}</td>
                                    <td>{{ $user -> name }}</td>
                                    <td>{{ $hakakses -> hakakses }}</td>
                                    @if($level=="Admin" || Session::get('username')=="alvian" || Session::get('username')=="aneksa")
                                    <td>
                                        <a href="{{ url($id_survey.'/administrasi/'.$user->username.'/edit') }}" type="button" class="btn palette-Indigo bg">Ubah</a>
                                        <!-- <a  onclick="openmodaledit('<?php echo $user->id_user  ?>','<?php echo $user->name  ?>','<?php echo $user->username  ?>','<?php echo $user->nip_user ?>','<?php echo $hakakses->hakakses ?>')"  class="btn palette-Indigo bg">Edit</a> -->
                                        
                                        <a href="{{ url($id_survey.'/administrasi/'.$user->username.'/delete' ) }}" type="button" class="btn palette-Red bg">Hapus</a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>