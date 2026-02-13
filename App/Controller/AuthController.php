<?php

namespace App\Controller;

use Core\Controller;
use Core\Request;
use App\Model\UserModel;

class AuthController extends Controller
{
    public function register()
    {
        $request = new Request;

        if ($request->isPost()) {
            $pseudo = trim((string)$request->getPost('pseudo'));
            $email = trim((string)$request->getPost('email'));
            $password = (string)$request->getPost('password');
            $password2 = (string)$request->getPost('password2');

            if ($pseudo === '' || $email === '' || $password === '') {
                $this->flash('errors', 'Champs requis manquants.');
                $this->redirect('auth/register');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->flash('errors', 'Adresse email invalide.');
                $this->redirect('auth/register');
            }

            if ($password !== $password2) {
                $this->flash('errors', 'Les mots de passe ne correspondent pas.');
                $this->redirect('auth/register');
            }

            if (strlen($password) < 8) {
                $this->flash('errors', 'Mot de passe trop court.');
                $this->redirect('auth/register');
            }

            $userModel = new UserModel;
            if ($userModel->findByEmail($email)) {
                $this->flash('errors', 'Cet email est déjà utilisé.');
                $this->redirect('auth/register');
            }

            $avatarPath = null;
            $file = $request->getFile('avatar');
            if ($file) {
                if (!$request->validateFileExtension('avatar')) {
                    $this->flash('errors', 'Format de fichier non autorisé.');
                    $this->redirect('auth/register');
                }

                if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
                    $this->flash('errors', 'Erreur de transfert.');
                    $this->redirect('auth/register');
                }

                if (($file['size'] ?? 0) > 2 * 1024 * 1024) {
                    $this->flash('errors', 'Fichier trop volumineux.');
                    $this->redirect('auth/register');
                }

                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $name = bin2hex(random_bytes(16)) . '.' . $ext;

                $targetDir = ROOT_PATH . '/public/uploads/avatars/';
                $targetPath = $targetDir . $name;

                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0775, true);
                }

                if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $this->flash('errors', 'Enregistrement impossible.');
                    $this->redirect('auth/register');
                }

                $avatarPath = 'public/uploads/avatars/' . $name;
            }

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $id = $userModel->create($pseudo, $email, $hash, $avatarPath);
            $user = $userModel->find($id);

            $this->session->set('user', $user);
            $this->flash('success', 'Compte créé.');
            $this->redirect('');
        }

        $this->render('layout/base.php', 'auth/register.php', [
            'pageTitle' => 'Inscription',
            'messages' => $this->consumeFlash(),
            'user' => $this->user()
        ]);
    }

    public function login()
    {
        $request = new Request;

        if ($request->isPost()) {
            $email = trim((string)$request->getPost('email'));
            $password = (string)$request->getPost('password');

            $userModel = new UserModel;
            $row = $userModel->findByEmail($email);

            if (!$row || !password_verify($password, $row['password'])) {
                $this->flash('errors', 'Identifiants invalides.');
                $this->redirect('auth/login');
            }

            $user = $userModel->find($row['id']);

            if (($user['status'] ?? '') !== 'ACTIVE') {
                $this->flash('errors', 'Votre compte est suspendu !');
                $this->redirect('auth/login');
            }

            $this->session->set('user', $user);
            $this->flash('success', 'Connexion établie.');
            $this->redirect('');
        }

        $this->render('layout/base.php', 'auth/login.php', [
            'pageTitle' => 'Connexion',
            'messages' => $this->consumeFlash(),
            'user' => $this->user()
        ]);
    }

    public function logout()
    {
        $this->session->clear();
        $this->redirect('');
    }
}
