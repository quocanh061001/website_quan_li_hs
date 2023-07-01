<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class diemtheomon extends Model
{
    use HasFactory;
    protected $table = 'diemtheomon';
    public $timestamps = false;
    protected $fillable =['maloaidiem', 'hs_mh', 'diem', 'hk_nh'];
}
