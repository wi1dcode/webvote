<?php

namespace App\Controller;

use Core\Controller;
use Core\Request;
use App\Model\PetitionModel;
use App\Model\CategoryModel;
use App\Model\SignatureModel;
use App\Model\CommentModel;

class PetitionController extends Controller
{
    public function show($id)
    {
        $petitionModel = new PetitionModel;
        $signatureModel = new SignatureModel;

        $petition = $petitionModel->find((int)$id);
        if (!$petition || $petition['status'] !== 'PUBLISHED') {
            $this->flash('errors', 'Ressource introuvable.');
            $this->redirect('');
        }

        $user = $this->user();
        $signed = false;
        if ($user) {
            $signed = $signatureModel->hasSigned($petition['id'], $user['id']);
        }

        $commentModel = new CommentModel;
        $comments = $commentModel->listForPetition($petition['id']);

        $this->render('layout/base.php', 'petition/show.php', [
            'pageTitle' => $petition['title'],
            'petition' => $petition,
            'signed' => $signed,
            'comments' => $comments,
            'messages' => $this->consumeFlash(),
            'user' => $user
        ]);
    }

    public function create()
    {
        $this->requireLogin();
        $this->requireActive();

        $request = new Request;
        $petitionModel = new PetitionModel;
        $categoryModel = new CategoryModel;

        if ($request->isPost()) {
            $categoryId = (int)$request->getPost('category_id');
            $title = trim((string)$request->getPost('title'));
            $description = trim((string)$request->getPost('description'));
            $goal = (int)$request->getPost('goal_signatures');

            if ($categoryId <= 0 || $title === '' || $description === '' || $goal <= 0) {
                $this->flash('errors', 'Données invalides.');
                $this->redirect('petition/create');
            }

            $imagePath = null;
            $file = $request->getFile('image');

            if ($file) {
                if (!$request->validateFileExtension('image')) {
                    $this->flash('errors', 'Format de fichier non autorisé.');
                    $this->redirect('petition/create');
                }

                if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
                    $this->flash('errors', 'Erreur de transfert.');
                    $this->redirect('petition/create');
                }

                if (($file['size'] ?? 0) > 3 * 1024 * 1024) {
                    $this->flash('errors', 'Fichier trop volumineux.');
                    $this->redirect('petition/create');
                }

                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $name = bin2hex(random_bytes(16)) . '.' . $ext;

                $targetDir = ROOT_PATH . '/public/uploads/petitions/';
                $targetPath = $targetDir . $name;

                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0775, true);
                }

                if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $this->flash('errors', 'Enregistrement impossible.');
                    $this->redirect('petition/create');
                }

                $imagePath = 'public/uploads/petitions/' . $name;
            }

            $user = $this->user();
            $id = $petitionModel->create($user['id'], $categoryId, $title, $description, $goal, $imagePath);

            $this->flash('success', 'Pétition créée.');
            $this->redirect('petition/show/' . $id);
        }

        $this->render('layout/base.php', 'petition/form.php', [
            'pageTitle' => 'Nouvelle pétition',
            'categories' => $categoryModel->listAll(),
            'petition' => null,
            'messages' => $this->consumeFlash(),
            'user' => $this->user()
        ]);
    }

    public function edit($id)
    {
        $this->requireLogin();
        $this->requireActive();

        $petitionModel = new PetitionModel;
        $categoryModel = new CategoryModel;
        $request = new Request;

        $petition = $petitionModel->find((int)$id);
        if (!$petition) {
            $this->flash('errors', 'Ressource introuvable.');
            $this->redirect('');
        }

        $user = $this->user();
        if (($user['role'] ?? '') !== 'ADMIN' && (int)$petition['user_id'] !== (int)$user['id']) {
            $this->flash('errors', 'Accès refusé.');
            $this->redirect('');
        }

        if ($request->isPost()) {
            $categoryId = (int)$request->getPost('category_id');
            $title = trim((string)$request->getPost('title'));
            $description = trim((string)$request->getPost('description'));
            $goal = (int)$request->getPost('goal_signatures');

            if ($categoryId <= 0 || $title === '' || $description === '' || $goal <= 0) {
                $this->flash('errors', 'Données invalides.');
                $this->redirect('petition/edit/' . (int)$id);
            }

            $imagePath = null;
            $file = $request->getFile('image');

            if ($file) {
                if (!$request->validateFileExtension('image')) {
                    $this->flash('errors', 'Format de fichier non autorisé.');
                    $this->redirect('petition/edit/' . (int)$id);
                }

                if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
                    $this->flash('errors', 'Erreur de transfert.');
                    $this->redirect('petition/edit/' . (int)$id);
                }

                if (($file['size'] ?? 0) > 3 * 1024 * 1024) {
                    $this->flash('errors', 'Fichier trop volumineux.');
                    $this->redirect('petition/edit/' . (int)$id);
                }

                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $name = bin2hex(random_bytes(16)) . '.' . $ext;

                $targetDir = ROOT_PATH . '/public/uploads/petitions/';
                $targetPath = $targetDir . $name;

                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0775, true);
                }

                if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $this->flash('errors', 'Enregistrement impossible.');
                    $this->redirect('petition/edit/' . (int)$id);
                }

                $imagePath = 'public/uploads/petitions/' . $name;
            }

            $petitionModel->update((int)$id, $categoryId, $title, $description, $goal, $imagePath);
            $this->flash('success', 'Modification enregistrée.');
            $this->redirect('petition/show/' . (int)$id);
        }

        $this->render('layout/base.php', 'petition/form.php', [
            'pageTitle' => 'Modifier',
            'categories' => $categoryModel->listAll(),
            'petition' => $petition,
            'messages' => $this->consumeFlash(),
            'user' => $this->user()
        ]);
    }

    public function delete($id)
    {
        $this->requireLogin();
        $this->requireActive();

        $petitionModel = new PetitionModel;
        $petition = $petitionModel->find((int)$id);
        if (!$petition) {
            $this->flash('errors', 'Ressource introuvable.');
            $this->redirect('');
        }

        $user = $this->user();
        if (($user['role'] ?? '') !== 'ADMIN' && (int)$petition['user_id'] !== (int)$user['id']) {
            $this->flash('errors', 'Accès refusé.');
            $this->redirect('');
        }

        $petitionModel->delete((int)$id);
        $this->flash('success', 'Suppression effectuée.');
        $this->redirect('');
    }

    public function mine()
    {
        $this->requireLogin();
        $petitionModel = new PetitionModel;

        $user = $this->user();
        $petitions = $petitionModel->listByUser($user['id']);

        $this->render('layout/base.php', 'petition/mine.php', [
            'pageTitle' => 'Mes pétitions',
            'petitions' => $petitions,
            'messages' => $this->consumeFlash(),
            'user' => $user
        ]);
    }
}
