<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Send_otp extends Model
{
    use HasFactory;

    public $timestamps="true";

    protected $table="send_otps";

    protected $guarded=[];
}
