<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loguser extends Model
{

	protected $table = 'loguser';

    protected $fillable = [
        'id_user', 'status', 'waktu_login','waktu_logout',
    ];

    public $timestamps = false;

}
