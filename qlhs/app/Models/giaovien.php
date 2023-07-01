<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class giaovien extends Model
{
    use HasFactory;
    
    protected $table = 'giaovien';
    public $timestamps = false;
    protected $fillable =['name', 'gioitinh', 'bomon', 'state'];

}
