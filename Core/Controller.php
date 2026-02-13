<?php

namespace Core;

class Controller
{
    protected $session;

    public function __construct()
    {
        $this->session = new Session;
    }

    public function render($layout, $template, $params = [])
    {
        extract($params);

        ob_start();
        require ROOT_PATH . '/App/View/' . $template;
        $content = ob_get_clean();

        ob_start();
        require ROOT_PATH . '/App/View/' . $layout;
        return ob_end_flush();
    }

    public function redirect($path = '')
    {
        header('Location: ' . ROOT_URL . ltrim($path, '/'));
        exit;
    }

    public function flash($type, $message)
    {
        $this->session->set($type, $message);
    }

    public function consumeFlash()
    {
        $messages = [
            'success' => $this->session->get('success'),
            'errors' => $this->session->get('errors'),
        ];
        $this->session->remove('success');
        $this->session->remove('errors');
        return $messages;
    }

    public function user()
    {
        return $this->session->get('user');
    }

    public function requireLogin()
    {
        if (!$this->user()) {
            $this->flash('errors', 'Accès refusé.');
            $this->redirect('auth/login');
        }
    }

    public function requireActive()
    {
        $user = $this->user();
        if (!$user || ($user['status'] ?? '') !== 'ACTIVE') {
            $this->flash('errors', 'Accès refusé.');
            $this->redirect('');
        }
    }

    public function requireAdmin()
    {
        $user = $this->user();
        if (!$user || ($user['role'] ?? '') !== 'ADMIN') {
            $this->flash('errors', 'Accès refusé.');
            $this->redirect('');
        }
    }
}
