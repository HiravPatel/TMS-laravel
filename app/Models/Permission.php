<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = ['name'];

    public $timestamps = true;

    // Permission + Role (Many-to-Many via role_mappings)
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_mappings', 'permission_id', 'role_id');
    }
}

