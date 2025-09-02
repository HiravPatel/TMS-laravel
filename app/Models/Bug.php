<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Bug extends Model
{
    use HasFactory,softDeletes;

    protected $table="bugs";

    public $timestamps=true;

    protected $guarded=[];

    public function task(){
        return $this->belongsTo(Task::class,'task_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
