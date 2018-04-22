<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'provinsi';
    protected $fillable =  array('id_Provinsi','nama_Provinsi');

    public $timestamps ="false";
}
