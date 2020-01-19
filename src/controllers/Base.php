<?php
namespace Controllers;

class Base
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    protected function view($key, $data = []) {
        return \View::render($key, $data);
    }

    protected function redirect($url) {
        error_log('Redirect to ' . $url);
        header('Location: ' . $url);

        return '';
    }

    protected function redirectWithErrors($uri, $errors) {
        $_SESSION['errors'] = $errors;
        return $this->redirect($uri);
    }

    protected function redirectWithError($uri, $error) {
        $_SESSION['errors'][] = $error;
        return $this->redirect($uri);
    }

    protected function redirectWithMessage($uri, $message) {
        $_SESSION['messages'][] = $message;
        return $this->redirect($uri);
    }
}
