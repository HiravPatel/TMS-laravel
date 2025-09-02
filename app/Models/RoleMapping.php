<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleMapping extends Model
{
    use HasFactory;

    protected $table = 'role_mappings';

    protected $fillable = ['role_id', 'permission_id'];

    public $timestamps = true;

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class,'permission_id');
    }
}
