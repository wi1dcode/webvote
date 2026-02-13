<?php

namespace App\Controller;

use Core\Controller;
use Core\Request;
use App\Model\PetitionModel;
use App\Model\CategoryModel;

class IndexController extends Controller
{
    public function index()
    {
        $request = new Request;
        $petitionModel = new PetitionModel;
        $categoryModel = new CategoryModel;

        $filters = [
            'q' => trim((string)$request->getGet('q')),
            'category_id' => $request->getGet('category_id')
        ];

        $petitions = $petitionModel->listPublished($filters);
        $categories = $categoryModel->listAll();

        $this->render('layout/base.php', 'petition/index.php', [
            'pageTitle' => 'Pétitions',
            'petitions' => $petitions,
            'categories' => $categories,
            'filters' => $filters,
            'messages' => $this->consumeFlash(),
            'user' => $this->user()
        ]);
    }
}
