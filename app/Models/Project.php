<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\softDeletes;

class Project extends Model
{
    use HasFactory,softDeletes;

    protected $table="projects";

    protected $fillable=['name','description','start_date','due_date','status','leader_id'];

    public $timestamps=true;

     public function leader() {
        return $this->belongsTo(User::class, 'leader_id');
    }

   public function members()
{
    return $this->belongsToMany(User::class, 'project_mappings', 'project_id', 'member_id')
                ->withTimestamps();
}

}
