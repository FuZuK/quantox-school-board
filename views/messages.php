<?php if (array_key_exists('messages', $_SESSION) && count($_SESSION['messages'])): ?>
    <div class="alert alert-success">
        <?php foreach ($_SESSION['messages'] as $message): ?>
            <div><?php echo $message ?></div>
        <?php endforeach ?>
    </div>
    <?php unset($_SESSION['messages']) ?>
<?php endif ?>