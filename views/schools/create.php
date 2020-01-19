<?php $title = 'School creation' ?>
<?php include __DIR__ . '/../header.php'; ?>
<form action="/schools/create" method="POST">
    <div class="form-group">
        <label for="name">School name</label>
        <input type="text" class="form-control" name="name" id="name">
    </div>
    <div class="form-group">
        <label for="board">Board</label>
        <select name="board" class="form-control" id="board">
            <?php foreach ($boards as $board): ?>
                <option value="<?php echo $board['id'] ?>"><?php echo htmlspecialchars($board['name']) ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
</form>
<?php include __DIR__ . '/../footer.php'; ?>
