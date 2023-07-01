<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class hs_kt extends Model
{
    use HasFactory;
    protected $table = 'hs_kt';
    public $timestamps = true;
    protected $fillable =['hs_mh', 'makhenthuong', 'diem', 'created_at', 'updated_at'];

}
