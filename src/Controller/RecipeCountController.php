<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\HttpFoundation\Request;

class RecipeCountController
{
    public function __construct(private RecipeRepository $recipeRepository){

    }

    public function __invoke(Request $request): int{
        return $this->recipeRepository->count([]);
    }
}