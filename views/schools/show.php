<?php
$title = 'School "' . htmlspecialchars($school['name']) . '"';
include __DIR__ . '/../header.php';
?>
<table class="table">
    <tr>
        <th>First name</th>
        <th>Last name</th>
        <th># grades</th>
        <th>Result</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($students as $student): ?>
        <tr>
            <td><?php echo htmlspecialchars($student['first_name']) ?></td>
            <td><?php echo htmlspecialchars($student['last_name']) ?></td>
            <td><?php echo $student['grades_number'] ?></td>
            <td><?php echo $student['result'] ?></td>
            <td>
                <a href="/schools/<?php echo $school['id'] ?>/students/<?php echo $student['id'] ?>" class="btn btn-primary">View</a>
                <a href="/schools/<?php echo $school['id'] ?>/students/<?php echo $student['id'] ?>/grades/create" class="btn btn-success">Grade</a>
                <form action="/schools/<?php echo $school['id'] ?>/students/<?php echo $student['id'] ?>/delete" method="post" style="display: none" id="student_delete_<?php echo $student['id'] ?>"></form>
                <a href="#" class="btn btn-danger" onclick="document.getElementById('student_delete_<?php echo $student['id'] ?>').submit()">Delete</a>
            </td>
        </tr>
    <?php endforeach ?>
</table>
<div class="p-3">
    <a href="/schools/<?php echo $school['id'] ?>/students/create" class="btn btn-primary">Add student</a>
</div>
<?php
include __DIR__ . '/../footer.php';
?>
