<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Worklog extends Model
{
    use HasFactory,softDeletes;

    public $timestamps=true;

    protected $table="worklogs";

    protected $fillable = [
        'title',
        'project_id',
        'task_id',
        'description',
        'date',
        'user_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
