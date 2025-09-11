<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Project;

class DateWithinProject implements Rule
{
    protected $projectId;
    protected $startDate;
    protected $dueDate;

    public function __construct($projectId, $startDate, $dueDate)
    {
        $this->projectId = $projectId;
        $this->startDate = $startDate;
        $this->dueDate   = $dueDate;
    }

    public function passes($attribute, $value)
    {
        $project = Project::find($this->projectId);

        if (!$project) return false;

        return $this->startDate >= $project->start_date && $this->dueDate <= $project->due_date;
    }

    public function message()
    {
        return "Task dates must be within the project period.";
    }
}
