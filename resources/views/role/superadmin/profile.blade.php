@foreach ($survey as $f_survey) 
    <?php
        $hakakses = DB::table($f_survey -> id_survey.'-hakakses') -> where('id_users', $user->username) -> get();
    ?>
    @foreach ($hakakses as $f_hakakses)
        {{ $f_hakakses -> id_users }} sebagai {{ $f_hakakses -> hakakses }}
    @endforeach
@endforeach