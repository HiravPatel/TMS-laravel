<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\softDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, softDeletes;
    protected $table = 'users';

    protected $guarded = [];

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_mappings', 'member_id', 'project_id');
    }
}
