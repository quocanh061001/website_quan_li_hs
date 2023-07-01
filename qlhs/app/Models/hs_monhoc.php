<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hs_monhoc extends Model
{
    use HasFactory;
    protected $table = 'hs_monhoc';
    public $timestamps = false;
    protected $fillable =['mahs', 'mamonhoc', 'DTB'];
}
