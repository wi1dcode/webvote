<?php

namespace Core;

class Session
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set($index, $value)
    {
        $_SESSION[$index] = $value;
    }

    public function get($index)
    {
        return isset($_SESSION[$index]) ? $_SESSION[$index] : null;
    }

    public function has($index)
    {
        return isset($_SESSION[$index]);
    }

    public function remove($index)
    {
        unset($_SESSION[$index]);
    }

    public function clear()
    {
        session_unset();
    }
}
