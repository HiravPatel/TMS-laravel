<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Task extends Model
{
    use HasFactory,softDeletes;

    protected $table="tasks";

    protected $guarded=[];

    public $timestamp=true;

    public function project()
    {
    return $this->belongsTo(Project::class);
    }

    public function assignedto()
    {
    return $this->belongsTo(User::class, 'assigned_to');
    }
}
