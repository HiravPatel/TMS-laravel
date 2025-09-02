<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projectmapping extends Model
{
    use HasFactory;

    protected $table="project_mappings";

    public $timestamps=true;

    protected $guarded=[];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function member() {
        return $this->belongsTo(User::class, 'member_id');
    }
}
