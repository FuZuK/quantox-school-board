<?php $title = 'School student grade creation' ?>
<?php include __DIR__ . '/../../../header.php'; ?>
<form action="/schools/<?php echo $school['id'] ?>/students/<?php echo $student['id'] ?>/grades/create" method="POST">
    <div class="form-group">
        <label for="grade">Grade</label>
        <select name="grade" id="grade" class="form-control">
            <?php for ($i = $range['from']; $i <= $range['to']; $i++): ?>
                <option value="<?php echo $i ?>"><?php echo $i ?></option>
            <?php endfor ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Add</button>
</form>
<?php include __DIR__ . '/../../../footer.php'; ?>
