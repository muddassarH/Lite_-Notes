<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=[];
    public function  getRouteKeyName()
    {
        return "uuid";
    }
    public function user(){
        return $this->belongsto(User::class);

    }
}