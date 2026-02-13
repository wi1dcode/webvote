<?php

namespace App\Controller;

use Core\Controller;
use App\Model\SignatureModel;
use App\Model\PetitionModel;

class SignatureController extends Controller
{
    public function create($petitionId)
    {
        $this->requireLogin();
        $this->requireActive();

        $petitionModel = new PetitionModel;
        $signatureModel = new SignatureModel;

        $petition = $petitionModel->find((int)$petitionId);
        if (!$petition || $petition['status'] !== 'PUBLISHED') {
            $this->flash('errors', 'Ressource introuvable.');
            $this->redirect('');
        }

        $user = $this->user();
        if ($signatureModel->hasSigned($petition['id'], $user['id'])) {
            $this->flash('errors', 'Déjà signé.');
            $this->redirect('petition/show/' . (int)$petitionId);
        }

        $signatureModel->create($petition['id'], $user['id']);
        $this->flash('success', 'Signature enregistrée.');
        $this->redirect('petition/show/' . (int)$petitionId);
    }

    public function delete($petitionId)
    {
        $this->requireLogin();
        $this->requireActive();

        $signatureModel = new SignatureModel;
        $user = $this->user();

        $signatureModel->delete((int)$petitionId, (int)$user['id']);
        $this->flash('success', 'Signature retirée.');
        $this->redirect('petition/show/' . (int)$petitionId);
    }
}
