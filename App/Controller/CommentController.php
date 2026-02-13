<?php

namespace App\Controller;

use Core\Controller;
use Core\Request;
use App\Model\CommentModel;
use App\Model\PetitionModel;

class CommentController extends Controller
{
    public function create($petitionId)
    {
        $this->requireLogin();
        $this->requireActive();

        $request = new Request;
        if (!$request->isPost()) {
            $this->redirect('petition/show/' . (int)$petitionId);
        }

        $content = trim((string)$request->getPost('content'));
        if ($content === '') {
            $this->flash('errors', 'Message vide.');
            $this->redirect('petition/show/' . (int)$petitionId);
        }

        $petitionModel = new PetitionModel;
        $petition = $petitionModel->find((int)$petitionId);
        if (!$petition || $petition['status'] !== 'PUBLISHED') {
            $this->flash('errors', 'Ressource introuvable.');
            $this->redirect('');
        }

        $commentModel = new CommentModel;
        $commentModel->create((int)$petitionId, (int)$this->user()['id'], $content);

        $this->flash('success', 'Message ajouté.');
        $this->redirect('petition/show/' . (int)$petitionId);
    }

    public function delete($id, $petitionId)
    {
        $this->requireLogin();
        $this->requireActive();

        $commentModel = new CommentModel;
        $comment = $commentModel->find((int)$id);

        if (!$comment) {
            $this->flash('errors', 'Ressource introuvable.');
            $this->redirect('petition/show/' . (int)$petitionId);
        }

        $user = $this->user();
        $isOwner = ((int)$comment['user_id'] === (int)$user['id']);
        $isAdmin = (($user['role'] ?? '') === 'ADMIN');

        if (!$isOwner && !$isAdmin) {
            $this->flash('errors', 'Accès refusé.');
            $this->redirect('petition/show/' . (int)$petitionId);
        }

        $commentModel->delete((int)$id);
        $this->flash('success', 'Message supprimé.');
        $this->redirect('petition/show/' . (int)$petitionId);
    }
}
