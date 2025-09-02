<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles'; 

    protected $fillable = ['role'];

    public $timestamps = true;

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_id','role_mappings');
    }
}


