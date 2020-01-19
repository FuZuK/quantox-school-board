<?php

class View {
    public static function render($path, $values = []) {
        ob_start();
        extract($values);
        require '../views/' . $path . '.php';
        return ob_get_clean();
    }
}
