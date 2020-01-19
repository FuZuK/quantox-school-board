<?php if (array_key_exists('errors', $_SESSION) && count($_SESSION['errors'])): ?>
    <div class="alert alert-danger" role="alert">
        <?php foreach ($_SESSION['errors'] as $error): ?>
            <div><?php echo $error ?></div>
        <?php endforeach ?>
    </div>
    <?php unset($_SESSION['errors']) ?>
<?php endif ?>