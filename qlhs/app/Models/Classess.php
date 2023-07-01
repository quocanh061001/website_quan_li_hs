<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classess extends Model
{
    use HasFactory;
    protected $table = 'lop';
    public $timestamps = false;
    protected $fillable =['name', 'magv', 'makhoi', 'namhoc'];

}
