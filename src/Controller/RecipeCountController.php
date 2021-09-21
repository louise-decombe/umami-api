<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Symfony\Component\HttpFoundation\Request;

class RecipeCountController
{

    public function __construct(private RecipeRepository $recipeRepository) {

    }

    public function __invoke(Request $request): int
    {
        $onlineQuery = $request->get('online');
        $conditions = [];
        if ($onlineQuery !== null) {
            $conditions = ['online' => $onlineQuery === '1' ? true : false];
        }
        return $this->recipeRepository->count($conditions);
    }

}
