<?php

namespace Core;

class Request
{
    public function isPost()
    {
        return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
    }

    public function isGet()
    {
        return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET';
    }

    public function getPost($field)
    {
        return isset($_POST[$field]) ? $_POST[$field] : null;
    }

    public function getGet($field)
    {
        return isset($_GET[$field]) ? $_GET[$field] : null;
    }

    public function getFile($field)
    {
        if (!empty($_FILES[$field]['name'])) {
            return $_FILES[$field];
        }
        return null;
    }

    public function validateFileExtension($field, $extensions = ['png', 'jpg', 'jpeg', 'webp'])
    {
        $file = $this->getFile($field);
        if (!$file) {
            return false;
        }
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        return in_array($extension, $extensions, true);
    }
}
