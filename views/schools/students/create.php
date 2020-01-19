<?php $title = 'School student creation' ?>
<?php include __DIR__ . '/../../header.php'; ?>
<form action="/schools/<?php echo $school['id'] ?>/students/create" method="POST">
    <div class="form-group">
        <label for="first_name">First name</label>
        <input type="text" class="form-control" name="first_name" id="first_name">
    </div>
    <div class="form-group">
        <label for="last_name">Last name</label>
        <input type="text" class="form-control" name="last_name" id="last_name">
    </div>
    <button type="submit" class="btn btn-primary">Add</button>
</form>
<?php include __DIR__ . '/../../footer.php'; ?>
