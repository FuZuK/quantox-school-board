<?php
$title = 'Schools list';
include __DIR__ . '/../header.php';
?>
<table class="table">
    <tr>
        <th>Name</th>
        <th>Board</th>
        <th># students</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($schools as $school): ?>
        <tr>
            <td><a href="/schools/<?php echo $school['id'] ?>"><?php echo htmlspecialchars($school['name']) ?></a></td>
            <td><?php echo htmlspecialchars($school['board_info']['name']) ?></td>
            <td><?php echo $school['number_of_students'] ?></td>
            <td>
                <form action="/schools/<?php echo $school['id'] ?>/delete" method="post" style="display: none" id="school_delete_<?php echo $school['id'] ?>"></form>
                <a href="#" class="btn btn-danger" onclick="document.getElementById('school_delete_<?php echo $school['id'] ?>').submit()">Delete</a>
            </td>
        </tr>
    <?php endforeach ?>
</table>
<div class="p-3">
    <a href="/schools/create" class="btn btn-primary">Create school</a>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
