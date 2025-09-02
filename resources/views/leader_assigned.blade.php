<!DOCTYPE html>
<html>
<head>
    <title>Leader Assignment</title>
</head>
<body>
    <h2>Hello {{ $project->leader->name }},</h2>
    <p>Congratulations! You have been selected as the <strong>leader</strong> of the project <strong>{{ $project->name }}</strong>.</p>
    <p>Start Date: {{ $project->start_date }}</p>
    <p>Due Date: {{ $project->due_date }}</p>
    <br>
    <p>Thank you!</p>
</body>
</html>
