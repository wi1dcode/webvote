<?php

namespace App\Controller;

use Core\Controller;
use Core\Request;
use App\Model\UserModel;

class UserController extends Controller
{
        public function profile()
    {
        $this->requireLogin();

        $request = new Request;
        $userModel = new UserModel;
        $user = $this->user();

        if ($request->isPost()) {
            if ($request->getPost('section') === 'avatar') {
                $file = $request->getFile('avatar');

                if (!$file) {
                    $this->flash('errors', 'Fichier manquant.');
                    $this->redirect('user/profile');
                }

                if (!$request->validateFileExtension('avatar')) {
                    $this->flash('errors', 'Format de fichier non autorisé.');
                    $this->redirect('user/profile');
                }

                if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
                    $this->flash('errors', 'Erreur de transfert.');
                    $this->redirect('user/profile');
                }

                if (($file['size'] ?? 0) > 2 * 1024 * 1024) {
                    $this->flash('errors', 'Fichier trop volumineux.');
                    $this->redirect('user/profile');
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
                    $this->redirect('user/profile');
                }

                $publicPath = 'public/uploads/avatars/' . $name;
                $userModel->updateAvatar($user['id'], $publicPath);

                $this->session->set('user', $userModel->find($user['id']));
                $this->flash('success', 'Avatar mis à jour.');
                $this->redirect('user/profile');
            }

            if ($request->getPost('section') === 'password') {
                $current = (string)$request->getPost('password_current');
                $new = (string)$request->getPost('password_new');
                $confirm = (string)$request->getPost('password_confirm');

                if ($current === '' || $new === '' || $confirm === '') {
                    $this->flash('errors', 'Champs requis manquants.');
                    $this->redirect('user/profile');
                }

                if ($new !== $confirm) {
                    $this->flash('errors', 'Les mots de passe ne correspondent pas.');
                    $this->redirect('user/profile');
                }

                if (strlen($new) < 8) {
                    $this->flash('errors', 'Mot de passe trop court.');
                    $this->redirect('user/profile');
                }

                $hash = $userModel->getPasswordHash($user['id']);
                if (!$hash || !password_verify($current, $hash)) {
                    $this->flash('errors', 'Mot de passe actuel incorrect.');
                    $this->redirect('user/profile');
                }

                $userModel->updatePassword($user['id'], password_hash($new, PASSWORD_DEFAULT));
                $this->flash('success', 'Mot de passe modifié.');
                $this->redirect('user/profile');
            }

            $this->flash('errors', 'Action invalide.');
            $this->redirect('user/profile');
        }

        $this->render('layout/base.php', 'user/profile.php', [
            'pageTitle' => 'Profil',
            'messages' => $this->consumeFlash(),
            'user' => $this->user()
        ]);
    }

    public function banned()
    {
        $this->requireLogin();

        $user = $this->user();
        if (($user['status'] ?? '') === 'ACTIVE') {
            $this->redirect('');
        }

        $this->render('layout/base.php', 'user/banned.php', [
            'pageTitle' => 'Compte suspendu',
            'messages' => $this->consumeFlash(),
            'user' => $this->user()
        ]);
    }

}
