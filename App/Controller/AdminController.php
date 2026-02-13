<?php

namespace App\Controller;

use Core\Controller;
use App\Model\UserModel;
use App\Model\PetitionModel;

class AdminController extends Controller
{
    public function users()
    {
        $this->requireAdmin();

        $userModel = new UserModel;
        $users = $userModel->listAll();

        $this->render('layout/base.php', 'admin/users.php', [
            'pageTitle' => 'Utilisateurs',
            'users' => $users,
            'messages' => $this->consumeFlash(),
            'user' => $this->user()
        ]);
    }

    public function ban($id)
    {
        $this->requireAdmin();

        $userModel = new UserModel;
        $userModel->setStatus((int)$id, 'BANNED');

        $this->flash('success', 'Utilisateur mis à jour.');
        $this->redirect('admin/users');
    }

    public function unban($id)
    {
        $this->requireAdmin();

        $userModel = new UserModel;
        $userModel->setStatus((int)$id, 'ACTIVE');

        $this->flash('success', 'Utilisateur mis à jour.');
        $this->redirect('admin/users');
    }

    public function promote($id)
    {
        $this->requireAdmin();

        $userModel = new UserModel;
        $userModel->setRole((int)$id, 'ADMIN');

        $this->flash('success', 'Utilisateur mis à jour.');
        $this->redirect('admin/users');
    }

    public function demote($id)
    {
        $this->requireAdmin();

        $userModel = new UserModel;
        $userModel->setRole((int)$id, 'USER');

        $this->flash('success', 'Utilisateur mis à jour.');
        $this->redirect('admin/users');
    }

    public function petitions()
    {
        $this->requireAdmin();

        $petitionModel = new PetitionModel;
        $petitions = $petitionModel->listAdmin();

        $this->render('layout/base.php', 'admin/petitions.php', [
            'pageTitle' => 'Pétitions',
            'petitions' => $petitions,
            'messages' => $this->consumeFlash(),
            'user' => $this->user()
        ]);
    }

    public function hide($id)
    {
        $this->requireAdmin();

        $petitionModel = new PetitionModel;
        $petitionModel->setStatus((int)$id, 'HIDDEN');

        $this->flash('success', 'Pétition mise à jour.');
        $this->redirect('admin/petitions');
    }

    public function publish($id)
    {
        $this->requireAdmin();

        $petitionModel = new PetitionModel;
        $petitionModel->setStatus((int)$id, 'PUBLISHED');

        $this->flash('success', 'Pétition mise à jour.');
        $this->redirect('admin/petitions');
    }
}
